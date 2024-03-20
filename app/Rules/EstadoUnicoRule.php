<?php

namespace App\Rules;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Rule;

class EstadoUnicoRule implements Rule
{
    
    private $idModel;
    private $table;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id, $table)
    {
        $this->idModel = $id;
        $this->table   = $table;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return !($value == 'on' && DB::table("$this->table")->where('estado', 1)->where('id','!=',$this->idModel)->exists());
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '(*) Ya existe un registro activo, debe desactivarlo o debe desactivar este registro que intenta guardar.';
    }
}
