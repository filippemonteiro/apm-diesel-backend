@extends('relatorios.base')
@section("content")
    <hr />
    <div class="row">
        <div class="col">
            <strong>ESTOQUE VS PEDIDO</strong> 
            <br />
            <strong>EMISSÃO: </strong> {{$date}}
            <hr />
            
            <strong>PRODUTOS</strong>
            <table class="table table-striped table-hover" style="border: 1px solid #CCC; width: 100%;">
                <thead>
                    <tr>
                        <th>DESCRIÇÃO DO PRODUTO</th>
                        <th class="text-right">QTDE EM ESTOQUE</th>
                        <th class="text-right">QTDE / PEDIDO</th>
                        <th class="text-right">SITUAÇÃO</th>
                        <th class="text-right">QTDE</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                        <tr>
                            <td>{{$item->titulo}}</td>
                            <td class="text-right">{{$item->quantidade_estoque ? $item->quantidade_estoque : 0}}</td>
                            <td class="text-right">{{$item->quantidade}}</td>
                            <td class="text-right">{{$item->quantidade - $item->quantidade_estoque < 0 ? 'SOBRA' : 'FALTA'}}</td>
                            <td class="text-right">{{$item->quantidade - $item->quantidade_estoque}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    
@endsection
