<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Community;
use App\Models\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class ChatController extends Controller
{
    use WithPagination;
    public function index($tipo, $tipoid)
    {
        return view('chat.chat-messages', compact('tipo', 'tipoid'));
    }
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
    public function destroy(Chat $chat)
    {
        //
    }
    public function abrirChat($tipo, $tipoid)
    {
        $textoFormateado = ["", ""];
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
            ->leftJoin('chats', function ($join) {
                $join->on(function ($join) {
                    $join->on('friends.frienduno_id', '=', 'chats.user_id')
                        ->whereNull('chats.destinatario_id');
                })->orWhere(function ($join) {
                    $join->on('friends.frienddos_id', '=', 'chats.user_id')
                        ->whereNull('chats.destinatario_id');
                })->orWhere(function ($join) {
                    $join->on('friends.frienduno_id', '=', 'chats.destinatario_id')
                        ->where('chats.user_id', '=', auth()->user()->id);
                })->orWhere(function ($join) {
                    $join->on('friends.frienddos_id', '=', 'chats.destinatario_id')
                        ->where('chats.user_id', '=', auth()->user()->id);
                });
            })
            ->selectRaw('friends.*, MAX(chats.created_at) as created_order')
            ->groupBy('friends.id')
            ->orderBy('created_order', 'desc')
            ->simplePaginate(5);
        $myCommunities = Community::where('communities.user_id', auth()->user()->id)
            ->leftJoin('chats', function ($join) {
                $join->on('communities.id', '=', 'chats.community_id');
            })
            ->selectRaw('communities.*, MAX(chats.created_at) as created_order')
            ->groupBy('communities.id')
            ->orderBy('created_order', 'desc')
            ->simplePaginate(5);
        $communitiesParticipante = auth()->user()->communities()
            ->leftJoin('chats', function ($join) {
                $join->on('communities.id', '=', 'chats.community_id');
            })
            ->selectRaw('communities.*, MAX(chats.created_at) as created_order, MAX(chats.updated_at) as updated_order')
            ->groupBy('communities.id', 'community_user.user_id', 'community_user.created_at', 'community_user.updated_at')
            ->orderBy('created_order', 'desc')
            ->simplePaginate(5);
        $ultimomensajefriends = [];
        foreach ($friends as $item) {
            if (Chat::where(function ($query) {
                $query->where('destinatario_id', auth()->user()->id)
                    ->orWhere('user_id', auth()->user()->id);
            })->where(function ($query) use ($item) {
                $query->where('destinatario_id', $item->user_id)->orWhere('user_id', $item->user_id);
            })->where('community_id', null)->count()) {
                $ultimomensajefriends[$item->user_id] = Chat::where(function ($query) {
                    $query->where('destinatario_id', auth()->user()->id)
                        ->orWhere('user_id', auth()->user()->id);
                })
                    ->where(function ($query) use ($item) {
                        $query->where('destinatario_id', $item->user_id)
                            ->orWhere('user_id', $item->user_id);
                    })
                    ->where('community_id', null)
                    ->orderBy('id', 'desc')
                    ->get();
                foreach ($ultimomensajefriends[$item->user_id] as $ultimomensajefriend) {
                    $arraymensajes = explode(",", $ultimomensajefriend->leido);
                }
            } else $ultimomensajefriends[$item->user_id] = "No hay mensajes";
        }
        $ultimomensajecomunidadesparticipante = [];
        foreach ($communitiesParticipante as $item) {
            if (Chat::where('community_id', $item->id)->count()) $ultimomensajecomunidadesparticipante[$item->id] = Chat::where('community_id', $item->id)->orderBy('id', 'desc')->get();
            else $ultimomensajecomunidadesparticipante[$item->id] = "No hay mensajes";
        }
        $ultimomensajemiscomunidades = [];
        foreach ($myCommunities as $item) {
            if (Chat::where('community_id', $item->id)->count()) $ultimomensajemiscomunidades[$item->id] = Chat::where('community_id', $item->id)->orderBy('id', 'desc')->get();
            else $ultimomensajemiscomunidades[$item->id] = "No hay mensajes";
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
                $mensajesnoleidos = Chat::where(function ($query) {
                    $query->where('destinatario_id', auth()->user()->id)
                        ->orWhere('user_id', auth()->user()->id);
                })
                    ->where(function ($query) use ($tipoid) {
                        $query->where('destinatario_id', $tipoid)
                            ->orWhere('user_id', $tipoid);
                    })
                    ->where('community_id', null)
                    ->where('leido', '0')
                    ->orderBy('id', 'desc')
                    ->get();
                foreach ($mensajesnoleidos as $mensajenoleido) {
                    $mensajenoleido->update([
                        'leido' => auth()->user()->id . ","
                    ]);
                }
                break;
            case 2:
                $mensajes = Chat::where('community_id', $tipoid)
                    ->orderBy('id', 'desc')
                    ->get();
                $mensajesnoleidos = Chat::where('community_id', $tipoid)
                    ->where('leido', '0')
                    ->orderBy('id', 'desc')
                    ->get();
                foreach ($mensajesnoleidos as $mensajenoleido) {
                    $mensajenoleido->update([
                        'leido' => auth()->user()->id . ","
                    ]);
                }
                break;
        }
        if ($friends->count() || $myCommunities->count() || $communitiesParticipante->count()) {
            $textoFormateado[1] .= "<ul role='list' class='max-w-sm divide-y divide-gray-200'>";
            if ($friends->count()) {
                $textoFormateado[1] .= "<li class='py-3 sm:py-4'><h2 class='text-lg font-semibold text-center mb-5'>CONTACTOS</h2>";
                foreach ($friends as $friend) {
                    $textoFormateado[1] .= "<a href=\"" . route('chat.index', ['tipo' => '1', 'tipoid' => $friend->user_id]) . "\" class='flex items-center space-x-3 relative mb-5'><div class='flex-shrink-0'><img class='w-8 h-8 rounded-full' src=\"" . $friend->user->profile_photo_url . "\" title='" . $friend->user->name . "' alt='" . $friend->user->name . "'></div><div class='min-w-0'><p class='text-sm font-semibold truncate'>" . $friend->user->name . "</p><p class='text-sm truncate'>";
                    if ($ultimomensajefriends[$friend->user_id] == 'No hay mensajes') {
                        $textoFormateado[1] .= $ultimomensajefriends[$friend->user_id];
                    } else {
                        $textoFormateado[1] .= $ultimomensajefriends[$friend->user_id][0]['contenido'];
                    }
                    $textoFormateado[1] .= "</p></div>";
                    if ($ultimomensajefriends[$friend->user_id] != 'No hay mensajes' && $ultimomensajefriends[$friend->user_id]->where('leido', 0)->count()) {
                        $textoFormateado[1] .= "<div class='absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold bg-blue-300 rounded-full top-0 right-0'>" . $ultimomensajefriends[$friend->user_id]->where('leido', 0)->count() . "</div>";
                    }
                    $textoFormateado[1] .= "</a>";
                }
                $textoFormateado[1] .= "</li>";
            }
            if ($myCommunities->count()) {
                $textoFormateado[1] .= "<li class='py-3 sm:py-4'><h2 class='text-lg font-semibold text-center mb-5'>MIS COMUNIDADES</h2>";
                foreach ($myCommunities as $myCommunity) {
                    $textoFormateado[1] .= "<a href=\"" . route('chat.index', ['tipo' => '2', 'tipoid' => $myCommunity->id]) . "\" class='flex items-center space-x-3 relative mb-5'><div class='flex-shrink-0'><img class='w-8 h-8 rounded-full' src=\"" . Storage::url($myCommunity->imagen) . "\" title=\"" . $myCommunity->nombre . "\" alt=\"" . $myCommunity->nombre . "\"></div><div class='min-w-0'><p class='text-sm font-semibold truncate'>" . $myCommunity->nombre . "</p><p class='text-sm truncate'>";
                    if ($ultimomensajemiscomunidades[$myCommunity->id] == 'No hay mensajes') {
                        $textoFormateado[1] .= $ultimomensajemiscomunidades[$myCommunity->id];
                    } else {
                        $textoFormateado[1] .= $ultimomensajemiscomunidades[$myCommunity->id][0]['contenido'];
                    }
                    $textoFormateado[1] .= "</p></div>";
                    if ($ultimomensajemiscomunidades[$myCommunity->id] != 'No hay mensajes' && $ultimomensajemiscomunidades[$myCommunity->id]->where('leido', 0)->count()) {
                        $textoFormateado[1] .= "<div class='absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold bg-blue-300 rounded-full top-0 right-0'>" . $ultimomensajemiscomunidades[$myCommunity->id]->where('leido', 0)->count() . "</div>";
                    }
                    $textoFormateado[1] .= "</a>";
                }
                $textoFormateado[1] .= "</li>";
            }
            if ($communitiesParticipante->count()) {
                $textoFormateado[1] .= "<li class='py-3 sm:py-4'><h2 class='text-lg font-semibold text-center mb-5'>COMUNIDADES</h2>";
                foreach ($communitiesParticipante as $communityParticipante) {
                    $textoFormateado[1] .= "<a href=\"" . route('chat.index', ['tipo' => '2', 'tipoid' => $communityParticipante->id]) . "\" class='flex items-center space-x-3 relative mb-5'><div class='flex-shrink-0'><img class='w-8 h-8 rounded-full' src=\"" . Storage::url($communityParticipante->imagen) . "\" title=\"" . $communityParticipante->nombre . "\" alt=\"" . $communityParticipante->nombre . "\"></div><div class='min-w-0'><p class='text-sm font-semibold truncate'>" . $communityParticipante->nombre . "</p><p class='text-sm truncate'>";
                    if ($ultimomensajecomunidadesparticipante[$communityParticipante->id] == 'No hay mensajes') {
                        $textoFormateado[1] .= $ultimomensajecomunidadesparticipante[$communityParticipante->id];
                    } else {
                        $textoFormateado[1] .= $ultimomensajecomunidadesparticipante[$communityParticipante->id][0]['contenido'];
                    }
                    $textoFormateado[1] .= "</p></div>";
                    if ($ultimomensajecomunidadesparticipante[$communityParticipante->id] != 'No hay mensajes' && $ultimomensajecomunidadesparticipante[$communityParticipante->id]->where('leido', 0)->count()) {
                        $textoFormateado[1] .= "<div class='absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold bg-blue-300 rounded-full top-0 right-0'>" . $ultimomensajecomunidadesparticipante[$communityParticipante->id]->where('leido', 0)->count() . "</div>";
                    }
                    $textoFormateado[1] .= "</a>";
                }

                $textoFormateado[1] .= "</li>";
            }
            $textoFormateado[1] .= "</ul>";
        } else {
            $textoFormateado[1] .= "";
        }
        if (self::comprobarChat($tipo, $tipoid)) {
            $textoFormateado[0] = "<img src='" . Storage::url('logochat.png') . "' class='h-96 mx-auto' alt='logo Ofiuco'>";
            return $textoFormateado;
        }
        if ($mensajes->count()) {
            foreach ($mensajes->reverse() as $mensaje) {
                if ($mensaje->user_id == auth()->user()->id) {
                    $textoFormateado[0] .= "<div class = 'flex flex-row-reverse'>";
                    if ($mensaje->user->is_admin) {
                        if (auth()->user()->temaoscuro) {
                            $textoFormateado[0] .= "<p class='max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mt-2 mx-2 rounded-tl-xl text-white bg-gradient-to-r from-red-600 from-10% via-indigo-600 via-80% to-blue-600 to-90%'><span class='flex flex-wrap my-3'><a class='flex flex-col' href='" . route('perfiluser.show', $mensaje->user->id) . "'><img class='h-8 w-8 rounded-full ml-4 cursor-pointer' src='" . $mensaje->user->profile_photo_url . "' title='mensaje de " . $mensaje->user->name . "'alt='" . $mensaje->user->name . "' /></a><span class = 'flex flex-col mx-3 px-2 text-xl rounded-xl'>" . $mensaje->user->name . "</span></span>" . $mensaje->contenido . "</p>";
                        } else {
                            $textoFormateado[0] .= "<p class='max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mt-2 mx-2 rounded-tl-xl text-white bg-gradient-to-r from-red-500 from-10% via-indigo-500 via-80% to-blue-500 to-90%'><span class='flex flex-wrap my-3'><a class='flex flex-col' href='" . route('perfiluser.show', $mensaje->user->id) . "'><img class='h-8 w-8 rounded-full ml-4 cursor-pointer' src='" . $mensaje->user->profile_photo_url . "' title='mensaje de " . $mensaje->user->name . "'alt='" . $mensaje->user->name . "' /></a><span class = 'flex flex-col mx-3 px-2 text-xl rounded-xl'>" . $mensaje->user->name . "</span></span>" . $mensaje->contenido . "</p>";
                        }
                    } else if ($mensaje->community_id != null && $mensaje->community->user_id == $mensaje->user_id) {
                        if (auth()->user()->temaoscuro) {
                            $textoFormateado[0] .= "<p class='max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mt-2 mx-2 rounded-tl-xl bg-blue-700 text-white'><span class='flex flex-wrap my-3'><a class='flex flex-col' href='" . route('perfiluser.show', $mensaje->user->id) . "'><img class='h-8 w-8 rounded-full ml-4 cursor-pointer' src='" . $mensaje->user->profile_photo_url . "' title='mensaje de " . $mensaje->user->name . "'alt='" . $mensaje->user->name . "' /></a><span class = 'flex flex-col mx-3 px-2 text-xl rounded-xl'>" . $mensaje->user->name . "</span></span>" . $mensaje->contenido . "</p>";
                        } else {
                            $textoFormateado[0] .= "<p class='max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mt-2 mx-2 rounded-tl-xl bg-blue-400'><span class='flex flex-wrap my-3'><a class='flex flex-col' href='" . route('perfiluser.show', $mensaje->user->id) . "'><img class='h-8 w-8 rounded-full ml-4 cursor-pointer' src='" . $mensaje->user->profile_photo_url . "' title='mensaje de " . $mensaje->user->name . "'alt='" . $mensaje->user->name . "' /></a><span class = 'flex flex-col mx-3 px-2 text-xl rounded-xl'>" . $mensaje->user->name . "</span></span>" . $mensaje->contenido . "</p>";
                        }
                    } else {
                        if (auth()->user()->temaoscuro) {
                            $textoFormateado[0] .= "<p class='max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mt-2 mx-2 rounded-tl-xl bg-gray-700 text-white'><span class='flex flex-wrap my-3'><a class='flex flex-col' href='" . route('perfiluser.show', $mensaje->user->id) . "'><img class='h-8 w-8 rounded-full ml-4 cursor-pointer' src='" . $mensaje->user->profile_photo_url . "' title='mensaje de " . $mensaje->user->name . "'alt='" . $mensaje->user->name . "' /></a><span class = 'flex flex-col mx-3 px-2 text-xl rounded-xl'>" . $mensaje->user->name . "</span></span>" . $mensaje->contenido . "</p>";
                        } else {
                            $textoFormateado[0] .= "<p class='max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mt-2 mx-2 rounded-tl-xl bg-gray-300'><span class='flex flex-wrap my-3'><a class='flex flex-col' href='" . route('perfiluser.show', $mensaje->user->id) . "'><img class='h-8 w-8 rounded-full ml-4 cursor-pointer' src='" . $mensaje->user->profile_photo_url . "' title='mensaje de " . $mensaje->user->name . "'alt='" . $mensaje->user->name . "' /></a><span class = 'flex flex-col mx-3 px-2 text-xl rounded-xl'>" . $mensaje->user->name . "</span></span>" . $mensaje->contenido . "</p>";
                        }
                    }
                    $textoFormateado[0] .= "</div>";
                } else {
                    $textoFormateado[0] .= "<div class = 'flex'>";
                    if ($mensaje->user->is_admin) {
                        if (auth()->user()->temaoscuro) {
                            $textoFormateado[0] .= "<p class='max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mt-2 mx-2 rounded-tr-xl text-white bg-gradient-to-r from-red-600 from-10% via-indigo-600 via-80% to-blue-600 to-90%'><span class='flex flex-wrap my-3'><a class='flex flex-col' href='" . route('perfiluser.show', $mensaje->user->id) . "'><img class='h-8 w-8 rounded-full ml-4 cursor-pointer' src='" . $mensaje->user->profile_photo_url . "' title='mensaje de " . $mensaje->user->name . "'alt='" . $mensaje->user->name . "' /></a><span class = 'flex flex-col mx-3 px-2 text-xl rounded-xl'>" . $mensaje->user->name . "</span></span>" . $mensaje->contenido . "</p>";
                        } else {
                            $textoFormateado[0] .= "<p class='max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mt-2 mx-2 rounded-tr-xl text-white bg-gradient-to-r from-red-500 from-10% via-indigo-500 via-80% to-blue-500 to-90%'><span class='flex flex-wrap my-3'><a class='flex flex-col' href='" . route('perfiluser.show', $mensaje->user->id) . "'><img class='h-8 w-8 rounded-full ml-4 cursor-pointer' src='" . $mensaje->user->profile_photo_url . "' title='mensaje de " . $mensaje->user->name . "'alt='" . $mensaje->user->name . "' /></a><span class = 'flex flex-col mx-3 px-2 text-xl rounded-xl'>" . $mensaje->user->name . "</span></span>" . $mensaje->contenido . "</p>";
                        }
                    } else if ($mensaje->community_id != null && $mensaje->community->user_id == $mensaje->user_id) {
                        if (auth()->user()->temaoscuro) {
                            $textoFormateado[0] .= "<p class='max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mt-2 mx-2 rounded-tr-xl bg-blue-700 text-white'><span class='flex flex-wrap my-3'><a class='flex flex-col' href='" . route('perfiluser.show', $mensaje->user->id) . "'><img class='h-8 w-8 rounded-full ml-4 cursor-pointer' src='" . $mensaje->user->profile_photo_url . "' title='mensaje de " . $mensaje->user->name . "'alt='" . $mensaje->user->name . "' /></a><span class = 'flex flex-col mx-3 px-2 text-xl rounded-xl'>" . $mensaje->user->name . "</span></span>" . $mensaje->contenido . "</p>";
                        } else {
                            $textoFormateado[0] .= "<p class='max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mt-2 mx-2 rounded-tr-xl bg-blue-400'><span class='flex flex-wrap my-3'><a class='flex flex-col' href='" . route('perfiluser.show', $mensaje->user->id) . "'><img class='h-8 w-8 rounded-full ml-4 cursor-pointer' src='" . $mensaje->user->profile_photo_url . "' title='mensaje de " . $mensaje->user->name . "'alt='" . $mensaje->user->name . "' /></a><span class = 'flex flex-col mx-3 px-2 text-xl rounded-xl'>" . $mensaje->user->name . "</span></span>" . $mensaje->contenido . "</p>";
                        }
                    } else {
                        if (auth()->user()->temaoscuro) {
                            $textoFormateado[0] .= "<p class='max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mt-2 mx-2 rounded-tr-xl bg-gray-700 text-white'><span class='flex flex-wrap my-3'><a class='flex flex-col' href='" . route('perfiluser.show', $mensaje->user->id) . "'><img class='h-8 w-8 rounded-full ml-4 cursor-pointer' src='" . $mensaje->user->profile_photo_url . "' title='mensaje de " . $mensaje->user->name . "'alt='" . $mensaje->user->name . "' /></a><span class = 'flex flex-col mx-3 px-2 text-xl rounded-xl'>" . $mensaje->user->name . "</span></span>" . $mensaje->contenido . "</p>";
                        } else {
                            $textoFormateado[0] .= "<p class='max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mt-2 mx-2 rounded-tr-xl bg-gray-300'><span class='flex flex-wrap my-3'><a class='flex flex-col' href='" . route('perfiluser.show', $mensaje->user->id) . "'><img class='h-8 w-8 rounded-full ml-4 cursor-pointer' src='" . $mensaje->user->profile_photo_url . "' title='mensaje de " . $mensaje->user->name . "'alt='" . $mensaje->user->name . "' /></a><span class = 'flex flex-col mx-3 px-2 text-xl rounded-xl'>" . $mensaje->user->name . "</span></span>" . $mensaje->contenido . "</p>";
                        }
                    }
                    $textoFormateado[0] .= "</div>";
                }
            }
        } else {
            $textoFormateado[0] = "<p class='text-center'>SE EL PRIMERO EN MANDAR UN MENSAJE</p><img src='" . Storage::url('logochat.png') . "' class='h-96 mx-auto' alt='logo Ofiuco'>";
        }
        return $textoFormateado;
    }

    private function comprobarChat($tipo, $tipoid)
    {
        if ($tipo != 1 && $tipo != 2) {
            return true;
        }
        //comprobar que sean amigos o pertenezca a la comunidad
    }
}
