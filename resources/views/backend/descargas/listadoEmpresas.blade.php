<table>
    <thead>
        <tr style="outline: 1px solid black">
            <th style="background-color: #157347;width:250px;color:white">Razon Social</th>
            <th style="background-color: #157347;width:150px;color:white">Grupo</th>
            <th style="background-color: #157347;width:200px;color:white">Actividad</th>
            <th style="background-color: #157347;width:150px;color:white">Categoria</th>
            <th style="background-color: #157347;width:250px;color:white;text-align:center">Rango Venta Inicial</th>
            <th style="background-color: #157347;width:250px;color:white;text-align:center">Rango Venta Final</th>
            <th style="background-color: #157347;width:250px;color:white;text-align:center">Rango Personal Inicial</th>
            <th style="background-color: #157347;width:250px;color:white;text-align:center">Rango Personal Final</th>
            <th style="background-color: #157347;width:270px;color:white;text-align:center">Programa de Integridad: Nivel Moderado</th>
            <th style="background-color: #157347;width:270px;color:white;text-align:center">Programa de Integridad: Nivel Medio</th>
            <th style="background-color: #157347;width:270px;color:white;text-align:center">Programa de Integridad: Nivel Avanzado</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($empresas as $empresa)
            <tr>
                <td>{{ $empresa->razonSocial }}</td>
                <td>{{ $empresa->Grupo ?? 'sin clasificar' }}</td>
                <td>{{ $empresa->Actividad ?? 'sin clasificar' }}</td>
                <td>{{ $empresa->Categoria ?? 'sin clasificar' }}</td>
                <td>{{ $empresa->RangoVentaInicial ?? 'sin clasificar' }}</td>
                @if ($empresa->RangoVentaFinal == null)
                    <td style="text-align: right">∞</td>
                @else
                    <td>{{ $empresa->RangoVentaFinal }}</td>
                @endif
                <td>{{ $empresa->RangoPersonalInicial ?? 'sin clasificar' }}</td>
                @if ($empresa->RangoPersonalFinal == null)
                    <td style="text-align: right">∞</td>
                @else
                    <td>{{ $empresa->RangoPersonalFinal }}</td>
                @endif

                <td style="text-align: right">{{$empresa->respuestaModerado}}/{{$empresa->totalModerado}} </td>
                <td style="text-align: right">{{$empresa->respuestaMedio}}/{{$empresa->totalMedio}} </td>
                <td style="text-align: right">{{$empresa->respuestaAvanzado}}/{{$empresa->totalAvanzado}} </td>
                
            </tr>
        @endforeach
    </tbody>
</table>
