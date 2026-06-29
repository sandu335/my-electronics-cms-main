<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorCodeMail;
use Carbon\Carbon;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'Date de autentificare invalide.'])
                ->onlyInput('email');
        }

        $user = Auth::user();

        // if user has 2FA enabled, generate code, email it, and require verification
        if ($user->two_factor_enabled) {
            $code = random_int(100000, 999999);
            $user->two_factor_code = (string) $code;
            $user->two_factor_expires_at = Carbon::now()->addMinutes(10);
            $user->save();

            // send code by email
            try {
                Mail::to($user->email)->send(new TwoFactorCodeMail($user));
            } catch (\Throwable $e) {
                // continue even if mail fails
            }

            // log out and store pending 2FA session
            Auth::logout();
            $request->session()->put('2fa:user:id', $user->id);
            $request->session()->put('2fa:remember', $request->boolean('remember'));

            return redirect()->route('2fa.index');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
