@extends('relatorios.base')
@section("content")
    <hr />
    <div class="row">
        <div class="col">
            <strong>EMISSÃO: </strong> {{$date}}
            <hr />
            @foreach($data as $item)
                <div style="border: 1px solid #CCC; border-radius: 10px; padding: 10px;">
                    <strong>DATA DA VISITA:</strong> {{$item->data_visita_f}} AS {{$item->hora_visita}}<br />
                    <strong>NOME/RAZÃO SOCIAL:</strong> {{$item->cliente->razao_social}} | {{$item->cliente->nome_fantasia}}<br />
                    <strong>CNPJ / CPF: </strong>{{$item->cliente->cnpj}} | {{$item->cliente->cpf}} <br />
                    <strong>ENDEREÇO:</strong> {{$item->cliente->logradouro}}, {{$item->cliente->numero}}
                    <strong>CEP:</strong>  {{$item->cliente->cep}}  <strong>COMPLEMENTO:</strong>  {{$item->cliente->complemento}}  <br />
                    <strong>BAIRRO:</strong> {{$item->cliente->bairro}} - <strong>MUNICÍPIO:</strong>  {{$item->cliente->cidade}} - <strong>ESTADO:</strong>  {{$item->cliente->uf}} <br />
                    <strong>TELEFONES:</strong>  {{$item->cliente->fone}} | {{$item->cliente->celular}} | {{$item->cliente->telefone}} <br />
                    <strong>VENDEDOR:</strong> {{$item->vendedor->name}} <br />
                    <strong>OBS DO CLIENTE: </strong> {{$item->observacao}} <br />
                </div>
                <hr />
            @endforeach
        </div>
    </div>
    
@endsection
