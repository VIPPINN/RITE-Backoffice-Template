<table>
    <thead>
        <tr style="outline: 1px solid black">
                <th style="background-color: #157347;width:350px;color:white">Actividad</th>
                <th style="background-color: #157347;width:100px;color:white">Cantidad</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($actividades as $keyActividad => $actividad)
            <tr>
                <td>{{ $actividad->descripcion }}</td>
                <td>{{ $cantidades[$actividad->descripcion] }}</td>
            </tr>
        @endforeach
        <tr>
            <td style="background-color: red; color: white">No declara</td>
            <td style="background-color: red; color: white">{{ $noClasificadas}}</td>
        </tr>
    </tbody>
</table>
