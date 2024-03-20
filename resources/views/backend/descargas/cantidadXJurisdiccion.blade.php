<table>
    <thead>
        <tr style="outline: 1px solid black">
                <th style="background-color: #157347;width:350px;color:white">Provincia</th>
                <th style="background-color: #157347;width:300px;color:white">Cantidad de Empresas y Entidades Registradas</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($jurisdicciones as $keyCategoria => $jurisdiccion)
            <tr>
                <td>{{ $jurisdiccion->nombre }}</td>
                <td>{{ $cantidades[$jurisdiccion->nombre] }}</td>
            </tr>
        @endforeach
        <tr>
            <td style="background-color: red; color: white">No declara</td>
            <td style="background-color: red; color: white">{{ $noClasificadas}}</td>
        </tr>
    </tbody>
</table>
