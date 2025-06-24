@extends('relatorios.base')
@section("content")
<div class="">
    <hr />
    <div class="row">
        <div class="col">
            <strong>EMISSÃO: </strong> {{$date}}
        </div>
    </div>
    <hr />
    <table class="table table-hover table-striped" style="width: 100%;">
        <thead>
            <tr>
                <th>Produto</th>
                <th class="text-right">Quantidade</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['list'] as $item)
                <tr>
                    <td>{{$item['produto']->titulo}}</td>
                    <td  class="text-right">{{$item['quantidade']}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table class="table table-hover table-striped" style="width: 100%;">
        <thead>
            <tr>
                <th>Nº do Pedido</th>
                <th>Cliente</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['pedidos'] as $item)
                <tr>
                    <td>{{$item->codigo}}</td>
                    <td>{{$item->cliente->razao_social}}</td>
                </tr>
            @endforeach
        </tbody>
        
    </table>
</div>
@endsection
