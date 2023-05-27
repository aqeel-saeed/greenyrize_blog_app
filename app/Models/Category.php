<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'encoded_image'
    ];
    public function posts() {
        return $this->belongsToMany(Post::class);
    }
}
