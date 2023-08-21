<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TemaoscuroController extends Controller
{
    public function cambiartema(){
        $user=auth()->user();
        if(auth()->user()->temaoscuro){
            $user->update([
                "temaoscuro"=>0
            ]);
        }else{
            $user->update([
                "temaoscuro"=>1
            ]);
        }
        return back();
    }
}
