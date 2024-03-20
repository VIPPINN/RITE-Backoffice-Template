<?php

namespace app\Services;

use Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ArchivoNombreCargadoService
{
    private $pathFiles;

    public function GenerarNombre($file, $model, $tabla, $campo, $id=0) : string
    {
        $destinationPath = env('PATH_FILES')."/$model/";
        $profilePDF = md5(Carbon::now()->timestamp). "." . $file->getClientOriginalExtension();
        $oldFile = DB::table("$tabla")->select("$campo as enlace")->where('id', $id)->first();
        if(!empty($oldFile->enlace)) $pathToDelete = public_path(env('PATH_FILES')."/$model/".$oldFile->enlace);
        /* if(!empty($oldFile->enlace)) unlink("$pathToDelete"); */
        $file->move($destinationPath, $profilePDF);
        return "$profilePDF";
    }

    public function GenerarNombreYMiniaturaDeImagen($image, $modelo, $tabla, $campo, $id=0) : string
    {
        $destinationPath = env('PATH_FILES')."/$modelo/";
        $profileImage = md5(Carbon::now()->timestamp). "." . $image->getClientOriginalExtension();
        
        /** Redimensionar la imagen */
        $image_resize = Image::make($image);
        $image_resize->resize(292, null, function($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $image_resize->orientate();
        $image_resize->save(public_path($destinationPath.'thumb-' . $profileImage));
        /** =======================*/

        $oldFile = DB::table("$tabla")->select("$campo as enlace")->where('id', $id)->first();
        if(!empty($oldFile->enlace)) 
        {
            $pathToDelete = public_path(env('PATH_FILES')."/$modelo/".$oldFile->enlace);
            $pathToDeleteThumb = public_path(env('PATH_FILES')."/$modelo/thumb-".$oldFile->enlace);
            if(file_exists($pathToDelete)) unlink($pathToDelete);
            if(file_exists($pathToDeleteThumb)) unlink($pathToDeleteThumb);
        }

        
        $image->move($destinationPath, $profileImage);
        
        return "$profileImage";   
    }
    public function GenerarNombreTyC($file, $model) : string
    {
        $destinationPath = env('PATH_FILES')."/$model/";
        $profilePDF = $file->getClientOriginalName();
        $profilePDF = Str::ascii($profilePDF);
        $file->move($destinationPath,$profilePDF);
        return "$profilePDF";

        
       
    }

    public function GenerarNombreSinModificar($file,$name, $model, $tabla, $campo, $id=0): string{
        $destinationPath = env('PATH_FILES')."/$model/";
        $profilePDF = $name;
        $file->move($destinationPath, $profilePDF);
        return "$profilePDF";
    }
}