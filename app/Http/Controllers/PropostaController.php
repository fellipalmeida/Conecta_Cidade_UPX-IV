<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PropostaController extends Controller
{
    /**
     * Exibe a lista de propostas
     */
    public function index(Request $request)
    {
        $query = DB::table('propostas')
            ->select('propostas.*')
            ->orderBy('propostas.created_at', 'desc');

        // Filtro por status
        if ($request->filled('status')) {
            $query->where('propostas.status', $request->status);
        }

        // Filtro de busca
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('propostas.titulo', 'LIKE', "%{$search}%")
                    ->orWhere('propostas.descricao', 'LIKE', "%{$search}%")
                    ->orWhere('propostas.localizacao', 'LIKE', "%{$search}%");
            });
        }

        // Paginação
        $propostas = $query->paginate(9);

        // Se o usuário estiver logado, verificar quais propostas ele já votou
        $votosUsuario = [];
        if (session('user_id')) {
            $votosUsuario = DB::table('votos')
                ->where('user_id', session('user_id'))
                ->pluck('voto', 'proposta_id')
                ->toArray();
        }

        // Adicionar informação de voto do usuário em cada proposta
        foreach ($propostas as $proposta) {
            $proposta->usuario_votou = isset($votosUsuario[$proposta->id]) ? $votosUsuario[$proposta->id] : null;
            $proposta->total_votos = $proposta->total_votos_favoravel +
                $proposta->total_votos_contrario +
                $proposta->total_votos_neutro;

            // Calcular porcentagens
            if ($proposta->total_votos > 0) {
                $proposta->percentual_favoravel = round(($proposta->total_votos_favoravel / $proposta->total_votos) * 100);
                $proposta->percentual_contrario = round(($proposta->total_votos_contrario / $proposta->total_votos) * 100);
                $proposta->percentual_neutro = round(($proposta->total_votos_neutro / $proposta->total_votos) * 100);
            } else {
                $proposta->percentual_favoravel = 0;
                $proposta->percentual_contrario = 0;
                $proposta->percentual_neutro = 0;
            }
        }

        // Estatísticas
        $stats = [
            'total' => DB::table('propostas')->count(),
            'em_votacao' => DB::table('propostas')->where('status', 'em_votacao')->count(),
            'aprovadas' => DB::table('propostas')->where('status', 'aprovada')->count(),
            'implementadas' => DB::table('propostas')->where('status', 'implementada')->count(),
        ];

        return view('propostas.index', compact('propostas', 'stats'));
    }

    /**
     * Exibe os detalhes de uma proposta
     */
    public function show($id)
    {
        $proposta = DB::table('propostas')
            ->where('id', $id)
            ->first();

        if (!$proposta) {
            return redirect()->route('propostas.index')
                ->with('error', 'Proposta não encontrada');
        }

        // Verificar se o usuário já votou
        $votoUsuario = null;
        if (session('user_id')) {
            $voto = DB::table('votos')
                ->where('user_id', session('user_id'))
                ->where('proposta_id', $id)
                ->first();

            $votoUsuario = $voto ? $voto->voto : null;
        }

        // Calcular estatísticas de votos
        $proposta->total_votos = $proposta->total_votos_favoravel +
            $proposta->total_votos_contrario +
            $proposta->total_votos_neutro;

        if ($proposta->total_votos > 0) {
            $proposta->percentual_favoravel = round(($proposta->total_votos_favoravel / $proposta->total_votos) * 100);
            $proposta->percentual_contrario = round(($proposta->total_votos_contrario / $proposta->total_votos) * 100);
            $proposta->percentual_neutro = round(($proposta->total_votos_neutro / $proposta->total_votos) * 100);
        } else {
            $proposta->percentual_favoravel = 0;
            $proposta->percentual_contrario = 0;
            $proposta->percentual_neutro = 0;
        }

        // Buscar últimos votantes (opcional - apenas contagem)
        $ultimosVotantes = DB::table('votos')
            ->select('users.name', 'votos.voto', 'votos.created_at')
            ->join('users', 'votos.user_id', '=', 'users.id')
            ->where('votos.proposta_id', $id)
            ->orderBy('votos.created_at', 'desc')
            ->limit(10)
            ->get();

        return view('propostas.show', compact('proposta', 'votoUsuario', 'ultimosVotantes'));
    }

    /**
     * Registra ou atualiza o voto do usuário
     */
    public function votar(Request $request, $id)
    {
        // Verifica se está logado
        if (!session('user_id')) {
            return redirect()->route('login')
                ->with('error', 'Você precisa estar logado para votar');
        }

        // Validação
        $validator = Validator::make($request->all(), [
            'voto' => 'required|in:favoravel,contrario,neutro'
        ], [
            'voto.required' => 'Selecione uma opção de voto',
            'voto.in' => 'Opção de voto inválida'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        // Verificar se a proposta existe e está em votação
        $proposta = DB::table('propostas')->find($id);

        if (!$proposta) {
            return back()->with('error', 'Proposta não encontrada');
        }

        if ($proposta->status !== 'em_votacao') {
            return back()->with('error', 'Esta proposta não está mais em votação');
        }

        // Verificar se a data de votação ainda está válida
        if ($proposta->data_fim_votacao && $proposta->data_fim_votacao < date('Y-m-d')) {
            return back()->with('error', 'O período de votação desta proposta já encerrou');
        }

        try {
            DB::beginTransaction();

            // Verificar se o usuário já votou
            $votoExistente = DB::table('votos')
                ->where('user_id', session('user_id'))
                ->where('proposta_id', $id)
                ->first();

            if ($votoExistente) {
                // Atualizar voto existente
                DB::table('votos')
                    ->where('user_id', session('user_id'))
                    ->where('proposta_id', $id)
                    ->update([
                        'voto' => $request->voto,
                        'updated_at' => now()
                    ]);

                $mensagem = 'Seu voto foi atualizado com sucesso!';
            } else {
                // Inserir novo voto
                DB::table('votos')->insert([
                    'user_id' => session('user_id'),
                    'proposta_id' => $id,
                    'voto' => $request->voto,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                $mensagem = 'Voto registrado com sucesso!';
            }

            DB::commit();

            return back()->with('success', $mensagem);

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Erro ao registrar voto. Tente novamente.');
        }
    }

    /**
     * Remove o voto do usuário
     */
    public function removerVoto($id)
    {
        if (!session('user_id')) {
            return redirect()->route('login');
        }

        try {
            DB::table('votos')
                ->where('user_id', session('user_id'))
                ->where('proposta_id', $id)
                ->delete();

            return back()->with('success', 'Voto removido com sucesso!');

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao remover voto');
        }
    }

    /**
     * Exibe propostas que o usuário votou
     */
    public function minhasVotacoes()
    {
        if (!session('user_id')) {
            return redirect()->route('login');
        }

        $propostas = DB::table('propostas')
            ->select('propostas.*', 'votos.voto', 'votos.created_at as data_voto')
            ->join('votos', 'propostas.id', '=', 'votos.proposta_id')
            ->where('votos.user_id', session('user_id'))
            ->orderBy('votos.created_at', 'desc')
            ->paginate(9);

        // Adicionar estatísticas de cada proposta
        foreach ($propostas as $proposta) {
            $proposta->total_votos = $proposta->total_votos_favoravel +
                $proposta->total_votos_contrario +
                $proposta->total_votos_neutro;

            if ($proposta->total_votos > 0) {
                $proposta->percentual_favoravel = round(($proposta->total_votos_favoravel / $proposta->total_votos) * 100);
                $proposta->percentual_contrario = round(($proposta->total_votos_contrario / $proposta->total_votos) * 100);
                $proposta->percentual_neutro = round(($proposta->total_votos_neutro / $proposta->total_votos) * 100);
            }
        }

        // Estatísticas do usuário
        $stats = [
            'total_votos' => DB::table('votos')->where('user_id', session('user_id'))->count(),
            'favoravel' => DB::table('votos')->where('user_id', session('user_id'))->where('voto', 'favoravel')->count(),
            'contrario' => DB::table('votos')->where('user_id', session('user_id'))->where('voto', 'contrario')->count(),
            'neutro' => DB::table('votos')->where('user_id', session('user_id'))->where('voto', 'neutro')->count(),
        ];

        return view('propostas.minhas-votacoes', compact('propostas', 'stats'));
    }
}
