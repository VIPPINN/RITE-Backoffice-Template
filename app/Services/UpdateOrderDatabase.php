<?php

namespace app\Services;

use Illuminate\Support\Facades\DB;

class UpdateOrderDatabase
{
    public function actualizarOrden($id, $tabla, $estado, $ordenNuevo)
    {
        
        $ultimoNumeroDeOrden = DB::table("$tabla")
                                ->select('orden')
                                ->where('estado',1)
                                ->orderBy('orden', 'desc')
                                ->first();
        
        if(is_null($id))
        {
            if($ultimoNumeroDeOrden && (intval($ordenNuevo) > (intval($ultimoNumeroDeOrden->orden) + 1))) return intval($ultimoNumeroDeOrden->orden) + 1;

            return DB::table("$tabla")
                        ->where('estado',$estado)
                        ->where('orden','>=',$ordenNuevo)
                        ->increment('orden', 1);
        }
        else 
        {
            $ordenActual = DB::table("$tabla")->select('orden')->where('id',$id)->first();
            
            if(intval($ordenActual->orden) === intval($ordenNuevo)) return 0;
            
            if(intval($ordenActual->orden) > intval($ordenNuevo))
            {
                return DB::table("$tabla")
                            ->where('estado',$estado)
                            ->where('orden','>=',intval($ordenNuevo))
                            ->where('orden','<',intval($ordenActual->orden))
                            ->increment('orden', 1);
            }
            else 
            {
                DB::table("$tabla")
                    ->where('estado',$estado)
                    ->where('orden','<=',intval($ordenNuevo))
                    ->where('orden','>',intval($ordenActual->orden))
                    ->decrement('orden', 1);

                if (intval($ordenNuevo) > (intval($ultimoNumeroDeOrden->orden))) 
                {
                    return intval($ultimoNumeroDeOrden->orden);
                }
                else 
                {
                    return 0;
                }
            }
        }
    }

}