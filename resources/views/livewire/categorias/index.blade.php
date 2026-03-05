<div>
 <table class="table-auto">
  <thead>
    <tr>
      <th>Id</th>
      <th>Nome</th>
      <th>Estado</th>
      <th>Operações</th>
    </tr>
  </thead>
  <tbody>
        @foreach  ($categorias as $categoria)
        <tr>
        <td>{{$categoria->id}}</td>  
        <td>{{$categoria->nome}}</td>
        <td>{{$categoria->estado}}</td>
        <td>...</td>
</tr>
        @endforeach
  </tbody>
</table>

</div>
