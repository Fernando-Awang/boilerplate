<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    protected $fillable = [
           'gallery_category_id',
           'source',
           'caption',
    ];
    public function category()
    {
        return $this->belongsTo(GalleryCategory::class, 'gallery_category_id', 'id');
    }
}
