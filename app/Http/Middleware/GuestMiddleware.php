<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GuestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Se o usuário já estiver logado, redireciona para o dashboard
        if (session('user_id')) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
