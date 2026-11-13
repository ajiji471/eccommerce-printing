<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PlanCode;
use Database\Factories\PlanFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property PlanCode $code
 * @property array<string, bool> $features
 */
final class Plan extends Model
{
    /** @use HasFactory<PlanFactory> */
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'max_orders_per_month',
        'max_products',
        'max_admins',
        'storage_quota_mb',
        'features',
        'price',
    ];

    /** @return array<string, class-string|string> */
    protected function casts(): array
    {
        return [
            'code' => PlanCode::class,
            'features' => 'array',
            'max_orders_per_month' => 'integer',
            'max_products' => 'integer',
            'max_admins' => 'integer',
            'storage_quota_mb' => 'integer',
            'price' => 'integer',
        ];
    }

    /** @return HasMany<TenantSubscription, $this> */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(TenantSubscription::class);
    }

    public function hasFeature(string $feature): bool
    {
        return (bool) ($this->features[$feature] ?? false);
    }
}
