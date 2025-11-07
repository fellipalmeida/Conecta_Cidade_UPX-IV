@extends('layouts.app-sidebar')

@section('styles')
    <style>
        .profile-container {
            max-width: 600px;
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



        .form-section {
            margin-bottom: 2rem;
        }

        .form-section:last-of-type {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #e5e7eb;
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

        .form-actions {
            display: flex;
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

        /* Alerta de Sucesso */
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

    </style>
@endsection

@section('content')
    <div class="profile-container">
        <div class="page-header">
            <h1 class="page-title">👤 Meu Perfil</h1>
            <p class="page-subtitle">Atualize suas informações pessoais e senha</p>
        </div>


        <form action="{{ route('profile.update') }}" method="POST">
            @csrf

            <div class="form-card">
                <div class="form-section">
                    <h2 class="section-title">
                        Informações Pessoais
                    </h2>

                    <div class="form-group">
                        <label for="name" class="form-label">
                            Nome Completo
                        </label>
                        <input type="text"
                               class="form-control @error('name') error @enderror"
                               id="name"
                               name="name"
                               value="{{ old('name', $user->name) }}"
                               required>
                        @error('name')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">
                            Endereço de E-mail
                        </label>
                        <input type="email"
                               class="form-control @error('email') error @enderror"
                               id="email"
                               name="email"
                               value="{{ old('email', $user->email) }}"
                               required>
                        @error('email')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-section">
                    <h2 class="section-title">
                        Alterar Senha
                    </h2>
                    <p class="form-hint" style="margin-bottom: 1.5rem;">
                        Deixe os campos abaixo em branco se não quiser alterar sua senha.
                    </p>

                    <div class="form-group">
                        <label for="password" class="form-label">
                            Nova Senha
                        </label>
                        <input type="password"
                               class="form-control @error('password') error @enderror"
                               id="password"
                               name="password">
                        @error('password')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">
                            Confirmar Nova Senha
                        </label>
                        <input type="password"
                               class="form-control"
                               id="password_confirmation"
                               name="password_confirmation">
                        {{-- O erro de confirmação já aparece no campo 'password' --}}
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        Salvar Alterações
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
