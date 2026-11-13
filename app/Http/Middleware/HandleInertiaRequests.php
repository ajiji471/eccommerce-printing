<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Domain\Tenancy\PlanLimitService;
use App\Domain\Tenancy\TenantContext;
use App\Models\Tenant;
use App\Models\TenantSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();
        $tenant = app(TenantContext::class)->get();

        return array_merge(parent::share($request), [
            'name' => config('app.name'),
            'locale' => app()->getLocale(),
            'auth' => [
                'user' => $user === null ? null : [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'email_verified' => $user->hasVerifiedEmail(),
                    'is_super_admin' => $user->isSuperAdmin(),
                    'is_admin' => $tenant !== null && $user->isAdminOf($tenant),
                ],
            ],
            'tenant' => $tenant === null ? null : $this->tenantProps($tenant),
            'flash' => [
                'success' => $request->session()->get('success'),
                'error' => $request->session()->get('error'),
            ],
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function tenantProps(Tenant $tenant): array
    {
        /** @var TenantSettings|null $settings */
        $settings = Cache::remember(
            "t{$tenant->id}:settings",
            now()->addHour(),
            fn () => $tenant->settings
        );

        $plan = app(PlanLimitService::class)->planFor($tenant);
        $ownBranding = $plan?->hasFeature('own_branding') ?? false;

        return [
            'id' => $tenant->id,
            'slug' => $tenant->slug,
            'display_name' => $tenant->display_name,
            'brand_name' => $ownBranding ? $tenant->display_name : config('app.name'),
            'logo_url' => $tenant->logo_path,
            'accent_color' => $tenant->accent_color,
            'footer' => $tenant->footer,
            'plan' => $plan?->code?->value,
            'own_branding' => $ownBranding,
            'ppn_percent' => $settings?->ppn_percent,
            'active_couriers' => $settings->active_couriers ?? [],
        ];
    }
}
