<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class AuthController extends Controller
{
    public function login(): Response
    {
        return inertia('auth/login');
    }

    public function authentication(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $user = User::where('email', $request->email)->first();
        if (is_null($user)) {
            return back()->withErrors(['error' => "Email yang anda masukkan salah"]);
        }
        if (!Auth::attempt(['email' => $user->email, 'password' => $request->password]) && !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['error' => "Password yang anda masukkan salah"]);
        }
        $request->session()->regenerate();
        return to_route('home');
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return to_route('auth.login');
    }
}
