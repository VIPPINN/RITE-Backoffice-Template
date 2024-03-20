<?php

namespace App\Http\Controllers\backend;

use DB;
use Carbon\Carbon;
use App\Models\HomeVideo;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use App\Services\FiltroService;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateHomeVideoRequest;

class HomeVideoController extends Controller
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
        $videos = $filtro->filtroEstado($estado, 'Video');

        return view('backend.videos.index', [
            'videos' => $videos
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(HomeVideo $videos)
    {
        $videos = DB::table('Video')->where('estado',1)->paginate(10);

        LogActivity::addToLog('Video - Listado');

        return view('backend.videos.index', [
            'videos' => $videos,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.videos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UpdateHomeVideoRequest $request, HomeVideo $videos)
    {
      $data=array();
      $data['titulo']    = $request->title;
      $data['enlace']    = $request->link;
      $data['estado']    = $request->estado;
      $data['fechaAlta'] = DB::raw('CURRENT_TIMESTAMP');

      DB::table('Video')->insert($data);

      LogActivity::addToLog('Video - Guardado el video '.$request->title);
  
      return redirect()->route('videos.index')
                      ->with('success','El video fue guardado satisfactoriamente.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HomeVideo  $HomeVideo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!is_numeric($id)) return abort(404);

        $videos = DB::table('Video')->where('id', $id)->first();

        LogActivity::addToLog('Video - Mostrando el video '.$videos->titulo);

        return view('backend.videos.show')
                  ->with('videos', $videos);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HomeVideo  $HomeVideo
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $videos = DB::table('Video')->where('id', $id)->first();

        return view('backend.videos.edit')
                  ->with('videos', $videos);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HomeVideo  $HomeVideo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHomeVideoRequest $request, HomeVideo $video)
    {
      $data=array();
      $data['titulo']    = $request->title;
      $data['enlace']    = $request->link;
      $data['estado']    = $request->estado;
      $data['fechaAlta'] = DB::raw('CURRENT_TIMESTAMP');
      if($request->estado == 1) $data['fechaBaja'] = '';

      DB::table('Video')->where('id', $video->id)->update($data);

      LogActivity::addToLog('Video - Actualizado el video '.$request->title);

      return redirect()->route('videos.index')
                      ->with('success','El video se ha actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HomeVideo  $HomeVideo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $oldOrder = DB::table('Video')->select('titulo')->where('id',$id)->first();

        $data['estado']    = 0;
        $data['fechaBaja'] = DB::raw('CURRENT_TIMESTAMP');

        DB::table('Video')->where('id', $id)->update($data);

        LogActivity::addToLog('Video - Se dió de baja el video '.$oldOrder->titulo);
        
        return redirect()->route('videos.index')
          ->with('success','El video se ha borrado con éxito');
    }
}
