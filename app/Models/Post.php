<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_category_id',
        'author',
        'title',
        'slug',
        'thumbnail',
        'content',
    ];
    public function category()
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id', 'id');
    }
    public function get_author()
    {
        return $this->belongsTo(User::class, 'author', 'id');
    }
}
