<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PropostaController extends Controller
{
    /**
     * Lista pública de propostas
     */
    public function index(Request $request)
    {
        $query = DB::table('propostas')
            ->select(
                'propostas.*',
                'users.name as usuario_nome',
                'categorias_propostas.nome as categoria_nome',
                'categorias_propostas.icone as categoria_icone',
                DB::raw('(SELECT COUNT(*) FROM proposta_votos WHERE proposta_id = propostas.id AND tipo_voto = "a_favor") as votos_a_favor'),
                DB::raw('(SELECT COUNT(*) FROM proposta_votos WHERE proposta_id = propostas.id AND tipo_voto = "contra") as votos_contra'),
                DB::raw('(SELECT COUNT(*) FROM proposta_votos WHERE proposta_id = propostas.id AND tipo_voto = "neutro") as votos_neutro'),
                DB::raw('(SELECT COUNT(*) FROM comentarios_propostas WHERE proposta_id = propostas.id) as total_comentarios')
            )
            ->join('users', 'propostas.user_id', '=', 'users.id')
            ->join('categorias_propostas', 'propostas.categoria_id', '=', 'categorias_propostas.id')
            ->orderBy('propostas.created_at', 'desc');

        $propostas = $query->paginate(10);
        $categorias = DB::table('categorias_propostas')->orderBy('nome')->get();

        return view('propostas.index', compact('propostas', 'categorias'));
    }

    public function create()
    {
        $categorias = DB::table('categorias_propostas')->orderBy('nome')->get();
        return view('propostas.create', compact('categorias'));
    }

    /**
     * Salva a nova proposta
     */
    public function store(Request $request)
    {
        if (!session('user_id')) {
            return redirect()->route('login');
        }

        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'categoria_id' => 'required|exists:categorias_propostas,id',
            'localizacao' => 'nullable|string|max:255', // Campo da sua tabela
        ]);

        $propostaId = DB::table('propostas')->insertGetId([
            'user_id' => session('user_id'),
            'categoria_id' => $request->categoria_id,
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'localizacao' => $request->localizacao,
            'status' => 'em_votacao', // O status padrão da sua tabela
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('propostas.show', $propostaId)
            ->with('success', 'Proposta enviada com sucesso!');
    }


    /**
     * Exibe detalhes da proposta
     */
    public function show($id)
    {
        $proposta = DB::table('propostas')
            ->select(
                'propostas.*',
                'users.name as usuario_nome',
                'categorias_propostas.nome as categoria_nome',
                'categorias_propostas.icone as categoria_icone',
                DB::raw('(SELECT COUNT(*) FROM proposta_votos WHERE proposta_id = propostas.id AND tipo_voto = "a_favor") as votos_a_favor'),
                DB::raw('(SELECT COUNT(*) FROM proposta_votos WHERE proposta_id = propostas.id AND tipo_voto = "contra") as votos_contra'),
                DB::raw('(SELECT COUNT(*) FROM proposta_votos WHERE proposta_id = propostas.id AND tipo_voto = "neutro") as votos_neutro')
            )
            ->join('users', 'propostas.user_id', '=', 'users.id')
            ->join('categorias_propostas', 'propostas.categoria_id', '=', 'categorias_propostas.id')
            ->where('propostas.id', $id)
            ->first();

        if (!$proposta) {
            abort(404, 'Proposta não encontrada');
        }

        // Comentários
        $comentarios = DB::table('comentarios_propostas')
            ->select('comentarios_propostas.*', 'users.name as usuario_nome')
            ->join('users', 'comentarios_propostas.user_id', '=', 'users.id')
            ->where('comentarios_propostas.proposta_id', $id)
            ->orderBy('comentarios_propostas.created_at', 'desc')
            ->get();

        // Verifica o voto do usuário logado
        $meuVoto = null;
        if (session('user_id')) {
            $meuVoto = DB::table('proposta_votos')
                ->where('proposta_id', $id)
                ->where('user_id', session('user_id'))
                ->first();
        }

        return view('propostas.show', compact('proposta', 'comentarios', 'meuVoto'));
    }

    /**
     * Adiciona um comentário
     */
    public function addComment(Request $request, $id)
    {
        if (!session('user_id')) {
            return redirect()->route('login');
        }

        $request->validate(['comentario' => 'required|string|max:1000']);

        DB::table('comentarios_propostas')->insert([
            'proposta_id' => $id,
            'user_id' => session('user_id'),
            'comentario' => $request->comentario,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('propostas.show', $id)
            ->with('success', 'Comentário adicionado!');
    }

    /**
     * Registra um voto
     */
    public function votar(Request $request, $id)
    {
        if (!session('user_id')) {
            return redirect()->route('login');
        }

        $request->validate([
            'tipo_voto' => 'required|in:a_favor,contra,neutro'
        ]);

        DB::table('proposta_votos')->updateOrInsert(
            [
                'proposta_id' => $id,
                'user_id' => session('user_id')
            ],
            [
                'tipo_voto' => $request->tipo_voto,
                'created_at' => now()
            ]
        );

        return redirect()->route('propostas.show', $id)
            ->with('success', 'Voto registrado com sucesso!');
    }

    /**
     * Remove o voto do usuário
     */
    public function removerVoto(Request $request, $id)
    {
        if (!session('user_id')) {
            return redirect()->route('login');
        }

        DB::table('proposta_votos')
            ->where('proposta_id', $id)
            ->where('user_id', session('user_id'))
            ->delete();

        return redirect()->route('propostas.show', $id)
            ->with('success', 'Seu voto foi removido.');
    }

    /**
     * Exibe propostas que o usuário votou
     */
    public function minhasVotacoes(Request $request)
    {
        if (!session('user_id')) {
            return redirect()->route('login');
        }

        $propostas = DB::table('propostas')
            ->select(
                'propostas.*',
                'categorias_propostas.nome as categoria_nome',
                'proposta_votos.tipo_voto',
                DB::raw('(SELECT COUNT(*) FROM proposta_votos WHERE proposta_id = propostas.id AND tipo_voto = "a_favor") as votos_a_favor'),
                DB::raw('(SELECT COUNT(*) FROM proposta_votos WHERE proposta_id = propostas.id AND tipo_voto = "contra") as votos_contra'),
                DB::raw('(SELECT COUNT(*) FROM proposta_votos WHERE proposta_id = propostas.id AND tipo_voto = "neutro") as votos_neutro')
            )
            ->join('categorias_propostas', 'propostas.categoria_id', '=', 'categorias_propostas.id')
            ->join('proposta_votos', 'propostas.id', '=', 'proposta_votos.proposta_id')
            ->where('proposta_votos.user_id', session('user_id'))
            ->orderBy('proposta_votos.created_at', 'desc')
            ->paginate(10);

        return view('propostas.minhas-votacoes', compact('propostas'));
    }
}
