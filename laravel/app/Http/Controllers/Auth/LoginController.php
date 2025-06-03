<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function showLoginForm()
    {
        if (auth()->user()) {
            return redirect()->route('profile.user');
        }
        return Inertia::render('Auth/Login', [
            'title' => 'Облик - Вход',
        ]);
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'min:5'],
            'password' => ['required', 'string', 'min:3'],
        ]);
    }
}
