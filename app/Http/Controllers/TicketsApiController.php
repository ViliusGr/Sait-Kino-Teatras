<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Ticket;
use App\Models\Screening;

class TicketsApiController extends Controller
{

    public function index(Screening $screening){
        return $screening->tickets;
    }

    public function get(Screening $screening, Ticket $ticket){
        return Screening::find($screening->id)->tickets()->where('id', $ticket->id)->first();
    }

    public function store(Screening $screening){
        $result = request()->validate([
            'cost' => 'required'
        ]);

        $ticket = new Ticket;
        $ticket->cost = request('cost');
        $screening->tickets()->save($ticket);

        return $ticket;
    
    }

    public function update(Screening $screening, Ticket $ticket){

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

    public function destroy(Screening $screening, Ticket $ticket){

        $ticket->delete();

        return response()->json([], 204);

    }
}
