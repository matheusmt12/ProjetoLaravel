<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pessoa;
class PessoaController extends Controller
{
    public function cadastrar(){


        return view('Pessoa.Create');
    }

    public function index(){

        $pessoas = Pessoa::all();

        return view('Pessoa.index',compact('pessoas'));


    }

    public function salvarPessoa(Request $request){

        Pessoa::create([
            'name' => $request->input('name'),
            'telefone'=> $request->input('telefone')
        ]);

        return redirect('/pessoa')->with('mensagem', 'Produto cadastrado.');
    }


    public function remove($id){


        $pessoa = Pessoa::find($id);
        

        if($pessoa){
            $pessoa->delete();
            return redirect('/')->with('mensagem', 'Venda removida com sucesso.');
        }
        return redirect('/')->with('mensagem', 'Venda removida com sucesso.');
    }
}
