<?php

namespace app\Services;

use Illuminate\Support\Facades\DB;

class FormatearFecha
{
    public function DiaMesAnioToAnioMesDia($fecha)
    {
        if($fecha!='0000-00-00')
        {
            $v_fecha = explode('-',$fecha);
            $dia = $v_fecha[0];
            if (strlen($dia) == 1)
                $dia="0".$dia;
                $mes=$v_fecha[1];
            if (strlen($mes) == 1)
                $mes="0".$mes;
                $ano=$v_fecha[2];
                $ret_fecha = $ano ."-" . $mes . "-" .$dia;
        }
        else
        {
            $ret_fecha="";
        
        }
        return $ret_fecha;
    }
}