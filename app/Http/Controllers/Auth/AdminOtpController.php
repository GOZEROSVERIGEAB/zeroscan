<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Middleware\EnsureSuperAdmin;
use App\Models\User;
use App\Notifications\OtpLoginNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;

class AdminOtpController extends Controller
{
    private const MAX_OTP_ATTEMPTS = 5;

    private const MAX_VERIFY_ATTEMPTS = 5;

    private const DECAY_MINUTES = 10;

    public function showLoginForm(): View
    {
        return view('auth.admin-otp-login');
    }

    public function sendOtp(Request $request): RedirectResponse
    {
        $throttleKey = 'admin-otp-send:'.$request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, self::MAX_OTP_ATTEMPTS)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            return back()->withErrors([
                'email' => __('admin.auth.too_many_attempts', ['seconds' => $seconds]),
            ]);
        }

        $request->validate([
            'email' => ['required', 'email'],
        ]);

        RateLimiter::hit($throttleKey, self::DECAY_MINUTES * 60);

        if (! EnsureSuperAdmin::isAllowedEmail($request->email)) {
            return back()->withErrors([
                'email' => __('admin.auth.not_authorized'),
            ]);
        }

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()->withErrors([
                'email' => __('admin.auth.email_not_found'),
            ]);
        }

        if (! $user->isSuperAdmin()) {
            return back()->withErrors([
                'email' => __('admin.auth.not_authorized'),
            ]);
        }

        $otp = random_int(100000, 999999);

        Cache::put("admin-otp:{$user->id}", $otp, now()->addMinutes(10));

        Notification::route('mail', $user->email)
            ->notify(new OtpLoginNotification($otp));

        return redirect()->route('admin.otp.verify.form', ['user' => $user->id])
            ->with('status', __('admin.auth.code_sent'));
    }

    public function showVerifyForm(User $user): View
    {
        if (! EnsureSuperAdmin::isAllowedEmail($user->email)) {
            abort(403);
        }

        return view('auth.admin-otp-verify', ['user' => $user]);
    }

    public function verifyOtp(Request $request, User $user): RedirectResponse
    {
        if (! EnsureSuperAdmin::isAllowedEmail($user->email)) {
            abort(403);
        }

        $throttleKey = "admin-otp-verify:{$user->id}";

        if (RateLimiter::tooManyAttempts($throttleKey, self::MAX_VERIFY_ATTEMPTS)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            Cache::forget("admin-otp:{$user->id}");

            return redirect()->route('admin.login')->withErrors([
                'email' => __('admin.auth.too_many_attempts', ['seconds' => $seconds]),
            ]);
        }

        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $cachedOtp = Cache::get("admin-otp:{$user->id}");

        if (! $cachedOtp) {
            return back()->withErrors(['otp' => __('admin.auth.code_expired')]);
        }

        if ($cachedOtp != $request->otp) {
            RateLimiter::hit($throttleKey, self::DECAY_MINUTES * 60);

            return back()->withErrors(['otp' => __('admin.auth.invalid_code')]);
        }

        RateLimiter::clear($throttleKey);
        Cache::forget("admin-otp:{$user->id}");
        Auth::login($user);
        $user->update(['otp_verified_at' => now()]);

        return redirect()->route('admin.dashboard');
    }

    public function resendOtp(Request $request, User $user): RedirectResponse
    {
        if (! EnsureSuperAdmin::isAllowedEmail($user->email)) {
            abort(403);
        }

        $throttleKey = "admin-otp-resend:{$user->id}";

        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            return back()->withErrors([
                'otp' => __('admin.auth.too_many_attempts', ['seconds' => $seconds]),
            ]);
        }

        RateLimiter::hit($throttleKey, 60);

        $otp = random_int(100000, 999999);

        Cache::put("admin-otp:{$user->id}", $otp, now()->addMinutes(10));

        Notification::route('mail', $user->email)
            ->notify(new OtpLoginNotification($otp));

        return back()->with('status', __('admin.auth.code_resent'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
