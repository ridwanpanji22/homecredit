<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $login_type = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        if (!Auth::attempt([$login_type => $request->login, 'password' => $request->password])) {
            return back()->withErrors([
                'login' => 'Login gagal. Email/no HP atau password salah.',
            ]);
        }

        $request->session()->regenerate();

        // Cek role & redirect
        $user = Auth::user();
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.index');
            case 'owner':
                return redirect()->route('owner.dashboard');
            case 'nasabah':
                return redirect()->route('nasabah.dashboard');
            default:
                Auth::logout();
                return back()->withErrors(['login' => 'Role tidak dikenali']);
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
