<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRedesRequest extends FormRequest
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

    public function prepareForValidation()
    {
        $this->merge(['estado' => $this->status == 'on' ? 1 : 0]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nombre'     => 'required',
            'link'       => 'required',
            'image_logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function messages() : array
    {
        return [
            'nombre.required'  => '(*) El nombre es requerido. Debe ingresarlo. ',
            'link.required'    => '(*) El link a la red social es requerida. Debe ingresarla. ',
            'image_logo.image' => '(*) El archivo debe ser una imagen. ',
            'image_logo.mimes' => '(*) Error en el formato, los permitidos son jpeg,png,jpg,gif,svg. ',
            'image_logo.max'   => '(*) La imagen no debe superar los 2048 kbytes. '
        ];
    }
}
