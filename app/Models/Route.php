<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];


    function pedagang(){
        return $this->belongsTo(User::class, 'users', 'id')->select('id', 'name', 'role');
    }
}
