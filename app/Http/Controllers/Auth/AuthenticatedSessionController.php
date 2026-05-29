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
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Tambahkan notifikasi sukses login
        return redirect()->intended(route('dashboard', absolute: false))
            ->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '!');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $userName = Auth::user()->name;
        
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Tambahkan notifikasi sukses logout
        return redirect('/login')
            ->with('info', 'Anda telah logout. Sampai jumpa kembali, ' . $userName . '!');
    }
}