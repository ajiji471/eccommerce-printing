<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Domain\Tenancy\TenantContext;
use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

final class ResolveTenant
{
    public function __construct(private readonly TenantContext $context) {}

    public function handle(Request $request, Closure $next): Response
    {
        $this->context->clear();

        $host = $this->normalizeHost($request->getHost());
        $platformDomain = $this->normalizeHost((string) config('app.platform_domain'));

        $tenant = null;

        if ($host !== $platformDomain) {
            $tenant = Tenant::query()->where('domain', $host)->first()
                ?? $this->findBySubdomain($host, $platformDomain);

            abort_if($tenant === null, 404);
        }

        if ($tenant !== null && $tenant->isSuspended()) {
            abort(503, 'Toko tidak tersedia.');
        }

        if ($tenant !== null) {
            $this->context->set($tenant);
            $request->attributes->set('tenant', $tenant);
        }

        return $next($request);
    }

    private function findBySubdomain(string $host, string $platformDomain): ?Tenant
    {
        $suffix = '.'.$platformDomain;

        if (! Str::endsWith($host, $suffix)) {
            return null;
        }

        $subdomain = Str::substr($host, 0, -strlen($suffix));

        if ($subdomain === '' || Str::contains($subdomain, '.')) {
            return null;
        }

        return Tenant::query()->where('slug', $subdomain)->first();
    }

    private function normalizeHost(string $host): string
    {
        return Str::lower(Str::before($host, ':'));
    }
}
