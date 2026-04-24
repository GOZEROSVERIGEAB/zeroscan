<?php

namespace App\Jobs;

use App\Models\ScanningSession;
use App\Notifications\EnvironmentReportNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Throwable;

class SendEnvironmentalReport implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 3;

    public int $backoff = 120;

    public int $timeout = 60;

    public function __construct(
        public ScanningSession $session
    ) {}

    public function handle(): void
    {
        if (! $this->session->email) {
            Log::warning('SendEnvironmentalReport: No email provided for session', [
                'session_id' => $this->session->id,
            ]);

            return;
        }

        if ($this->session->report_sent) {
            Log::info('SendEnvironmentalReport: Report already sent for session', [
                'session_id' => $this->session->id,
            ]);

            return;
        }

        try {
            Notification::route('mail', $this->session->email)
                ->notify(new EnvironmentReportNotification($this->session));

            $this->updateReportSentTimestamp();

            Log::info('Environmental report sent successfully', [
                'session_id' => $this->session->id,
                'email' => $this->session->email,
            ]);

        } catch (Throwable $e) {
            Log::error('Failed to send environmental report', [
                'session_id' => $this->session->id,
                'email' => $this->session->email,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    protected function updateReportSentTimestamp(): void
    {
        $updateData = [
            'report_sent' => true,
        ];

        if ($this->hasSessionColumn('report_sent_at')) {
            $updateData['report_sent_at'] = now();
        }

        $this->session->update($updateData);
    }

    protected function hasSessionColumn(string $column): bool
    {
        return in_array($column, $this->session->getFillable());
    }

    /**
     * Handle a job failure.
     */
    public function failed(?Throwable $exception): void
    {
        Log::error('SendEnvironmentalReport job failed permanently', [
            'session_id' => $this->session->id,
            'email' => $this->session->email,
            'error' => $exception?->getMessage(),
        ]);
    }
}
