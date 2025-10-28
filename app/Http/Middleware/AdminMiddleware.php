<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
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
        // Verifica se está logado
        if (!session('user_id')) {
            return redirect()->route('login')
                ->with('error', 'Você precisa estar logado');
        }

        // Verifica se é admin
        if (session('user_tipo') !== 'admin') {
            return redirect()->route('home')
                ->with('error', 'Você não tem permissão para acessar esta área');
        }

        return $next($request);
    }
}
