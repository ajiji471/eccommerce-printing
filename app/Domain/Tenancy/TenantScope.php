<?php

declare(strict_types=1);

namespace App\Domain\Tenancy;

use App\Exceptions\TenantContextMissingException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

final class TenantScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $tenantId = app(TenantContext::class)->idOrNull();

        if ($tenantId === null) {
            throw TenantContextMissingException::for($model::class);
        }

        $builder->where($model->getTable().'.tenant_id', $tenantId);
    }
}
