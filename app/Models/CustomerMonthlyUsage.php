<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerMonthlyUsage extends Model
{
    protected $table = 'customer_monthly_usage';

    protected $fillable = [
        'customer_id',
        'year',
        'month',
        'scan_count',
    ];

    protected $casts = [
        'year' => 'integer',
        'month' => 'integer',
        'scan_count' => 'integer',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public static function incrementScanCount(int $customerId): void
    {
        $year = (int) now()->format('Y');
        $month = (int) now()->format('n');

        static::updateOrCreate(
            [
                'customer_id' => $customerId,
                'year' => $year,
                'month' => $month,
            ],
            []
        )->increment('scan_count');
    }
}
