<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index()
    {
        if (!session('user_id')) {
            return redirect()->route('login');
        }

        $userId = session('user_id');

        $stats = [
            'total_reportes' => DB::table('reportes')
                ->where('user_id', $userId)
                ->count(),

            'reportes_pendentes' => DB::table('reportes')
                ->where('user_id', $userId)
                ->where('status', 'pendente')
                ->count(),

            'reportes_resolvidos' => DB::table('reportes')
                ->where('user_id', $userId)
                ->where('status', 'resolvido')
                ->count(),

            'total_votos' => DB::table('proposta_votos')
                ->where('user_id', $userId)
                ->count(),

            'comentarios' => DB::table('comentarios_reportes')
                ->where('user_id', $userId)
                ->count(),
        ];

        $ultimosReportes = DB::table('reportes')
            ->select('reportes.*', 'categorias.nome as categoria_nome', 'categorias.icone')
            ->join('categorias', 'reportes.categoria_id', '=', 'categorias.id')
            ->where('reportes.user_id', $userId)
            ->orderBy('reportes.created_at', 'desc')
            ->limit(5)
            ->get();

        $propostasEmVotacao = DB::table('propostas')
            ->where('status', 'em_votacao')
            ->where(function($query) {
                $query->whereNull('data_fim_votacao')
                    ->orWhere('data_fim_votacao', '>=', date('Y-m-d'));
            })
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        $votosUsuario = DB::table('proposta_votos')
            ->where('user_id', $userId)
            ->pluck('tipo_voto', 'proposta_id')
            ->toArray();

        foreach ($propostasEmVotacao as $proposta) {
            $proposta->usuario_votou = isset($votosUsuario[$proposta->id]) ? $votosUsuario[$proposta->id] : null;
        }

        $atividadesRecentes = DB::table('reportes')
            ->select('reportes.*', 'users.name as usuario_nome', 'categorias.nome as categoria_nome', 'categorias.icone')
            ->join('users', 'reportes.user_id', '=', 'users.id')
            ->join('categorias', 'reportes.categoria_id', '=', 'categorias.id')
            ->where('reportes.user_id', '!=', $userId)
            ->orderBy('reportes.created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact('stats', 'ultimosReportes', 'propostasEmVotacao', 'atividadesRecentes'));
    }
}
