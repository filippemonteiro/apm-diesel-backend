@extends('relatorios.base')
@section("content")
<div class="">
    <hr />
    <div class="row">
        <div class="col">
            <strong>
                Relatório: Produtos Mais Vendidos
            </strong>
        </div>
        <div class="col-md-4" style="text-align: right">
            <p>
                <strong>
                    Emissão: {{$date}}
                </strong>  
            </p>
        </div>
    </div>
    <hr />
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th scope="col">Título</th>
                <th scope="col">Quantidade</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
                <tr>
                    <td>{{$item->produto->titulo}}</td>
                    <td>{{$item->quantidade}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
