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
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
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

        .reporte-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
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

        .meta-icon {
            font-size: 1.2rem;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            display: inline-block;
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

        .urgencia-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
            display: inline-block;
        }

        .urgencia-baixa {
            background: #f0fdf4;
            color: #166534;
        }

        .urgencia-media {
            background: #fef3c7;
            color: #92400e;
        }

        .urgencia-alta {
            background: #fee2e2;
            color: #991b1b;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
        }

        .reporte-container .content-grid {
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
            gap: 2rem;
        }

        .main-content {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #f3f4f6;
        }

        .descricao-text {
            color: #374151;
            line-height: 1.7;
            white-space: pre-wrap;
        }

        .reporte-image {
            width: 100%;
            border-radius: 8px;
            margin-top: 1rem;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .reporte-image:hover {
            transform: scale(1.02);
        }

        #map {
            height: 300px;
            border-radius: 8px;
            margin-top: 1rem;
        }

        .localizacao-text {
            color: #374151;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-list {
            list-style: none;
            padding: 0;
        }

        .info-item {
            padding: 0.75rem 0;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #6b7280;
            font-size: 0.9rem;
        }

        .info-value {
            color: #374151;
            font-weight: 500;
        }

        .comentarios-section {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .comentario-form {
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 2px solid #f3f4f6;
        }

        .comentario-textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            resize: vertical;
            min-height: 100px;
            font-family: inherit;
        }

        .comentario-textarea:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .btn-comentar {
            margin-top: 1rem;
            padding: 0.75rem 1.5rem;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-comentar:hover {
            background: #1d4ed8;
        }

        .comentarios-list {
            max-height: 500px;
            overflow-y: auto;
        }

        .comentario-item {
            padding: 1rem 0;
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

        .empty-state {
            text-align: center;
            padding: 2rem;
            color: #9ca3af;
        }

        .empty-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
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

        .alert {
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        /* Modal de imagem */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.9);
        }

        .modal-content {
            margin: auto;
            display: block;
            max-width: 90%;
            max-height: 90%;
        }

        .close-modal {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
        }

        .close-modal:hover {
            color: #bbb;
        }


        @media (max-width: 968px) {
            .content-grid {
                grid-template-columns: 1fr;
            }

            .reporte-meta {
                flex-direction: column;
                gap: 0.75rem;
            }
        }

        @media (max-width: 768px) {
            .reporte-container {
                padding: 1rem;
            }

            .reporte-header {
                padding: 1.5rem;
            }

            .reporte-title {
                font-size: 1.5rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endsection

@section('content')
    <div class="reporte-container">


        <div class="reporte-header">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                <div>
                    <span class="protocolo-badge">Protocolo: {{ $reporte->protocolo }}</span>
                    <h1 class="reporte-title">{{ $reporte->titulo }}</h1>
                </div>
                <a href="{{ route('reportes.index') }}" class="btn btn-secondary">
                    ← Voltar
                </a>
            </div>

            <div class="reporte-meta">
                <div class="meta-item">
                    <span class="meta-icon">👤</span>
                    <span>{{ $reporte->usuario_nome }}</span>
                </div>

                <div class="meta-item">
                    <span class="meta-icon">📅</span>
                    <span>{{ \Carbon\Carbon::parse($reporte->created_at)->format('d/m/Y H:i') }}</span>
                </div>

                <div class="meta-item">
                    <span class="meta-icon">{{ $reporte->categoria_icone }}</span>
                    <span>{{ $reporte->categoria_nome }}</span>
                </div>

                <div class="meta-item">
                <span class="status-badge status-{{ $reporte->status }}">
                    {{ str_replace('_', ' ', $reporte->status) }}
                </span>
                </div>

                <div class="meta-item">
                <span class="urgencia-badge urgencia-{{ $reporte->urgencia }}">
                    Urgência: {{ ucfirst($reporte->urgencia) }}
                </span>
                </div>

                <div class="meta-item">
                    <span class="meta-icon">👁️</span>
                    <span>{{ $reporte->visualizacoes }} visualizações</span>
                </div>
            </div>


        </div>

        <div class="content-grid">
            <div>
                <div class="card" style="margin-bottom: 10px;">
                    <h2 class="card-title">Descrição do Problema</h2>
                    <p class="descricao-text">{{ $reporte->descricao }}</p>

                    @if($reporte->imagem)
                        <img src="{{ asset($reporte->imagem) }}"
                             alt="Imagem do reporte"
                             class="reporte-image"
                             onclick="abrirModal(this.src)">
                    @endif
                </div>

                <div class="card" style="margin-bottom: 10px;" >
                    <h2 class="card-title">Localização</h2>
                    <div class="localizacao-text">
                        <span>📍</span>
                        <span>{{ $reporte->localizacao }}</span>
                    </div>

                    @if($reporte->latitude && $reporte->longitude)
                        <div id="map"></div>
                    @endif
                </div>

                <!-- Comentários -->
                <div class="comentarios-section" style="margin-bottom: 10px;">
                    <h2 class="card-title">Comentários ({{ $comentarios->count() }})</h2>

                    @if(session('user_id'))
                        <form action="{{ route('reportes.comentar', $reporte->id) }}" method="POST" class="comentario-form">
                            @csrf
                            <textarea name="comentario"
                                      class="comentario-textarea"
                                      placeholder="Adicione um comentário..."
                                      required></textarea>
                            <button type="submit" class="btn-comentar">Enviar Comentário</button>
                        </form>
                    @else
                        <div class="alert alert-info" style="margin-bottom: 1.5rem;">
                            <a href="{{ route('login') }}">Faça login</a> para comentar neste reporte.
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
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">💬</div>
                            <p>Nenhum comentário ainda. Seja o primeiro a comentar!</p>
                        </div>
                    @endif
                </div>
            </div>


                <div class="card">
                    <h3 class="card-title">Informações</h3>
                    <ul class="info-list">
                        <li class="info-item">
                            <span class="info-label">Criado em</span>
                            <span class="info-value">{{ \Carbon\Carbon::parse($reporte->created_at)->format('d/m/Y') }}</span>
                        </li>
                        <li class="info-item">
                            <span class="info-label">Última atualização</span>
                            <span class="info-value">{{ \Carbon\Carbon::parse($reporte->updated_at)->format('d/m/Y') }}</span>
                        </li>
                        <li class="info-item">
                            <span class="info-label">Categoria</span>
                            <span class="info-value">{{ $reporte->categoria_nome }}</span>
                        </li>
                        <li class="info-item">
                            <span class="info-label">Urgência</span>
                            <span class="info-value urgencia-badge urgencia-{{ $reporte->urgencia }}">
                            {{ ucfirst($reporte->urgencia) }}
                        </span>
                        </li>
                        <li class="info-item">
                            <span class="info-label">Status</span>
                            <span class="info-value">
                            <span class="status-badge status-{{ $reporte->status }}">
                                {{ str_replace('_', ' ', $reporte->status) }}
                            </span>
                        </span>
                        </li>
                    </ul>


            </div>
        </div>
    </div>

    <div id="imageModal" class="modal">
        <span class="close-modal" onclick="fecharModal()">&times;</span>
        <img class="modal-content" id="modalImage">
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

            L.marker([{{ $reporte->latitude }}, {{ $reporte->longitude }}]).addTo(map)
                .bindPopup('{{ $reporte->titulo }}')
                .openPopup();
        });
        @endif

        function abrirModal(src) {
            document.getElementById('imageModal').style.display = 'block';
            document.getElementById('modalImage').src = src;
        }

        function fecharModal() {
            document.getElementById('imageModal').style.display = 'none';
        }


        function compartilhar() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $reporte->titulo }}',
                    text: 'Veja este reporte no Conecta Cidade',
                    url: window.location.href
                });
            } else {

                navigator.clipboard.writeText(window.location.href);
                alert('Link copiado para a área de transferência!');
            }
        }

        function copiarProtocolo() {
            navigator.clipboard.writeText('{{ $reporte->protocolo }}');
            alert('Protocolo copiado: {{ $reporte->protocolo }}');
        }
    </script>
@endsection
