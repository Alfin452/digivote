<?php

namespace App\Http\Controllers\AdminEvent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLoginForm()
    {
        // Jika sudah login, langsung lempar ke dashboard
        if (Auth::guard('event_admin')->check()) {
            return redirect()->route('admin-event.dashboard');
        }

        return view('admin-event.login');
    }

    // Memproses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba login menggunakan guard 'event_admin'
        if (Auth::guard('event_admin')->attempt($credentials)) {
            $request->session()->regenerate();

            // Update waktu login terakhir
            $admin = Auth::guard('event_admin')->user();
            $admin->update(['last_login' => now()]);

            return redirect()->intended(route('admin-event.dashboard'));
        }

        // Jika gagal
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // Memproses logout
    public function logout(Request $request)
    {
        Auth::guard('event_admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin-event.login');
    }
}
