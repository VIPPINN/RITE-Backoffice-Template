<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class NovedadesController extends Controller
{
  public function index()
  {
      try {
        
        //NOTICIAS
        $news = DB::table('news')
                    ->where('status', 1)
                    ->orderBy('orden', 'asc')
                    ->paginate(5);
      $meses = array("January" => "Enero","February" => "Febrero","March" =>"Marzo","April" =>"Abril",
      "May" =>"Mayo","June" =>"Junio","July" =>"Julio","August" =>"Agosto","September" =>"Septiembre",
      "October" =>"Octubre", "November" =>"Noviembre","December" =>"Diciembre");

        return view('frontend.novedades', [
          'news' => $news,
          'meses' => $meses,
          'ordenNovedades' => 'asc'
        ]);

      }   
      catch (\Throwable $t) {
        return "SE ha producido un error.";
      }
  }

  public function show($slug)
  {
      try {
        
        //NOTICIAS
        $news = DB::table('news')
                    ->where('slug', $slug)
                    ->orderBy('orden', 'asc')
                    ->get();

      $meses = array("January" => "Enero","February" => "Febrero","March" =>"Marzo","April" =>"Abril",
      "May" =>"Mayo","June" =>"Junio","July" =>"Julio","August" =>"Agosto","September" =>"Septiembre",
      "October" =>"Octubre", "November" =>"Noviembre","December" =>"Diciembre");

        return view('frontend.novedades-show', [
          'news' => $news,
          'meses' => $meses,
        ]);

      }   
      catch (\Throwable $t) {
          //return "Error when It was imported".$t->getMessage();
        return "Se ha producido un error.";
      }

  }

  public function OrdenNovedades($val)
  {
      try {
          
        //NOTICIAS
        $news = DB::table('news')
                    ->where('status', 1)
                    ->orderBy('orden', $val)
                    ->paginate(5);


      $meses = array("January" => "Enero","February" => "Febrero","March" =>"Marzo","April" =>"Abril",
      "May" =>"Mayo","June" =>"Junio","July" =>"Julio","August" =>"Agosto","September" =>"Septiembre",
      "October" =>"Octubre", "November" =>"Noviembre","December" =>"Diciembre");

        return view('frontend.novedades', [
          'news' => $news,
          'ordenNovedades' => $val,
          'meses' => $meses
        ]);

      }   
      catch (\Throwable $t) {
          return "Se ha producido un error.";
      }
  }

}
