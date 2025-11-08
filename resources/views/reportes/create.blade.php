@extends('layouts.app-sidebar')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        .create-container {
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
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: #6b7280;
            font-size: 1.1rem;
        }

        .form-card {
            background: white;
            border-radius: 16px;
            padding: 10px;
        }

        .form-section {
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
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

        .required {
            color: #ef4444;
            margin-left: 0.25rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-control.error {
            border-color: #ef4444;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .form-hint {
            color: #6b7280;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .categoria-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 1rem;
        }

        .categoria-item {
            position: relative;
        }

        .categoria-item input[type="radio"] {
            position: absolute;
            opacity: 0;
        }

        .categoria-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 5px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
        }

        .categoria-item input[type="radio"]:checked + .categoria-label {
            border-color: #2563eb;
            background: #eff6ff;
        }

        .categoria-label:hover {
            border-color: #9ca3af;
        }

        .categoria-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .categoria-name {
            font-size: 0.9rem;
            color: #374151;
            font-weight: 500;
        }

        .urgencia-options {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .urgencia-item {
            position: relative;
            flex: 1;
            min-width: 150px;
        }

        .urgencia-item input[type="radio"] {
            position: absolute;
            opacity: 0;
        }

        .urgencia-label {
            display: block;
            padding: 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
        }

        .urgencia-item input[type="radio"]:checked + .urgencia-label {
            border-color: currentColor;
        }

        .urgencia-baixa {
            color: #10b981;
        }

        .urgencia-media {
            color: #f59e0b;
        }

        .urgencia-alta {
            color: #ef4444;
        }

        .urgencia-label.urgencia-baixa:hover {
            background: #f0fdf4;
        }

        .urgencia-label.urgencia-media:hover {
            background: #fffbeb;
        }

        .urgencia-label.urgencia-alta:hover {
            background: #fef2f2;
        }

        .urgencia-title {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .urgencia-desc {
            font-size: 0.875rem;
            color: #6b7280;
        }

        #map {
            height: 400px;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            margin-top: 1rem;
        }

        .map-search {
            position: relative;
            margin-bottom: 1rem;
        }

        .map-search-input {
            width: 100%;
            padding: 0.75rem 1rem;
            padding-right: 3rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
        }

        .map-search-btn {
            position: absolute;
            right: 0.5rem;
            top: 50%;
            transform: translateY(-50%);
            padding: 0.5rem 1rem;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .file-upload {
            position: relative;
        }

        .file-upload-input {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-upload-label {
            display: block;
            padding: 2rem;
            border: 2px dashed #d1d5db;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .file-upload-label:hover {
            border-color: #2563eb;
            background: #f9fafb;
        }

        .file-upload-icon {
            font-size: 3rem;
            color: #9ca3af;
            margin-bottom: 0.5rem;
        }

        .file-upload-text {
            color: #374151;
            margin-bottom: 0.25rem;
        }

        .file-upload-hint {
            color: #6b7280;
            font-size: 0.875rem;
        }

        .preview-container {
            margin-top: 1rem;
        }

        .preview-image {
            max-width: 300px;
            max-height: 300px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #e5e7eb;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            font-size: 1rem;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background: #4b5563;
        }

        @media (max-width: 768px) {
            .create-container {
                padding: 1rem;
            }

            .form-card {
                padding: 1.5rem;
            }

            .categoria-grid {
                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            }

            .form-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
@endsection

@section('content')
    <div class="create-container">
        <div class="page-header">
            <h1 class="page-title">📍 Criar Novo Reporte</h1>
            <p class="page-subtitle">Relate um problema urbano para ajudar a melhorar nossa cidade</p>
        </div>

        <form action="{{ route('reportes.store') }}" method="POST" enctype="multipart/form-data" id="reporteForm">
            @csrf

            <div class="form-card">
                <div class="form-section">
                    <h2 class="section-title">
                        <span>📝</span>
                        Informações Básicas
                    </h2>

                    <div class="form-group">
                        <label for="titulo" class="form-label">
                            Título do Reporte
                            <span class="required">*</span>
                        </label>
                        <input type="text"
                               class="form-control @error('titulo') error @enderror"
                               id="titulo"
                               name="titulo"
                               value="{{ old('titulo') }}"
                               placeholder="Descreva brevemente o problema"
                               required>
                        @error('titulo')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                        <div class="form-hint">Seja claro e objetivo no título</div>
                    </div>

                    <div class="form-group">
                        <label for="descricao" class="form-label">
                            Descrição Detalhada
                            <span class="required">*</span>
                        </label>
                        <textarea class="form-control @error('descricao') error @enderror"
                                  id="descricao"
                                  name="descricao"
                                  placeholder="Descreva o problema com o máximo de detalhes possível..."
                                  required>{{ old('descricao') }}</textarea>
                        @error('descricao')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                        <div class="form-hint">Quanto mais detalhes, melhor para a resolução do problema</div>
                    </div>
                </div>

                <div class="form-section">
                    <h2 class="section-title">
                        <span>📂</span>
                        Categoria
                        <span class="required">*</span>
                    </h2>

                    <div class="categoria-grid">
                        <div class="categoria-item">
                            <input type="radio" id="categoria_1" name="categoria_id" value="1" {{ old('categoria_id') == '1' ? 'checked' : '' }} required>
                            <label for="categoria_1" class="categoria-label">
                                <span class="categoria-icon">🛣️</span>
                                <span class="categoria-name">Buracos na Rua</span>
                            </label>
                        </div>

                        <div class="categoria-item">
                            <input type="radio" id="categoria_2" name="categoria_id" value="2" {{ old('categoria_id') == '2' ? 'checked' : '' }} required>
                            <label for="categoria_2" class="categoria-label">
                                <span class="categoria-icon">🚦</span>
                                <span class="categoria-name">Semáforos</span>
                            </label>
                        </div>

                        <div class="categoria-item">
                            <input type="radio" id="categoria_3" name="categoria_id" value="3" {{ old('categoria_id') == '3' ? 'checked' : '' }} required>
                            <label for="categoria_3" class="categoria-label">
                                <span class="categoria-icon">🚸</span>
                                <span class="categoria-name">Falta de Sinalização</span>
                            </label>
                        </div>

                        <div class="categoria-item">
                            <input type="radio" id="categoria_4" name="categoria_id" value="4" {{ old('categoria_id') == '4' ? 'checked' : '' }} required>
                            <label for="categoria_4" class="categoria-label">
                                <span class="categoria-icon">🚌</span>
                                <span class="categoria-name">Transporte Público</span>
                            </label>
                        </div>

                        <div class="categoria-item">
                            <input type="radio" id="categoria_5" name="categoria_id" value="5" {{ old('categoria_id') == '5' ? 'checked' : '' }} required>
                            <label for="categoria_5" class="categoria-label">
                                <span class="categoria-icon">💡</span>
                                <span class="categoria-name">Iluminação Pública</span>
                            </label>
                        </div>

                        <div class="categoria-item">
                            <input type="radio" id="categoria_6" name="categoria_id" value="6" {{ old('categoria_id') == '6' ? 'checked' : '' }} required>
                            <label for="categoria_6" class="categoria-label">
                                <span class="categoria-icon">🗑️</span>
                                <span class="categoria-name">Limpeza Urbana</span>
                            </label>
                        </div>


                        <div class="categoria-item">
                            <input type="radio" id="categoria_8" name="categoria_id" value="8" {{ old('categoria_id') == '8' ? 'checked' : '' }} required>
                            <label for="categoria_8" class="categoria-label">
                                <span class="categoria-icon">⚠️</span>
                                <span class="categoria-name">Outros</span>
                            </label>
                        </div>
                    </div>
                    @error('categoria_id')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-section">
                    <h2 class="section-title">
                        <span>⚠️</span>
                        Nível de Urgência
                        <span class="required">*</span>
                    </h2>

                    <div class="urgencia-options">
                        <div class="urgencia-item">
                            <input type="radio"
                                   id="urgencia_baixa"
                                   name="urgencia"
                                   value="baixa"
                                   {{ old('urgencia', 'baixa') == 'baixa' ? 'checked' : '' }}
                                   required>
                            <label for="urgencia_baixa" class="urgencia-label urgencia-baixa">
                                <div class="urgencia-title">🟢 Baixa</div>
                                <div class="urgencia-desc">Pode ser resolvido sem pressa</div>
                            </label>
                        </div>

                        <div class="urgencia-item">
                            <input type="radio"
                                   id="urgencia_media"
                                   name="urgencia"
                                   value="media"
                                   {{ old('urgencia') == 'media' ? 'checked' : '' }}
                                   required>
                            <label for="urgencia_media" class="urgencia-label urgencia-media">
                                <div class="urgencia-title">🟡 Média</div>
                                <div class="urgencia-desc">Requer atenção moderada</div>
                            </label>
                        </div>

                        <div class="urgencia-item">
                            <input type="radio"
                                   id="urgencia_alta"
                                   name="urgencia"
                                   value="alta"
                                   {{ old('urgencia') == 'alta' ? 'checked' : '' }}
                                   required>
                            <label for="urgencia_alta" class="urgencia-label urgencia-alta">
                                <div class="urgencia-title">🔴 Alta</div>
                                <div class="urgencia-desc">Necessita atenção imediata</div>
                            </label>
                        </div>
                    </div>
                    @error('urgencia')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-section">
                    <h2 class="section-title">
                        <span>📍</span>
                        Localização
                        <span class="required">*</span>
                    </h2>

                    <div class="form-group">
                        <label for="localizacao" class="form-label">
                            Endereço ou Referência
                            <span class="required">*</span>
                        </label>
                        <div class="map-search">
                            <input type="text"
                                   class="map-search-input form-control @error('localizacao') error @enderror"
                                   id="localizacao"
                                   name="localizacao"
                                   value="{{ old('localizacao') }}"
                                   placeholder="Ex: Rua Principal, 123 - Centro"
                                   required>
                            <button type="button" class="map-search-btn" onclick="buscarEndereco()">
                                Buscar
                            </button>
                        </div>
                        @error('localizacao')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-hint">
                        Clique no mapa para marcar a localização exata do problema
                    </div>

                    <div id="map"></div>

                    <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                    <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">


                </div>

                <div class="form-section">
                    <h2 class="section-title">
                        <span>📷</span>
                        Imagem <span class="required">*</span>
                    </h2>

                    <div class="file-upload">
                        <input type="file"
                               class="file-upload-input"
                               id="imagem"
                               name="imagem"
                               accept="image/*"
                               onchange="previewImagem(event)"
                               required
                        >
                        <label for="imagem" class="file-upload-label">
                            <div class="file-upload-icon">📷</div>
                            <div class="file-upload-text">Clique para selecionar uma imagem</div>
                            <div class="file-upload-hint">JPG, PNG ou GIF - Máximo 5MB</div>
                        </label>
                    </div>

                    <div class="preview-container" id="preview-container" style="display: none;">
                        <img id="preview-image" class="preview-image" alt="Preview">
                    </div>

                    @error('imagem')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Ações -->
                <div class="form-actions">
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">
                        Criar Reporte
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        var map;
        var marker;

        document.addEventListener('DOMContentLoaded', function() {
            var defaultLat = -23.5505;
            var defaultLng = -46.6333;

            map = L.map('map').setView([defaultLat, defaultLng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            map.on('click', function(e) {
                adicionarMarcador(e.latlng.lat, e.latlng.lng);
            });

            var oldLat = document.getElementById('latitude').value;
            var oldLng = document.getElementById('longitude').value;
            if (oldLat && oldLng) {
                adicionarMarcador(parseFloat(oldLat), parseFloat(oldLng));
            }
        });

        function adicionarMarcador(lat, lng) {
            if (marker) {
                map.removeLayer(marker);
            }

            marker = L.marker([lat, lng]).addTo(map);

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            map.setView([lat, lng], 15);
        }

        function buscarEndereco() {
            var endereco = document.getElementById('localizacao').value;

            if (!endereco) {
                alert('Por favor, digite um endereço');
                return;
            }

            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(endereco)}&limit=1`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        var lat = parseFloat(data[0].lat);
                        var lng = parseFloat(data[0].lon);
                        adicionarMarcador(lat, lng);
                    } else {
                        alert('Endereço não encontrado. Tente marcar manualmente no mapa.');
                    }
                })
                .catch(error => {
                    console.error('Erro ao buscar endereço:', error);
                    alert('Erro ao buscar endereço. Tente marcar manualmente no mapa.');
                });
        }

        function previewImagem(event) {
            var input = event.target;
            var preview = document.getElementById('preview-image');
            var container = document.getElementById('preview-container');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    container.style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                container.style.display = 'none';
            }
        }

        document.getElementById('reporteForm').addEventListener('submit', function(e) {
            var lat = document.getElementById('latitude').value;
            var lng = document.getElementById('longitude').value;

            if (!lat || !lng) {
                e.preventDefault();
                alert('Por favor, marque a localização do problema no mapa');
                return false;
            }
        });
    </script>
@endsection
