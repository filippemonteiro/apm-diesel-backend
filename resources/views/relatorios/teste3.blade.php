@extends('relatorios.base')
@section("content")
<div class="row">
  <div class="col">
    <hr />
        <table class="table table-striped table-hover" style="border: 1px solid #CCC; width: 100%;">
          <thead>
              <tr>
                  <th colspan="5">
                    PEDIDO VS ESTOQUE LOJA
                  </th>
              </tr>
              <tr>
                  <th class="text-right" style="width: 20px">COD</th>
                  <th style="width: 200px">DESCRIÇÃO DO PRODUTO</th>
                  <th class="text-right" style="width: 50px">QTDE PEDIDO</th>
                  <th class="text-right" style="width: 50px">QTDE DE ESTOQUE</th>
                  <th class="text-right" style="width: 50px">SITUAÇÃO </th>
                  <th class="text-right" style="width: 50px">TOTAL </th>
              </tr>
              
          </thead>
          <tbody>
                  @foreach($data['produtos'] as $produto)
                      <tr>
                          <td style="width: 20px">{{$produto['codigo'] ?? ''}}</td>
                          <td style="width: 200px">{{$produto['titulo'] ?? ''}}</td>
                          <td class="text-right" style="width: 50px">{{$produto['quantidade_pedido']}}</td>
                          <td class="text-right" style="width: 50px">{{$produto['quantidade_estoque'] ?? 0}}</td>
                          <td class="text-right" style="width: 50px">
                              @if($produto['falta'] > 0)
                                FALTA
                              @else
                                SOBRA
                              @endif
                          </td>
                          <td class="text-right" style="width: 50px">{{abs($produto['falta'] ?? 0)}}</td>
                      </tr>
                  @endforeach
          </tbody>
        </table>
        <?php $count = 1; ?>
        <p>Página <?php echo $count; ?></p>
        @foreach($data['lista'] as $key => $item)
        <?php $count++; ?>
          @if($item['agrupado_por'] == 'semi_produto') 
            <div class="page-break"></div>
            <table class="table table-striped table-hover" style="border: 1px solid #CCC; width: 100%;">
              <thead>
                  <tr>
                      <th colspan="5">
                          STATUS: {{$item['status']}} 
                      </th>
                  </tr>
                  <tr>
                      <th class="text-right" style="width: 20px">COD</th>
                      <th style="width: 200px">DESCRIÇÃO DO PRODUTO</th>
                      <th class="text-right" style="width: 50px">QTDE PEDIDO</th>
                      <th class="text-right" style="width: 50px">QTDE DE ESTOQUE</th>
                      <th class="text-right" style="width: 50px">SITUAÇÃO </th>
                      <th class="text-right" style="width: 50px">TOTAL </th>
                  </tr>
              </thead>
              <tbody>
              @foreach($item['produtos'] as $cor => $itemCor)
                <tr>
                  <td style="width: 20px">{{$itemCor['produto_montagem_id'] ?? ''}}</td>
                  <td style="width: 200px">{{$itemCor['titulo'] ?? ''}}</td>
                  <td class="text-right" style="width: 50px">{{$itemCor['pedido']}}</td>
                  <td class="text-right" style="width: 50px">{{$itemCor['estoque'] ?? 0}}</td>
                  <td class="text-right" style="width: 50px">
                    @if(($itemCor['pedido'] - ($itemCor['estoque'] ?? 0)) > 0 && $itemCor['pedido'] > 0)
                      FALTA
                    @else
                      SOBRA
                    @endif
                  </td>
                  <td class="text-right" style="width: 50px">{{($itemCor['pedido'] ?? 0) - abs($itemCor['estoque'] ?? 0)}}</td>
                </tr>
              @endforeach
              </tbody>  
            </table>
            <p>Página <?php echo $count; ?></p>
            
          @endif

          @if($item['agrupado_por'] == 'cor') 
            <div class="page-break"></div>
            <table class="table table-striped table-hover" style="border: 1px solid #CCC; width: 100%;">
              <thead>
                <tr>
                  <th colspan="5">
                      STATUS: {{$item['status']}} 
                  </th>
                </tr>
                <tr>
                  <th class="text-right" style="width: 20px">COD</th>
                  <th style="width: 200px">DESCRIÇÃO DO PRODUTO</th>
                  <th class="text-right" style="width: 50px">QTDE PEDIDO</th>
                  <th class="text-right" style="width: 50px">QTDE DE ESTOQUE</th>
                  <th class="text-right" style="width: 50px">SITUAÇÃO </th>
                  <th class="text-right" style="width: 50px">TOTAL </th>
                </tr>
              </thead>
              <tbody>
                @foreach($item['produtos'] as $cor => $itemCor)
                  @foreach($itemCor as $semiProduto) 
                    @foreach($semiProduto as $produto) 
                      <tr>
                        <td style="width: 20px">{{$produto['produto_montagem_id'] ?? ''}}</td>
                        <td style="width: 200px">{{$produto['titulo'] ?? ''}}</td>
                        <td class="text-right" style="width: 50px">{{$produto['pedido']}}</td>
                        <td class="text-right" style="width: 50px">{{$produto['estoque'] ?? 0}}</td>
                        <td class="text-right" style="width: 50px">
                          @if(($produto['pedido'] - ($produto['estoque'] ?? 0)) > 0 && $produto['pedido'] > 0)
                            FALTA
                          @else
                            SOBRA
                          @endif
                        </td>
                        <td class="text-right" style="width: 50px">{{($produto['pedido'] ?? 0) - abs($produto['estoque'] ?? 0)}}</td>
                      </tr>
                    @endforeach  
                  @endforeach
                @endforeach 
              </tbody>
            </table> 
            <p>Página <?php echo $count; ?></p>
          @endif
        @endforeach
  </div>
</div>
@endsection