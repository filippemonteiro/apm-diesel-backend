@extends('relatorios.base')
@section("content")
    <hr />
    <div class="row">
        <div class="col">
            <strong>ORDEM DE PRODUÇÃO:</strong> {{$data['id']}} <br />
            <strong>SETOR DE PRODUÇÃO:</strong> {{$data['producao']->nome}} <br />
            <strong>EMISSÃO: </strong> {{$date}}
            <hr />
            
            <strong>PRODUTOS</strong>
            <table class="table table-striped table-hover" style="border: 1px solid #CCC; width: 100%;">
                <thead>
                    <tr>
                        <th>DESCRIÇÃO DO PRODUTO</th>
                        <th class="text-right">QTDE ESTOQUE</th>
                        <th class="text-right">QTDE PEDIDO</th>
                        <th class="text-right">SITUAÇÃO </th>
                        <th class="text-right">TOTAL</th>
                        <!-- <th class="text-right">R$ UNIT.</th>
                        <th class="text-right">R$ SUBTOTAL</th>
                        <th class="text-right">R$ DESC.</th>
                        <th class="text-right">R$ TOTAL C/ DESC.</th> -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['lista'] as $produto)
                        <tr>
                            <td>
                                {{$produto['titulo']}}
                                @if($data['producao']->agrupar_por == 'cor')
                                    - {{$produto['cor']}}
                                @endif
                            </td>
                            <td class="text-right">{{$produto['quantidade_estoque']}}</td>
                            <td class="text-right">{{$produto['quantidade']}}</td>
                            <td class="text-right">
                                    @if(($produto['quantidade_estoque'] - $produto['quantidade']) > 0)
                                        SOBRA
                                    @else
                                        FALTA
                                    @endif
                            </td>
                            <td class="text-right">{{$produto['quantidade_estoque'] - $produto['quantidade']}}</td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    
@endsection
