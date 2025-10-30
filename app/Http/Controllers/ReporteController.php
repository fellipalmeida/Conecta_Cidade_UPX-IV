<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReporteController extends Controller
{
    /**
     * Exibe lista pública de reportes
     */
    public function index(Request $request)
    {
        $query = DB::table('reportes')
            ->select(
                'reportes.*',
                'users.name as usuario_nome',
                'categorias.nome as categoria_nome',
                'categorias.icone as categoria_icone',
                DB::raw('(SELECT COUNT(*) FROM comentarios_reportes WHERE reporte_id = reportes.id) as total_comentarios')
            )
            ->join('users', 'reportes.user_id', '=', 'users.id')
            ->join('categorias', 'reportes.categoria_id', '=', 'categorias.id');

        // Filtros
        if ($request->has('categoria')) {
            $query->where('reportes.categoria_id', $request->categoria);
        }

        if ($request->has('status')) {
            $query->where('reportes.status', $request->status);
        }

        if ($request->has('busca')) {
            $busca = $request->busca;
            $query->where(function($q) use ($busca) {
                $q->where('reportes.titulo', 'like', "%{$busca}%")
                    ->orWhere('reportes.descricao', 'like', "%{$busca}%")
                    ->orWhere('reportes.endereco', 'like', "%{$busca}%");
            });
        }

        $reportes = $query->orderBy('reportes.created_at', 'desc')
            ->paginate(12);

        // Buscar categorias para filtro
        $categorias = DB::table('categorias')
            ->orderBy('nome')
            ->get();

        return view('reportes.index', compact('reportes', 'categorias'));
    }

    /**
     * Exibe formulário de criação de reporte
     */
    public function create()
    {
        if (!session('user_id')) {
            return redirect()->route('login');
        }

        $categorias = DB::table('categorias')
            ->where('ativo', 1)  // Mudado de 'ativa' para 'ativo'
            ->orderBy('nome')
            ->get();

        return view('reportes.create', compact('categorias'));
    }

    /**
     * Salva novo reporte
     */
    public function store(Request $request)
    {
        if (!session('user_id')) {
            return redirect()->route('login');
        }

        // Validação
        $request->validate([
            'titulo' => 'required|string|max:200',
            'descricao' => 'required|string',
            'categoria_id' => 'required|exists:categorias,id',
            'endereco' => 'required|string|max:255',
            'referencia' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'prioridade' => 'required|in:baixa,media,alta,urgente',
            'foto' => 'nullable|image|max:5120' // 5MB
        ]);

        // Gerar protocolo único
        $protocolo = $this->gerarProtocolo();

        // Upload da imagem
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $nomeFoto = time() . '_' . Str::slug($request->titulo) . '.' . $foto->getClientOriginalExtension();
            $foto->move(public_path('uploads/reportes'), $nomeFoto);
            $fotoPath = 'uploads/reportes/' . $nomeFoto;
        }

        // Inserir reporte
        $reporteId = DB::table('reportes')->insertGetId([
            'user_id' => session('user_id'),
            'categoria_id' => $request->categoria_id,
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'endereco' => $request->endereco,
            'referencia' => $request->referencia,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'prioridade' => $request->prioridade,
            'status' => 'pendente',
            'protocolo' => $protocolo,
            'foto' => $fotoPath,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Criar notificação para admins
        $this->criarNotificacaoAdmins($reporteId);

        return redirect()->route('reportes.show', $reporteId)
            ->with('success', 'Reporte criado com sucesso! Protocolo: ' . $protocolo);
    }

    /**
     * Exibe detalhes de um reporte
     */
    public function show($id)
    {
        $reporte = DB::table('reportes')
            ->select(
                'reportes.*',
                'users.name as usuario_nome',
                'users.email as usuario_email',
                'categorias.nome as categoria_nome',
                'categorias.icone as categoria_icone'
            )
            ->join('users', 'reportes.user_id', '=', 'users.id')
            ->join('categorias', 'reportes.categoria_id', '=', 'categorias.id')
            ->where('reportes.id', $id)
            ->first();

        if (!$reporte) {
            abort(404, 'Reporte não encontrado');
        }

        // Buscar comentários
        $comentarios = DB::table('comentarios_reportes')
            ->select('comentarios_reportes.*', 'users.name as usuario_nome')
            ->join('users', 'comentarios_reportes.user_id', '=', 'users.id')
            ->where('comentarios_reportes.reporte_id', $id)
            ->orderBy('comentarios_reportes.created_at', 'desc')
            ->get();

        // Incrementar visualizações (apenas se a coluna existir)
        // Comentado por enquanto - adicione a coluna visualizacoes se quiser usar
        // DB::table('reportes')
        //     ->where('id', $id)
        //     ->increment('visualizacoes');

        return view('reportes.show', compact('reporte', 'comentarios'));
    }

    /**
     * Exibe reportes do usuário logado
     */
    public function meusReportes(Request $request)
    {
        if (!session('user_id')) {
            return redirect()->route('login');
        }

        $query = DB::table('reportes')
            ->select(
                'reportes.*',
                'categorias.nome as categoria_nome',
                'categorias.icone as categoria_icone',
                DB::raw('(SELECT COUNT(*) FROM comentarios_reportes WHERE reporte_id = reportes.id) as total_comentarios')
            )
            ->join('categorias', 'reportes.categoria_id', '=', 'categorias.id')
            ->where('reportes.user_id', session('user_id'));

        // Filtro por status
        if ($request->has('status')) {
            $query->where('reportes.status', $request->status);
        }

        $reportes = $query->orderBy('reportes.created_at', 'desc')
            ->paginate(10);

        // Estatísticas
        $stats = [
            'total' => DB::table('reportes')->where('user_id', session('user_id'))->count(),
            'pendentes' => DB::table('reportes')->where('user_id', session('user_id'))->where('status', 'pendente')->count(),
            'em_analise' => DB::table('reportes')->where('user_id', session('user_id'))->where('status', 'em_analise')->count(),
            'em_andamento' => DB::table('reportes')->where('user_id', session('user_id'))->where('status', 'em_andamento')->count(),
            'resolvidos' => DB::table('reportes')->where('user_id', session('user_id'))->where('status', 'resolvido')->count(),
            'rejeitados' => DB::table('reportes')->where('user_id', session('user_id'))->where('status', 'rejeitado')->count(),
        ];

        return view('reportes.meus', compact('reportes', 'stats'));
    }

    /**
     * Adiciona comentário a um reporte
     */
    public function addComment(Request $request, $id)
    {
        if (!session('user_id')) {
            return redirect()->route('login');
        }

        $request->validate([
            'comentario' => 'required|string|max:1000'
        ]);

        // Verificar se o reporte existe
        $reporte = DB::table('reportes')->where('id', $id)->first();
        if (!$reporte) {
            abort(404, 'Reporte não encontrado');
        }

        // Inserir comentário
        DB::table('comentarios_reportes')->insert([
            'reporte_id' => $id,
            'user_id' => session('user_id'),
            'comentario' => $request->comentario,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Criar notificação para o dono do reporte (se não for ele mesmo comentando)
        if ($reporte->user_id != session('user_id')) {
            // Usando a estrutura da tabela notifications existente
            DB::table('notifications')->insert([
                'id' => Str::uuid(),
                'type' => 'App\Notifications\ComentarioReporte',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $reporte->user_id,
                'data' => json_encode([
                    'titulo' => 'Novo comentário em seu reporte',
                    'mensagem' => 'Alguém comentou no seu reporte: ' . $reporte->titulo,
                    'link' => '/reportes/' . $id
                ]),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        return redirect()->route('reportes.show', $id)
            ->with('success', 'Comentário adicionado com sucesso!');
    }

    /**
     * Busca reporte por protocolo
     */
    public function buscarPorProtocolo(Request $request)
    {
        $request->validate([
            'protocolo' => 'required|string'
        ]);

        $reporte = DB::table('reportes')
            ->where('protocolo', $request->protocolo)
            ->first();

        if (!$reporte) {
            return redirect()->back()
                ->with('error', 'Nenhum reporte encontrado com este protocolo.');
        }

        return redirect()->route('reportes.show', $reporte->id);
    }

    /**
     * Gera protocolo único
     */
    private function gerarProtocolo()
    {
        do {
            $protocolo = 'REP' . date('Y') . Str::upper(Str::random(6));
            $existe = DB::table('reportes')->where('protocolo', $protocolo)->exists();
        } while ($existe);

        return $protocolo;
    }

    /**
     * Cria notificação para admins
     */
    private function criarNotificacaoAdmins($reporteId)
    {
        $reporte = DB::table('reportes')->where('id', $reporteId)->first();

        // Buscar todos os admins
        $admins = DB::table('users')
            ->where('tipo', 'admin')  // Mudado de 'is_admin' para 'tipo'
            ->get();

        foreach ($admins as $admin) {
            DB::table('notifications')->insert([
                'id' => Str::uuid(),
                'type' => 'App\Notifications\NovoReporte',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $admin->id,
                'data' => json_encode([
                    'titulo' => 'Novo reporte criado',
                    'mensagem' => 'Um novo reporte foi criado: ' . $reporte->titulo,
                    'link' => '/reportes/' . $reporteId
                ]),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
