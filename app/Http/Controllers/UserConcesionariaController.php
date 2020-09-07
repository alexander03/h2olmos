<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserConcesionaria;
use Illuminate\Support\Facades\DB;

class UserConcesionariaController extends Controller
{
    //




    public function __construct()
    {
        $this->middleware('auth');
    }


    public function actual() {

        $razonsocial= UserConcesionaria::join('users', 'userconcesionaria.user_id', '=', 'users.id')
            ->join('concesionaria', 'userconcesionaria.concesionaria_id', '=', 'concesionaria.id')
            ->where('users.id','=',auth()->user()->id)
            ->where('userconcesionaria.estado','=',true)
            ->select('concesionaria.abreviatura as razonsocial')->get();
            if(count($razonsocial)>0){
                return $razonsocial[0]->razonsocial;
            }else{
                return "Sin Concesionaria";
            }
    }


    public function devolverConce($query) {

        return UserConcesionaria::join('users', 'userconcesionaria.user_id', '=', 'users.id')
        	->join('concesionaria', 'userconcesionaria.concesionaria_id', '=', 'concesionaria.id')
            ->where('users.id','=',auth()->user()->id)
            ->orderBy('concesionaria.id', 'ASC')
            ->select('concesionaria.id as id', 'concesionaria.razonsocial as razonsocial');
    }

    public function concesionaria($id) {

        DB::table('userconcesionaria')
                ->where('user_id', auth()->user()->id)
                ->update(['estado' => false]);
        
        DB::table('userconcesionaria')
                ->where('user_id', auth()->user()->id)
                ->where('concesionaria_id', $id)
                ->update(['estado' => true]);
        //return redirect()->route('home');
    }


}