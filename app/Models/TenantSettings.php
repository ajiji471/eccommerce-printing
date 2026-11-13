<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Database\Factories\TenantSettingsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * @property string $ppn_percent
 * @property array<int, string> $active_couriers
 */
final class TenantSettings extends Model
{
    /** @use HasFactory<TenantSettingsFactory> */
    use BelongsToTenant, HasFactory;

    protected static function booted(): void
    {
        $forget = static fn (self $settings) => Cache::forget("t{$settings->tenant_id}:settings");

        self::saved($forget);
        self::deleted($forget);
    }

    protected $fillable = [
        'bank_accounts',
        'origin',
        'active_couriers',
        'flat_rates',
        'ppn_percent',
        'business_hours',
        'midtrans_client_key',
        'midtrans_server_key',
        'midtrans_merchant_id',
        'midtrans_mode',
        'rajaongkir_key',
        'drive_folder_id',
        'gmail_token',
    ];

    protected function casts(): array
    {
        return [
            'bank_accounts' => 'array',
            'origin' => 'array',
            'active_couriers' => 'array',
            'flat_rates' => 'array',
            'business_hours' => 'array',
            'ppn_percent' => 'decimal:2',
            'midtrans_server_key' => 'encrypted',
            'rajaongkir_key' => 'encrypted',
            'gmail_token' => 'encrypted',
        ];
    }
}
