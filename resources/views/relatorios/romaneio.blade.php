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
                <th style="text-align: center;">DESTINATÁRIO</th>
                <th style="text-align: center;">CIDADE</th>
                <th style="text-align: center;">Nº DO PEDIDO</th>
                <th style="text-align: center;">VALOR A RECEBER DO PEDIDO</th>
                <th style="text-align: center;">FORMA DE PAGAMENTO</th>
                <th style="text-align: center;">TIPO DE PAGAMENTO</th>
                <th style="text-align: center;">PESO</th>
                <th  width="300px" style="text-align: center;">OBSERVAÇÕES</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['data'] as $item)
                <tr>
                    <td style="text-align: center;">{{$item->cliente->razao_social}}</td>
                    <td style="text-align: center;">{{$item->cliente->cidade}}</td>
                    <td style="text-align: center;">{{$item->codigo}}</td>
                    <td style="text-align: center;">
                        <?php echo 'R$ ' . number_format($item->total, 2, ',', '.'); ?>
                    </td>
                    <td style="text-align: center;">{{$item->forma_pagamento_id ? $item->forma_pagamento->name : ''}}</td>
                    <td style="text-align: center;">{{$item->tipo_pagamento ? $item->tipo_pagamento->descricao : ''}}</td>
                    <td style="text-align: center;">{{$item->pesoTotal}}</td>
                    <td width="300px" style="text-align: center;"></td>
                </tr>
            @endforeach
            <tr>
                <td colspan="7">
                    Peso Total
                </td>
                <th>
                    <?php echo $data['peso']; ?>
                </th>
            </tr>
            <tr>
                <td colspan="7">
                    Valor Total
                </td>
                <th>
                    <?php echo 'R$ ' . number_format($data['total'], 2, ',', '.'); ?>
                </th>
            </tr>
        </tbody>
       
    </table>
</div>
@endsection
