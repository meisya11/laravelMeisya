<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detailpesanan extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'order_name',
        'quantity',
        'detail_order',
    ];

    public function order()
    {
        return $this->belongsTo(Pesanan::class, 'order_id', 'id');
    }

}
