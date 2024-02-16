<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venda;
use App\Models\Parcela;
use App\Models\Pessoa;
use PDF;
use DateTime;
use App\Models\Produto;
class VendaController extends Controller
{


    public function index(){

        $vendas = Venda::all();
        return view('Venda.index',compact('vendas'));
    }

    public function consulta(Request $request){
        $query = $request->input('search');
    
        $vendas = Venda::when($query, function ($queryBuilder, $query) {
            return $queryBuilder->where('name', 'like', '%' . $query . '%');
        })->get();
    
        return view('Venda.index', compact('vendas'));
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




        if( $tipoVenda == 'vista'){
            $data = new DateTime();
            $venda = Venda::create([
    
                'name' => $request->input('name'),
                'valor' => $request->input('valor'),
                'data' => $data->format('Y-m-d H:i:s')
            
            ]);
            return redirect('/')->with('mensagem', 'Venda feita com sucesso');
        }else{
            $name = $request->input('name');
            return view('Venda.pagamentoPraso',compact('valor','name'));
        }

    }


    public function pagamento(Request $request){
       
        $parcelas = $request->input('parcela_valor');
        $dataVencimento = $request->input('parcela_data');
        $valor = $request->input('valorCompra');
        $name = $request->input('name');

        $parcelaTotal = 0;

        if (!is_array($parcelas) || empty($parcelas)) {
            return view('Venda.pagamentoPraso',compact('valor','name'))->with('erro', 'Voce precisa gerar as parcelas');
        }


        $data = new DateTime();
        $venda = Venda::create([

            'name' => $request->input('name'),
            'valor' => $request->input('valorCompra'),
            'data' => $data->format('Y-m-d H:i:s')
        
        ]);


        foreach ($parcelas as $key => $parcela ) {
            # code...
            $dataVencimentoParcela = $dataVencimento[$key];
            $parcela = $parcelas[$key];
             Parcela::create([
                'data_vencimento' => $dataVencimentoParcela ,
                'valor_parcela' => $parcela,
                'venda_id' => $venda->id
            ]);
        }
        


        $parcelasData = [
            'idVenda' => $venda->id,
            'parcelas' => $parcelas,
            'dataVencimento' => $dataVencimento
        ];

        $pdf = PDF::loadView('Venda.comprovante', $parcelasData);

        return tap($pdf->download("Parcelas$venda->id.pdf"), function () {
            redirect('/');
        });
        
    }

    public function resumoVenda($id){
        $vendas = Venda::find($id);
        if ($vendas){

            $resumo = [
                'name' => $vendas->name,
                'parcelas' =>$vendas->parcelas,
                'valor' =>$vendas->valor
            ];

            $pdf = PDF::loadView('resumoVenda', $resumo);

            return tap($pdf->download("Veanda.ResumoVenda$vendas->id.pdf"), function () {
                redirect('/');
            });

        }

    }
}
