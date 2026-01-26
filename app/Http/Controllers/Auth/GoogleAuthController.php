<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            Log::info('Google callback started');
            
            $googleUser = Socialite::driver('google')->user();
            
            Log::info('Google user data received', [
                'email' => $googleUser->getEmail(),
                'id' => $googleUser->getId(),
                'name' => $googleUser->getName()
            ]);
            
            // Cek apakah user sudah ada berdasarkan email
            $user = User::where('email', $googleUser->getEmail())->first();
            
            if (!$user) {
                Log::info('User not found - pending admin approval', [
                    'email' => $googleUser->getEmail(),
                    'name' => $googleUser->getName()
                ]);
                
                // Redirect ke login dengan error message
                return redirect()->route('login')->with([
                    'error' => 'Akun Google "' . $googleUser->getName() . '" belum terdaftar. Hubungi admin untuk daftar dulu ya!'
                ]);
                
            } else {
                Log::info('Existing user found', ['user_id' => $user->id]);
                
                // Update Google ID jika belum ada
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->getId(),
                    ]);
                    Log::info('Updated google_id for existing user');
                }
                
                // Cek kalau no_rumah kosong, kasih warning (optional, buat admin notice)
                if (empty($user->no_rumah)) {
                    Log::warning('User logged in but no_rumah is empty', ['user_id' => $user->id]);
                    // Optional: Redirect ke profile edit, tapi sementara skip
                }
            }
            
            // Manual login
            Auth::guard('web')->login($user, true);
            session()->regenerate();
            session()->save();
            
            Log::info('User logged in successfully via Google', [
                'user_id' => $user->id,
                'session_id' => session()->getId(),
                'auth_check' => Auth::check(),
                'user_role' => $user->role,
                'no_rumah' => $user->no_rumah ?? 'EMPTY'  // Log buat track
            ]);
            
            // Redirect berdasarkan role
            if ($user->role === 'admin') {
                Log::info('Redirecting admin to admin dashboard');
                return redirect()->route('admin.pembayaran.index');
            }
            
            Log::info('Redirecting user to user dashboard');
            return redirect()->route('user.dashboard');
            
        } catch (\Exception $e) {
            Log::error('Google Login Error Details:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('login')->with([
                'error' => 'Login dengan Google gagal. Error: ' . $e->getMessage()
            ]);
        }
    }
}