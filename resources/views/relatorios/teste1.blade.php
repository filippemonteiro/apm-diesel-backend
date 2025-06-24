@extends('relatorios.base')
@section("content")
<div class="row">
  <div class="col">
    <hr />
          @if(count($data['produtos']))
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
                              <td class="text-right" style="width: 50px">{{$produto['quantidade']}}</td>
                              <td class="text-right" style="width: 50px">{{$produto['estoque'] ?? 0}}</td>
                              <td class="text-right" style="width: 50px">
                                  @if(($produto['quantidade'] - $produto['estoque']) > 0)
                                    FALTA
                                  @else
                                    SOBRA
                                  @endif
                              </td>
                              <td class="text-right" style="width: 50px">{{abs(($produto['quantidade'] - $produto['estoque']) ?? 0)}}</td>
                          </tr>
                      @endforeach
              </tbody>
            </table>
            <p>Página <?php echo 1; ?></p>
            <div class="page-break"></div>
          @endif
          @foreach($data['lista'] as $key => $item)
            
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
                    @foreach($data['lista'][$key]['produtos'] as $produto)
                      
                        <tr>
                            <td style="width: 20px">{{$produto['produto_montagem_id'] ?? ''}}</td>
                            <td style="width: 200px">{{$produto['titulo'] ?? ''}} {{$produto['cor'] ?? ''}}</td>
                            <td class="text-right" style="width: 50px">{{$produto['_quantidade']}}</td>
                            <td class="text-right" style="width: 50px">{{$produto['_estoque'] ?? 0}}</td>
                            <td class="text-right" style="width: 50px">
                              @if(($produto['_quantidade'] - ($produto['_estoque'] ?? 0)) > 0 && $produto['_quantidade'] > 0)
                                FALTA
                              @else
                                SOBRA
                              @endif
                            </td>
                            <td class="text-right" style="width: 50px">{{abs($produto['_falta'] ?? 0)}}</td>
                        </tr>
                      
                    @endforeach
                </tbody>
            </table>
            <p>Página <?php echo $key + 2; ?></p>
            
          @endforeach
  </div>
</div>
@endsection