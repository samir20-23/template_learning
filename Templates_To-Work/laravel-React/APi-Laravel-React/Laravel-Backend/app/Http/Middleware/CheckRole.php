<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles  e.g. 'admin', 'formateur', 'user'
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        foreach ($roles as $role) {
            $method = 'is' . ucfirst(strtolower($role));
            if (method_exists($user, $method) && $user->$method()) {
                return $next($request);
            }
        }

        return redirect()->route('home'); // 👈 redirect instead of abort
    }
}
