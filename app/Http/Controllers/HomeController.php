<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Exibe a página inicial do Conecta Cidade
     */
    public function index()
    {
        return view('home.index');
    }
}
