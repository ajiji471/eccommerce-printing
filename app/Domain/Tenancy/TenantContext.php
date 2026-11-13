<?php

declare(strict_types=1);

namespace App\Domain\Tenancy;

use App\Exceptions\TenantContextMissingException;
use App\Models\Tenant;

final class TenantContext
{
    private ?Tenant $tenant = null;

    public function set(Tenant $tenant): void
    {
        $this->tenant = $tenant;
    }

    public function get(): ?Tenant
    {
        return $this->tenant;
    }

    public function getOrFail(): Tenant
    {
        return $this->tenant ?? throw TenantContextMissingException::for(Tenant::class);
    }

    public function idOrNull(): ?int
    {
        return $this->tenant?->getKey();
    }

    public function id(): int
    {
        return $this->tenant?->getKey() ?? throw TenantContextMissingException::for(Tenant::class);
    }

    public function check(): bool
    {
        return $this->tenant !== null;
    }

    public function clear(): void
    {
        $this->tenant = null;
    }
}
