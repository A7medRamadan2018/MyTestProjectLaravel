<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'job',
        'phone_number',
        'birth_date',
        'image'
    ];

    protected $casts =
    [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'password' => 'hashed',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
