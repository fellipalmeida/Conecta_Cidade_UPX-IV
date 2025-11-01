@extends('layouts.app-sidebar')

@section('page-title', 'Criar Nova Proposta')

@section('styles')
    <style>
        .create-container { max-width: 800px; margin: 0 auto; padding: 2rem; }
        .page-header { margin-bottom: 2rem; }
        .page-title { font-size: 2rem; font-weight: 700; color: #1f2937; }
        .form-card { background: white; border-radius: 16px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07); padding: 2rem; }
        .form-group { margin-bottom: 1.5rem; }
        .form-label { display: block; margin-bottom: 0.5rem; font-weight: 500; color: #374151; }
        .required { color: #ef4444; }
        .form-control { width: 100%; padding: 0.75rem 1rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: 1rem; }
        .form-control:focus { outline: none; border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }
        .form-control.error { border-color: #ef4444; }
        .error-message { color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; }
        textarea.form-control { min-height: 150px; resize: vertical; }
        .form-actions { display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #e5e7eb; }
        .btn { padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 500; cursor: pointer; border: none; font-size: 1rem; }
        .btn-primary { background: #2563eb; color: white; }
        .btn-secondary { background: #6b7280; color: white; }
    </style>
@endsection

@section('content')
    <div class="create-container">
        <div class="page-header">
            <h1 class="page-title">💡 Criar Nova Proposta</h1>
        </div>

        <form action="{{ route('propostas.store') }}" method="POST">
            @csrf
            <div class="form-card">
                <div class="form-group">
                    <label for="titulo" class="form-label">
                        Título da Proposta <span class="required">*</span>
                    </label>
                    <input type="text"
                           class="form-control @error('titulo') error @enderror"
                           id="titulo"
                           name="titulo"
                           value="{{ old('titulo') }}"
                           placeholder="Ex: Instalação de ciclovia na Avenida Principal"
                           required>
                    @error('titulo')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="categoria_id" class="form-label">
                        Categoria <span class="required">*</span>
                    </label>
                    <select name="categoria_id" id="categoria_id" class="form-control @error('categoria_id') error @enderror" required>
                        <option value="">Selecione uma categoria</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->icone }} {{ $categoria->nome }}
                            </option>
                        @endforeach
                    </select>
                    @error('categoria_id')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="descricao" class="form-label">
                        Descrição Detalhada <span class="required">*</span>
                    </label>
                    <textarea class="form-control @error('descricao') error @enderror"
                              id="descricao"
                              name="descricao"
                              placeholder="Descreva sua ideia. Por que ela é importante? Quem ela beneficia?"
                              required>{{ old('descricao') }}</textarea>
                    @error('descricao')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="localizacao" class="form-label">
                        Localização (Opcional)
                    </label>
                    <input type="text"
                           class="form-control @error('localizacao') error @enderror"
                           id="localizacao"
                           name="localizacao"
                           value="{{ old('localizacao') }}"
                           placeholder="Ex: Próximo à Praça da Matriz">
                    @error('localizacao')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <a href="{{ route('propostas.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">
                        Enviar Proposta
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
