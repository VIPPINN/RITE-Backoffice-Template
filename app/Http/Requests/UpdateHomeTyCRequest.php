<?php

namespace App\Http\Requests;

use App\Models\HomeTyC;
use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;


class UpdateHomeTyCRequest extends FormRequest
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
    public function rules(HomeTyC $tyc) : array
    {
        return [
            'texto1'    => 'required',
            'texto3'    => 'required',
            'id_cuestionario'=>'required',
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
            'texto1.required' => '(*) El texto1  es requerido. Debe ingresarlo. ',
            'texto3.required' => '(*) El texto3  es requerido. Debe ingresarlo. ',
            'id_cuestionario.required' => '(*) El cuestionario  es requerido. Debe ingresarlo. '
           
        ];
    }
}
