<?php

namespace App\Http\Livewire;

use App\Models\Community;
use App\Models\Friend;
use Livewire\Component;

class ShowMessages extends Component {
    public function render() {
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
            ->simplePaginate (5);
        $myCommunities = Community::where('user_id',auth()->user()->id)->simplePaginate (5);
        $communitiesParticipante = auth()->user()->communities()->simplePaginate (5);
        return view('livewire.show-messages',compact('friends','myCommunities','communitiesParticipante'));
    }
}
