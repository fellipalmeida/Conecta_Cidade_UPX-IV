@extends('layouts.app-sidebar')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        .reporte-container {
            max-width: 1250px;
            margin: 0 auto;
            padding: 2rem;
        }

        .reporte-header {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        .reporte-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 1rem;
        }

        .protocolo-badge {
            display: inline-block;
            background: #f3f4f6;
            color: #374151;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .reporte-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            color: #6b7280;
            font-size: 0.95rem;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #f3f4f6;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #374151;
        }

        /* Estilos harmonizados para inputs, selects e textareas */
        .form-control,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 1rem;
            font-family: inherit; /* Garante a mesma fonte */
            transition: all 0.2s;
            background-color: #fff; /* Fundo branco padrão */
            color: #1f2937; /* Cor do texto padrão */
        }

        .form-control:focus,
        .form-select:focus,
        .form-textarea:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 120px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            text-decoration: none;
            font-size: 1rem;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
            width: 100%;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .btn-secondary {
            background: #f3f4f6;
            color: #374151;
        }

        .btn-secondary:hover {
            background: #e5e7eb;
        }
    </style>
@endsection

@section('content')
    <div class="reporte-container">
        <div class="reporte-header">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                <div>
                    <span class="protocolo-badge">Protocolo: {{ $reporte->protocolo }}</span>
                    <h1 class="reporte-title">Gerenciar Reporte</h1>
                </div>
                <a href="{{ route('reportes.index') }}" class="btn btn-secondary">
                    ← Voltar
                </a>
            </div>

            <div class="reporte-meta">
                <div class="meta-item">
                    <span>👤</span>
                    <strong>{{ $reporte->usuario_nome }}</strong>
                </div>
                <div class="meta-item">
                    <span>📅</span>
                    <span>{{ \Carbon\Carbon::parse($reporte->created_at)->format('d/m/Y H:i') }}</span>
                </div>
                <div class="meta-item">
                    <span>{{ $reporte->categoria_icone }}</span>
                    <span>{{ $reporte->categoria_nome }}</span>
                </div>
            </div>
        </div>

        <div class="content-grid">
            <div class="main-content-details">
                <div class="card">
                    <h2 class="card-title">Detalhes do Problema</h2>
                    <h3 style="font-size: 1.1rem; color: #1f2937; margin-bottom: 0.5rem;">{{ $reporte->titulo }}</h3>
                    <p style="white-space: pre-wrap; color: #4b5563; line-height: 1.6;">{{ $reporte->descricao }}</p>

                    @if($reporte->imagem)
                        <div style="margin-top: 1.5rem;">
                            <h4 style="font-size: 1rem; color: #374151; margin-bottom: 0.5rem;">Imagem Anexada:</h4>
                            <img src="{{ asset($reporte->imagem) }}" alt="Imagem do reporte" style="max-width: 100%; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        </div>
                    @endif
                </div>

                @if($reporte->latitude && $reporte->longitude)
                    <div class="card">
                        <h2 class="card-title">Localização</h2>
                        <p style="color: #4b5563; margin-bottom: 1rem;">
                            <span style="margin-right: 0.5rem;">📍</span>
                            {{ $reporte->localizacao }}
                        </p>
                        <div id="map" style="height: 350px; border-radius: 8px; border: 1px solid #e5e7eb;"></div>
                    </div>
                @endif
            </div>

            <div class="admin-sidebar">
                <div class="card">
                    <h2 class="card-title">🛠️ Painel Administrativo</h2>
                    <form action="{{ route('reportes.update-status', $reporte->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            <label for="status" class="form-label">Status do Reporte</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="pendente" {{ $reporte->status == 'pendente' ? 'selected' : '' }}>🟡 Pendente</option>
                                <option value="em_analise" {{ $reporte->status == 'em_analise' ? 'selected' : '' }}>🔵 Em Análise</option>
                                <option value="em_andamento" {{ $reporte->status == 'em_andamento' ? 'selected' : '' }}>🟣 Em Andamento</option>
                                <option value="resolvido" {{ $reporte->status == 'resolvido' ? 'selected' : '' }}>🟢 Resolvido</option>
                                <option value="rejeitado" {{ $reporte->status == 'rejeitado' ? 'selected' : '' }}>🔴 Rejeitado</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="urgencia" class="form-label">Nível de Urgência</label>
                            <select name="urgencia" id="urgencia" class="form-select" required>
                                <option value="baixa" {{ $reporte->urgencia == 'baixa' ? 'selected' : '' }}>🟢 Baixa</option>
                                <option value="media" {{ $reporte->urgencia == 'media' ? 'selected' : '' }}>🟡 Média</option>
                                <option value="alta" {{ $reporte->urgencia == 'alta' ? 'selected' : '' }}>🔴 Alta</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="admin_note" class="form-label">Nota de Atualização (Opcional)</label>
                            <textarea
                                name="admin_note"
                                id="admin_note"
                                class="form-textarea"
                                placeholder="Adicione uma nota visível ao usuário sobre esta atualização..."
                            ></textarea>
                            <p style="font-size: 0.8rem; color: #6b7280; margin-top: 0.5rem;">
                                Esta nota será enviada ao usuário como uma notificação.
                            </p>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            💾 Salvar Alterações
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        @if($reporte->latitude && $reporte->longitude)
        document.addEventListener('DOMContentLoaded', function() {
            var map = L.map('map').setView([{{ $reporte->latitude }}, {{ $reporte->longitude }}], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);
            L.marker([{{ $reporte->latitude }}, {{ $reporte->longitude }}])
                .addTo(map)
                .bindPopup('<b>{{ $reporte->titulo }}</b><br>{{ $reporte->localizacao }}')
                .openPopup();
        });
        @endif
    </script>
@endsection
