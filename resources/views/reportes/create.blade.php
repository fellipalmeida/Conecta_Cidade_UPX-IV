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

        .map-search-controls {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .map-search {
            position: relative;
            flex: 1;
            display: flex;
            gap: 10px;
        }

        .map-search-input {
            width: 100%;
            padding: 0.75rem 1rem;
            padding-right: 3rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
        }

        .map-search-btn {
            padding: 0.5rem 1rem;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .map-geo-btn { /* Novo estilo para o botão de geolocalização */
            padding: 0.75rem 1rem;
            background: #10b981;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: background 0.2s;
        }

        .map-geo-btn:hover {
            background: #059669;
        }

        .map-geo-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
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
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .preview-wrapper {
            position: relative;
            width: 150px;
            height: 150px;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            background: #374151;
        }

        .preview-media {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .remove-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(239, 68, 68, 0.9);
            color: white;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            font-size: 0.8rem;
            cursor: pointer;
            line-height: 1;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
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

            .map-search-controls {
                flex-direction: column;
            }

            .map-search {
                flex-direction: column;
                gap: 10px;
            }

            .map-search-btn {
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
                        <div class="map-search-controls">
                            <div class="map-search">
                                <input type="text"
                                       class="map-search-input form-control @error('localizacao') error @enderror"
                                       id="localizacao"
                                       name="localizacao"
                                       value="{{ old('localizacao') }}"
                                       placeholder="Ex: Rua Principal, 123 - Centro"
                                       required>
                                <button type="button" class="map-search-btn" onclick="buscarEndereco()" style="position: static; transform: none;">
                                    Buscar
                                </button>
                            </div>
                            <button type="button" class="map-geo-btn" onclick="pegarLocalizacaoAtual()">
                                <span>Localização Atual</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                    <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
                                </svg>
                            </button>
                        </div>
                        @error('localizacao')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-hint">
                        Clique no mapa para marcar a localização exata do problema ou use o botão **GPS**
                    </div>

                    <div id="map"></div>

                    <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                    <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">


                </div>

                <div class="form-section">
                    <h2 class="section-title">
                        <span>📷</span>
                        Arquivos (Máx. 5) <span class="required">*</span>
                    </h2>

                    <div class="file-upload">
                        <input type="file"
                               class="file-upload-input"
                               id="imagem"
                               name="imagens[]"
                               accept="image/*,video/*"
                               onchange="handleFiles(event)"
                               multiple
                               required
                        >
                        <label for="imagem" class="file-upload-label">
                            <div class="file-upload-icon">📷</div>
                            <div class="file-upload-text">Clique para selecionar até 5 arquivos</div>
                            <div class="file-upload-hint">Imagens (JPG, PNG, GIF) ou Vídeos (MP4, MOV). Máximo 5MB por arquivo.</div>
                        </label>
                    </div>

                    <div class="preview-container" id="preview-container" style="display: none;">
                    </div>

                    @error('imagens')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                    @error('imagens.*')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

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
        let dataTransfer = new DataTransfer();
        const MAX_FILES = 5;
        const MAX_SIZE_MB = 5;
        const MAX_SIZE_BYTES = MAX_SIZE_MB * 1024 * 1024;
        const ALLOWED_TYPES = ['image/jpeg', 'image/png', 'image/gif', 'video/mp4', 'video/quicktime', 'video/x-msvideo', 'video/webm', 'video/mov', 'video/avi', 'video/wmv'];


        document.addEventListener('DOMContentLoaded', function() {
            var defaultLat = -23.5505;
            var defaultLng = -46.6333;

            map = L.map('map').setView([defaultLat, defaultLng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            map.on('click', function(e) {
                adicionarMarcador(e.latlng.lat, e.latlng.lng);
                buscarNomeEndereco(e.latlng.lat, e.latlng.lng);
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

        function buscarNomeEndereco(lat, lng) {
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`)
                .then(response => response.json())
                .then(data => {
                    let endereco = `Coordenadas: ${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                    if (data.address) {
                        const addr = data.address;

                        let partes = [];

                        if (addr.road) partes.push(addr.road);
                        if (addr.house_number) partes.push(addr.house_number);

                        if (partes.length > 0) {
                            let parte2 = [];
                            if (addr.neighbourhood) parte2.push(addr.neighbourhood);
                            if (addr.city || addr.town || addr.village) parte2.push(addr.city || addr.town || addr.village);

                            if (parte2.length > 0) {
                                endereco = partes.join(', ') + ' - ' + parte2.join(', ');
                            } else {
                                endereco = partes.join(', ');
                            }
                        } else {

                            endereco = data.display_name;
                        }

                    }
                    document.getElementById('localizacao').value = endereco;
                })
                .catch(error => {
                    console.error('Erro ao buscar nome do endereço:', error);
                    document.getElementById('localizacao').value = `Coordenadas: ${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                });
        }

        function pegarLocalizacaoAtual() {
            if (!navigator.geolocation) {
                alert('Geolocalização não é suportada por este navegador. Por favor, digite o endereço ou clique no mapa.');
                return;
            }

            const geoBtn = document.querySelector('.map-geo-btn');
            geoBtn.disabled = true;
            geoBtn.innerHTML = 'Buscando...';

            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    adicionarMarcador(lat, lng);
                    buscarNomeEndereco(lat, lng);

                    geoBtn.disabled = false;
                    geoBtn.innerHTML = '<span>GPS</span> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16"><path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/></svg>';
                },
                function(error) {
                    let mensagem = 'Erro ao obter localização. Tente marcar manualmente no mapa.';
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            mensagem = "Permissão de localização negada. Verifique as configurações do seu navegador/sistema. Lembre-se que alguns navegadores exigem **conexão HTTPS** para usar o GPS.";
                            break;
                        case error.POSITION_UNAVAILABLE:
                            mensagem = "Informações de localização indisponíveis (satélites, Wi-Fi, ou rede de celular).";
                            break;
                        case error.TIMEOUT:
                            mensagem = "A requisição de localização expirou. Tente novamente.";
                            break;
                        default:
                            mensagem = "Erro desconhecido ao obter localização. Verifique se o GPS está ativo (em mobile) ou se você autorizou o uso da localização.";
                            break;
                    }

                    alert("Localização Automática Falhou: " + mensagem);

                    geoBtn.disabled = false;
                    geoBtn.innerHTML = '<span>GPS</span> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16"><path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/></svg>';
                }
            );
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

        function handleFiles(event) {
            const input = event.target;
            const newFiles = input.files;

            let hasError = false;
            let tempTransfer = new DataTransfer();

            for (let i = 0; i < dataTransfer.files.length; i++) {
                tempTransfer.items.add(dataTransfer.files[i]);
            }

            for (let i = 0; i < newFiles.length; i++) {
                const file = newFiles[i];
                const fileType = file.type;

                if (!ALLOWED_TYPES.includes(fileType) && !ALLOWED_TYPES.some(type => fileType.startsWith(type.split('/')[0] + '/'))) {
                    alert(`Tipo de arquivo não suportado: ${file.name}. Por favor, envie apenas imagens ou vídeos.`);
                    hasError = true;
                    break;
                }

                if (file.size > MAX_SIZE_BYTES) {
                    alert(`Tamanho máximo excedido: O arquivo ${file.name} tem mais de ${MAX_SIZE_MB}MB.`);
                    hasError = true;
                    break;
                }

                tempTransfer.items.add(file);
            }

            if (tempTransfer.files.length > MAX_FILES && !hasError) {
                alert(`Limite de quantidade excedido: Você só pode anexar no máximo ${MAX_FILES} arquivos. (Total após seleção: ${tempTransfer.files.length})`);
                input.value = null;
                return;
            }


            if (!hasError) {
                dataTransfer = tempTransfer;
                input.files = dataTransfer.files;
            } else {
                input.value = null;
                return;
            }

            updatePreviews(dataTransfer.files);

            if (dataTransfer.files.length > 0) {
                document.getElementById('preview-container').style.display = 'flex';
                input.removeAttribute('required');
            } else {
                document.getElementById('preview-container').style.display = 'none';
                input.setAttribute('required', 'required');
            }
        }

        function updatePreviews(files) {
            const container = document.getElementById('preview-container');
            container.innerHTML = '';

            if (files.length === 0) {
                container.style.display = 'none';
                return;
            }

            container.style.display = 'flex';

            Array.from(files).forEach((file, index) => {
                const fileType = file.type;
                const previewWrapper = document.createElement('div');
                previewWrapper.className = 'preview-wrapper';

                if (fileType.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'preview-media';
                        previewWrapper.appendChild(img);
                    }
                    reader.readAsDataURL(file);
                } else if (fileType.startsWith('video/')) {
                    const video = document.createElement('video');
                    video.src = URL.createObjectURL(file);
                    video.className = 'preview-media';
                    previewWrapper.appendChild(video);

                    const overlay = document.createElement('div');
                    overlay.innerHTML = '▶️';
                    overlay.style.cssText = 'position: absolute; top: 0; left: 0; right: 0; bottom: 0; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: white; background: rgba(0,0,0,0.3);';
                    previewWrapper.appendChild(overlay);
                }

                const removeBtn = document.createElement('button');
                removeBtn.innerHTML = '✕';
                removeBtn.className = 'remove-btn';
                removeBtn.onclick = function(e) {
                    e.preventDefault();
                    removeFile(index);
                };
                previewWrapper.appendChild(removeBtn);

                container.appendChild(previewWrapper);
            });
        }

        function removeFile(index) {
            dataTransfer.items.remove(index);

            const input = document.getElementById('imagem');
            input.files = dataTransfer.files;

            updatePreviews(dataTransfer.files);

            if (dataTransfer.files.length === 0) {
                input.setAttribute('required', 'required');
            }
        }

        document.getElementById('reporteForm').addEventListener('submit', function(e) {
            var lat = document.getElementById('latitude').value;
            var lng = document.getElementById('longitude').value;
            const input = document.getElementById('imagem');

            if (!lat || !lng) {
                e.preventDefault();
                alert('Por favor, marque a localização do problema no mapa ou use o botão GPS');
                return false;
            }

            if (input.files.length === 0) {
                e.preventDefault();
                alert('Por favor, anexe pelo menos um arquivo (imagem ou vídeo).');
                return false;
            }
        });
    </script>
@endsection
