<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Screening extends Model
{
    use HasFactory;

    protected $fillable = [
        'time'
    ];


    public function tickets(){
        return $this->hasMany(Ticket::class);
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
}
