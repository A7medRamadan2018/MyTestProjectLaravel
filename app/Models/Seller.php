<?php

namespace App\Models;

use App\Events\SellerRegisteredEvent;
use App\Events\SellerRegisteringEvent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Seller extends Model
{
    use HasFactory, HasApiTokens;
    // protected $dispatchesEvents = [
    //     // 'created' => SellerRegisteredEvent::class,
    //     // 'creating' =>SellerRegisteringEvent::class
    // ];

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone_number',
        'birth_date',
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
    public function getFullNameAttribute(){
        return "{$this->first_name} {$this->last_name}";
    }
}
