<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Determine where to redirect users after login based on their role.
     *
     * @return string
     */
    protected function redirectTo(): string
    {
        $role = Auth::user()->role;

        if (strtolower($role) === 'admin') {
            return route('dashboard');
        }

        return route('home');
    }

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
