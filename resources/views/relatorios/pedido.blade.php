@extends('relatorios.base')
@section("content")
    <hr />
    <div class="row">
        <div class="col">
            <strong>PEDIDO:</strong> {{$data->codigo}} <br />
            <strong>EMISSÃO: </strong> {{$date}}
            <hr />
            <strong>NOME/RAZÃO SOCIAL:</strong> {{$data->cliente->razao_social}} | {{$data->cliente->nome_fantasia}}<br />
            <strong>CNPJ / CPF: </strong>{{$data->cliente->cnpj}} | {{$data->cliente->cpf}} <br />
            <strong>ENDEREÇO:</strong> {{$data->cliente->logradouro}}, {{$data->cliente->numero}}
            <strong>CEP:</strong>  {{$data->cliente->cep}}  <strong>COMPLEMENTO:</strong>  {{$data->cliente->complemento}}  <br />
            <strong>BAIRRO:</strong> {{$data->cliente->bairro}} - <strong>MUNICÍPIO:</strong>  {{$data->cliente->cidade}} - <strong>ESTADO:</strong>  {{$data->cliente->uf}} <br />
            <strong>TELEFONES:</strong>  {{$data->cliente->fone}} | {{$data->cliente->celular}} | {{$data->cliente->telefone}} <br />
            <strong>FORMA PAGTO:</strong> {{$data->forma_pagamento ? $data->forma_pagamento->name : 'NÃO APLICADA'}} - 
            <strong>TIPO DE PAGTO: </strong> {{$data->tipo_pagamento ? $data->tipo_pagamento->descricao : 'NÃO APLICADA'}}
            <br /><strong>VENDEDOR:</strong> {{$data->vendedor->name}} <br />
            <strong>OBS DO CLIENTE: </strong> {{$data->cliente->observacao}} <br />
            <strong>PESO TOTAL: </strong> {{$data->peso_total}} - <strong>TIPO DE FRETE: </strong> {{$data->frete}}  <br />
            <hr />
            
            <strong>PRODUTOS</strong>
            <table class="table table-striped table-hover" style="border: 1px solid #CCC; width: 100%;">
                <thead>
                    <tr>
                        <th>PRODUTO</th>
                        <th class="text-right">QTDE</th>
                        <th class="text-right">R$ UNIT.</th>
                        <th class="text-right">R$ SUBTOTAL</th>
                        <th class="text-right">R$ DESC.</th>
                        <th class="text-right">R$ TOTAL C/ DESC.</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data->itens as $item)
                        @if($item->exibir)
                            <tr>
                                <td>{{$item->produto->titulo}}</td>
                                <td class="text-right">{{$item->quantidade}}</td>
                                <td class="text-right">
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
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <table style="width: 100%">
        <tr>
            <td width="50%">
                Declaro que estou de pleno acordo com o pedido.<br />
                ___________________________________ <br />
                {{$data->cliente->razao_social}}
            </td>
            <td width="50%">
                <table  class="table table-striped table-hover" >
                    <tbody>
                        <tr>
                            <td>VALOR PRODUTO</td>
                            <td class="text-right">
                                <strong>
                                    {{$formatter->formatCurrency($data->total, 'BRL')}}
                                </strong>

                            </td>
                        </tr>
                        <tr>
                            <td>(-) DESCONTO</td>
                            <td class="text-right">
                                <strong>
                                    {{$formatter->formatCurrency($data->total * $data->desconto / 100, 'BRL')}}
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <th>VALOR A PAGAR</th>
                            <td class="text-right">
                                <strong>
                                    <?php 
                                        $total = $data->total - ($data->total * $data->desconto / 100);
                                        echo $formatter->formatCurrency($total, 'BRL') . '<br>';
                                    ?>
                                </strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>   
    <hr />
    <div class="row">
        <div class="col">
            Pedido conferido e recebido: Data: ___/___/______. <br /><br />
            Ass: __________________________________________________ <br />
            {{$data->cliente->razao_social}}
        </div>
    </div>
    <div class="row">
        <div class="col">
            <strong>HISTÓRICO DO PEDIDO</strong>
            <table class="table table-striped table-hover" style="border: 1px solid #CCC; width: 100%;">
                <thead>
                    <tr>
                        <th>STATUS</th>
                        
                        <th>OBSERVAÇÃO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data->historicos as $item)
                        <tr>
                            <td>{{$item->status}}</td>
                            <td>{{$item->observacao}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
@endsection
