<?php

use App\Chamados;
use App\Models\Client;
use App\Models\Cor;
use App\Models\Pedido;
use App\Models\Produto;
use App\Models\ProdutosImages;
use App\Models\OrdemProducao;
use App\Models\ProdutoProducao;
use App\Models\EstoqueProducao;
use App\Models\ProdutoMontagem;
use App\Models\TabelaPreco;
use App\Models\StatusProducao;
use App\Services\Relatorios\OrdemProducaoStatusRelatorios;
use App\Services\Relatorios\PedidosProducaoRelatorios;
use App\Services\NegociosServices;
use App\Services\OrdemProducaoNegocios;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

// use NumberFormatter;

Route::get('/', function() {
    return view('welcome');
});

Route::get('/relatorios', 'RelatoriosController@index');
Route::get('/relatorio', function () { 
    $data = Client::take(4)->get();
    
    foreach($data as $item) {
        $item->vendedor;
        $item->tabela;
    }
    
    // return view('relatorios.clientes', [
    //     'data' => $data,
    //     'date' => Carbon::now()->setTimezone('America/Sao_Paulo')->format('d/m/Y H:i:s')
    // ]);
    
    $pdf = Pdf::loadView('relatorios.clientes', [
        'data' => $data,
        'date' => Carbon::now()->setTimezone('America/Sao_Paulo')->format('d/m/Y H:i:s')
    ]);
    return $pdf->stream('invoice.pdf');
    // return $pdf->download('invoice.pdf');
});

Route::post('/chamados', function(Request $request) {
    try {
        DB::beginTransaction();

        $data = $request->all();
        $data['status'] = 'ABERTO';
        $data['criado_por'] = 1;
        $data['cidade_id'] = '1';
        $params = $data;
        $this->params = $params;
        $data = Chamados::create($params);
        DB::commit();
        return response()->json(['message' => 'Registro Atualizado com Sucesso', 'data' => $data]);
        
    } catch(Exception $e) {
        DB::rollBack();
        return response()->json(['message' => $e->getMessage()], 500);
    }
});