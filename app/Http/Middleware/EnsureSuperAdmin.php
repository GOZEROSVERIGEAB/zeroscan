<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureSuperAdmin
{
    private const SUPER_ADMIN_EMAILS = [
        'emilia.mastad@prezero.com',
        'andreas@gozero.se',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return redirect()->route('admin.login');
        }

        $user = Auth::user();

        // Check both: user must have super_admin role AND be in the email whitelist
        if (! $user->isSuperAdmin() || ! in_array($user->email, self::SUPER_ADMIN_EMAILS)) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login')->withErrors([
                'email' => __('admin.auth.not_authorized'),
            ]);
        }

        return $next($request);
    }

    public static function isAllowedEmail(string $email): bool
    {
        return in_array($email, self::SUPER_ADMIN_EMAILS);
    }
}
