@extends('layouts.master')
@section('content')
    <h5>Listagem de Códigos de Anúncios</h5>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Código do Produto</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
                <tr>
                    <td>{{ $item }}</td>
                    <td><a href="/adverts/show/{{$item}}">Ver Detalhes</a></td>
                </tr>
            @endforeach
        </tbody>
    </table> 
    {{ $offset }} de {{ $limit }} de Total de {{ $total }} Registros
    
@endsection()