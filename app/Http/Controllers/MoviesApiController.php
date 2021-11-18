<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Movie;

class MoviesApiController extends Controller
{
    public function index(){
        return Movie::all();
    }

    public function get(Movie $movie){
        return $movie;
    }

    public function store(){
        $result = request()->validate([
            'title' => 'required',
            'year' => 'required',
            'length' => 'required',
            'description' => 'required',
            'director' => 'required'
        ]);

        return Movie::create([
            'title' => request('title'),
            'year' => request('year'),
            'length' => request('length'),
            'description' => request('description'),
            'director' => request('director')
        ]);
    
    }

    public function update(Movie $movie){

        request()->validate([
            'title' => 'required',
            'year' => 'required',
            'length' => 'required',
            'description' => 'required',
            'director' => 'required'
        ]);
    
        $status = $movie->update([
            'title' => request('title'),
            'year' => request('year'),
            'length' => request('length'),
            'description' => request('description'),
            'director' => request('director')
        ]);
    
        return [
            'success' => $status
        ];
    
    }

    public function destroy(Movie $movie){

        $movie->delete();

        return response()->json([], 204);

    }
}
