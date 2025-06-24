@extends('relatorios.base')
@section("content")
    <hr />
    <div class="row">
        <div class="col">
            <strong>EMISSÃO: </strong> {{$date}}
            <hr />

            @foreach($data as $item)
                <strong>NOME/RAZÃO SOCIAL:</strong> {{$item->razao_social}} | {{$item->nome_fantasia}}<br />
                <strong>CNPJ / CPF: </strong>{{$item->cnpj}} | {{$item->cpf}} <br />
                <strong>ENDEREÇO:</strong> {{$item->logradouro}}, {{$item->numero}}
                <strong>CEP:</strong>  {{$item->cep}}  <strong>COMPLEMENTO:</strong>  {{$item->complemento}}  <br />
                <strong>BAIRRO:</strong> {{$item->bairro}} - <strong>MUNICÍPIO:</strong>  {{$item->cidade}} - <strong>ESTADO:</strong>  {{$item->uf}} <br />
                <strong>TELEFONES:</strong>  {{$item->fone}} | {{$item->celular}} | {{$item->telefone}} <br />
                <strong>VENDEDOR:</strong> {{$item->vendedor->name}} <br />
                <strong>OBS DO CLIENTE: </strong> {{$item->observacao}} <br />
                <strong>OBS DA VISITA: </strong>{{$item->visita ? $item->visita->observacao : ''}} <br />
                <strong>ÚLTIMA VISITA: </strong> {{$item->visita ? $item->visita->data : 'NÃO RECEBEU VISITA'}} - 
                <strong>ÚLTIMO PEDIDO: </strong> {{$item->venda ? $item->venda->data : 'NÃO REALIZOU PEDIDO'}} - 
                {{$item->venda ? $item->venda->dias . ' Dias' : ''}} 
                <br />
                {{$item->visita ? $item->visita->dias. ' Dias' : ''}} 
                <br />
                
                <br />
                <hr />
            @endforeach
        </div>
    </div>
    
@endsection
