@extends('layouts.app-sidebar')

@section('styles')
    <style>
        .reportes-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }

        .page-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: #6b7280;
            font-size: 1.2rem;
        }

        /* Busca por Protocolo */
        .protocolo-search {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            padding: 2rem;
            border-radius: 16px;
            margin-bottom: 3rem;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .protocolo-search-title {
            color: white;
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
            text-align: center;
        }

        .protocolo-form {
            display: flex;
            gap: 1rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .protocolo-input {
            flex: 1;
            padding: 0.875rem 1.25rem;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
        }

        .protocolo-input:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.3);
        }

        .protocolo-btn {
            padding: 0.875rem 2rem;
            background: white;
            color: #2563eb;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .protocolo-btn:hover {
            background: #f3f4f6;
            transform: translateY(-2px);
        }

        /* Filtros */
        .filters-section {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .filters-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .filters-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1f2937;
        }

        .clear-filters {
            color: #6b7280;
            text-decoration: none;
            font-size: 0.875rem;
        }

        .clear-filters:hover {
            color: #2563eb;
        }

        .filters-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
        }

        .filter-label {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 0.5rem;
        }

        .filter-select,
        .filter-input {
            padding: 0.625rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.875rem;
            background: white;
        }

        .filter-select:focus,
        .filter-input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .filter-btn {
            padding: 0.625rem 1.5rem;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
            align-self: flex-end;
        }

        .filter-btn:hover {
            background: #1d4ed8;
        }

        /* Grid de Reportes */
        .reportes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
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
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .reporte-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .no-image {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: white;
        }

        .reporte-content {
            padding: 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .reporte-categoria {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 0.75rem;
        }

        .reporte-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1f2937;
            text-decoration: none;
            margin-bottom: 0.5rem;
            line-height: 1.4;
        }

        .reporte-title:hover {
            color: #2563eb;
        }

        .reporte-description {
            color: #6b7280;
            font-size: 0.875rem;
            line-height: 1.6;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            flex: 1;
        }

        .reporte-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid #f3f4f6;
        }

        .meta-info {
            display: flex;
            gap: 1rem;
            font-size: 0.75rem;
            color: #9ca3af;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .status-badge {
            padding: 0.25rem 0.625rem;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pendente {
            background: #fef3c7;
            color: #92400e;
        }

        .status-em_analise {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-em_andamento {
            background: #e0e7ff;
            color: #3730a3;
        }

        .status-resolvido {
            background: #d1fae5;
            color: #065f46;
        }

        .status-rejeitado {
            background: #fee2e2;
            color: #991b1b;
        }

        .urgencia-indicator {
            position: absolute;
            top: 1rem;
            right: 1rem;
            padding: 0.375rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            background: white;
        }

        .urgencia-alta {
            color: #dc2626;
            box-shadow: 0 2px 8px rgba(220, 38, 38, 0.2);
        }

        .urgencia-media {
            color: #f59e0b;
            box-shadow: 0 2px 8px rgba(245, 158, 11, 0.2);
        }

        .urgencia-baixa {
            color: #10b981;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.2);
        }

        /* Estado Vazio */
        .empty-state {
            background: white;
            border-radius: 12px;
            padding: 4rem 2rem;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
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

        .btn-criar-reporte {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.875rem 1.75rem;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-criar-reporte:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
        }

        /* Paginação */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
        }

        .pagination a,
        .pagination span {
            padding: 0.5rem 0.875rem;
            border-radius: 8px;
            text-decoration: none;
            color: #6b7280;
            background: white;
            border: 1px solid #e5e7eb;
            transition: all 0.2s;
            font-size: 0.875rem;
        }

        .pagination a:hover {
            background: #f3f4f6;
            border-color: #d1d5db;
        }

        .pagination .active {
            background: #2563eb;
            color: white;
            border-color: #2563eb;
        }

        @media (max-width: 1024px) {
            .reportes-grid {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .reportes-container {
                padding: 1rem;
            }

            .page-title {
                font-size: 2rem;
            }

            .protocolo-form {
                flex-direction: column;
            }

            .filters-content {
                grid-template-columns: 1fr;
            }

            .reportes-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')
    <div class="reportes-container">
        <!-- Header -->
        <div class="page-header">
            <h1 class="page-title">🌆 Reportes da Cidade</h1>
            <p class="page-subtitle">Veja todos os problemas reportados pela comunidade</p>
        </div>

        <!-- Busca por Protocolo -->
        <div class="protocolo-search">
            <h2 class="protocolo-search-title">🔍 Buscar por Protocolo</h2>
            <form action="{{ route('reportes.buscar') }}" method="POST" class="protocolo-form">
                @csrf
                <input type="text"
                       name="protocolo"
                       class="protocolo-input"
                       placeholder="Digite o protocolo do reporte..."
                       required>
                <button type="submit" class="protocolo-btn">Buscar</button>
            </form>
        </div>

        <!-- Filtros -->
        <div class="filters-section">
            <div class="filters-header">
                <h3 class="filters-title">🎯 Filtros</h3>
                @if(request()->hasAny(['categoria', 'status', 'busca']))
                    <a href="{{ route('reportes.index') }}" class="clear-filters">Limpar filtros</a>
                @endif
            </div>

            <form action="{{ route('reportes.index') }}" method="GET" class="filters-content">
                <div class="filter-group">
                    <label class="filter-label">Categoria</label>
                    <select name="categoria" class="filter-select">
                        <option value="">Todas</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ request('categoria') == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label">Status</label>
                    <select name="status" class="filter-select">
                        <option value="">Todos</option>
                        <option value="pendente" {{ request('status') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                        <option value="em_analise" {{ request('status') == 'em_analise' ? 'selected' : '' }}>Em Análise</option>
                        <option value="em_andamento" {{ request('status') == 'em_andamento' ? 'selected' : '' }}>Em Andamento</option>
                        <option value="resolvido" {{ request('status') == 'resolvido' ? 'selected' : '' }}>Resolvido</option>
                        <option value="rejeitado" {{ request('status') == 'rejeitado' ? 'selected' : '' }}>Rejeitado</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label">Buscar</label>
                    <input type="text"
                           name="busca"
                           class="filter-input"
                           placeholder="Título, descrição ou local..."
                           value="{{ request('busca') }}">
                </div>

                <button type="submit" class="filter-btn">Aplicar Filtros</button>
            </form>
        </div>

        <!-- Lista de Reportes -->
        @if($reportes->count() > 0)
            <div class="reportes-grid">
                @foreach($reportes as $reporte)
                    <div class="reporte-card">
                        @if($reporte->imagem)
                            <img src="{{ asset($reporte->imagem) }}" alt="{{ $reporte->titulo }}" class="reporte-image">
                        @else
                            <div class="reporte-image no-image">
                                {{ $reporte->categoria_icone }}
                            </div>
                        @endif

                        @if($reporte->urgencia == 'alta')
                            <span class="urgencia-indicator urgencia-alta">🔴 Urgente</span>
                        @elseif($reporte->urgencia == 'media')
                            <span class="urgencia-indicator urgencia-media">🟡 Médio</span>
                        @endif

                        <div class="reporte-content">
                            <div class="reporte-categoria">
                                <span>{{ $reporte->categoria_icone }}</span>
                                <span>{{ $reporte->categoria_nome }}</span>
                            </div>

                            <a href="{{ route('reportes.show', $reporte->id) }}" class="reporte-title">
                                {{ $reporte->titulo }}
                            </a>

                            <p class="reporte-description">{{ $reporte->descricao }}</p>

                            <div class="reporte-meta">
                                <div class="meta-info">
                        <span class="meta-item">
                            <span>📍</span>
                            <span>{{ Str::limit($reporte->localizacao, 20) }}</span>
                        </span>
                                    <span class="meta-item">
                            <span>💬</span>
                            <span>{{ $reporte->total_comentarios }}</span>
                        </span>
                                </div>
                                <span class="status-badge status-{{ $reporte->status }}">
                        {{ str_replace('_', ' ', $reporte->status) }}
                    </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Paginação -->
            @if($reportes->hasPages())
                <div class="pagination">
                    {{ $reportes->links() }}
                </div>
            @endif

        @else
            <!-- Estado Vazio -->
            <div class="empty-state">
                <div class="empty-icon">🔍</div>
                <h2 class="empty-title">Nenhum reporte encontrado</h2>
                <p class="empty-text">
                    @if(request()->hasAny(['categoria', 'status', 'busca']))
                        Tente ajustar os filtros ou realizar uma nova busca.
                    @else
                        Seja o primeiro a reportar um problema em nossa cidade!
                    @endif
                </p>
                @if(session('user_id'))
                    <a href="{{ route('reportes.create') }}" class="btn-criar-reporte">
                        <span>➕</span>
                        <span>Criar Reporte</span>
                    </a>
                @endif
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        // Auto-submit dos filtros quando mudarem (opcional)
        document.querySelectorAll('.filter-select').forEach(select => {
            select.addEventListener('change', function() {
                // Você pode descomentar a linha abaixo se quiser que os filtros sejam aplicados automaticamente
                // this.closest('form').submit();
            });
        });
    </script>
@endsection
