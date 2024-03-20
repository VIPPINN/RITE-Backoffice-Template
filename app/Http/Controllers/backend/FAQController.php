<?php

namespace App\Http\Controllers\backend;

use DB;
use App\Models\Faq;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use App\Services\FiltroService;
use App\Http\Controllers\Controller;
use App\Services\UpdateOrderDatabase;
use App\Http\Requests\UpdatePreguntaFrecuenteRequest;

class FAQController extends Controller
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
        $faqs = $filtro->filtroEstadoOrdenado($estado, 'PreguntaFrecuente');

        return view('backend.faqs.index', [
            'faqs' => $faqs
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faqs = DB::table('PreguntaFrecuente')
            ->orderBy('orden')
            ->where('estado',1)
            ->paginate(10);

        LogActivity::addToLog('Preguntas Frecuentes - Listado');

        return view('backend.faqs.index', [
            'faqs' => $faqs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ultimoNumeroDeOrden = DB::table('PreguntaFrecuente')
                                ->select('orden')
                                ->where('estado',1)
                                ->orderBy('orden', 'desc')
                                ->first();
        
        return view('backend.faqs.create', [
            'ultimoNumeroDeOrden' => $ultimoNumeroDeOrden == null ? 0 : $ultimoNumeroDeOrden->orden
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpdatePreguntaFrecuenteRequest $request)
    {
        DB::beginTransaction();
        try 
        {
            $data = array();
            
            $objVerificoOrden = new UpdateOrderDatabase();

            $checked = $objVerificoOrden->actualizarOrden(null,'PreguntaFrecuente', $request->status, $request->orden);
            
            $data['titulo']    = $request->titulo;
            $data['texto']     = $request->editor;
            $data['orden']     = $checked != 0 ? $checked : $request->orden;
            $data['estado']    = $request->status;
            $data['fechaAlta'] = DB::raw('CURRENT_TIMESTAMP');

            DB::table('PreguntaFrecuente')->insert($data);

            LogActivity::addToLog('Preguntas Frecuentes - Creada la pregunta '.$request->titulo);

            DB::commit();

            return redirect()->route('faqs.index')
                ->with('success', 'La pregunta fue creada satisfactoriamente.');
        }
        catch (Throwable $e)
        {
            DB::rollback();
            return redirect()->route('faqs.index')->with('error', 'Se ha producido un error en la transacción.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!is_numeric($id)) return abort(404);

        $faqs = DB::table('PreguntaFrecuente')
            ->where('id', $id)
            ->first();
            
        LogActivity::addToLog('Preguntas Frecuentes - Viendo la pregunta '.$faqs->titulo);

        return view('backend.faqs.show')
            ->with('faqs', $faqs);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $faqs = DB::table('PreguntaFrecuente')
            ->where('id', $id)
            ->first();

        return view('backend.faqs.edit')
            ->with('faqs', $faqs);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePreguntaFrecuenteRequest $request, $id)
    {
        DB::beginTransaction();
        try 
        {
            $objVerificoOrden = new UpdateOrderDatabase();
            
            $checked = $objVerificoOrden->actualizarOrden($id,'PreguntaFrecuente', $request->status, $request->orden);
            
            $data['titulo']    = $request->titulo;
            $data['texto']     = $request->editor;
            $data['orden']     = $checked != 0 ? $checked : $request->orden;
            $data['estado']    = $request->status;
            if($request->status == 1) $data['fechaBaja'] = '';
    
            DB::table('PreguntaFrecuente')->where('id', $id)->update($data);

            LogActivity::addToLog('Preguntas Frecuentes - Editada la pregunta '.$request->titulo);
            
            DB::commit();
            
            return redirect()->route('faqs.index')
                ->with('success', 'La pregunta se ha actualizado con éxito');
        }
        catch (Throwable $e) 
        {
            DB::rollback();
            return redirect()->route('faqs.index')->with('error', 'Se ha producido un error en la transacción.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try 
        {
            $oldOrder = DB::table('PreguntaFrecuente')->select('orden', 'titulo')->where('id',$id)->first();
            
            $objVerificoOrden = new UpdateOrderDatabase();
            
            $checked = $objVerificoOrden->actualizarOrden($id,'PreguntaFrecuente', 0, $oldOrder->orden);

            $data['estado']    = 0;
            $data['orden']     = $checked != 0 ? $checked : $oldOrder->orden;
            $data['fechaBaja'] = DB::raw('CURRENT_TIMESTAMP');

            DB::table('PreguntaFrecuente')->where('id', $id)->update($data);

            LogActivity::addToLog('Preguntas Frecuentes - Se dió de baja la pregunta '.$oldOrder->titulo);

            DB::commit();

            return redirect()->route('faqs.index')
                ->with('success', 'La pregunta se ha actualizado con éxito');
        }
        catch (Throwable $e) 
        {
            DB::rollback();
            return redirect()->route('faqs.index')->with('error', 'Se ha producido un error en la transacción.');
        }
    }

}
