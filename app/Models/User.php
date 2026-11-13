<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Role;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /** @var list<string> */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'is_super_admin',
    ];

    /** @var list<string> */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /** @return array<string, class-string|string> */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_super_admin' => 'boolean',
        ];
    }

    /** @return HasMany<TenantUser, $this> */
    public function tenantMemberships(): HasMany
    {
        return $this->hasMany(TenantUser::class);
    }

    /** @return BelongsToMany<Tenant, $this> */
    public function tenants(): BelongsToMany
    {
        return $this->belongsToMany(Tenant::class, 'tenant_users')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function isSuperAdmin(): bool
    {
        return (bool) $this->is_super_admin;
    }

    public function isAdminOf(Tenant $tenant): bool
    {
        return $this->tenantMemberships()
            ->where('tenant_id', $tenant->getKey())
            ->where('role', Role::Admin->value)
            ->exists();
    }

    public function isAdmin(): bool
    {
        return $this->tenantMemberships()->where('role', Role::Admin->value)->exists();
    }

    public function homePath(): string
    {
        if ($this->isSuperAdmin()) {
            return '/platform';
        }

        if ($this->isAdmin()) {
            return '/admin';
        }

        return '/akun';
    }
}
