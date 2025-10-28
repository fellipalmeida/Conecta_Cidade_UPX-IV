<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthMiddleware
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
        // Verifica se o usuário está logado (tem user_id na sessão)
        if (!session('user_id')) {
            return redirect()->route('login')
                ->with('error', 'Você precisa estar logado para acessar esta página');
        }

        return $next($request);
    }
}
