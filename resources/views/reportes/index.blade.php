@extends('layouts.app')

@section('title', 'Reportes - Conecta Cidade')

@section('styles')
    <style>
        .page-header {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            color: white;
            padding: 3rem 2rem;
            border-radius: 16px;
            margin-bottom: 2rem;
            text-align: center;
        }

        .page-header h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .page-header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .stats-bar {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-item {
            background: white;
            padding: 1.25rem;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #2563eb;
        }

        .stat-label {
            color: #6b7280;
            font-size: 0.9rem;
            margin-top: 0.25rem;
        }

        .filters-section {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .filters-form {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr auto;
            gap: 1rem;
            align-items: end;
        }

        .form-group-inline {
            display: flex;
            flex-direction: column;
        }

        .form-label-inline {
            font-size: 0.9rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .form-input-inline {
            padding: 0.75rem;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 1rem;
        }

        .form-input-inline:focus {
            outline: none;
            border-color: #2563eb;
        }

        .btn-filter {
            padding: 0.75rem 1.5rem;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-filter:hover {
            background: #1e40af;
        }

        .btn-clear {
            padding: 0.75rem 1.5rem;
            background: #6b7280;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-clear:hover {
            background: #4b5563;
        }

        .reportes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .reporte-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
            display: flex;
            flex-direction: column;
        }

        .reporte-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.15);
        }

        .reporte-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: #9ca3af;
        }

        .reporte-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .reporte-content {
            padding: 1.25rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .reporte-header-card {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.75rem;
        }

        .reporte-category {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.25rem 0.75rem;
            background: #eff6ff;
            color: #1e40af;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .badge {
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-pendente {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-em_analise {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-em_andamento {
            background: #e0e7ff;
            color: #3730a3;
        }

        .badge-resolvido {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-rejeitado {
            background: #fee2e2;
            color: #991b1b;
        }

        .reporte-title-card {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .reporte-description {
            color: #6b7280;
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            flex: 1;
        }

        .reporte-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid #f3f4f6;
        }

        .reporte-meta {
            font-size: 0.85rem;
            color: #9ca3af;
        }

        .reporte-user {
            font-weight: 500;
            color: #6b7280;
        }

        .reporte-link {
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .reporte-link:hover {
            text-decoration: underline;
        }

        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
        }

        .pagination {
            display: flex;
            gap: 0.5rem;
            list-style: none;
        }

        .pagination a,
        .pagination span {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            text-decoration: none;
            color: #374151;
            background: white;
            border: 1px solid #e5e7eb;
        }

        .pagination a:hover {
            background: #f3f4f6;
        }

        .pagination .active span {
            background: #2563eb;
            color: white;
            border-color: #2563eb;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .empty-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .empty-text {
            color: #6b7280;
            margin-bottom: 1.5rem;
        }

        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 1.75rem;
            }

            .filters-form {
                grid-template-columns: 1fr;
            }

            .reportes-grid {
                grid-template-columns: 1fr;
            }

            .stats-bar {
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Page Header -->
    <div class="page-header">
        <h1>📍 Reportes da Comunidade</h1>
        <p>Veja os problemas reportados pela comunidade e acompanhe as soluções</p>
    </div>

    <!-- Stats Bar -->
    <div class="stats-bar">
        <div class="stat-item">
            <div class="stat-number">{{ $stats['total'] }}</div>
            <div class="stat-label">Total de Reportes</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $stats['pendentes'] }}</div>
            <div class="stat-label">Pendentes</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $stats['em_andamento'] }}</div>
            <div class="stat-label">Em Andamento</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $stats['resolvidos'] }}</div>
            <div class="stat-label">Resolvidos</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filters-section">
        <form action="{{ route('reportes.index') }}" method="GET" class="filters-form">
            <div class="form-group-inline">
                <label class="form-label-inline">Buscar</label>
                <input
                    type="text"
                    name="search"
                    class="form-input-inline"
                    placeholder="Buscar por título, descrição ou protocolo..."
                    value="{{ request('search') }}"
                >
            </div>

            <div class="form-group-inline">
                <label class="form-label-inline">Categoria</label>
                <select name="categoria" class="form-input-inline">
                    <option value="">Todas</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ request('categoria') == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group-inline">
                <label class="form-label-inline">Status</label>
                <select name="status" class="form-input-inline">
                    <option value="">Todos</option>
                    <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                    <option value="em_analise" {{ request('status') == 'em_analise' ? 'selected' : '' }}>Em Análise</option>
                    <option value="em_andamento" {{ request('status') == 'em_andamento' ? 'selected' : '' }}>Em Andamento</option>
                    <option value="resolvido" {{ request('status') == 'resolvido' ? 'selected' : '' }}>Resolvido</option>
                    <option value="rejeitado" {{ request('status') == 'rejeitado' ? 'selected' : '' }}>Rejeitado</option>
                </select>
            </div>

            <button type="submit" class="btn-filter">Filtrar</button>

            @if(request()->hasAny(['search', 'categoria', 'status']))
                <a href="{{ route('reportes.index') }}" class="btn-clear">Limpar</a>
            @endif
        </form>
    </div>

    <!-- Reportes Grid -->
    @if($reportes->count() > 0)
        <div class="reportes-grid">
            @foreach($reportes as $reporte)
                <div class="reporte-card">
                    <div class="reporte-image">
                        @if($reporte->foto)
                            <img src="{{ asset($reporte->foto) }}" alt="{{ $reporte->titulo }}">
                        @else
                            📷
                        @endif
                    </div>

                    <div class="reporte-content">
                        <div class="reporte-header-card">
                        <span class="reporte-category">
                            {{ $reporte->icone }} {{ $reporte->categoria_nome }}
                        </span>
                            <span class="badge badge-{{ $reporte->status }}">
                            {{ str_replace('_', ' ', $reporte->status) }}
                        </span>
                        </div>

                        <h3 class="reporte-title-card">
                            {{ $reporte->titulo }}
                        </h3>

                        <p class="reporte-description">
                            {{ $reporte->descricao }}
                        </p>

                        <div class="reporte-footer">
                            <div class="reporte-meta">
                                <div class="reporte-user">Por {{ $reporte->usuario_nome }}</div>
                                <div>{{ \Carbon\Carbon::parse($reporte->created_at)->format('d/m/Y') }}</div>
                            </div>
                            <a href="{{ route('reportes.show', $reporte->id) }}" class="reporte-link">
                                Ver detalhes →
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="pagination-wrapper">
            {{ $reportes->links() }}
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">🔍</div>
            <h2 class="empty-title">Nenhum reporte encontrado</h2>
            <p class="empty-text">
                @if(request()->hasAny(['search', 'categoria', 'status']))
                    Tente ajustar os filtros de busca
                @else
                    Seja o primeiro a reportar um problema na sua cidade!
                @endif
            </p>
            @if(session('user_id'))
                <a href="{{ route('reportes.create') }}" class="btn btn-primary">Criar Primeiro Reporte</a>
            @else
                <a href="{{ route('register') }}" class="btn btn-primary">Cadastre-se para Reportar</a>
            @endif
        </div>
    @endif
@endsection
