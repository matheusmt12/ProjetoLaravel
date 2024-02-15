<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venda;
use App\Models\Parcela;
use App\Models\Pessoa;
use App\Models\Produto;
class VendaController extends Controller
{


    public function index(){

        $vendas = Venda::all();
        return view('Venda.index',compact('vendas'));
    }

    public function salva(Request $request){
        $pessoas = Pessoa::all();
        $produtos = Produto::all();
        return view('Venda.criarVenda',compact('pessoas','produtos'));
    }


    public function remove($id){


        $venda = Venda::find($id);
        

        if($venda){

            $venda->parcelas()->delete();

            $venda->delete();
            return redirect('/')->with('mensagem', 'Venda removida com sucesso.');
        }
        return redirect('/')->with('mensagem', 'Venda removida com sucesso.');
    }


    public function detalhes($id) {
        $vendas = Venda::find($id);
        if ($vendas){

            return view('Venda.detalhes', compact('vendas'));

        }

    }
    
    public function criarVenda(Request $request){

        $precos = $request->input('precos');
        $tipoVenda = $request->input('tipoPagamento');
        $valor = $request->input('valor');


        
        $venda = Venda::create([

            'name' => $request->input('name'),
            'valor' => $request->input('valor'),
        ]);

        $idVenda = $venda->id;

        if( $tipoVenda == 'vista'){
            return redirect('/')->with('mensagem', 'Venda feita com sucesso');
        }else{
            return view('pagamentoPraso',compact('valor','idVenda'));
        }

    }


    public function pagamento(Request $request){
       
        $parcelas = $request->input('parcela_valor');
        $dataVencimento = $request->input('parcela_data');
        $idVenda = $request->input('idVenda');
        foreach ($parcelas as $key => $parcela ) {
            # code...
            $dataVencimentoParcela = $dataVencimento[$key];
            $parcela = $parcelas[$key];
             Parcela::create([
                'data_vencimento' => $dataVencimentoParcela ,
                'valor_parcela' => $parcela,
                'venda_id' => $idVenda
            ]);



        }

        return redirect('/')->with('mensagem', 'Venda feita com sucesso');
    }
}
