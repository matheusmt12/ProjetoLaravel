<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pessoa;
class PessoaController extends Controller
{
    public function cadastrar(){


        return view('Pessoa.Create');
    }


    public function salvarPessoa(Request $request){

        Pessoa::create([
            'name' => $request->input('name'),
            'telefone'=> $request->input('telefone')
        ]);

        return redirect('/')->with('mensagem', 'Produto cadastrado.');
    }
}
