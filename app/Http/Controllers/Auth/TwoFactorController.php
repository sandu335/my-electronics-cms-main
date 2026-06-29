<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorCodeMail;

class TwoFactorController extends Controller
{
    public function verify(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $userId = $request->session()->get('2fa:user:id');
        if (! $userId) {
            return redirect()->route('login');
        }

        $user = User::find($userId);
        if (! $user) {
            return redirect()->route('login');
        }

        if (! $user->two_factor_code || ! $user->two_factor_expires_at || Carbon::now()->gt($user->two_factor_expires_at)) {
            return back()->withErrors(['code' => 'Codul a expirat. Solicitați re-trimiterea.']);
        }

        if (! hash_equals($user->two_factor_code, $request->input('code'))) {
            return back()->withErrors(['code' => 'Cod invalid.']);
        }

        // code valid, clear and log in
        $user->two_factor_code = null;
        $user->two_factor_expires_at = null;
        $user->save();

        Auth::loginUsingId($user->id, $request->session()->pull('2fa:remember', false));
        $request->session()->regenerate();
        $request->session()->forget('2fa:user:id');

        return redirect()->intended(route('admin.dashboard'));
    }

    public function resend(Request $request)
    {
        $userId = $request->session()->get('2fa:user:id');
        if (! $userId) {
            return redirect()->route('login');
        }

        $user = User::find($userId);
        if (! $user) {
            return redirect()->route('login');
        }

        $code = random_int(100000, 999999);
        $user->two_factor_code = (string) $code;
        $user->two_factor_expires_at = Carbon::now()->addMinutes(10);
        $user->save();

        try {
            Mail::to($user->email)->send(new TwoFactorCodeMail($user));
        } catch (\Throwable $e) {
            // ignore
        }

        return back()->with('success', 'Codul a fost retrimis.');
    }
}
