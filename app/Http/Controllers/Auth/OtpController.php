<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\OtpLoginNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;

class OtpController extends Controller
{
    private const MAX_OTP_ATTEMPTS = 5;
    private const MAX_VERIFY_ATTEMPTS = 5;
    private const DECAY_MINUTES = 10;

    public function showLoginForm(): View
    {
        return view('auth.otp-login');
    }

    public function sendOtp(Request $request): RedirectResponse
    {
        $throttleKey = 'otp-send:' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, self::MAX_OTP_ATTEMPTS)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            return back()->withErrors([
                'email' => __('scanit.auth.too_many_attempts', ['seconds' => $seconds]),
            ]);
        }

        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.exists' => __('scanit.auth.email_not_found'),
        ]);

        RateLimiter::hit($throttleKey, self::DECAY_MINUTES * 60);

        $user = User::where('email', $request->email)->first();
        $otp = random_int(100000, 999999);

        Cache::put("otp:{$user->id}", $otp, now()->addMinutes(10));

        Notification::route('mail', $user->email)
            ->notify(new OtpLoginNotification($otp));

        return redirect()->route('otp.verify.form', ['user' => $user->id])
            ->with('status', __('scanit.auth.code_sent'));
    }

    public function showVerifyForm(User $user): View
    {
        return view('auth.otp-verify', ['user' => $user]);
    }

    public function verifyOtp(Request $request, User $user): RedirectResponse
    {
        $throttleKey = "otp-verify:{$user->id}";

        if (RateLimiter::tooManyAttempts($throttleKey, self::MAX_VERIFY_ATTEMPTS)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            Cache::forget("otp:{$user->id}");

            return redirect()->route('login')->withErrors([
                'email' => __('scanit.auth.too_many_attempts', ['seconds' => $seconds]),
            ]);
        }

        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $cachedOtp = Cache::get("otp:{$user->id}");

        if (! $cachedOtp) {
            return back()->withErrors(['otp' => __('scanit.auth.code_expired')]);
        }

        if ($cachedOtp != $request->otp) {
            RateLimiter::hit($throttleKey, self::DECAY_MINUTES * 60);

            return back()->withErrors(['otp' => __('scanit.auth.invalid_code')]);
        }

        RateLimiter::clear($throttleKey);
        Cache::forget("otp:{$user->id}");
        Auth::login($user);
        $user->update(['otp_verified_at' => now()]);

        return redirect()->intended('/dashboard');
    }

    public function resendOtp(Request $request, User $user): RedirectResponse
    {
        $throttleKey = "otp-resend:{$user->id}";

        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            return back()->withErrors([
                'otp' => __('scanit.auth.too_many_attempts', ['seconds' => $seconds]),
            ]);
        }

        RateLimiter::hit($throttleKey, 60);

        $otp = random_int(100000, 999999);

        Cache::put("otp:{$user->id}", $otp, now()->addMinutes(10));

        Notification::route('mail', $user->email)
            ->notify(new OtpLoginNotification($otp));

        return back()->with('status', __('scanit.auth.code_resent'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
