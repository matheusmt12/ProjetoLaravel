<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Produto;
class ProdutoController extends Controller
{

    public function index(){

        $produtos = Produto::all();

        return view('Produto.index', compact('produtos'));

    }


    public function cadastrar(){
        return view('Produto.Create');
    }

    public function salvarProduto(Request $request){


        $request->validate([
            'name' => 'required|unique:pessoas'
        ],
        [
            'name.unique' => 'Este nome ja existe no banco'
        ]);


        Produto::create([

            'name' => $request->input('name'),
            'valor' => $request->input('valor'),
        ]);
        return redirect('/produto')->with('mensagem', 'Produto cadastrado.');

    }

    public function edit($idProduto){

        $produto = Produto::find($idProduto);

        return view('Produto.edit',compact('produto'));

    }

    public function editSalvar(Request $request){
        
        $produto = Produto::find($request->input('id'));


        if($produto){

            $produto->update([
                'id' => $request->input('id'),
                'name' => $request->input('name'),
                'valor' => $request->input('valor'),
            ]);
            return redirect('/produto')->with('mensagem', 'Produto editado.');
        }
        return redirect('/produto')->with('mensagem', 'Produto não encontrado.');

    }

    public function remove($id){


        $produto = Produto::find($id);

        if($produto){
            $produto->delete();
            return redirect('/produto')->with('mensagem', 'Produto removido com sucesso.');
        }
        return redirect('/produto')->with('mensagem', 'Falha ao remover produto.');
    }
}
