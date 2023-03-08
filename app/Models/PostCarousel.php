<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCarousel extends Model
{
    use HasFactory;

    protected $table = 'post_carousels';

    protected $fillable = [
        'post_id',
        'is-ad',
        'content',
        'see_more',
        'media',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
