<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\LogActivity;
use Illuminate\Support\Facades\DB;
use App\Services\ArchivoNombreCargadoService;


class DestroyCuestionarioController extends Controller
{
    public function destroy($id)
    {
    
      dd("hola");
      try{
        dd($id);
        $oldOrder = DB::table('Cuestionario')->select('descripcion')->where('id',$id)->first();
    
        $data['estadoAoI']    = 0;
        $data['fechaBaja'] = DB::raw('CURRENT_TIMESTAMP');
    
        DB::table('Cuestionario')->where('id', $id)->update($data);
    
        DB::commit();
    
        LogActivity::addToLog('Cuestionario - Se dió de baja el cuestionario '.$oldOrder->descripcion);
        
        $success = true;
    
        $message = "Cuestionario borrado con éxito";
    
        
      }catch (\Error $e){
        $success = false;
    
    $message = "Error al borrar el cuestionario";
      }
    
      
      
        return response()->json([
    
        'success' => $success,
          
       'message' => $message,
          
          ]);
       
    
    
       /*  return view('backend.nuevoCuestionario.index')
          ->with('success','El cuestionario se ha borrado con éxito'); */
    }
}