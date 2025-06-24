@extends('relatorios.base')
@section("content")
<div class="">
    <hr />
    <div class="row">
        <div class="col">
            <strong>
                Relatório: Produtos
            </strong>
        </div>
        <div class="col-md-4" style="text-align: right">
            <p>
                <strong>
                    Emissão: {{$data}}
                </strong>  
            </p>
        </div>
    </div>
    <hr />
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th scope="col">#</th>
                <!-- <th scope="col">Imagem</th> -->
                <th scope="col">Título</th>
                <th scope="col">Preço</th>
            </tr>
        </thead>
        <tbody>
            @foreach($produtos as $item)
                <tr>
                    <td>{{$item['id']}}</td>
                    <!-- <td><img src="{{$item['image']}}" width="110px" /></td> -->
                    <td>{{$item['titulo']}}</td>
                    <td style="text-align: center;">
                        <?php echo 'R$ ' . number_format($item['valor'], 2, ',', '.'); ?>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
