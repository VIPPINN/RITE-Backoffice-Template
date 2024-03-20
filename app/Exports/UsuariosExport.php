<?php

namespace App\Exports;

use App\Models\Usuario;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class UsuariosExport implements FromQuery, WithTitle, WithHeadings, WithColumnWidths
{
    private $month;
    private $year;

    public function __construct(int $year, int $month)
    {
        $this->month = $month;
        $this->year  = $year;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        $empresasPrueba = DB::table('GrupoUsuario')->where('descripcion', 'LIKE', '%Prueba%')->first();
        $idPrueba = $empresasPrueba->id;
        $empresasAutorizado = DB::table('GrupoUsuario')->where('descripcion', 'LIKE', '%Autorizado%')->first();
        $idAutorizado = $empresasAutorizado->id;

        return Usuario::query()
            ->leftJoin('Clasificacion', 'Usuario.idClasificacionUltima', 'Clasificacion.id')
            ->select('Usuario.razonSocial', 'Usuario.fechaAlta', 'Clasificacion.id')
            ->whereYear('Usuario.fechaAlta', $this->year)
            ->whereMonth('Usuario.fechaAlta', $this->month)
            ->where('idTipoPersona', 2)
            ->where('Usuario.fechaBaja', NULL)
            ->where('idGrupoUsuario', '!=', $idPrueba)
            ->where('idGrupoUsuario', '!=', $idAutorizado);
    }

    public function title(): string
    {
        $meses = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
        return  $meses[$this->month - 1] . ' ' . $this->year;
    }

    public function headings(): array
    {
        return [
            'Razon Social',
            'Fecha Alta'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 50,
            'B' => 20      
        ];
    }
}
