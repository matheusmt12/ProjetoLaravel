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
            $idVenda = null;
            return view('Venda.pagamentoPraso',compact('valor','name','idVenda'));
        }

    }


    public function pagamento(Request $request){
       
        $parcelas = $request->input('parcela_valor');
        $dataVencimento = $request->input('parcela_data');
        $valor = $request->input('valorCompra');
        $name = $request->input('name');
        $idVenda = $request->input('idVenda');
        $parcelaTotal = 0;

        if (!is_array($parcelas) || empty($parcelas)) {
            return view('Venda.pagamentoPraso',compact('valor','name'))->with('erro', 'Voce precisa gerar as parcelas');
        }

        if($idVenda == null){
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
        }else{

            $data = new DateTime();
            $venda = Venda::find($idVenda);
            $venda->update([
                'id' => $idVenda,
                'name' => $request->input('name'),
                'valor' => $valor,
                'data' => $data->format('Y-m-d H:i:s')
            
            ]);

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

        }


        // $parcelasData = [
        //     'idVenda' => $venda->id,
        //     'parcelas' => $parcelas,
        //     'dataVencimento' => $dataVencimento
        // ];

        // $pdf = PDF::loadView('Venda.comprovante', $parcelasData);

        // return tap($pdf->download("Parcelas$venda->id.pdf"), function () {
        //     redirect('/');
        // });
        
        return redirect('/');
    }

    public function edit($id){

        $vendas = Venda::find($id);
        $pessoas = Pessoa::all();
        
        return view('Venda.edit',compact('vendas','pessoas'));
           
    }

    public function editSalvar(Request $request){

        $venda = Venda::find($request->input('id'));
        $tipoVenda = $request->input('tipoPagamento');
        $parcelas = count($venda->parcelas);
        if($venda){

            if($parcelas == 0){

                if( $tipoVenda == 'vista'){
                    
                    $data = new DateTime();
                    $venda->update([
                        'id' => $request->input('id'),
                        'name' => $request->input('name'),
                        'valor' => $request->input('valor'),
                        'data' => $data->format('Y-m-d H:i:s')
                    
                    ]);
                }
                else{
                    $idVenda = $request->input('id');
                    $name = $request->input('name');
                    $valor = $request->input('valor');
                    return view('Venda.pagamentoPraso',compact('valor','name','idVenda'));

                }
            }elseif ($parcelas != 0 && $tipoVenda == 'vista') {

                $venda->parcelas()->delete();
                $data = new DateTime();
                $venda->update([
                    'id' => $request->input('id'),
                    'name' => $request->input('name'),
                    'valor' => $request->input('valor'),
                    'data' => $data->format('Y-m-d H:i:s')
                
                ]);
            }
            else{

                $idVenda = $request->input('id');
                $valor = $request->input('valor');
                $name = $request->input('name');
                $venda->parcelas()->delete();
                return view('Venda.pagamentoPraso',compact('valor','name','idVenda'));
            }
        }
            return redirect('/');
    }

    

    public function resumoVenda($id){
        $vendas = Venda::find($id);
        if ($vendas){

            $resumo = [
                'name' => $vendas->name,
                'parcelas' =>$vendas->parcelas,
                'valor' =>$vendas->valor
            ];

            $pdf = PDF::loadView('Venda.resumoVenda', $resumo);

            return tap($pdf->download("ResumoVenda$vendas->id.pdf"), function () {
                redirect('/');
            });

        }

    }
}
