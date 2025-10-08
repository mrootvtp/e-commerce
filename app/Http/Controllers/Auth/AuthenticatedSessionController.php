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

        $user = Auth::user();
        $token = $user->createToken('web-session')->plainTextToken;
        
        $request->session()->put('sanctum_token', $token);

        return redirect()->intended(route('home'))->with('token', $token);

        
    }

  
    public function destroy(Request $request): RedirectResponse
    {
        
        if (Auth::check()) {
            Auth::user()->tokens()->delete();
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
