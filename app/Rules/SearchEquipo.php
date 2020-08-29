<?php

namespace App\Rules;

use App\Equipo;
use Exception;
use Illuminate\Contracts\Validation\Rule;

class SearchEquipo implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        
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
        if($value){
            try{
                $equipoDB =  Equipo::where('codigo', $value) -> get();
                if( !$equipoDB -> isEmpty() ) 
                    return true;
                else return false; 
            }catch(Exception $error){
                return false; 
            }
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'No se encontró un equipo con ese código';
    }
}