<table>
    <thead>
        <tr style="outline: 1px solid black">
                <th style="background-color: #157347;width:350px;color:white">Categoria</th>
                <th style="background-color: #157347;width:100px;color:white">Cantidad</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($categorias as $keyCategoria => $categoria)
            <tr>
                <td>{{ $categoria->descripcion }}</td>
                <td>{{ $cantidades[$categoria->descripcion] }}</td>
            </tr>
        @endforeach
        <tr>
            <td style="background-color: red; color: white">No declara</td>
            <td style="background-color: red; color: white">{{ $noClasificadas}}</td>
        </tr>
    </tbody>
</table>
