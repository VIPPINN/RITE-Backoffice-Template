<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;

class InitialController extends Controller
{
  public function index()
  {
      try {
        return redirect()->route('login');
      }   
      catch (\Throwable $t) {
        return "An error has occurred while retrieving data";
      }
  }  
}
