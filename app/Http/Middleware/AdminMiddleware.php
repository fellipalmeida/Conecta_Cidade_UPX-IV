<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('user_id')) {
            return redirect()->route('login')
                ->with('error', 'Você precisa estar logado');
        }

        if (session('user_tipo') !== 'admin') {
            return redirect()->route('home')
                ->with('error', 'Você não tem permissão para acessar esta área');
        }

        return $next($request);
    }
}
