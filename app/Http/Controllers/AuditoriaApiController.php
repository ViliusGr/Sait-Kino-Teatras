<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auditorium;

class AuditoriaApiController extends Controller
{
    public function index(){
        return Auditorium::all();
    }

    public function get(Auditorium $auditorium){
        return $auditorium;
    }

    public function store(){
        $result = request()->validate([
            'code' => 'required',
            'numberOfRows' => 'required',
            'numberOfSeatsInRow' => 'required'
        ]);

        return Auditorium::create([
            'code' => request('code'),
            'numberOfRows' => request('numberOfRows'),
            'numberOfSeatsInRow' => request('numberOfSeatsInRow')
        ]);
    
    }

    public function update(Auditorium $auditorium){

        request()->validate([
            'code' => 'required',
            'numberOfRows' => 'required',
            'numberOfSeatsInRow' => 'required'
        ]);
    
        $status = $auditorium->update([
            'code' => request('code'),
            'numberOfRows' => request('numberOfRows'),
            'numberOfSeatsInRow' => request('numberOfSeatsInRow')
        ]);
    
        return [
            'success' => $status
        ];
    
    }

    public function destroy(Auditorium $auditorium){

        $auditorium->delete();

        return response()->json([], 204);

    }
}
