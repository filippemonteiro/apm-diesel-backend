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
            @foreach($data as $item)
                <tr>
                    <td>{{$item['produto']->titulo}}</td>
                    <td  class="text-right">{{$item['quantidade']}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
