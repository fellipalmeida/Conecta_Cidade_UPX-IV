@extends('layouts.app-sidebar')

@section('page-title', $proposta->titulo)

@section('styles')
    <style>
        .proposta-container {
            max-width: 1250px;
            margin: 0 auto;
            padding: 2rem;
        }
        .card {
            background: white;
            border-radius: 12px;
            padding: 1.75rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
        }
        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #f3f4f6;
        }
        .proposta-header {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }
        .proposta-categoria {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            color: #6b7280;
            margin-bottom: 1rem;
        }
        .proposta-title {
            font-size: 2.25rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 1rem;
            line-height: 1.2;
        }
        .proposta-meta {
            color: #6b7280;
            font-size: 0.9rem;
        }
        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
        }
        .content-grid > .sidebar {
            position: static;
            top: auto;
        }
        .main-content {
            display: flex;
            flex-direction: column;
            gap: 0;
        }
        .sidebar .card {
            margin-bottom: 2rem;
        }
        .descricao-text {
            color: #374151;
            line-height: 1.7;
            white-space: pre-wrap;
            font-size: 1rem;
        }

        /* Votação */
        .votos-barra-container {
            width: 100%;
            background: #f3f4f6;
            height: 16px;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 1rem;
        }
        .votos-barra {
            height: 100%;
            background: #10b981;
            transition: width 0.3s ease;
        }
        .votos-totais {
            display: flex;
            justify-content: space-between;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }
        .votos-favor {
            font-weight: 600;
            color: #10b981;
        }
        .votos-contra {
            font-weight: 600;
            color: #ef4444;
        }
        .votos-neutro {
            font-weight: 600;
            color: #6b7280;
        }

        .botoes-voto {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }
        .btn-voto {
            padding: 10px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            border: 2px solid #e5e7eb;
            background: #f9fafb;
            transition: all 0.2s;
            text-align: center;
            font-size: 0.9rem;
        }

        .btn-voto:hover {
            border-color: #d1d5db;
        }

        .btn-voto.favor {
            color: #10b981;
        }
        .btn-voto.favor:hover, .btn-voto.favor.active {
            background: #f0fdf4;
            border-color: #10b981;
        }

        .btn-voto.contra {
            color: #ef4444;
        }
        .btn-voto.contra:hover, .btn-voto.contra.active {
            background: #fef2f2;
            border-color: #ef4444;
        }

        .btn-voto.neutro {
            color: #6b7280;
        }
        .btn-voto.neutro:hover, .btn-voto.neutro.active {
            background: #f3f4f6;
            border-color: #6b7280;
        }

        .btn-remover-voto {
            width: 100%;
            background: none;
            border: none; color: #6b7280;
            font-size: 0.875rem;
            cursor: pointer;
            text-decoration: underline;
        }
        .btn-remover-voto:hover {
            color: #1f2937;
        }

        .localizacao-text {
            color: #374151;
            display: flex;
            gap: 0.5rem;
            font-size: 0.95rem; }

        .comentario-form {
            margin-bottom:
                1.5rem;
        }
        .comentario-textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            min-height: 100px;
        }
        .btn-comentar {
            margin-top: 1rem;
            padding: 0.75rem 1.5rem;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }
        .comentarios-list {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        .comentario-item {
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #f3f4f6;
        }
        .comentario-item:last-child {
            border-bottom: none;
        }
        .comentario-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }
        .comentario-author {
            font-weight: 600;
            color: #1f2937;
        }
        .comentario-date {
            color: #9ca3af;
            font-size: 0.875rem;
        }
        .comentario-text {
            color: #374151;
            line-height: 1.6;
        }
        .alert-info {
            background: #f0f9ff;
            color: #026aa2;
            border: 1px solid #bae6fd;
            padding: 1rem;
            border-radius: 8px;
        }

        @media (max-width: 968px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
            .botoes-voto {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')
    <div class="proposta-container">
        <div class="proposta-header">

            <h1 class="proposta-title">{{ $proposta->titulo }}</h1>
            <div class="proposta-categoria">
            <div >
                <span >{{ $proposta->categoria_icone }}</span>
                <span>{{ $proposta->categoria_nome }}</span>
            </div>
                <p class="proposta-meta">|</p>
            <p class="proposta-meta">
                Proposto por <strong>{{ $proposta->usuario_nome }}</strong> em {{ \Carbon\Carbon::parse($proposta->created_at)->format('d/m/Y') }}
            </p>
            </div>
        </div>

        <div class="content-grid">
            <div class="">
                <div class="card">
                    <h2 class="card-title">Detalhes da Proposta</h2>
                    <div class="descricao-text">{{ $proposta->descricao }}</div>
                </div>

                <div class="card">
                    <h2 class="card-title">Discussão ({{ $comentarios->count() }})</h2>
                    @if(session('user_id'))
                        <form action="{{ route('propostas.comentar', $proposta->id) }}" method="POST" class="comentario-form">
                            @csrf
                            <textarea name="comentario" class="comentario-textarea" placeholder="Participe da discussão..." required></textarea>
                            <button type="submit" class="btn-comentar">Enviar Comentário</button>
                        </form>
                    @else
                        <div class="alert-info">
                            <a href="{{ route('login') }}">Faça login</a> para votar ou comentar.
                        </div>
                    @endif
                    @if($comentarios->count() > 0)
                        <div class="comentarios-list">
                            @foreach($comentarios as $comentario)
                                <div class="comentario-item">
                                    <div class="comentario-header">
                                        <span class="comentario-author">{{ $comentario->usuario_nome }}</span>
                                        <span class="comentario-date">{{ \Carbon\Carbon::parse($comentario->created_at)->diffForHumans() }}</span>
                                    </div>
                                    <p class="comentario-text">{{ $comentario->comentario }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div>
                <div class="card">
                    <h3 class="card-title">Votação</h3>
                    @php
                        $totalVotos = $proposta->votos_a_favor + $proposta->votos_contra + $proposta->votos_neutro;
                        $percentFavor = ($totalVotos > 0) ? ($proposta->votos_a_favor / $totalVotos) * 100 : 0;
                    @endphp
                    <div class="votos-barra-container">
                        <div class="votos-barra" style="width: {{ $percentFavor }}%"></div>
                    </div>
                    <div class="votos-totais">
                        <span class="votos-favor">👍 {{ $proposta->votos_a_favor }}</span>
                        <span class="votos-neutro">😐 {{ $proposta->votos_neutro }}</span>
                        <span class="votos-contra">👎 {{ $proposta->votos_contra }}</span>
                    </div>

                    @if(session('user_id'))
                        <div class="botoes-voto">
                            <form action="{{ route('propostas.votar', $proposta->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="tipo_voto" value="a_favor">
                                <button type="submit" class="btn-voto favor {{ $meuVoto && $meuVoto->tipo_voto == 'a_favor' ? 'active' : '' }}">
                                    Apoiar
                                </button>
                            </form>
                            <form action="{{ route('propostas.votar', $proposta->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="tipo_voto" value="neutro">
                                <button type="submit" class="btn-voto neutro {{ $meuVoto && $meuVoto->tipo_voto == 'neutro' ? 'active' : '' }}">
                                    Neutro
                                </button>
                            </form>
                            <form action="{{ route('propostas.votar', $proposta->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="tipo_voto" value="contra">
                                <button type="submit" class="btn-voto contra {{ $meuVoto && $meuVoto->tipo_voto == 'contra' ? 'active' : '' }}">
                                    Não Apoiar
                                </button>
                            </form>
                        </div>
                        @if($meuVoto)
                            <form action="{{ route('propostas.remover-voto', $proposta->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-remover-voto">Remover meu voto</button>
                            </form>
                        @endif
                    @else
                        <p style="font-size: 0.9rem; text-align: center; color: #6b7280;">
                            <a href="{{ route('login') }}">Faça login</a> para votar.
                        </p>
                    @endif
                </div>

                @if($proposta->localizacao)
                    <div class="card">
                        <h3 class="card-title">Localização</h3>
                        <div class="localizacao-text">
                            <span>📍</span>
                            <span>{{ $proposta->localizacao }}</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
