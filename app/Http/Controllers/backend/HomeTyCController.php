<?php

namespace App\Http\Controllers\backend;

use DB;
use Image;
use Carbon\Carbon;
use App\Models\HomeTyC;
use App\Models\TyCPDFs;
use Illuminate\Support\Str;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use App\Services\FiltroService;
use App\Services\FormatearFecha;
use App\Http\Controllers\Controller;
use App\Services\UpdateOrderDatabase;
use App\Http\Requests\UpdateHomeTyCRequest;
use App\Http\Requests\UpdateHomeTyCPDFsRequest;
use App\Services\ArchivoNombreCargadoService;



class HomeTyCController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filtro($estado)
    {
        if(!is_numeric($estado)) return abort(404);
        
        $filtro = new FiltroService();
        $tyc = $filtro->filtroEstadoOrdenadoTyC($estado, 'TyC');

        return view('backend.tyc.index', [
            'tyc' => $tyc
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // Indices
      
        $tyc = DB::table('TyC')
            ->Join('Cuestionario', 'TyC.id_cuestionario', '=', 'Cuestionario.id') 
           ->select(
                'tyc.*',
                'Cuestionario.descripcion AS descripcionCuestionario',
           )
            ->where('Cuestionario.fechaBaja',null)
            ->paginate(10);
           // $tyc = DB::table('TyC')
           
        LogActivity::addToLog('TyC - Listado');

      return view('backend.tyc.index', [
        'tyc' => $tyc
      ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    
        $cuestionarios = DB::table('Cuestionario')->get();
       /*  $ultimoNumeroDeOrden = DB::table('TyC')
                                ->select('id')
                                ->where('estado',1)
                                ->orderBy('id')
                                ->first(); */
        
        return view('backend.tyc.create', [
            'cuestionarios' => $cuestionarios
     
          ]);
            
        //     ,
        //     'ultimoNumeroDeOrden' => $ultimoNumeroDeOrden == null ? 0 : $ultimoNumeroDeOrden->id
        // ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpdateHomeTyCRequest $request, HomeTyC $tyc,TyCPDFs $tycpdfs, ArchivoNombreCargadoService $serviceNombre)
    {
     //  dd($request);
        DB::beginTransaction();
        try 
        {
         
            $data=array();
            $pdfdata=array();
       if($request->estado == "on"){
            $tyc=DB::table('TyC')
            ->where('estado',1)
            ->where('id_cuestionario',$request->id_cuestionario)
            ->first();
         
//todo para actualizar el estado a false
            if (!$tyc ==null){
             
                $data['titulo']            = $tyc->titulo;
               // $data['slug']              = $tyc->slug;
                $data['texto1']            = $tyc->texto1;
                $data['texto2']            = $tyc->texto2;
                $data['texto3']            = $tyc->texto3;
                $data['id_cuestionario']   = $tyc->id_cuestionario;        
                $data['estado']            =False;  
                $data['fechaAlta']         = DB::raw('CURRENT_TIMESTAMP');

               
                    DB::table('TyC')->where('id', $tyc->id)->update($data);              
                     
            }
          }
           
            $data['titulo']            = $request->titulo;
            $data['texto1']            = $request->texto1;
            $data['texto2']            = $request->texto2;
            $data['texto3']            = $request->texto3;
            $data['id_cuestionario']   = $request->id_cuestionario;
            if($request->estado==null){
              $data['estado']            = false;
            }else{
              $data['estado']            = true;
            }
           
            $data['fechaAlta']         = DB::raw('CURRENT_TIMESTAMP');
            DB::table('TyC')->insert($data);
            
            //marcar cuestionario
            $cuestionario=DB::table('Cuestionario')
                          ->where('id',$request->id_cuestionario)
                          ->first();
            if($request->estado == "on" && $cuestionario->estadoTyC == 0){
              $data2=array();
              $data2['estadoTyC']=1;
              DB::table('Cuestionario')->where('id',$request->id_cuestionario)
                                      ->update($data2);
            }
            
            
            //pdfs
            $tyc=DB::table('TyC')
            ->max('id');
                   
            if($tyc){
              if($request->inputs){
              foreach($request->inputs as $key =>$value){              
                $pdfdata['pdfNombre']         = $serviceNombre->GenerarNombreTyC($value['pdfNombre'],'TyCPDFs');
                $pdfdata['idTyC']             = $tyc;
                $pdfdata['fechaAlta']         = DB::raw('CURRENT_TIMESTAMP');
                $pdfdata['fechaBaja']         = null; 
                $pdfdata['orden']             =$key;
              
                DB::table('TyCPDFs')->insert($pdfdata);                  
                }
              }
              }      
                LogActivity::addToLog('TyC - Agregado el checkbox '.$request->titulo);
                LogActivity::addToLog('TyCPDFs - Agregado pdf ');
             

                DB::commit();
                return redirect()->route('tyc.index')
                ->with('success','El checkbox fue creado correctamente.');
          
                     
        }
        catch (Throwable $e)
        {
            DB::rollback();
            return redirect()->route('tyc.index')->with('error', 'Se ha producido un error en la transacción.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HomeTyC  $tyc
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!is_numeric($id)) return abort(404);

       
       $tyc = DB::table('TyC')->where('id', $id)->first();
     /*  $tyc= DB::table('TyC')::join('Cuestionario','TyC.id_cuestionario','=','Cuestionario.id')
                ->get(['TyC.*','Cuestionario.descripcion'])
                ->where('id', $id)->first();
 */
        LogActivity::addToLog('TyC - Viendo '.$tyc->titulo);

        $cuestionarios = DB::table('Cuestionario')->where('id', $tyc->id_cuestionario) ->first();
        $tycpdfs= DB::table('TyCPDFs')
        ->where('idTyC',$id)
        ->where('fechaBaja',null)
        ->get();

       

        return view('backend.tyc.show')
                    ->with(['tyc'=> $tyc ,
                    'tycpdfs'=>$tycpdfs
                            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HomeTyC  $tyc
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $i=0;
      $tyc = DB::table('TyC')
      ->Join('Cuestionario', 'TyC.id_cuestionario', '=', 'Cuestionario.id') 
     ->select('tyc.*',
              'Cuestionario.descripcion AS descripcionCuestionario',
              'Cuestionario.id AS idCuestionario'
     )
      ->where('tyc.id',$id)
      ->first();

     
        $cuestionarios = DB::table('Cuestionario');

        $tycpdfs= DB::table('TyCPDFs')
                ->where('idTyC',$id)
                ->get();

                
        $tycpdfscant= DB::table('TyCPDFs')
        ->where('idTyC',$id)
        ->count();
        return view('backend.tyc.edit')
                  ->with(['tyc' => $tyc,
                  'cuestionarios' => $cuestionarios,
                  'tycpdfs'=>$tycpdfs,
                  'i'=>$i,
                  'tycpdfscant'=>$tycpdfscant
                ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HomeTyC  $tyc
     *  @param  \App\Models\TyCPDFs  $tyc
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHomeTyCRequest $request,$id,TyCPDFs $tycpdfs, ArchivoNombreCargadoService $serviceNombre)
    {
         
        DB::beginTransaction();
        try 
        {    
          if($request->estado == "on"){

            $tyc=DB::table('TyC')
            ->select('TYC.*')
            ->where('estado',1)
            ->where('id_cuestionario',$request->id_cuestionario)
            ->orderBy('id')
            ->first();

//todo parta actualizar el estado a false
            if (!$tyc ==null){
                $data['titulo']            = $tyc->titulo;
               // $data['slug']              = $tyc->slug;
                $data['texto1']            = $tyc->texto1;
                $data['texto2']            = $tyc->texto2;
                $data['texto3']            = $tyc->texto3;
                $data['id_cuestionario']   = $tyc->id_cuestionario;        
                $data['estado']            =False;  
                $data['fechaAlta']         = DB::raw('CURRENT_TIMESTAMP');


                 if(!$tyc->id==null){
                    DB::table('TyC')->where('id', $tyc->id)->update($data);              
                      }
            }
          }
         
             $data=array();
            $data['titulo']            = $request->titulo;
            $data['texto1']            = $request->texto1;
            $data['texto2']            = $request->texto2;
            $data['texto3']            = $request->texto3;
            $data['id_cuestionario']   = $request->id_cuestionario;
            if($request->estado==null){
              $data['estado']            = 0;
            }           
            if($request->estado == "on"){             
              $data['estado']            = 1;
            }        
            $data['fechaAlta']         = DB::raw('CURRENT_TIMESTAMP');

           DB::table('TyC')->where('id', $id)->update($data);

            LogActivity::addToLog('TyC - Actualizado el checkbox '.$request->titulo);

             //marcar cuestionario
             $cuestionario=DB::table('Cuestionario')
             ->where('id',$request->id_cuestionario)
             ->first();
              if($request->estado == "on" && $cuestionario->estadoTyC == 0){
              $data2=array();
              $data2['estadoTyC']=1;
              DB::table('Cuestionario')->where('id',$request->id_cuestionario)
                                      ->update($data2);
              }

            if($request->chec_0){
            $data1=array();
           
           $tycpdfs= DB::table('TyCPDFs')
                ->where('idTyC',$id)
                ->where('fechaBaja',null)
                ->get();
       
            if($request->files){               
              foreach($request->files as $index => $pdf){
           
                $pdfName = $serviceNombre->GenerarNombreTyC($pdf,'TyCPDFs');
              
              foreach($tycpdfs as $key =>$value) {                            
                $var="chec_"."$value->orden";                
                  if($request->$var == "on"){
                    $data1['pdfNombre'] = $pdfName;
                    
                    DB::table('TyCPDFs')->where('idTyC', $id)
                                        ->where('orden',$value->orden)->update($data1);                    
                  }        
              }
              
              }   
            }
          }
            $orden=DB::table('TyCPDFs')
            ->where('idTyC',$id)
            ->max('orden');

            if($request->inputs){
              foreach($request->inputs as $key =>$value){              
                $pdfdata['pdfNombre']         = $serviceNombre->GenerarNombreTyC($value['pdfNombre'],'TyCPDFs');
                $pdfdata['idTyC']             = $id;
                $pdfdata['fechaAlta']         = DB::raw('CURRENT_TIMESTAMP');
                $pdfdata['fechaBaja']         = null; 
                $pdfdata['orden']             =$orden + 1;
              
                DB::table('TyCPDFs')->insert($pdfdata);   
                $orden=DB::table('TyCPDFs')
                ->where('idTyC',$id)
                ->max('orden');             
                }
            }
            
              
            DB::commit();
            return redirect()->route('tyc.index')
                            ->with('success','El checkbox fue actualizado correctamente.');
        }
        catch (Throwable $e)
        {
            DB::rollback();
            return redirect()->route('backend.tyc.index')->with('error', 'Se ha producido un error en la transacción.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HomeTyC  $tyc
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try 
        {
            $oldOrder = DB::table('TyC')->select('id_cuestionario')->where('id',$id)->first();

          
            $data=array();
            $data['estado']    = False;
            $data['fechaBaja'] = DB::raw('CURRENT_TIMESTAMP');
            
            DB::table('TyC')->where('id', $id)->update($data);
            $data1=array();           
            $data1['fechaBaja'] = DB::raw('CURRENT_TIMESTAMP');
            
            DB::table('TyCPDFs')->where('idTyC', $id)->update($data1);

            LogActivity::addToLog('TyC - Se dió de baja el cuestionario ');
        
            DB::commit();

            return redirect()->route('tyc.index')
                             ->with('success', 'El registro se ha borrado con éxito');
        }
        catch (Throwable $e)
        {
            DB::rollback();
            return redirect()->route('backend.tyc.index')->with('error', 'Se ha producido un error en la transacción.');
        }
    }

    public function guardarArchivo(Request $request,ArchivoNombreCargadoService $serviceNombre)
  {
    
    $disk = Storage::disk('public');
    $log  = Log::channel('daily');
    
   // $carpeta = env('ADJUNTOS_REPUESTAS','evidencia_preguntas');
    
    try {
         
    
     /*  $nombreDelArchivoGuardado = $disk->putfile($carpeta, $request->content);
      
      if (!$nombreDelArchivoGuardado) throw new \Exception("ProgramaEntidadesController::guardarArchivo() - No se pudo guardar el archivo", 6427); */
      $data['pdfNombre'] = $serviceNombre->GenerarNombre($request->content, 'TyC_PDFs', 'TyC_PDFs', 'pdfNombre');
     
    
      /* DB::table('Adjunto')->upsert( [ ['idRespuesta' => $idRespuesta, 'pathAdjunto' => $nombreDelArchivoGuardado,'idPregunta' => $request->idPregunta], ], ['idRespuesta','idPregunta'], ['pathAdjunto'] ); */
      
      /* $fullPath = $disk->url($nombreDelArchivoGuardado); */
      
     /*  $log->info('ProgramaEntidadesController::guardarArchivo() - $nombreDelArchivoGuardado: ' . $fullPath . '; idRespuesta ' . $idRespuesta); */
     DB::table('TyC_PDFs')->insert($data);
      /* return $fullPath; */
      Log::channel('daily')->info('-----PASO EL INSERT-----');
      return ('https://www.rite.gob.ar/storage/uploads/Adjunto/'.$data['pdfNombre']);
      }
    catch (\Exception $e) {
      Log::channel('daily')->info('-----DENTRO DEL CATCH-----');
      $log->error('HomeTyCController::guardarArchivo() - '. $e->getMessage());
      return $e->getMessage();
      }
  }


  public function cargarArchivo(Request $request){
    $idRespuesta  = $this->buscarIdRespuesta($request->idPregunta);
    $adjunto      = DB::table('Adjunto')->where('idRespuesta',$idRespuesta)->orderBy('id','desc')->first();
    
  /*   if(!is_object($adjunto)) return false;
    if(empty($adjunto->pathAdjunto)) return false;

    Log::channel('daily')->info(json_encode($adjunto)); */

    return ('https://www.rite.gob.ar/storage/uploads/Adjunto/'. $adjunto->pathAdjunto);

  }


  

}
