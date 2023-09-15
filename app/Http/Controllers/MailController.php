<?php

namespace App\Http\Controllers;

use App\Mail\ContactoMailable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function pintarFormulario(){
        return view('contactanos.contacto');
    }
    public function procesarFormulario(Request $request){
        $request->validate([
            'nombre'=>['required','string','min:3'],
            'email'=>['required','email'],
            'contenido'=>['required','string','min:10']
        ]);
        //Hemos pasado las validaciones, enviamos el email
        try{
            Mail::to('ofiucoemail@gmail.com')->send(new ContactoMailable($request->nombre,$request->email , $request->contenido));
            return redirect()->route('inicio')->with('info', 'Se ha enviado el correo');
        }catch(\Exception $ex){
            return redirect()->route('inicio')->with('info', 'No se pudo enviar el correo, inténtelo más tarde');
        }
    }
}
