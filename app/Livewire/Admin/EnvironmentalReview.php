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

    public function edit(Inventory $inventory): void
    {
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

        $factor = $category->factors()->where('is_default', true)->first()
            ?? $category->factors()->first();

        if (! $factor) {
            session()->flash('error', 'Ingen faktor hittades för vald kategori');

            return;
        }

        $weight = $this->editing->weight ?? 1.0;

        $this->editing->update([
            'environmental_category_id' => $category->id,
            'environmental_factor_id' => $factor->id,
            'co2_savings' => $factor->co2_kg_per_kg * $weight,
            'water_savings' => $factor->water_liters_per_kg ? $factor->water_liters_per_kg * $weight : null,
            'energy_savings' => $factor->energy_kwh_per_kg ? $factor->energy_kwh_per_kg * $weight : null,
            'environmental_data_source' => 'verified_database',
            'environmental_data_verified' => true,
            'co2_source' => $factor->source?->name ?? 'Manuellt vald kategori',
            'co2_calculation_notes' => "Kategori manuellt ändrad till: {$category->name}",
        ]);

        session()->flash('success', "Räknade om med kategori {$category->name}: {$this->editing->co2_savings} kg CO2");
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
