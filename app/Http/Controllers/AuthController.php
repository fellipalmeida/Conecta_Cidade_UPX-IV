<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Exibe o formulário de login
     */
    public function showLogin()
    {
        // Se já estiver logado, redireciona
        if (session('user_id')) {
            return redirect()->route('home');
        }

        return view('auth.login');
    }

    /**
     * Processa o login
     */
    public function login(Request $request)
    {
        // Validação
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ], [
            'email.required' => 'O email é obrigatório',
            'email.email' => 'Digite um email válido',
            'password.required' => 'A senha é obrigatória',
            'password.min' => 'A senha deve ter no mínimo 6 caracteres'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Buscar usuário
        $user = DB::table('users')
            ->where('email', $request->email)
            ->first();

        // Verificar se existe e se a senha está correta
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()
                ->withErrors(['email' => 'Email ou senha incorretos'])
                ->withInput();
        }

        // Criar sessão
        session([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_tipo' => $user->tipo
        ]);

        // Redirecionar baseado no tipo de usuário
        return redirect()->route('dashboard')
            ->with('success', 'Bem-vindo de volta, ' . $user->name . '!');
    }

    /**
     * Exibe o formulário de registro
     */
    public function showRegister()
    {
        // Se já estiver logado, redireciona
        if (session('user_id')) {
            return redirect()->route('home');
        }

        return view('auth.register');
    }

    /**
     * Processa o registro
     */
    public function register(Request $request)
    {
        // Validação
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'cpf' => 'required|string|size:11',
            'telefone' => 'nullable|string|max:15',
            'password' => 'required|string|min:6|confirmed',
            'cidade' => 'nullable|string|max:50'
        ], [
            'name.required' => 'O nome é obrigatório',
            'email.required' => 'O email é obrigatório',
            'email.email' => 'Digite um email válido',
            'cpf.required' => 'O CPF é obrigatório',
            'cpf.size' => 'O CPF deve ter 11 dígitos',
            'password.required' => 'A senha é obrigatória',
            'password.min' => 'A senha deve ter no mínimo 6 caracteres',
            'password.confirmed' => 'As senhas não conferem'
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        // Verificar se email já existe
        $emailExists = DB::table('users')
            ->where('email', $request->email)
            ->exists();

        if ($emailExists) {
            return back()
                ->withErrors(['email' => 'Este email já está cadastrado'])
                ->withInput();
        }

        // Verificar se CPF já existe
        $cpfExists = DB::table('users')
            ->where('cpf', $request->cpf)
            ->exists();

        if ($cpfExists) {
            return back()
                ->withErrors(['cpf' => 'Este CPF já está cadastrado'])
                ->withInput();
        }

        // Criar usuário
        try {
            $userId = DB::table('users')->insertGetId([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'cpf' => $request->cpf,
                'telefone' => $request->telefone,
                'tipo' => 'cidadao',
                'cidade' => $request->cidade ?? 'Sorocaba',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Fazer login automático
            $user = DB::table('users')->find($userId);

            session([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'user_tipo' => $user->tipo
            ]);

            return redirect()->route('dashboard')
                ->with('success', 'Cadastro realizado com sucesso! Bem-vindo ao Conecta Cidade!');

        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => 'Erro ao criar conta. Tente novamente.'])
                ->withInput();
        }
    }

    /**
     * Faz logout
     */
    public function logout()
    {
        session()->flush();

        return redirect()->route('home')
            ->with('success', 'Logout realizado com sucesso!');
    }
}
