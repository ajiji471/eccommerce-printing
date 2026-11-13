<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Domain\Tenancy\TenantContext;
use App\Enums\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class EnsureTenantRole
{
    public function __construct(private readonly TenantContext $context) {}

    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();
        $tenant = $this->context->get();

        abort_unless($user !== null && $tenant !== null, 403);

        $required = $roles === [] ? [Role::Admin] : array_map(
            static fn (string $role): Role => Role::from($role),
            $roles
        );

        $allowed = in_array(Role::Admin, $required, true) && $user->isAdminOf($tenant);

        abort_unless($allowed, 403);

        return $next($request);
    }
}
