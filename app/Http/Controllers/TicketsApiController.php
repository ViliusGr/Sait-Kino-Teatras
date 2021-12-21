<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Ticket;
use App\Models\Movie;
use App\Models\Screening;
use App\Models\User;

class TicketsApiController extends Controller
{

    public function index(User $user){
        
        try{
            $us = auth()->userOrFail();
        } catch(\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e){
            return response()->json([ 'error' => $e->getMessage() ]);
        }
        if($us != $user){
            return response()->json([ 'error' => 'Wrong user.' ]);
        }
        foreach($us->tickets as $ticket){
            $screening = Screening::where('id', $ticket->screening_id)->first();
            $ticket->screening()->associate($screening);
            $movie = Movie::where('id', $screening->movie_id)->first();
            $screening->movie()->associate($movie);
        }
        
        return $us->tickets;
    }

    public function get(User $user, Ticket $ticket){
        try{
            $us = auth()->userOrFail();
        } catch(\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e){
            return response()->json([ 'error' => $e->getMessage() ]);
        }

        if($us != $user){
            return response()->json([ 'error' => 'Wrong user.' ]);
        }

        

        return User::find($user->id)->tickets()->where('id', $ticket->id)->first();
    }

    public function store(User $user){
        $result = request()->validate([
            'cost' => 'required',
            'screening_id' => 'required'
        ]);

        try{
            $us = auth()->userOrFail();
        } catch(\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e){
            return response()->json([ 'error' => $e->getMessage() ]);
        }

        if($us != $user){
            return response()->json([ 'error' => 'Wrong user.' ]);
        }


        $ticket = new Ticket;
        $ticket->cost = request('cost');
        $screening_id = request('screening_id');
        $screening = Screening::where('id', $screening_id)->first();

        $ticket->screening()->associate($screening);
        $user->tickets()->save($ticket);
        

        return $ticket;
    
    }

    public function update(User $user, Ticket $ticket){

        request()->validate([
            'cost' => 'required'
        ]);

        try{
            $us = auth()->userOrFail();
        } catch(\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e){
            return response()->json([ 'error' => $e->getMessage() ]);
        }

        if($us != $user){
            return response()->json([ 'error' => 'Wrong user.' ]);
        }
    
        $status = $ticket->update([
            'cost' => request('cost')
        ]);
    
        return [
            'success' => $status
        ];
    
    }

    public function destroy(User $user, Ticket $ticket){

        try{
            $us = auth()->userOrFail();
        } catch(\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e){
            return response()->json([ 'error' => $e->getMessage() ]);
        }

        if($us != $user){
            return response()->json([ 'error' => 'Wrong user.' ]);
        }

        $ticket->delete();

        return response()->json([], 204);

    }
}
