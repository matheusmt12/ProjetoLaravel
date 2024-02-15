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

        Produto::create([

            'name' => $request->input('name'),
            'valor' => $request->input('valor'),
        ]);
        return redirect('/produto')->with('mensagem', 'Produto cadastrado.');

    }
}
