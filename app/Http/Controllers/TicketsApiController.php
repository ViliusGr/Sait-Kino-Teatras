<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Ticket;
use App\Models\Screening;
use App\Models\User;

class TicketsApiController extends Controller
{

    public function index(User $user){
        return $user->tickets;
    }

    public function get(User $user, Ticket $ticket){
        return User::find($user->id)->tickets()->where('id', $ticket->id)->first();
    }

    public function store(User $user){
        $result = request()->validate([
            'cost' => 'required'
        ]);

        $ticket = new Ticket;
        $ticket->cost = request('cost');
        $user->tickets()->save($ticket);

        return $ticket;
    
    }

    public function update(User $user, Ticket $ticket){

        request()->validate([
            'cost' => 'required'
        ]);
    
        $status = $ticket->update([
            'cost' => request('cost')
        ]);
    
        return [
            'success' => $status
        ];
    
    }

    public function destroy(User $user, Ticket $ticket){

        $ticket->delete();

        return response()->json([], 204);

    }
}
