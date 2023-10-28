<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Community;
use App\Models\Friend;
use Illuminate\Http\Request;
use Livewire\WithPagination;

class ChatController extends Controller
{
    use WithPagination;

    protected $mensajes;
    public $tipo;
    public $tipoid;
    protected $layout = 'layouts.app';

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $tipo, $tipoid)
    {
        $this->tipo = $tipo;
        $this->tipoid = $tipoid;
        switch ($this->tipo) {
            case 0:
                $this->mensajes = Chat::where('id', '0')->paginate(15);
                break;
            case 1:
                $this->mensajes = Chat::where('destinatario_id', auth()->user()->id)
                    ->orderBy('id', 'desc')
                    ->paginate(15);

                break;
            case 2:
                $this->mensajes = Chat::where('community_id', $this->tipoid)
                    ->orderBy('id', 'desc')
                    ->paginate(15);

                break;
            default:
                return redirect()->route('chat.index', ['tipo' => 0, 'tipoid' => 0]);
        }
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
        $mensajes = $this->mensajes;
        $tipo = $this->tipo;
        $tipoid = $this->tipoid;
        return view('chat.chat-messages', compact('friends', 'myCommunities', 'communitiesParticipante', 'mensajes', 'tipo', 'tipoid'));
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
    public function store(Request $request)
    {
        //
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

    public function abrirChat(Request $request, $tipo, $tipoid)
    {
        $this->tipo = $tipo;
        $this->tipoid = $tipoid;
        switch ($this->tipo) {
            case 0:
                $this->mensajes = Chat::where('id', '0')->paginate(15);
                break;
            case 1:
                $this->mensajes = Chat::where('destinatario_id', auth()->user()->id)
                    ->orderBy('id', 'desc')
                    ->paginate(15);

                break;
            case 2:
                $this->mensajes = Chat::where('community_id', $this->tipoid)
                    ->orderBy('id', 'desc')
                    ->paginate(15);

                break;
            default:
                return redirect()->route('messages.show', ['tipo' => 0, 'tipoid' => 0]);
        }
        Chat::create([
            'user_id' => auth()->user()->id,
            'destinatario_id' => 1,
            'contenido' => "prueba1"
        ]);
        return response()->json(['mensajes' => $this->mensajes]);
    }
}
