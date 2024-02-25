<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'admin_id',
    ];

    protected $casts =
    [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
