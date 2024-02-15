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


        $request->validate([
            'name' => 'required|unique:pessoas'
        ],
        [
            'name.unique' => 'Este nome ja existe no banco'
        ]
    
    );

      
        
        Pessoa::create([
            'name' => $request->input('name'),
            'telefone'=> $request->input('telefone')
        ]);

        return redirect('/pessoa')->with('mensagem', 'Produto cadastrado.');
    }

    public function edit($id){
        $pessoa = Pessoa::find($id);

        return view('Pessoa.edit', compact('pessoa'));

    }

    public function editSalvar(Request $request){

        $pessoa = Pessoa::find($request->input('id'));

        if($pessoa){
            $pessoa->update([
                'id' => $request->input('id'),
                'name' => $request->input('name'),
                'telefone' => $request->input('telefone'),
            ]);
            return redirect('/pessoa')->with('mensagem', 'Editado com sucesso.');
        }
        return redirect('/pessoa')->with('mensagem', 'Pessoa não encontrada.');
    }


    public function remove($id){


        $pessoa = Pessoa::find($id);
        

        if($pessoa){
            $pessoa->delete();
            return redirect('/pessoa')->with('mensagem', 'Pessoa removida com sucesso.');
        }
        return redirect('/pessoa')->with('mensagem', 'Falha ao remover pessoa.');
    }
}
