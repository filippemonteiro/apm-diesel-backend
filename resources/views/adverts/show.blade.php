@extends('layouts.master')
@section('content')
    <br />
    <br />
    <h3>Detalhes do Produto</h3>
    <h6>
        <strong>ID:</strong>  {{$data->id}}
    </h6>
    <h6>
        <strong>Site ID:</strong>  {{$data->site_id}}
    </h6>
    <h6>
        <strong>Título:</strong> 
        {{$data->title}}
    </h6>
    <h6>
        <strong>Sub título:</strong> 
        {{$data->subtitle}}
    </h6>
    <h6>
        <strong>Descrição ID:</strong> 
        <ul>
            @foreach($data->descriptions as $des)
                <li>
                    <a href="/description/show/{{$data->id}}">{{$des->id}}</a>
                </li>
                <hr />
            @endforeach      
        <ul>
    </h6>
    <h6>
        <strong>Descrição:</strong> 
        {{$description}}
    </h6>
    <h6>
        <strong>Vendedor ID: </strong> 
        {{$data->seller_id}}
    </h6>
    <h6>
        <strong>Categoria ID: </strong> 
        <a href="/categories/show/{{$data->category_id}}">{{$data->category_id}}</a>
    </h6>
    <h6>
        <strong>Preço:</strong> 
        {{$data->price}}
    </h6>
    <h6>
        <strong>Preço Base:</strong> 
        {{$data->base_price}}
    </h6>
    <h6>
        <strong>Preço Original:</strong> 
        {{$data->original_price}}
    </h6>
    <h6>
        <strong>Preço Base:</strong> 
        {{$data->base_price}}
    </h6>
    <h6>
        <strong>Inventário ID:</strong> 
        {{$data->inventory_id}}
    </h6>

    <h6>
        <strong>Moeda ID:</strong> 
        {{$data->currency_id}}
    </h6>
    <h6>
        <strong>Qualidade Inicial:</strong> 
        {{$data->initial_quantity}}
    </h6>
    <h6>
        <strong>Qualidade Disponível:</strong> 
        {{$data->available_quantity}}
    </h6>
    <h6>
        <strong>Qualidade Vendida:</strong> 
        {{$data->sold_quantity}}
    </h6>
    <h3>Termos</h3>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Valor ID</th>
                <th>Nome de Valor</th>
                <th>Detalhes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data->sale_terms as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->value_id }}</td>
                    <td>{{ $item->value_name }}</td>
                    <td>
                        <ul>
                            
                        </ul>
                    </td>

                </tr>
            @endforeach()
        </tbody>
    </table> 
    <h6>
        <strong>Modo de Compra:</strong> 
        {{$data->buying_mode}}
    </h6>

    <h6>
        <strong>Listagem de Tipo ID :</strong> 
        {{$data->listing_type_id}}
    </h6>

    <h6>
        <strong>Iniciado em:</strong> 
        {{$data->start_time}}
    </h6>
    <h6>
        <strong>Parado em:</strong> 
        {{$data->stop_time}}
    </h6>
    <h6>
        <strong>Parado em:</strong> 
        {{$data->stop_time}}
    </h6>
    <h6>
        <strong>Finalizado em:</strong> 
        {{$data->end_time}}
    </h6>
    <h6>
        <strong>Tempo de Expiracao:</strong> 
        {{$data->condition}}
    </h6>
    
    <h6>
        <strong>Condição:</strong> 
        {{$data->expiration_time}}
    </h6>
    <h6>
        <strong>Link:</strong> 
        <a href="{{$data->permalink}}" target="_blank">{{$data->permalink}}</a>
    </h6>
    <h6>
        <strong>Imagem thumbnail:</strong> 
        <a href="{{$data->thumbnail}}" target="_blank">{{$data->thumbnail}}</a>
    </h6>
    <h6>
        <strong>Imagem Segura:</strong> 
        <a href="{{$data->secure_thumbnail}}" target="_blank">{{$data->secure_thumbnail}}</a>
    </h6>
    <h3>Imagens</h3>
    <div class="row">
        @foreach($data->pictures as $image)
            <div class="col-md-3">
                <img src="{{ $image->url }}" width="200px"  />
            </div>    
        @endforeach()   
    </div>       
    <h6>
        <strong>Vídeo: ID</strong> 
        {{$data->video_id}}
    </h6>

    <h6>
        <strong>Aceita Mercago Pago: </strong> 
        {{$data->accepts_mercadopago}}
    </h6>

    
@endsection()
