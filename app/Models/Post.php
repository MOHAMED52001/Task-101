<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'title',
        'content',
        'category_id',
        'media'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function carousels()
    {
        return $this->hasMany(PostCarousel::class);
    }
}
