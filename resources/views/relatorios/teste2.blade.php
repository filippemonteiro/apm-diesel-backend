@extends('relatorios.base')
@section("content")
<div class="row">
  <div class="col">
    <hr />
        @foreach($data as $key => $item)
          <table class="table table-striped table-hover" style="border: 1px solid #CCC; width: 100%;">
              <thead>
                  <tr>
                      <th colspan="5">
                          
                      </th>
                  </tr>
                  <tr>
                        <th class="text-right">COD</th>
                      <th>DESCRIÇÃO DO PRODUTO</th>
                      <th class="text-right">QTDE PEDIDO</th>
                      <th class="text-right">QTDE DE ESTOQUE</th>
                      <th class="text-right">SITUAÇÃO </th>
                      <th class="text-right">TOTAL </th>
                  </tr>
                  
              </thead>
              <tbody>
                      @foreach($item as $produto)
                          <tr>
                            <td>{{$produto['produto_montagem_id'] ?? ''}}</td>
                              <td>{{$produto['titulo'] ?? ''}}</td>
                              <td>{{$produto['pedido']}}</td>
                              <td>{{$produto['estoque'] ?? 0}}</td>
                              <td>
                                  @if(($produto['pedido'] - ($produto['estoque'] ?? 0)) > 0 && $produto['pedido'] > 0)
                                    FALTA
                                  @else
                                    SOBRA
                                  @endif
                              </td>
                              <td>{{abs($produto['falta'] ?? 0)}}</td>
                          </tr>
                      @endforeach
              </tbody>
          </table>
          <p>Página <?php echo $key + 1; ?></p>
          <div class="page-break"></div>
      @endforeach
  </div>
</div>
@endsection