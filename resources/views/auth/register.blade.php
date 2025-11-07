@extends('layouts.app')

@section('title', 'Cadastro - Conecta Cidade')

@section('styles')
    <style>
        .auth-container {
            max-width: 550px;
            margin: 3rem auto;
        }

        .auth-card {
            background: white;
            padding: 2.5rem;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .auth-subtitle {
            color: #6b7280;
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: #374151;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .form-label .required {
            color: #ef4444;
        }

        .form-label .optional {
            color: #9ca3af;
            font-weight: 400;
            font-size: 0.85rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .form-input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-input.error {
            border-color: #ef4444;
        }

        .form-error {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: block;
        }

        .form-help {
            color: #6b7280;
            font-size: 0.85rem;
            margin-top: 0.5rem;
            display: block;
        }

        .form-checkbox {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            margin: 1rem 0;
        }

        .form-checkbox input {
            width: 18px;
            height: 18px;
            cursor: pointer;
            margin-top: 2px;
        }

        .form-checkbox label {
            font-size: 0.9rem;
            color: #374151;
            cursor: pointer;
            line-height: 1.5;
        }

        .form-checkbox label a {
            color: #2563eb;
            text-decoration: none;
        }

        .form-checkbox label a:hover {
            text-decoration: underline;
        }

        .btn-submit {
            width: 100%;
            padding: 0.875rem;
            background: linear-gradient(135deg, #2563eb, #1e40af);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .auth-divider {
            text-align: center;
            margin: 1.5rem 0;
            color: #9ca3af;
            position: relative;
        }

        .auth-divider::before,
        .auth-divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 40%;
            height: 1px;
            background: #e5e7eb;
        }

        .auth-divider::before {
            left: 0;
        }

        .auth-divider::after {
            right: 0;
        }

        .auth-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #6b7280;
            font-size: 0.95rem;
        }

        .auth-link a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
        }

        .auth-link a:hover {
            text-decoration: underline;
        }

        .password-requirements {
            background: #f3f4f6;
            padding: 0.75rem;
            border-radius: 6px;
            margin-top: 0.5rem;
            font-size: 0.85rem;
            color: #6b7280;
        }

        .password-requirements ul {
            margin: 0.5rem 0 0 1.5rem;
        }

        .password-requirements li {
            margin: 0.25rem 0;
        }

        @media (max-width: 768px) {
            .auth-container {
                margin: 1rem;
            }

            .auth-card {
                padding: 1.5rem;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection

@section('content')
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1 class="auth-title">Criar sua conta</h1>
                <p class="auth-subtitle">Junte-se a nós e ajude a transformar sua cidade!</p>
            </div>

            <form action="{{ route('register.post') }}" method="POST">
                @csrf

                <!-- Nome -->
                <div class="form-group">
                    <label for="name" class="form-label">
                        Nome Completo <span class="required">*</span>
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-input @error('name') error @enderror"
                        value="{{ old('name') }}"
                        required
                    >
                    @error('name')
                    <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email e CPF -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="email" class="form-label">
                            Email <span class="required">*</span>
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-input @error('email') error @enderror"
                            value="{{ old('email') }}"
                            placeholder="seu@email.com"
                            required
                        >
                        @error('email')
                        <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="cpf" class="form-label">
                            CPF <span class="required">*</span>
                        </label>
                        <input
                            type="text"
                            id="cpf"
                            name="cpf"
                            class="form-input @error('cpf') error @enderror"
                            value="{{ old('cpf') }}"
                            placeholder="00000000000"
                            maxlength="11"
                            required
                        >
                        @error('cpf')
                        <span class="form-error">{{ $message }}</span>
                        @enderror

                    </div>
                </div>

                <!-- Telefone e Cidade -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="telefone" class="form-label">
                            Telefone <span class="required">*</span>
                        </label>
                        <input
                            type="text"
                            id="telefone"
                            name="telefone"
                            class="form-input @error('telefone') error @enderror"
                            value="{{ old('telefone') }}"
                            placeholder="(15) 99999-9999"
                            required
                        >
                        @error('telefone')
                        <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="cidade" class="form-label">
                            Cidade <span class="required">*</span>
                        </label>
                        <input
                            type="text"
                            id="cidade"
                            name="cidade"
                            class="form-input @error('cidade') error @enderror"
                            required
                        >
                        @error('cidade')
                        <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Senha -->
                <div class="form-group">
                    <label for="password" class="form-label">
                        Senha <span class="required">*</span>
                    </label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-input @error('password') error @enderror"
                        placeholder="••••••••"
                        required
                    >
                    @error('password')
                    <span class="form-error">{{ $message }}</span>
                    @enderror
                    <div class="password-requirements">
                        <strong>Requisitos da senha:</strong>
                        <ul>
                            <li>Mínimo de 6 caracteres</li>
                            <li>Recomendado: letras, números e símbolos</li>
                        </ul>
                    </div>
                </div>

                <!-- Confirmar Senha -->
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">
                        Confirmar Senha <span class="required">*</span>
                    </label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="form-input"
                        placeholder="••••••••"
                        required
                    >
                </div>

                <!-- Termos de Uso -->
                <div class="form-checkbox">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">
                        Eu concordo com os <a href="#">Termos de Uso</a> e
                        <a href="#">Política de Privacidade</a> do Conecta Cidade
                    </label>
                </div>

                <!-- Botão Submit -->
                <button type="submit" class="btn-submit">
                    Criar Minha Conta
                </button>
            </form>

            <div class="auth-divider">ou</div>

            <div class="auth-link">
                Já tem uma conta? <a href="{{ route('login') }}">Faça login</a>
            </div>
        </div>
    </div>

    <script>
        // Máscara para CPF
        document.getElementById('cpf').addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '').slice(0, 11);
        });

        // Máscara para Telefone
        document.getElementById('telefone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');

            if (value.length <= 11) {
                if (value.length > 6) {
                    value = value.replace(/^(\d{2})(\d{5})(\d{0,4}).*/, '($1) $2-$3');
                } else if (value.length > 2) {
                    value = value.replace(/^(\d{2})(\d{0,5})/, '($1) $2');
                } else if (value.length > 0) {
                    value = value.replace(/^(\d*)/, '($1');
                }
            }

            e.target.value = value;
        });
    </script>
@endsection
