<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class DashboardController extends Controller
{
    public function __invoke(Request $request): Response
    {
        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'newOrders' => 0,
                'awaitingVerification' => 0,
                'revenueThisMonth' => 0,
                'lowStock' => 0,
            ],
        ]);
    }
}
