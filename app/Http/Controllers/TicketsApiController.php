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
        //$tickets = auth()->user()->tickets;
        
        try{
            $user = auth()->userOrFail();
        } catch(\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e){
            return response()->json([ 'error' => $e->getMessage() ]);
        }

        return $user->posts;
    }

    public function get(User $user, Ticket $ticket){
        return User::find($user->id)->tickets()->where('id', $ticket->id)->first();
    }

    public function store(User $user){
        $result = request()->validate([
            'cost' => 'required'
        ]);

        try{
            $user = auth()->userOrFail();
        } catch(\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e){
            return response()->json([ 'error' => $e->getMessage() ]);
        }

        $ticket = new Ticket;
        $ticket->cost = request('cost');
        $screening = Screening::where('id', 1)->first();

        $ticket->screening()->associate($screening);
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
