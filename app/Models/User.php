<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Profile;
use App\Models\Route;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    function route()
    {
        return $this->hasMany(Route::class, 'users', 'id');
    }
    function user()
    {
        return $this->hasMany(Route::class, 'name', 'name');
    }
    function product()
    {
        return $this->hasMany(Product::class, 'pedagang', 'id');
    }
    function lastRoute()
    {
        return $this->hasMany(Route::class, 'users', 'id')->latest()->take(1);
    }

     function profile()
    {
        return $this->hasOne(Profile::class,'user_id','id');
    }
    function pesanan()
    {
        return $this->hasMany(Pesanan::class,'user_id','id');
    }

    function datapedagang()
    {
        return $this->hasMany(Pesanan::class,'pedagang_id','id');
    }
}
