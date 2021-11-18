<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auditorium extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'numberOfRows',
        'numberOfSeatsInRow'
    ];

    public function rows(){
        return $this->hasMany(Row::class);
    }
}
