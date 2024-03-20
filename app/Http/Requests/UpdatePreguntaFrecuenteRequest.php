<?php

namespace App\Http\Requests;

use App\Models\Faq;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePreguntaFrecuenteRequest extends FormRequest
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
    public function rules(Faq $faq)
    {
        return [
            'titulo' => 'required',
            'editor' => 'required',
            'orden'  => 'required'
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
            'titulo.required' => '(*) El título es requerido. Debe ingresarlo. ',
            'editor.required' => '(*) La respuesta es requerida. Debe ingresarla. ',
            'orden.required'  => '(*) El orden es requerido. Debe ingresarlo.'
        ];
    }
}
