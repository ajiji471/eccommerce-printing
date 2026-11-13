<?php

declare(strict_types=1);

namespace App\Http\Controllers\Platform;

use App\Enums\TenantStatus;
use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class DashboardController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $tenants = Tenant::query()->count();
        $active = Tenant::query()->where('status', TenantStatus::Active->value)->count();

        return Inertia::render('Platform/Dashboard', [
            'stats' => [
                'tenants' => $tenants,
                'activeTenants' => $active,
                'suspendedTenants' => $tenants - $active,
            ],
        ]);
    }
}
