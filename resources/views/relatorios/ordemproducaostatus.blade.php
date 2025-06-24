@extends('relatorios.base')
@section("content")
    <hr />
    <div class="row">
        <div class="col">
            <strong>ORDEM DE PRODUÇÃO:</strong> {{$data->id}} <br />
            <strong>EMISSÃO: </strong> {{$date}}
            <hr />
            
            <strong>PRODUTOS</strong>
            @foreach($data->produtos_agrupados as $key => $item)
                <table class="table table-striped table-hover" style="border: 1px solid #CCC; width: 100%;">
                    <thead>
                        <tr>
                            <th colspan="2">
                                STATUS: {{$key}} 
                            </th>
                        </tr>
                        <tr>
                            <th>DESCRIÇÃO DO PRODUTO</th>
                            <th class="text-right">PRODUÇÃO</th>
                            <th class="text-right">QTDE PEDIDO</th>
                            <th class="text-right">SITUAÇÃO </th>
                            <th class="text-right">QTDE DE ESTOQUE</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach($data->produtos_agrupados[$key] as $produto)
                                <tr>
                                    <td>{{$produto->produto->titulo}}</td>
                                    <td class="text-right">{{$produto->quantidade_estoque}}</td>
                                    <td class="text-right">{{$produto->quantidade}}</td>
                                    <td class="text-right">
                                            @if(($produto->quantidade_estoque - $produto->quantidade) > 0)
                                                SOBRA
                                            @else
                                                FALTA
                                            @endif
                                    </td>
                                    <td class="text-right">{{$produto->quantidade_estoque - $produto->quantidade}}</td>
                                </tr>
                            @endforeach
                    </tbody>
                </table>
            @endforeach
        </div>
    </div>
    
    
@endsection
