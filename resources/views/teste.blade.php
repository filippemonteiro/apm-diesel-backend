<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teste demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  </head>
  <body>
    <table class="table table-hover">
        <tr>
            <th>Produto</th>
            <th>Status</th>
            <th>Pedido Original</th>
            <th>Estoque</th>
            <th>Pedido de Producao</th>
            <th>Falta</th>
        </tr>
        @foreach($params as $item)
        <tr>
            <td>{{$item['produto']}}</td>
            <td>{{$item['status']}}</td>
            <td>{{$item['pedido_original']}}</td>
            
            <td>{{$item['estoque']}}</td>
            <td>{{$item['pedido']}}</td>
            <td>{{$item['falta']}}</td>
            
        </tr>
        @endforeach
    </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
</html>