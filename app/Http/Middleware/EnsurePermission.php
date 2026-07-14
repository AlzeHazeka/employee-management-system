<?php

namespace App\Http\Middleware;

use App\Support\Permissions;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePermission
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $user = $request->user();
        if (! $user) {
            return $this->deny($request, $permission);
        }

        $permission = trim($permission);
        if ($permission === '') {
            return $this->deny($request, $permission);
        }

        if (! $user->can($permission)) {
            return $this->deny($request, $permission);
        }

        return $next($request);
    }

    private function deny(Request $request, string $permission): Response
    {
        $message = $permission === Permissions::PAYROLL_VIEW
            ? 'Anda tidak memiliki akses ke fitur penggajian.'
            : 'Anda tidak memiliki akses ke fitur ini.';

        if ($request->expectsJson()) {
            abort(403, $message);
        }

        return redirect()
            ->route('dashboard')
            ->with('error', $message)
            ->with('flash.banner', $message)
            ->with('flash.bannerStyle', 'danger');
    }
}
