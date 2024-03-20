<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCarruselRequest extends FormRequest
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
        $this->merge(['status' => $this->status == 'on' ? 1 : 0]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'   => 'required',
            'link'    => 'required',
            'orden'   => 'required',
            'imagepc' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
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
            'title.required'   => '(*) El título es requerido. Debe ingresarlo. ',
            'link.required'    => '(*) El link a la red social es requerida. Debe ingresarla. ',
            'orden.required'   => '(*) El orden es requerido. Debe ingresarlo. ',
            'imagepc.mimes'    => '(*) Solo se aceptan los siguientes tipos de imagenes: jpeg,png,jpg,gif,svg.',
            'imagepc.max'      => '(*) El máximo permito para las imagens es de 2MB'
        ];
    }
}
