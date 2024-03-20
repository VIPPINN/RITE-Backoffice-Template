<?php

namespace App\Http\Requests;

use App\Models\TyCPDFs;
use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;


class UpdateHomeTyCPDFsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

  /*   public function prepareForValidation()
    {
        $this->merge([
            'estado' => $this->status == 'on' ? 1 : 0,
            'slug'   => Str::slug(strip_tags($this->title))."-".Str::random(5)
        ]);
    } */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
     public function rules(TyCPDFs $tycpdfs) : array
    {
        return [
            'pdfNombre'     => 'required'
           
        ];
    } 

    /**
     * Get the validation error message.
     *
     * @return array
     */
    public function messages() : array
    {
        return [
            'pdfNombre.required'     => '(*) El pdf es requerido. Debe ingresarlo. ',
          
           
        ];
    }
}
