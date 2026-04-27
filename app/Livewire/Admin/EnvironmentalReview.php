<?php

namespace App\Livewire\Admin;

use App\Models\EnvironmentalCategory;
use App\Models\Inventory;
use App\Models\ScanningSession;
use App\Notifications\EnvironmentReportNotification;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;

class EnvironmentalReview extends Component
{
    public ?Inventory $editing = null;

    public ?float $co2 = null;

    public ?float $water = null;

    public ?float $energy = null;

    public ?string $notes = null;

    public ?int $newCategoryId = null;

    public function edit(int $inventoryId): void
    {
        $inventory = Inventory::find($inventoryId);

        if (! $inventory) {
            session()->flash('error', 'Objektet hittades inte');

            return;
        }

        $this->editing = $inventory;
        $this->co2 = (float) $inventory->co2_savings ?: null;
        $this->water = (float) $inventory->water_savings ?: null;
        $this->energy = (float) $inventory->energy_savings ?: null;
        $this->notes = null;
        $this->newCategoryId = $inventory->environmental_category_id;
    }

    public function cancel(): void
    {
        $this->reset(['editing', 'co2', 'water', 'energy', 'notes', 'newCategoryId']);
    }

    public function saveManual(): void
    {
        $this->validate([
            'co2' => ['required', 'numeric', 'min:0.01'],
        ]);

        $this->editing->setManualEnvironmentalData(
            $this->co2,
            $this->water,
            $this->energy,
            $this->notes
        );

        session()->flash('success', "Sparade manuell data för {$this->editing->name}");
        $this->cancel();
    }

    public function recalculate(): void
    {
        if (! $this->newCategoryId) {
            return;
        }

        $category = EnvironmentalCategory::with('factors')->find($this->newCategoryId);

        if (! $category) {
            return;
        }

        $factor = $category->factors()
            ->where('is_active', true)
            ->where('is_verified', true)
            ->first();

        if (! $factor) {
            session()->flash('error', 'Ingen verifierad faktor hittades för vald kategori');

            return;
        }

        $co2Savings = $factor->calculateCo2Savings();
        $waterSavings = $factor->calculateWaterSavings();

        $this->editing->update([
            'environmental_category_id' => $category->id,
            'environmental_factor_id' => $factor->id,
            'co2_savings' => $co2Savings,
            'water_savings' => $waterSavings,
            'energy_savings' => null,
            'environmental_data_source' => 'verified_database',
            'environmental_data_verified' => true,
            'co2_source' => $factor->source_name ?? 'Manuellt vald kategori',
            'co2_calculation_notes' => "Kategori manuellt ändrad till: {$category->name_sv}",
        ]);

        session()->flash('success', "Räknade om med kategori {$category->name_sv}: {$co2Savings} kg CO2");
        $this->cancel();
    }

    public function sendBlockedReport(int $sessionId): void
    {
        $session = ScanningSession::find($sessionId);

        if (! $session) {
            session()->flash('error', 'Sessionen hittades inte');

            return;
        }

        if ($session->report_sent) {
            session()->flash('error', 'Rapporten har redan skickats');

            return;
        }

        if ($session->hasZeroCo2Inventories()) {
            session()->flash('error', 'Det finns fortfarande objekt utan CO2-data. Korrigera dessa först.');

            return;
        }

        if (! $session->email) {
            session()->flash('error', 'Sessionen saknar e-postadress');

            return;
        }

        Notification::route('mail', $session->email)
            ->notify(new EnvironmentReportNotification($session));

        $session->update([
            'report_sent' => true,
            'report_blocked' => false,
            'report_blocked_reason' => null,
            'completed_at' => now(),
        ]);

        session()->flash('success', "Rapporten skickades till {$session->email}");
    }

    public function render()
    {
        $inventories = Inventory::needsEnvironmentalReview()
            ->with(['station.facility', 'environmentalCategory'])
            ->latest()
            ->limit(50)
            ->get();

        $categories = EnvironmentalCategory::orderBy('name_sv')->get();

        $blockedSessions = ScanningSession::where('report_blocked', true)
            ->where('report_sent', false)
            ->with(['station.facility', 'inventories'])
            ->latest()
            ->get()
            ->map(function ($session) {
                $session->zero_co2_count = $session->getZeroCo2Count();
                $session->can_send = $session->zero_co2_count === 0;

                return $session;
            });

        return view('livewire.admin.environmental-review', [
            'inventories' => $inventories,
            'categories' => $categories,
            'blockedSessions' => $blockedSessions,
        ])->layout('components.layouts.admin');
    }
}
