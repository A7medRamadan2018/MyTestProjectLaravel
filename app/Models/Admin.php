<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Admin extends Model
{
    use HasFactory, HasApiTokens, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
        'job',
        'phone_number',
        'birth_date',
        'super_admin'
    ];

    protected $casts =
    [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'password' => 'hashed',
        'super_admin' => 'boolean',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }
}
