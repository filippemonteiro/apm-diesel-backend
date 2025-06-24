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
    <div class="row">
        <div class="col">
            <strong>TABELA DE PREÇO: </strong> {{$data['tabela']->name}}
        </div>
    </div>
    <table class="table table-hover table-striped" style="width: 100%;">
        <thead>
            <tr>
                <th" width="140px">CÓD. PRODUTO</th>
                <th" width="140px">CÓD. DE BARRAS</th>
                <th" width="140px">NCM</th>
                <th">PRODUTO</th>
                <th style="text-align: center;">VALOR</th>
                <!-- <th style="text-align: center;">Nº DO PEDIDO</th>
                <th style="text-align: center;">VALOR A RECEBER DO PEDIDO</th>
                <th style="text-align: center;">FORMA DE PAGAMENTO</th>
                <th style="text-align: center;">OBSERVAÇÕES</th> -->
            </tr>
        </thead>
        <tbody>
            @foreach($data['produtos'] as $item)
                <tr>
                    <td>{{$item->codigo_geral}}</td>
                    <td>{{$item->codigo}}</td>
                    <td>{{$item->ncm}}</td>
                    <td>{{$item->titulo}}</td>
                    <td style="text-align: center;">
                        <?php echo 'R$ ' . number_format($item->preco, 2, ',', '.'); ?>
                    </td>
                    <!-- <td style="text-align: center;">{{$item->codigo}}</td>
                    <td style="text-align: center;">{{$item->total}}</td>
                    <td style="text-align: center;">{{$item->forma_pagamento && $item->forma_pagamento->nome}}</td>
                    <td style="text-align: center;">{{$item->observacao}}</td> -->
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
