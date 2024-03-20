<table>
    <thead>
        <tr style="outline: 1px solid black">
            <th style="background-color: #157347;width:250px;color:white">Razon Social</th>
            <th style="background-color: #157347;width:150px;color:white">¿La organización realizó una evaluación de sus
                riesgos particulares?</th>
            <th style="background-color: #157347;width:200px;color:white">¿Tiene la organización un Código de
                Ética/Conducta aprobado?</th>
            <th style="background-color: #157347;width:150px;color:white">¿Qué áreas de la organización y/o terceras
                personas participaron del diseño del Código de Etica/Conducta?</th>
            <th style="background-color: #157347;width:250px;color:white;text-align:center">¿Contiene una mención
                explícita a la Tolerancia Cero a los delitos previstos en el art. 1° de la Ley 27.401?</th>
            <th style="background-color: #157347;width:250px;color:white;text-align:center">¿Existen reglas y
                procedimientos aprobadas específicamente dirigidas a guiar las interacciones entre quienes integran la
                organización y quienes ejercen la función pública?</th>
            <th style="background-color: #157347;width:250px;color:white;text-align:center">¿Algunas de estas reglas y
                procedimientos están dirigidos a evitar irregularidades en los procesos de licitación y en la ejecución
                de contratos administrativos?</th>
            <th style="background-color: #157347;width:250px;color:white;text-align:center">¿Están extendidas a terceras
                partes que representan a la organización en esa interacción?</th>
            <th style="background-color: #157347;width:250px;color:white;text-align:center">¿Realiza la organización de
                algún tipo de capacitación general relativa al Programa de Integridad?</th>
            <th style="background-color: #157347;width:250px;color:white;text-align:center">¿Qué porcentaje de la
                nómina del personal actual fue entrenada en temas relativos al Código de Ética en el último año?</th>
            <th style="background-color: #157347;width:250px;color:white;text-align:center">¿A quién estuvo dirigida la
                capacitación?</th>
            <th style="background-color: #157347;width:250px;color:white;text-align:center">¿Con qué periodicidad
                actualiza la formación del personal ya capacitado?</th>
            <th style="background-color: #157347;width:250px;color:white;text-align:center">¿Tiene la organización un
                mecanismo de reporte como un canal o línea de integridad?</th>
            <th style="background-color: #157347;width:250px;color:white;text-align:center">¿De qué manera se puede
                utilizar el canal?
        </tr>
    </thead>
    <tbody>
        @foreach ($empresas as $empresa)
            <tr>
                <td>{{ $empresa->razonSocial }}</td>
                <td>{{ $empresa->Primera }}</td>
                <td>{{ $empresa->Segunda }}</td>
                <td>{{ $empresa->Tercera }}</td>
                <td>{{ $empresa->Cuarta }}</td>
                <td>{{ $empresa->Quinta }}</td>
                <td>{{ $empresa->Sexta }}</td>
                <td>{{ $empresa->Septima }}</td>
                <td>{{ $empresa->Octava }}</td>
                <td>{{ $empresa->Novena }}</td>
                <td>{{ $empresa->Decima }}</td>
                <td>{{ $empresa->DecimaPrimera }}</td>
                <td>{{ $empresa->DecimaSegunda }}</td>
                <td>{{ $empresa->DecimaTercera }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
