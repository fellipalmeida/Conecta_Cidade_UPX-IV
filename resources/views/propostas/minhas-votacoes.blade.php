@extends('layouts.app-sidebar')

@section('page-title', 'Minhas Votações')

@section('styles')
    <style>
        .votacoes-container {
            max-width: 1250px;
            margin: 0 auto;
            padding: 2rem;
            background-color: white;
            border-radius: 15px;
        }
        .page-header {
            margin-bottom: 2rem;
        }
        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
        }
        .propostas-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .proposta-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.2s;
            border-left: 6px solid gray;
        }
        .proposta-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transform: translateY(-3px);
        }
        .proposta-info {
            flex: 1;
        }
        .proposta-title {
            font-size: 1.15rem;
            font-weight: 600;
            color: #1f2937;
            text-decoration: none;
            margin-bottom: 0.5rem;
        }
        .proposta-title:hover {
            color: #2563eb;
        }
        .proposta-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            color: #6b7280;
            font-size: 0.875rem;
        }
        .meu-voto {
            font-size: 1rem;
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            white-space: nowrap;
        }
        .meu-voto.favor {
            background: #f0fdf4;
            color: #10b981;
        }
        .meu-voto.contra {
            background: #fef2f2;
            color: #ef4444;
        }
        .meu-voto.neutro {
            background: #f3f4f6;
            color: #6b7280;
        }

        /* --- RESPONSIVIDADE (NOVO) --- */
        @media (max-width: 768px) {
            .votacoes-container {
                padding: 1rem;
            }
            .proposta-card {
                /* Empilha o conteúdo (info + status do voto) */
                flex-direction: column;
                align-items: flex-start;
            }
            .proposta-info {
                width: 100%;
                margin-bottom: 1rem;
            }
            .proposta-meta {
                /* Garante que os metadados (apoios, neutros, etc.) quebrem bem */
                gap: 0.75rem;
            }
            .proposta-card > div:last-child {
                /* Ajusta o contêiner do voto para ocupar a largura total no mobile */
                width: 100%;
                margin-left: 0;
                text-align: left;
                padding-top: 1rem;
                border-top: 1px solid #f3f4f6;
            }
            .meu-voto {
                /* O badge do voto se ajusta à nova largura */
                display: block;
                width: 100%;
                text-align: center;
            }
        }
    </style>
@endsection

@section('content')
    <div class="votacoes-container">
        <div class="page-header">
            <h1 class="page-title">📝 Minhas Votações</h1>
        </div>

        @if($propostas->count() > 0)
            <div class="propostas-list">
                @foreach($propostas as $proposta)
                    <div class="proposta-card">
                        <div class="proposta-info">
                            <a href="{{ route('propostas.show', $proposta->id) }}" class="proposta-title">
                                {{ $proposta->titulo }}
                            </a>
                            <div class="proposta-meta">
                                <span>Categoria: <strong>{{ $proposta->categoria_nome }}</strong></span>
                                <span>Apoios: <strong>{{ $proposta->votos_a_favor }}</strong></span>
                                <span>Neutros: <strong>{{ $proposta->votos_neutro }}</strong></span>
                                <span>Rejeições: <strong>{{ $proposta->votos_contra }}</strong></span>
                            </div>
                        </div>
                        <div style="margin-left: 1rem;">
                            @if($proposta->tipo_voto == 'a_favor')
                                <span class="meu-voto favor">👍 Você Apoiou</span>
                            @elseif($proposta->tipo_voto == 'contra')
                                <span class="meu-voto contra">👎 Você Não Apoiou</span>
                            @else
                                <span class="meu-voto neutro">😐 Voto Neutro</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            @if($propostas->hasPages())
                <div class="pagination" style="margin-top: 2rem;">
                    {{ $propostas->links() }}
                </div>
            @endif
        @else
            <div style="background: white; padding: 2rem; text-align: center; border-radius: 12px;">
                <h2 style="font-size: 1.2rem; margin-bottom: 0.5rem;">Você ainda não votou</h2>
                <p>Explore as <a href="{{ route('propostas.index') }}">propostas da cidade</a> e dê sua opinião.</p>
            </div>
        @endif
    </div>
@endsection
