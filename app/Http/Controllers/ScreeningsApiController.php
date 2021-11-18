<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Movie;
use App\Models\Screening;

class ScreeningsApiController extends Controller
{
    public function index(Movie $movie){
        return $movie->screenings;
    }

    public function get(Movie $movie, Screening $screening){
        return Movie::find($movie->id)->screenings()->where('id', $screening->id)->first();
        //return $screening;
    }

    public function store(Movie $movie){
        $result = request()->validate([
            'time' => 'required'
        ]);

        $scr = new Screening;
        $scr->time = request('time');
        $movie->screenings()->save($scr);

        return $scr;
    
    }

    public function update(Movie $movie, Screening $screening){

        request()->validate([
            'time' => 'required'
        ]);
    
        $status = $screening->update([
            'time' => request('time')
        ]);
    
        return [
            'success' => $status
        ];
    
    }

    public function destroy(Movie $movie, Screening $screening){

        $screening->delete();

        return response()->json([], 204);

    }

}
