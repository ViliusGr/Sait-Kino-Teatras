<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Row extends Model
{
    use HasFactory;


    public function seats(){
        return $this->hasMany(Seat::class);
    }


    public function auditorium()
    {
        return $this->belongsTo(Auditorium::class);
    }
}
