<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Admin extends Model
{
    use HasFactory, HasApiTokens, Notifiable;
    protected $fillable =
    [
        'first_name',
        'last_name',
        'email',
        'password',
        'job',
        'phone_number',
        'birth_date',
        'super_admin',
        'status'
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

    // protected static function booted()
    // {
    //     static::addGlobalScope('admins', function (Builder $builder) {
    //         $builder->where('super_admin', 0 );

    //     });
    // }
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function getSuperAdmin()
    {
        return $this->super_admin;
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
