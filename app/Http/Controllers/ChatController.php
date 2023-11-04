<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Community;
use App\Models\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class ChatController extends Controller {
    use WithPagination;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $tipo, $tipoid) {
        $friends = Friend::where('aceptado', 'SI')
            ->where(function ($query) {
                $query->where('frienduno_id', auth()->user()->id)
                    ->orWhere('frienddos_id', auth()->user()->id);
            })
            ->get();
        foreach ($friends as $friend) {
            if ($friend->user_id == auth()->user()->id) {
                if ($friend->frienduno_id == auth()->user()->id) {
                    $friend->update([
                        "user_id" => $friend->frienddos_id,
                    ]);
                } else {
                    $friend->update([
                        "user_id" => $friend->frienduno_id,
                    ]);
                }
            }
        }
        $friends = Friend::where('aceptado', 'SI')
            ->where(function ($query) {
                $query->where('frienduno_id', auth()->user()->id)
                    ->orWhere('frienddos_id', auth()->user()->id);
            })
            ->simplePaginate(5);
        $myCommunities = Community::where('user_id', auth()->user()->id)->simplePaginate(5);
        $communitiesParticipante = auth()->user()->communities()->simplePaginate(5);
        return view('chat.chat-messages', compact('friends', 'myCommunities', 'communitiesParticipante', 'tipo', 'tipoid'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $tipo, $tipoid)
    {
        if (!is_null($request->contenido)) {
            if ($tipo == 1) {
                Chat::create([
                    'user_id' => auth()->user()->id,
                    'destinatario_id' => $tipoid,
                    'contenido' => $request->contenido
                ]);
            } else if ($tipo == 2) {
                Chat::create([
                    'user_id' => auth()->user()->id,
                    'community_id' => $tipoid,
                    'contenido' => $request->contenido
                ]);
            }
        }
        return redirect()->route('chat.index', compact('tipo', 'tipoid'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Chat $chat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chat $chat)
    {
        //
    }

    public function abrirChat($tipo, $tipoid)
    {
        $textoFormateado = "";
        if(self::comprobarChat($tipo, $tipoid)){
            $textoFormateado="<img src='". Storage::url('logochat.png') ."' class='h-96 mx-auto' alt='logo Ofiuco'>";
            return $textoFormateado;
        }
        switch ($tipo) {
            case 1:
                $mensajes = Chat::where(function ($query) {
                    $query->where('destinatario_id', auth()->user()->id)
                        ->orWhere('user_id', auth()->user()->id);
                    })
                    ->where(function ($query) use ($tipoid) {
                        $query->where('destinatario_id', $tipoid)
                            ->orWhere('user_id', $tipoid);
                    })
                    ->where('community_id', null)
                    ->orderBy('id', 'desc')
                    ->get();
                break;
            case 2:
                $mensajes = Chat::where('community_id', $tipoid)
                    ->orderBy('id', 'desc')
                    ->get();
                break;
        }
        if ($mensajes->count()) {
            foreach ($mensajes->reverse() as $mensaje) {
                if ($mensaje->user_id == auth()->user()->id) {
                    $textoFormateado.="<div class = 'flex flex-row-reverse'>";
                    if ($mensaje->user->is_admin) {
                        if (auth()->user()->temaoscuro) {
                            $textoFormateado.="<p class='max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mt-2 mx-2 rounded-tl-xl text-white bg-gradient-to-r from-red-600 from-10% via-indigo-600 via-80% to-blue-600 to-90%'><span class='flex flex-wrap my-3'><a class='flex flex-col' href='" . route('perfiluser.show', $mensaje->user->id) . "'><img class='h-8 w-8 rounded-full ml-4 cursor-pointer' src='" . $mensaje->user->profile_photo_url . "' title='mensaje de " . $mensaje->user->name . "'alt='" . $mensaje->user->name . "' /></a><span class = 'flex flex-col mx-3 px-2 text-xl rounded-xl'>" . $mensaje->user->name . "</span></span>".$mensaje->contenido."</p>";
                        } else {
                            $textoFormateado.="<p class='max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mt-2 mx-2 rounded-tl-xl text-white bg-gradient-to-r from-red-500 from-10% via-indigo-500 via-80% to-blue-500 to-90%'><span class='flex flex-wrap my-3'><a class='flex flex-col' href='" . route('perfiluser.show', $mensaje->user->id) . "'><img class='h-8 w-8 rounded-full ml-4 cursor-pointer' src='" . $mensaje->user->profile_photo_url . "' title='mensaje de " . $mensaje->user->name . "'alt='" . $mensaje->user->name . "' /></a><span class = 'flex flex-col mx-3 px-2 text-xl rounded-xl'>" . $mensaje->user->name . "</span></span>".$mensaje->contenido."</p>";
                        }
                    } else if ($mensaje->community_id != null && $mensaje->community->user_id == $mensaje->user_id) {
                        if (auth()->user()->temaoscuro) {
                            $textoFormateado.="<p class='max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mt-2 mx-2 rounded-tl-xl bg-blue-700 text-white'><span class='flex flex-wrap my-3'><a class='flex flex-col' href='" . route('perfiluser.show', $mensaje->user->id) . "'><img class='h-8 w-8 rounded-full ml-4 cursor-pointer' src='" . $mensaje->user->profile_photo_url . "' title='mensaje de " . $mensaje->user->name . "'alt='" . $mensaje->user->name . "' /></a><span class = 'flex flex-col mx-3 px-2 text-xl rounded-xl'>" . $mensaje->user->name . "</span></span>".$mensaje->contenido."</p>";
                        } else {
                            $textoFormateado.="<p class='max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mt-2 mx-2 rounded-tl-xl bg-blue-400'><span class='flex flex-wrap my-3'><a class='flex flex-col' href='" . route('perfiluser.show', $mensaje->user->id) . "'><img class='h-8 w-8 rounded-full ml-4 cursor-pointer' src='" . $mensaje->user->profile_photo_url . "' title='mensaje de " . $mensaje->user->name . "'alt='" . $mensaje->user->name . "' /></a><span class = 'flex flex-col mx-3 px-2 text-xl rounded-xl'>" . $mensaje->user->name . "</span></span>".$mensaje->contenido."</p>";
                        }
                    } else {
                        if (auth()->user()->temaoscuro) {
                            $textoFormateado.="<p class='max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mt-2 mx-2 rounded-tl-xl bg-gray-700 text-white'><span class='flex flex-wrap my-3'><a class='flex flex-col' href='" . route('perfiluser.show', $mensaje->user->id) . "'><img class='h-8 w-8 rounded-full ml-4 cursor-pointer' src='" . $mensaje->user->profile_photo_url . "' title='mensaje de " . $mensaje->user->name . "'alt='" . $mensaje->user->name . "' /></a><span class = 'flex flex-col mx-3 px-2 text-xl rounded-xl'>" . $mensaje->user->name . "</span></span>".$mensaje->contenido."</p>";
                        } else {
                            $textoFormateado.="<p class='max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mt-2 mx-2 rounded-tl-xl bg-gray-300'><span class='flex flex-wrap my-3'><a class='flex flex-col' href='" . route('perfiluser.show', $mensaje->user->id) . "'><img class='h-8 w-8 rounded-full ml-4 cursor-pointer' src='" . $mensaje->user->profile_photo_url . "' title='mensaje de " . $mensaje->user->name . "'alt='" . $mensaje->user->name . "' /></a><span class = 'flex flex-col mx-3 px-2 text-xl rounded-xl'>" . $mensaje->user->name . "</span></span>".$mensaje->contenido."</p>";
                        }
                    }
                    $textoFormateado.="</div>";
                } else {
                    $textoFormateado.="<div class = 'flex'>";
                    if ($mensaje->user->is_admin) {
                        if (auth()->user()->temaoscuro) {
                            $textoFormateado.="<p class='max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mt-2 mx-2 rounded-tr-xl text-white bg-gradient-to-r from-red-600 from-10% via-indigo-600 via-80% to-blue-600 to-90%'><span class='flex flex-wrap my-3'><a class='flex flex-col' href='" . route('perfiluser.show', $mensaje->user->id) . "'><img class='h-8 w-8 rounded-full ml-4 cursor-pointer' src='" . $mensaje->user->profile_photo_url . "' title='mensaje de " . $mensaje->user->name . "'alt='" . $mensaje->user->name . "' /></a><span class = 'flex flex-col mx-3 px-2 text-xl rounded-xl'>" . $mensaje->user->name . "</span></span>".$mensaje->contenido."</p>";
                        } else {
                            $textoFormateado.="<p class='max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mt-2 mx-2 rounded-tr-xl text-white bg-gradient-to-r from-red-500 from-10% via-indigo-500 via-80% to-blue-500 to-90%'><span class='flex flex-wrap my-3'><a class='flex flex-col' href='" . route('perfiluser.show', $mensaje->user->id) . "'><img class='h-8 w-8 rounded-full ml-4 cursor-pointer' src='" . $mensaje->user->profile_photo_url . "' title='mensaje de " . $mensaje->user->name . "'alt='" . $mensaje->user->name . "' /></a><span class = 'flex flex-col mx-3 px-2 text-xl rounded-xl'>" . $mensaje->user->name . "</span></span>".$mensaje->contenido."</p>";
                        }
                    } else if ($mensaje->community_id != null && $mensaje->community->user_id == $mensaje->user_id) {
                        if (auth()->user()->temaoscuro) {
                            $textoFormateado.="<p class='max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mt-2 mx-2 rounded-tr-xl bg-blue-700 text-white'><span class='flex flex-wrap my-3'><a class='flex flex-col' href='" . route('perfiluser.show', $mensaje->user->id) . "'><img class='h-8 w-8 rounded-full ml-4 cursor-pointer' src='" . $mensaje->user->profile_photo_url . "' title='mensaje de " . $mensaje->user->name . "'alt='" . $mensaje->user->name . "' /></a><span class = 'flex flex-col mx-3 px-2 text-xl rounded-xl'>" . $mensaje->user->name . "</span></span>".$mensaje->contenido."</p>";
                        } else {
                            $textoFormateado.="<p class='max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mt-2 mx-2 rounded-tr-xl bg-blue-400'><span class='flex flex-wrap my-3'><a class='flex flex-col' href='" . route('perfiluser.show', $mensaje->user->id) . "'><img class='h-8 w-8 rounded-full ml-4 cursor-pointer' src='" . $mensaje->user->profile_photo_url . "' title='mensaje de " . $mensaje->user->name . "'alt='" . $mensaje->user->name . "' /></a><span class = 'flex flex-col mx-3 px-2 text-xl rounded-xl'>" . $mensaje->user->name . "</span></span>".$mensaje->contenido."</p>";
                        }
                    } else {
                        if (auth()->user()->temaoscuro) {
                            $textoFormateado.="<p class='max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mt-2 mx-2 rounded-tr-xl bg-gray-700 text-white'><span class='flex flex-wrap my-3'><a class='flex flex-col' href='" . route('perfiluser.show', $mensaje->user->id) . "'><img class='h-8 w-8 rounded-full ml-4 cursor-pointer' src='" . $mensaje->user->profile_photo_url . "' title='mensaje de " . $mensaje->user->name . "'alt='" . $mensaje->user->name . "' /></a><span class = 'flex flex-col mx-3 px-2 text-xl rounded-xl'>" . $mensaje->user->name . "</span></span>".$mensaje->contenido."</p>";
                        } else {
                            $textoFormateado.="<p class='max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mt-2 mx-2 rounded-tr-xl bg-gray-300'><span class='flex flex-wrap my-3'><a class='flex flex-col' href='" . route('perfiluser.show', $mensaje->user->id) . "'><img class='h-8 w-8 rounded-full ml-4 cursor-pointer' src='" . $mensaje->user->profile_photo_url . "' title='mensaje de " . $mensaje->user->name . "'alt='" . $mensaje->user->name . "' /></a><span class = 'flex flex-col mx-3 px-2 text-xl rounded-xl'>" . $mensaje->user->name . "</span></span>".$mensaje->contenido."</p>";
                        }
                    }
                    $textoFormateado.="</div>";
                }
            }
        } else {
            $textoFormateado = "<p class='text-center'>SE EL PRIMERO EN MANDAR UN MENSAJE</p><img src='". Storage::url('logochat.png') ."' class='h-96 mx-auto' alt='logo Ofiuco'>";
        }
        return $textoFormateado;
    }

    private function comprobarChat($tipo, $tipoid){
        if($tipo!=1 && $tipo!=2){
            return true;
        }
        //comprobar que sean amigos o pertenezca a la comunidad
    }
}
