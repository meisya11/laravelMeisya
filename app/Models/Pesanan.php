<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'lokasi',
        'alamat',
        'status',
        'order_time',
    ];

    public function userpesanan()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function pesananpedagang()
    {
        return $this->belongsTo(User::class,'pedagang_id','id');
    }
    function detail()
    {
        return $this->hasMany(Detailpesanan::class,'order_id','id');
    }
}
