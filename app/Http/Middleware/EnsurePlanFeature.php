<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Domain\Tenancy\PlanLimitService;
use App\Domain\Tenancy\TenantContext;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class EnsurePlanFeature
{
    public function __construct(
        private readonly TenantContext $context,
        private readonly PlanLimitService $plans,
    ) {}

    public function handle(Request $request, Closure $next, string $feature): Response
    {
        $tenant = $this->context->getOrFail();

        abort_unless(
            $this->plans->allows($tenant, $feature),
            403,
            'Fitur ini tidak tersedia pada paket langganan Anda.'
        );

        return $next($request);
    }
}
