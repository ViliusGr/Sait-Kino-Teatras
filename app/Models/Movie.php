<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'year',
        'length',
        'description',
        'director' 
    ];

    public function screenings(){
        return $this->hasMany(Screening::class);
    }
}
