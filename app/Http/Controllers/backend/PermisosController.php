<?php

namespace App\Http\Controllers\backend;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

use Illuminate\Http\Request;

class PermisosController extends Controller
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

    public function index(){
        $permisos = DB::table('permissions')->get();

        return view('backend.permisos.index', [
            'permisos' => $permisos
          ]);
    }

    public function create(){
        return view('backend.permisos.create');
    }

    public function store(Request $request){
        $permission = Permission::create(['name' =>  $request->nombre]);

        return redirect()->route('permisos.index');
    }

    public function edit($id){
        $permiso = DB::table('permissions')->where('id',$id)->first();

        return view('backend.permisos.edit',['permiso' => $permiso]);
    }

    public function update(Request $request,$id){
      
        $nombre['name'] = $request->nombre;
        DB::table('permissions')->where('id',$id)->update($nombre);

        return redirect()->route('permisos.index');
    }

    public function destroy($id)
  {

    $permiso = Permission::destroy($id);


    return redirect()->route('permisos.index')
      ->with('success', 'El permiso fue borrado con exito');
  }


}
