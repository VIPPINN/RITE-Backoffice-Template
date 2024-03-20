<?php

namespace App\Http\Requests;

use App\Models\About;
use Illuminate\Support\Facades\DB;
use App\Rules\EstadoUnicoRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\QueEsRite\VerificoCargaArchivoRule;

class UpdateQueEsRiteRequest extends FormRequest
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
    public function rules(About $about) :  array
    {
        $checkId = !$this->about ? 0 :  $this->about->id;
        
        return [
            'titulo'       => 'required',
            'editor_short' => 'required',
            'editor_large' => 'required',
            'status'       => [new EstadoUnicoRule($checkId, 'QueEsRite')],
            'file'         => 'mimes:pdf|max:10024'
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
            'titulo.required'       => '(*) El título es requerido. Debe ingresarlo. ',
            'editor_large.required' => '(*) El texto resumido es requerido. Debe ingresarlo. ',
            'editor_short.required' => '(*) El texto detallado es requerido. Debe ingresarlo. ',
            'file.mimes'            => "(*) Solamente puede cargar archivos del tipo PDF.",
            'file.max'              => "(*) El tamaño de archivo supera el límite permitido (10Mb)."
        ];
    }
}
