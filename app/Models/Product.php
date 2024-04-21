<?php

namespace App\Models;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'price',
        'quantity',
        'is_available',
        'category_id',
        'seller_id'
    ];
    protected $casts = [
        'is_available' => 'boolean',
    ];
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
