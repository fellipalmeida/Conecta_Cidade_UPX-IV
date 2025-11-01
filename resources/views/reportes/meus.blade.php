@extends('layouts.app-sidebar')

@section('styles')
    <style>
        .meus-reportes-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: #6b7280;
            font-size: 1.1rem;
        }

        /* Estatísticas */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.25rem;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            border-top: 3px solid #e5e7eb;
            transition: transform 0.2s;
            text-decoration: none;
        }

        .stat-card:hover {
            transform: translateY(-3px);
        }

        .stat-card.active {
            border-top-color: #2563eb;
            background: #eff6ff;
        }

        .stat-card.pendente {
            border-top-color: #f59e0b;
        }

        .stat-card.em_analise {
            border-top-color: #3b82f6;
        }

        .stat-card.em_andamento {
            border-top-color: #6366f1;
        }

        .stat-card.resolvido {
            border-top-color: #10b981;
        }

        .stat-card.rejeitado {
            border-top-color: #ef4444;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            color: #6b7280;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Filtros e Ações */
        .controls-section {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .filter-tabs {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .filter-tab {
            padding: 0.625rem 1.25rem;
            background: #f3f4f6;
            color: #6b7280;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }

        .filter-tab:hover {
            background: #e5e7eb;
            color: #374151;
        }

        .filter-tab.active {
            background: #2563eb;
            color: white;
        }

        .btn-novo-reporte {
            padding: 0.75rem 1.5rem;
            background: #2563eb;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: background 0.2s;
        }

        .btn-novo-reporte:hover {
            background: #1d4ed8;
        }

        .reportes-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .reporte-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            transition: all 0.2s;
            border-left: 4px solid transparent;
        }

        .reporte-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .reporte-card.pendente {
            border-left-color: #f59e0b;
        }

        .reporte-card.em_analise {
            border-left-color: #3b82f6;
        }

        .reporte-card.em_andamento {
            border-left-color: #6366f1;
        }

        .reporte-card.resolvido {
            border-left-color: #10b981;
        }

        .reporte-card.rejeitado {
            border-left-color: #ef4444;
        }

        .reporte-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .reporte-info {
            flex: 1;
        }

        .reporte-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
            text-decoration: none;
            display: block;
            margin-bottom: 0.5rem;
        }

        .reporte-title:hover {
            color: #2563eb;
        }

        .reporte-meta {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            color: #6b7280;
            font-size: 0.875rem;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .status-badge {
            padding: 0.375rem 0.875rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            white-space: nowrap;
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

        .reporte-descricao {
            color: #4b5563;
            line-height: 1.6;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .reporte-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid #f3f4f6;
        }

        .protocolo-badge {
            background: #f3f4f6;
            color: #374151;
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .reporte-actions {
            display: flex;
            gap: 0.5rem;
        }

        .action-btn {
            padding: 0.5rem 1rem;
            background: #f3f4f6;
            color: #374151;
            border: none;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }

        .action-btn:hover {
            background: #e5e7eb;
        }

        .action-btn.primary {
            background: #2563eb;
            color: white;
        }

        .action-btn.primary:hover {
            background: #1d4ed8;
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

        /* Paginação */
        .pagination {
            margin-top: 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
        }

        .pagination a,
        .pagination span {
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            text-decoration: none;
            color: #6b7280;
            background: white;
            border: 1px solid #e5e7eb;
            transition: all 0.2s;
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

        @media (max-width: 768px) {
            .meus-reportes-container {
                padding: 1rem;
            }

            .stats-container {
                grid-template-columns: repeat(2, 1fr);
            }

            .controls-section {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-tabs {
                width: 100%;
            }

            .filter-tab {
                flex: 1;
                text-align: center;
            }

            .btn-novo-reporte {
                width: 100%;
                justify-content: center;
            }

            .reporte-header {
                flex-direction: column;
            }

            .reporte-footer {
                flex-direction: column;
                gap: 1rem;
            }

            .reporte-actions {
                width: 100%;
            }

            .action-btn {
                flex: 1;
            }
        }
    </style>
@endsection

@section('content')
    <div class="meus-reportes-container">
        <div class="page-header">
            <h1 class="page-title">📋 Meus Reportes</h1>
            <p class="page-subtitle">Acompanhe o status de todos os seus reportes</p>
        </div>

        <div class="stats-container">
            <a href="{{ route('reportes.meus') }}" class="stat-card {{ !request('status') ? 'active' : '' }}">
                <div class="stat-value">{{ $stats['total'] }}</div>
                <div class="stat-label">Total</div>
            </a>

            <a href="{{ route('reportes.meus', ['status' => 'pendente']) }}" class="stat-card pendente {{ request('status') == 'pendente' ? 'active' : '' }}">
                <div class="stat-value">{{ $stats['pendentes'] }}</div>
                <div class="stat-label">Pendentes</div>
            </a>

            <a href="{{ route('reportes.meus', ['status' => 'em_analise']) }}" class="stat-card em_analise {{ request('status') == 'em_analise' ? 'active' : '' }}">
                <div class="stat-value">{{ $stats['em_analise'] }}</div>
                <div class="stat-label">Em Análise</div>
            </a>

            <a href="{{ route('reportes.meus', ['status' => 'em_andamento']) }}" class="stat-card em_andamento {{ request('status') == 'em_andamento' ? 'active' : '' }}">
                <div class="stat-value">{{ $stats['em_andamento'] }}</div>
                <div class="stat-label">Em Andamento</div>
            </a>

            <a href="{{ route('reportes.meus', ['status' => 'resolvido']) }}" class="stat-card resolvido {{ request('status') == 'resolvido' ? 'active' : '' }}">
                <div class="stat-value">{{ $stats['resolvidos'] }}</div>
                <div class="stat-label">Resolvidos</div>
            </a>

            <a href="{{ route('reportes.meus', ['status' => 'rejeitado']) }}" class="stat-card rejeitado {{ request('status') == 'rejeitado' ? 'active' : '' }}">
                <div class="stat-value">{{ $stats['rejeitados'] }}</div>
                <div class="stat-label">Rejeitados</div>
            </a>
        </div>

         <div class="controls-section">
            <div class="filter-tabs">
                <a href="{{ route('reportes.meus') }}" class="filter-tab {{ !request('status') ? 'active' : '' }}">
                    Todos
                </a>
                <a href="{{ route('reportes.meus', ['status' => 'pendente']) }}" class="filter-tab {{ request('status') == 'pendente' ? 'active' : '' }}">
                    Pendentes
                </a>
                <a href="{{ route('reportes.meus', ['status' => 'em_analise']) }}" class="filter-tab {{ request('status') == 'em_analise' ? 'active' : '' }}">
                    Em Análise
                </a>
                <a href="{{ route('reportes.meus', ['status' => 'em_andamento']) }}" class="filter-tab {{ request('status') == 'em_andamento' ? 'active' : '' }}">
                    Em Andamento
                </a>
                <a href="{{ route('reportes.meus', ['status' => 'resolvido']) }}" class="filter-tab {{ request('status') == 'resolvido' ? 'active' : '' }}">
                    Resolvidos
                </a>
                <a href="{{ route('reportes.meus', ['status' => 'rejeitado']) }}" class="filter-tab {{ request('status') == 'rejeitado' ? 'active' : '' }}">
                    Rejeitados
                </a>
            </div>

            <a href="{{ route('reportes.create') }}" class="btn-novo-reporte">
                <span>➕</span>
                <span>Novo Reporte</span>
            </a>
        </div>

        @if($reportes->count() > 0)
            <div class="reportes-list">
                @foreach($reportes as $reporte)
                    <div class="reporte-card {{ $reporte->status }}">
                        <div class="reporte-header">
                            <div class="reporte-info">
                                <a href="{{ route('reportes.show', $reporte->id) }}" class="reporte-title">
                                    {{ $reporte->titulo }}
                                </a>
                                <div class="reporte-meta">
                        <span class="meta-item">
                            <span>{{ $reporte->categoria_icone }}</span>
                            <span>{{ $reporte->categoria_nome }}</span>
                        </span>
                                    <span class="meta-item">
                            <span>📍</span>
                            <span>{{ Str::limit($reporte->localizacao, 30) }}</span>
                        </span>
                                    <span class="meta-item">
                            <span>📅</span>
                            <span>{{ \Carbon\Carbon::parse($reporte->created_at)->format('d/m/Y') }}</span>
                        </span>
                                    <span class="meta-item">
                            <span>💬</span>
                            <span>{{ $reporte->total_comentarios }} comentários</span>
                        </span>
                                </div>
                            </div>
                            <span class="status-badge status-{{ $reporte->status }}">
                    {{ str_replace('_', ' ', $reporte->status) }}
                </span>
                        </div>

                        <p class="reporte-descricao">{{ $reporte->descricao }}</p>

                        <div class="reporte-footer">
                            <span class="protocolo-badge">{{ $reporte->protocolo }}</span>
                            <div class="reporte-actions">
                                <a href="{{ route('reportes.show', $reporte->id) }}" class="action-btn primary">
                                    Ver Detalhes
                                </a>
                                <button class="action-btn" onclick="copiarProtocolo('{{ $reporte->protocolo }}')">
                                    📋 Copiar
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($reportes->hasPages())
                <div class="pagination">
                    {{ $reportes->links() }}
                </div>
            @endif

        @else
            <div class="empty-state">
                <div class="empty-icon">📭</div>
                <h2 class="empty-title">
                    @if(request('status'))
                        Nenhum reporte {{ str_replace('_', ' ', request('status')) }}
                    @else
                        Você ainda não criou nenhum reporte
                    @endif
                </h2>
                <p class="empty-text">
                    @if(request('status'))
                        Não há reportes com o status selecionado.
                    @else
                        Comece relatando um problema em sua cidade e ajude a melhorar nossa comunidade!
                    @endif
                </p>
                <a href="{{ route('reportes.create') }}" class="btn-novo-reporte">
                    <span>➕</span>
                    <span>Criar Primeiro Reporte</span>
                </a>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        function copiarProtocolo(protocolo) {
            navigator.clipboard.writeText(protocolo).then(function() {
                alert('Protocolo copiado: ' + protocolo);
            }, function(err) {
                console.error('Erro ao copiar protocolo: ', err);
            });
        }
    </script>
@endsection
