@extends('layouts.app-sidebar')

@section('page-title', 'Propostas da Cidade')

@section('styles')
    <style>
        .propostas-container { max-width: 1200px; margin: 0 auto; padding: 2rem; }
        .page-header { margin-bottom: 2rem; }
        .page-title { font-size: 2rem; font-weight: 700; color: #1f2937; }
        .header-actions { margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center; }
        .propostas-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.5rem; }
        .proposta-card { background: white; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); display: flex; flex-direction: column; transition: all 0.2s; }
        .proposta-card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1); }
        .proposta-content { padding: 1.5rem; flex: 1; }
        .proposta-categoria { display: inline-flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; color: #6b7280; margin-bottom: 0.75rem; }
        .proposta-title { font-size: 1.25rem; font-weight: 600; color: #1f2937; text-decoration: none; margin-bottom: 0.75rem; }
        .proposta-title:hover { color: #2563eb; }
        .proposta-descricao { color: #6b7280; font-size: 0.9rem; line-height: 1.6; margin-bottom: 1rem; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; flex: 1; }
        .proposta-footer { padding: 1rem 1.5rem; border-top: 1px solid #f3f4f6; display: flex; justify-content: space-between; align-items: center; }
        .proposta-votos { display: flex; gap: 1rem; font-size: 0.9rem; font-weight: 500; }
        .votos-favor { color: #10b981; }
        .votos-contra { color: #ef4444; }
        .votos-neutro { color: #6b7280; }
        .proposta-comentarios { font-size: 0.9rem; color: #6b7280; }
        .pagination { margin-top: 2rem; }
    </style>
@endsection

@section('content')
    <div class="propostas-container">
        <div class="page-header">
            <h1 class="page-title">Propostas da Cidade</h1>
        </div>

        <div class="header-actions">
            <p style="color: #6b7280;">Veja e vote em propostas de melhoria urbana.</p>
            <a href="{{ route('propostas.create') }}" class="btn btn-primary">
                <span>➕</span>
                <span>Criar Proposta</span>
            </a>
        </div>

        @if($propostas->count() > 0)
            <div class="propostas-grid">
                @foreach($propostas as $proposta)
                    <div class="proposta-card">
                        <div class="proposta-content">
                            <div class="proposta-categoria">
                                <span>{{ $proposta->categoria_icone }}</span>
                            </div>
                            <a href="{{ route('propostas.show', $proposta->id) }}" class="proposta-title">
                                {{ $proposta->titulo }}
                            </a>
                            <p class="proposta-descricao">{{ $proposta->descricao }}</p>
                        </div>
                        <div class="proposta-footer">
                            <div class="proposta-votos">
                                <span class="votos-favor">👍 {{ $proposta->votos_a_favor }}</span>
                                <span class="votos-contra">👎 {{ $proposta->votos_contra }}</span>
                                <span class="votos-neutro">😐 {{ $proposta->votos_neutro }}</span>
                            </div>
                            <span class="proposta-comentarios">💬 {{ $proposta->total_comentarios }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($propostas->hasPages())
                <div class="pagination">
                    {{ $propostas->links() }}
                </div>
            @endif
        @else
            <div style="background: white; padding: 2rem; text-align: center; border-radius: 12px;">
                <h2 style="font-size: 1.2rem; margin-bottom: 0.5rem;">Nenhuma proposta encontrada</h2>
                <p>Seja o primeiro a criar uma proposta de melhoria!</p>
            </div>
        @endif
    </div>
@endsection
