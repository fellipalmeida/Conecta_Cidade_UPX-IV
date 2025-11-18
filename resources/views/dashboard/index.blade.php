@extends('layouts.app-sidebar')

@section('styles')
    <style>
        .dashboard-container {
            max-width: 1250px;
            margin: 0 auto;
            padding: 2rem;
            background-color: white;
            border-radius: 15px;
        }

        .welcome-section {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            color: white;
            padding: 2rem;
            border-radius: 16px;
            margin-bottom: 2rem;
        }

        .welcome-section h1 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .welcome-section p {
            opacity: 0.9;
            font-size: 1.1rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #2563eb;
        }

        .stat-card.success {
            border-left-color: #10b981;
        }

        .stat-card.warning {
            border-left-color: #f59e0b;
        }

        .stat-card.info {
            border-left-color: #3b82f6;
        }

        .stat-label {
            color: #6b7280;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #1f2937;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f3f4f6;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #1f2937;
        }

        .card-link {
            color: #2563eb;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .card-link:hover {
            text-decoration: underline;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #9ca3af;
        }

        .empty-state-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .reporte-item,
        .proposta-item,
        .atividade-item {
            padding: 1rem;
            border-bottom: 1px solid #f3f4f6;
            transition: background 0.2s;
        }

        .reporte-item:last-child,
        .proposta-item:last-child,
        .atividade-item:last-child {
            border-bottom: none;
        }

        .reporte-item:hover,
        .atividade-item:hover {
            background: #f9fafb;
        }

        .reporte-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 0.5rem;
        }

        .reporte-title {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.25rem;
        }

        .reporte-meta {
            font-size: 0.85rem;
            color: #6b7280;
            display: flex;
            gap: 1rem;
            align-items: center;
            /* Permite quebra de linha para mobile */
            flex-wrap: wrap;
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

        .proposta-card {
            background: #f9fafb;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .proposta-title {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .proposta-status {
            font-size: 0.85rem;
            color: #6b7280;
            margin-bottom: 0.75rem;
        }

        .vote-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
            margin-top: 0.5rem;
        }

        .vote-favoravel {
            background: #d1fae5;
            color: #065f46;
        }

        .vote-contrario {
            background: #fee2e2;
            color: #991b1b;
        }

        .vote-neutro {
            background: #e5e7eb;
            color: #374151;
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 3rem;
        }

        .action-btn {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.25rem;
            background: white;
            border-radius: 12px;
            text-decoration: none;
            color: #1f2937;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
        }

        .action-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .action-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #2563eb, #1e40af);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .action-text h3 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .action-text p {
            font-size: 0.85rem;
            color: #6b7280;
        }

        /* --- MEDIA QUERIES PARA RESPONSIVIDADE --- */

        /* 968px e abaixo: Tablet para Mobile Grande */
        @media (max-width: 968px) {
            /* Faz as duas colunas principais se empilharem */
            .content-grid {
                grid-template-columns: 1fr;
            }
        }

        /* 768px e abaixo: Celular Grande */
        @media (max-width: 768px) {
            .dashboard-container {
                padding: 1rem; /* Reduz o padding */
            }

            /* Stats grid: 4 colunas -> 2 colunas */
            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }

            /* Quick actions: auto-fit com minmax já ajuda, mas forçamos 1 coluna aqui */
            .quick-actions {
                grid-template-columns: 1fr;
            }

            /* Ajuste para Atividades Recentes e Meus Últimos Reportes */
            .reporte-header {
                flex-direction: column; /* Empilha os itens (info + badge) */
                align-items: flex-start;
                gap: 0.5rem;
            }
        }

        /* 500px e abaixo: Celular Pequeno (força stats grid a empilhar totalmente) */
        @media (max-width: 500px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')
    <div class="dashboard-container" >

        <div class="page-header" style="margin-bottom: 40px;">
            <h1 class="page-title" style="font-size: 35px">🏠 Dashboard</h1>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Meus Reportes</div>
                <div class="stat-value">{{ $stats['total_reportes'] }}</div>
            </div>
            <div class="stat-card warning">
                <div class="stat-label">Pendentes</div>
                <div class="stat-value">{{ $stats['reportes_pendentes'] }}</div>
            </div>
            <div class="stat-card success">
                <div class="stat-label">Resolvidos</div>
                <div class="stat-value">{{ $stats['reportes_resolvidos'] }}</div>
            </div>
            <div class="stat-card info">
                <div class="stat-label">Votos Dados</div>
                <div class="stat-value">{{ $stats['total_votos'] }}</div>
            </div>
        </div>

        <h2 class="section-title">Ações Rápidas</h2>
        <div class="quick-actions">
            <a href="{{ route('reportes.create') }}" class="action-btn">
                <div class="action-icon">📍</div>
                <div class="action-text">
                    <h3>Novo Reporte</h3>
                    <p>Relate um problema urbano</p>
                </div>
            </a>
            <a href="{{ route('propostas.index') }}" class="action-btn">
                <div class="action-icon">🗳️</div>
                <div class="action-text">
                    <h3>Ver Propostas</h3>
                    <p>Vote em propostas ativas</p>
                </div>
            </a>
            <a href="{{ route('reportes.meus') }}" class="action-btn">
                <div class="action-icon">📋</div>
                <div class="action-text">
                    <h3>Meus Reportes</h3>
                    <p>Acompanhe seus reportes</p>
                </div>
            </a>
            <a href="{{ route('propostas.minhas-votacoes') }}" class="action-btn">
                <div class="action-icon">✓</div>
                <div class="action-text">
                    <h3>Minhas Votações</h3>
                    <p>Veja onde você votou</p>
                </div>
            </a>
        </div>

        <div class="content-grid">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Meus Últimos Reportes</h2>
                    <a href="{{ route('reportes.meus') }}" class="card-link">Ver todos &rarr;</a>
                </div>

                @if($ultimosReportes->count() > 0)
                    @foreach($ultimosReportes as $reporte)
                        <div class="reporte-item">
                            <div class="reporte-header">
                                <div>
                                    <a href="{{ route('reportes.show', $reporte->id) }}" class="reporte-title">
                                        {{ $reporte->titulo }}
                                    </a>
                                    <div class="reporte-meta">
                                        <span>{{ $reporte->categoria_nome }}</span>
                                        <span>&bull;</span>
                                        <span>{{ \Carbon\Carbon::parse($reporte->created_at)->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                                <span class="badge badge-{{ $reporte->status }}">
                                {{ str_replace('_', ' ', $reporte->status) }}
                            </span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">📭</div>
                        <p>Você ainda não criou nenhum reporte</p>
                        <a href="{{ route('reportes.create') }}" class="btn btn-primary" style="margin-top: 1rem;">Criar Primeiro Reporte</a>
                    </div>
                @endif
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Propostas em Votação</h2>
                    <a href="{{ route('propostas.index') }}" class="card-link">Ver todas &rarr;</a>
                </div>

                @if($propostasEmVotacao->count() > 0)
                    @foreach($propostasEmVotacao as $proposta)
                        <div class="proposta-card">
                            <a href="{{ route('propostas.show', $proposta->id) }}" class="proposta-title">
                                {{ $proposta->titulo }}
                            </a>
                            <div class="proposta-status">
                                {{ $proposta->localizacao }}
                            </div>
                            @if($proposta->usuario_votou)
                                <span class="vote-badge vote-{{ $proposta->usuario_votou }}">
                                ✓ Você votou: {{ ucfirst($proposta->usuario_votou) }}
                            </span>
                            @else
                                <a href="{{ route('propostas.show', $proposta->id) }}" class="btn btn-primary" style="width: 100%; margin-top: 0.5rem; padding: 0.5rem;">
                                    Votar Agora
                                </a>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">🗳️</div>
                        <p>Nenhuma proposta em votação no momento</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Atividades Recentes da Comunidade</h2>
                <a href="{{ route('reportes.index') }}" class="card-link">Ver todos os reportes &rarr;</a>
            </div>

            @if($atividadesRecentes->count() > 0)
                @foreach($atividadesRecentes as $atividade)
                    <div class="atividade-item">
                        <div class="reporte-header">
                            <div>
                                <a href="{{ route('reportes.show', $atividade->id) }}" class="reporte-title">
                                    {{ $atividade->titulo }}
                                </a>
                                <div class="reporte-meta">
                                    <span>Por {{ $atividade->usuario_nome }}</span>
                                    <span>&bull;</span>
                                    <span>{{ $atividade->categoria_nome }}</span>
                                    <span>&bull;</span>
                                    <span>{{ \Carbon\Carbon::parse($atividade->created_at)->diffForHumans() }}</span>
                                </div>
                            </div>
                            <span class="badge badge-{{ $atividade->status }}">
                            {{ str_replace('_', ' ', $atividade->status) }}
                        </span>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">🌆</div>
                    <p>Nenhuma atividade recente</p>
                </div>
            @endif
        </div>
    </div>
@endsection
