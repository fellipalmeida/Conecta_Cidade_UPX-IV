<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Exibe a página de perfil do usuário.
     */
    public function show(Request $request)
    {
        $userId = session('user_id');

        if (!$userId) {
            return redirect()->route('login');
        }

        $user = DB::table('users')->where('id', $userId)->first();

        if (!$user) {
            // Se o usuário não for encontrado (raro), desloga
            return redirect()->route('logout');
        }

        return view('profile.show', compact('user'));
    }

    /**
     * Atualiza as informações do perfil do usuário.
     */
    public function update(Request $request)
    {
        $userId = session('user_id');

        if (!$userId) {
            return redirect()->route('login');
        }

        // Validação
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($userId), // Ignora o email do próprio usuário
            ],
            'password' => 'nullable|string|min:8|confirmed', // 'confirmed' busca por 'password_confirmation'
        ], [
            'name.required' => 'O campo nome é obrigatório.',
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'Por favor, insira um e-mail válido.',
            'email.unique' => 'Este e-mail já está em uso por outra conta.',
            'password.min' => 'A nova senha deve ter pelo menos 8 caracteres.',
            'password.confirmed' => 'A confirmação da nova senha não confere.',
        ]);

        // Dados a serem atualizados
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'updated_at' => now()
        ];

        // Se o usuário preencheu o campo de nova senha, atualiza a senha
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Atualiza no banco de dados
        DB::table('users')->where('id', $userId)->update($data);

        return redirect()->route('profile.show')
            ->with('success', 'Perfil atualizado com sucesso!');
    }
}
