<?php

declare(strict_types=1);

namespace App\Http\Controllers\Storefront;

use App\Domain\Tenancy\TenantContext;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class HomeController extends Controller
{
    public function __invoke(Request $request, TenantContext $context): Response
    {
        if ($context->check()) {
            return Inertia::render('Storefront/Home');
        }

        return Inertia::render('Platform/Landing');
    }
}
