@extends('relatorios.base')
@section("content")
    <hr />
    <div class="row">
        <div class="col">
            <strong>ORDEM DE PRODUÇÃO:</strong> {{$data->id}} <br />
            <strong>EMISSÃO: </strong> {{$date}}
            <hr />
            
            <strong>PRODUTOS</strong>
            <table class="table table-striped table-hover" style="border: 1px solid #CCC; width: 100%;">
                <thead>
                    <tr>
                        <th>DESCRIÇÃO DO PRODUTO</th>
                        <th class="text-right">QTDE</th>
                        <!-- <th class="text-right">R$ UNIT.</th>
                        <th class="text-right">R$ SUBTOTAL</th>
                        <th class="text-right">R$ DESC.</th>
                        <th class="text-right">R$ TOTAL C/ DESC.</th> -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($data->produtos_agrupados as $item)
                        <tr>
                            <td>{{$item->produto->titulo}}</td>
                            <td class="text-right">{{$item->quantidade}}</td>
                            <!-- <td class="text-right">
                                {{$formatter->formatCurrency($item->preco, 'BRL')}}
                            </td>
                            <td class="text-right">
                                {{$formatter->formatCurrency($item->preco * $item->quantidade, 'BRL')}}
                            </td>
                            <td class="text-right">
                                {{$formatter->formatCurrency((($item->preco * $item->quantidade) * $data->desconto) / 100, 'BRL')}}
                            </td>
                            <td class="text-right">
                                {{$formatter->formatCurrency($item->preco * $item->quantidade - ((($item->preco * $item->quantidade) * $data->desconto) / 100), 'BRL')}}
                            </td> -->
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    
@endsection
