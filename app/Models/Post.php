<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $filleable = [
        'post_category_id',
        'author',
        'title',
        'slug',
        'thumbnail',
        'content',
    ];
}
