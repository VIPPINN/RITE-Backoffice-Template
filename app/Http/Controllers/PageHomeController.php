<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class PageHomeController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    
      //TODOS LOS SLIDERS ACTIVOS
      $sliders = DB::table('homeslider')
             ->where('status', 1)
             ->get();

      //QUÉ ES RITE
      $about = DB::table('about')->get();

      //VIDEO
      $videos = DB::table('home_videos')
             ->where('status', 1)
             -> orderBy('id', 'desc')
             ->limit(1)
             ->get();

      //NOTICIAS
      $news = DB::table('news')
             ->where('status', 1)
             -> orderBy('id', 'desc')
             ->limit(3)
             ->get();


      return view('welcome', [
        'sliders' => $sliders,
        'about' => $about,
        'videos' => $videos,
        'news' => $news,
      ]);

    }
}
