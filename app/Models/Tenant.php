<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\TenantStatus;
use Database\Factories\TenantFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property TenantStatus $status
 */
final class Tenant extends Model
{
    /** @use HasFactory<TenantFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'display_name',
        'slug',
        'domain',
        'status',
        'logo_path',
        'accent_color',
        'address',
        'contact',
        'footer',
    ];

    /** @return array<string, class-string|string> */
    protected function casts(): array
    {
        return [
            'status' => TenantStatus::class,
            'contact' => 'array',
            'deleted_at' => 'datetime',
        ];
    }

    /** @return HasMany<TenantUser, $this> */
    public function memberships(): HasMany
    {
        return $this->hasMany(TenantUser::class);
    }

    /** @return BelongsToMany<User, $this> */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'tenant_users')
            ->withPivot('role')
            ->withTimestamps();
    }

    /** @return HasOne<TenantSettings, $this> */
    public function settings(): HasOne
    {
        return $this->hasOne(TenantSettings::class);
    }

    /** @return HasMany<TenantSubscription, $this> */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(TenantSubscription::class);
    }

    /** @return HasOne<TenantSubscription, $this> */
    public function activeSubscription(): HasOne
    {
        return $this->hasOne(TenantSubscription::class)
            ->where('status', 'active')
            ->latestOfMany('starts_at');
    }

    public function currentPlan(): ?Plan
    {
        return $this->activeSubscription?->plan;
    }

    public function isSuspended(): bool
    {
        return $this->status === TenantStatus::Suspended;
    }
}
