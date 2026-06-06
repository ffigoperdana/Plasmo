<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (!$user || !$user->role) {
            abort(403);
        }

        $aliases = [
            'admin' => 'Administrator',
            'administrator' => 'Administrator',
            'pencari-donor' => 'Pencari Donor',
            'pencari donor' => 'Pencari Donor',
            'pendonor' => 'Pendonor',
        ];

        $allowedRoles = collect($roles)
            ->flatMap(fn ($role) => explode('|', $role))
            ->map(fn ($role) => $aliases[strtolower(trim($role))] ?? trim($role))
            ->map(fn ($role) => strtolower($role))
            ->all();

        if (!in_array(strtolower($user->role->name), $allowedRoles, true)) {
            abort(403);
        }

        return $next($request);
    }
}
