@extends('relatorios.base')
@section("content")
<div class="">
    <hr />
    <div class="row">
        <div class="col">
            <strong>EMISSÃO: </strong> {{$date}}

            <?php if(!empty($data['data_inicio'])): ?>
                <br />
                <strong>PERÍODO: </strong> {{$data['data_inicio']}} à {{$data['data_fim']}}
            <?php endif; ?>
            
            
        </div>
    </div>
    <hr />
    @foreach($data['list'] as $item)
        
        <strong>Vendedor(a): {{$item['vendedor']->name}}</strong>
        <table class="table table-hover table-striped" style="width: 100%;">
            <thead>
                <tr>
                    <th>EMISSÃO</th>
                    <th>CÓD. PEDIDO</th>
                    <th>DTA. ENTREGA</th>
                    <th>RAZÃO SOCIAL</th>
                    <th>CNPJ/CPF</th>
                    <th class="text-right">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @foreach($item['pedidos'] as $pedido)
                    <tr>
                        <td>{{$pedido->created_at->format('d/m/Y')}}</td>
                        <td>{{$pedido->codigo}}</td>
                        <td>{{$pedido->data_entrega}}</td>
                        <td>{{$pedido->cliente->razao_social}}</td>
                        <td>{{$pedido->cliente->cnpj ? $pedido->cliente->cnpj : $pedido->cliente->cpf}}</td>
                        <th class="text-right"> 
                            {{$formatter->formatCurrency($pedido->total, 'BRL')}}
                        </th>
                    </tr>
                @endforeach()
                <tr>
                    <th colspan="4">Total</th>
                    <th class="text-right">
                        {{$formatter->formatCurrency($item['total'], 'BRL')}}
                    </th>
                </tr>
            </tbody>
        </table>
           
    @endforeach()  
            
    <table class="table table-hover table-striped" style="width: 100%;">
        <thead>
            <tr>
                <th>Total Geral</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th class="text-right"> 
                    {{$formatter->formatCurrency($data['total_geral'], 'BRL')}}
                </th>
            </tr>
        </tbody>
    </table>
    
</div>
@endsection
