<?php

namespace app\Services;

use Illuminate\Support\Facades\DB;

class UnicoRegistroService
{
    public function verificarSiEsElUnicoActivo($id) : bool
    {
        return $result = DB::table('QueEsRite')->where('id','!=', $id)->where('estado', 1)->exists();
    }
}