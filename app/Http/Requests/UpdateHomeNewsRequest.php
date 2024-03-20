<?php

namespace App\Http\Requests;

use App\Models\HomeNews;
use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;


class UpdateHomeNewsRequest extends FormRequest
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
        $this->merge([
            'estado' => $this->status == 'on' ? 1 : 0,
            'slug'   => Str::slug(strip_tags($this->title))."-".Str::random(5)
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(HomeNews $novedades) : array
    {
        return [
            'title'     => 'required',
            'slug'      => 'unique:Novedades,slug',
            'txt_short' => 'required',
            'txt_large' => 'required',
            'fecha'     => 'required',
            'orden'     => 'required',
            'image'     => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
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
            'title.required'     => '(*) El título es requerido. Debe ingresarlo. ',
            'slug'               => '(*) Debe modificar el título de tal manera que sea único',
            'txt_short.required' => '(*) El texto resumido es requerido. Debe ingresarlo. ',
            'txt_large.required' => '(*) El texto detallado es requerido. Debe ingresarlo. ',
            'fecha.required'     => '(*) La fecha es requerida. Debe ingresarlo. ',
            'orden.required'     => '(*) El orden es requerido. Debe ingresarlo. ',
            'image.mimes'        => '(*) Error en el formato, los permitidos son jpeg,png,jpg,gif,svg. ',
            'image.image'        => '(*) El archivo ingresado debe ser una imagen. ',
            'image.max'          => '(*) La imagen no debe superar los 2048 kbytes. ',
        ];
    }
}
