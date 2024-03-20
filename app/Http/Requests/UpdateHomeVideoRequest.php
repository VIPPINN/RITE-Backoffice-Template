<?php

namespace App\Http\Requests;

use App\Models\HomeVideo;
use App\Rules\EstadoUnicoRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateHomeVideoRequest extends FormRequest
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
    public function rules(HomeVideo $video) : array
    {
        $checkId = !$this->video ? 0 :  $this->video->id;
        
        return [
            'title'  => 'required',
            'link'   => 'required',
            'status' => [new EstadoUnicoRule($checkId, 'Video')]
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
            'title.required' => '(*) El título es requerido. Debe ingresarlo. ',
            'link.required'  => '(*) El enlace al video es requerido. Debe ingresarlo.'
        ];
    }
}
