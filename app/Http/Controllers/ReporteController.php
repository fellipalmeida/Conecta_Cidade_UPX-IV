<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReporteController extends Controller
{
    /**
     * Exibe a lista de todos os reportes (público)
     */
    public function index(Request $request)
    {
        $query = DB::table('reportes')
            ->select('reportes.*', 'users.name as usuario_nome', 'categorias.nome as categoria_nome', 'categorias.icone')
            ->join('users', 'reportes.user_id', '=', 'users.id')
            ->join('categorias', 'reportes.categoria_id', '=', 'categorias.id')
            ->orderBy('reportes.created_at', 'desc');

        // Filtros
        if ($request->filled('status')) {
            $query->where('reportes.status', $request->status);
        }

        if ($request->filled('categoria')) {
            $query->where('reportes.categoria_id', $request->categoria);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('reportes.titulo', 'LIKE', "%{$search}%")
                    ->orWhere('reportes.descricao', 'LIKE', "%{$search}%")
                    ->orWhere('reportes.protocolo', 'LIKE', "%{$search}%");
            });
        }

        // Paginação
        $reportes = $query->paginate(12);

        // Buscar categorias para o filtro
        $categorias = DB::table('categorias')
            ->where('ativo', true)
            ->orderBy('nome')
            ->get();

        // Estatísticas
        $stats = [
            'total' => DB::table('reportes')->count(),
            'pendentes' => DB::table('reportes')->where('status', 'pendente')->count(),
            'em_andamento' => DB::table('reportes')->where('status', 'em_andamento')->count(),
            'resolvidos' => DB::table('reportes')->where('status', 'resolvido')->count(),
        ];

        return view('reportes.index', compact('reportes', 'categorias', 'stats'));
    }

    /**
     * Exibe o formulário de criar reporte
     */
    public function create()
    {
        // Verifica se está logado
        if (!session('user_id')) {
            return redirect()->route('login')
                ->with('error', 'Você precisa estar logado para criar um reporte');
        }

        $categorias = DB::table('categorias')
            ->where('ativo', true)
            ->orderBy('nome')
            ->get();

        return view('reportes.create', compact('categorias'));
    }

    /**
     * Salva um novo reporte
     */
    public function store(Request $request)
    {
        // Verifica se está logado
        if (!session('user_id')) {
            return redirect()->route('login')
                ->with('error', 'Você precisa estar logado');
        }

        // Validação
        $validator = Validator::make($request->all(), [
            'categoria_id' => 'required|exists:categorias,id',
            'titulo' => 'required|string|max:200',
            'descricao' => 'required|string|max:1000',
            'endereco' => 'required|string|max:255',
            'referencia' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // 5MB
        ], [
            'categoria_id.required' => 'Selecione uma categoria',
            'titulo.required' => 'O título é obrigatório',
            'titulo.max' => 'O título deve ter no máximo 200 caracteres',
            'descricao.required' => 'A descrição é obrigatória',
            'descricao.max' => 'A descrição deve ter no máximo 1000 caracteres',
            'endereco.required' => 'O endereço é obrigatório',
            'foto.image' => 'O arquivo deve ser uma imagem',
            'foto.mimes' => 'A imagem deve ser JPG, JPEG ou PNG',
            'foto.max' => 'A imagem deve ter no máximo 5MB',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Gerar protocolo único
            $ano = date('Y');
            $ultimoReporte = DB::table('reportes')
                ->where('protocolo', 'LIKE', "REP-{$ano}-%")
                ->orderBy('id', 'desc')
                ->first();

            if ($ultimoReporte) {
                $ultimoNumero = intval(substr($ultimoReporte->protocolo, -4));
                $novoNumero = $ultimoNumero + 1;
            } else {
                $novoNumero = 1;
            }

            $protocolo = 'REP-' . $ano . '-' . str_pad($novoNumero, 4, '0', STR_PAD_LEFT);

            // Upload da foto
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $fotoNome = time() . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();
                $foto->move(public_path('uploads/reportes'), $fotoNome);
                $fotoPath = 'uploads/reportes/' . $fotoNome;
            }

            // Inserir reporte
            $reporteId = DB::table('reportes')->insertGetId([
                'user_id' => session('user_id'),
                'categoria_id' => $request->categoria_id,
                'titulo' => $request->titulo,
                'descricao' => $request->descricao,
                'endereco' => $request->endereco,
                'referencia' => $request->referencia,
                'foto' => $fotoPath,
                'protocolo' => $protocolo,
                'status' => 'pendente',
                'prioridade' => 'media',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return redirect()->route('reportes.show', $reporteId)
                ->with('success', 'Reporte criado com sucesso! Protocolo: ' . $protocolo);

        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => 'Erro ao criar reporte. Tente novamente.'])
                ->withInput();
        }
    }

    /**
     * Exibe os detalhes de um reporte
     */
    public function show($id)
    {
        $reporte = DB::table('reportes')
            ->select('reportes.*', 'users.name as usuario_nome', 'users.email as usuario_email',
                'categorias.nome as categoria_nome', 'categorias.icone', 'categorias.descricao as categoria_descricao')
            ->join('users', 'reportes.user_id', '=', 'users.id')
            ->join('categorias', 'reportes.categoria_id', '=', 'categorias.id')
            ->where('reportes.id', $id)
            ->first();

        if (!$reporte) {
            return redirect()->route('reportes.index')
                ->with('error', 'Reporte não encontrado');
        }

        // Buscar comentários
        $comentarios = DB::table('comentarios_reportes')
            ->select('comentarios_reportes.*', 'users.name as usuario_nome')
            ->join('users', 'comentarios_reportes.user_id', '=', 'users.id')
            ->where('comentarios_reportes.reporte_id', $id)
            ->orderBy('comentarios_reportes.created_at', 'asc')
            ->get();

        return view('reportes.show', compact('reporte', 'comentarios'));
    }

    /**
     * Adiciona um comentário ao reporte
     */
    public function addComment(Request $request, $id)
    {
        // Verifica se está logado
        if (!session('user_id')) {
            return redirect()->route('login')
                ->with('error', 'Você precisa estar logado');
        }

        $validator = Validator::make($request->all(), [
            'comentario' => 'required|string|max:500'
        ], [
            'comentario.required' => 'O comentário não pode estar vazio',
            'comentario.max' => 'O comentário deve ter no máximo 500 caracteres'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        try {
            DB::table('comentarios_reportes')->insert([
                'reporte_id' => $id,
                'user_id' => session('user_id'),
                'comentario' => $request->comentario,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return back()->with('success', 'Comentário adicionado com sucesso!');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Erro ao adicionar comentário']);
        }
    }

    /**
     * Exibe os reportes do usuário logado
     */
    public function meusReportes()
    {
        if (!session('user_id')) {
            return redirect()->route('login');
        }

        $reportes = DB::table('reportes')
            ->select('reportes.*', 'categorias.nome as categoria_nome', 'categorias.icone')
            ->join('categorias', 'reportes.categoria_id', '=', 'categorias.id')
            ->where('reportes.user_id', session('user_id'))
            ->orderBy('reportes.created_at', 'desc')
            ->paginate(12);

        // Estatísticas do usuário
        $stats = [
            'total' => DB::table('reportes')->where('user_id', session('user_id'))->count(),
            'pendentes' => DB::table('reportes')->where('user_id', session('user_id'))->where('status', 'pendente')->count(),
            'em_andamento' => DB::table('reportes')->where('user_id', session('user_id'))->where('status', 'em_andamento')->count(),
            'resolvidos' => DB::table('reportes')->where('user_id', session('user_id'))->where('status', 'resolvido')->count(),
        ];

        return view('reportes.meus', compact('reportes', 'stats'));
    }

    /**
     * Busca reporte por protocolo
     */
    public function buscarPorProtocolo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'protocolo' => 'required|string'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $reporte = DB::table('reportes')
            ->where('protocolo', 'LIKE', '%' . $request->protocolo . '%')
            ->first();

        if (!$reporte) {
            return back()->with('error', 'Reporte não encontrado com o protocolo informado');
        }

        return redirect()->route('reportes.show', $reporte->id);
    }
}
