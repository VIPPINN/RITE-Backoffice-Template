<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolController extends Controller
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

    public function index()
    {
        $roles = Role::with('permissions')->get();

        return view('backend.roles.index', [
            'roles' => $roles
        ]);
    }

    public function create()
    {
        $permisos = Permission::all();

        return view('backend.roles.create', ['permisos' => $permisos]);
    }

    public function store(Request $request)
    {
        $nombre = $request->nombre;
        $permisos = $request->permisos;

        $rol = new Role;
        $rol->name = $nombre;

        $rol->save();

        $rol->permissions()->sync($permisos);

        return redirect()->route('roles.index');
    }

    public function edit($id)
    {
        $rol = Role::with('permissions')->where('id', $id)->first();
        $permisos = Permission::all();

        return view('backend.roles.edit', [
            'rol' => $rol,
            'permisos' => $permisos
        ]);
    }

    public function update(Request $request, $id)
    {

        $permisos = $request->input('permisos');

        $data['name'] = $request->nombre;

        DB::table('roles')->where('id', $id)->update($data);

        $rol = Role::findOrFail($id);
        $rol->permissions()->sync($permisos);

        return redirect()->route('roles.index');
    }

    public function destroy($id)
    {

        $rol = Role::destroy($id);


        return redirect()->route('roles.index')
            ->with('success', 'El rol fue borrado con exito');
    }
}
