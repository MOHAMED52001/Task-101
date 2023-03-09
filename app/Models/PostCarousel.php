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
        'is_ad',
        'content',
        'see_more',
        'img',
        'video',
        'pub_num',
        'slot_num',
        'ad_script',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
