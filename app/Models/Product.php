<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'id','nama', 'jumlah', 'detail','harga','pedagang'
    ];

    function pedagang(){
        return $this->belongsTo(User::class, 'pedagang', 'id');
    }
}
