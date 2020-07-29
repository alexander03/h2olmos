<?php

namespace App\Rules;

use App\Ua;
use Exception;
use Illuminate\Contracts\Validation\Rule;

class SearchUaPadre implements Rule
{
    private $nombAtt = "";

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value){

        $this -> nombAtt = $attribute;

        if($value){
            try{
                $uaDB =  Ua::where('codigo', $value) -> get();
                if( !$uaDB -> isEmpty() ) return true;
                else return false; 
            }catch(Exception $error){
                return false; 
            }
        }
    
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(){

        return 'El código de UA no existe.';
    }
}