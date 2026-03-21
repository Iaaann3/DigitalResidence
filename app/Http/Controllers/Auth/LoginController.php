<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function username()
    {
        return 'no_rumah';
    }

    /**
     * Override redirect setelah login sukses.
     * Kalau AJAX → return JSON dengan redirect URL.
     * Kalau biasa → redirect seperti biasa.
     */
    protected function authenticated(Request $request, $user)
    {
        $redirectUrl = match($user->role) {
            'admin' => route('admin.pembayaran.index'),
            'user'  => route('user.dashboard'),
            default => null,
        };

        // Role tidak valid
        if (!$redirectUrl) {
            Auth::logout();
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Role tidak valid, hubungi admin.',
                ], 403);
            }
            return redirect()->route('login')->withErrors([
                'login' => 'Role tidak valid, hubungi admin.',
            ]);
        }

        // AJAX request dari fetch JS
        if ($request->ajax()) {
            return response()->json([
                'success'      => true,
                'redirect_url' => $redirectUrl,
            ]);
        }

        return redirect($redirectUrl);
    }

    /**
     * Override respons gagal login.
     * Kalau AJAX → return JSON error.
     * Kalau biasa → throw ValidationException seperti default.
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'No. Rumah atau password salah.',
            ], 422);
        }

        // Fallback ke behaviour default Laravel
        throw \Illuminate\Validation\ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}