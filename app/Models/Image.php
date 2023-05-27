<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $fillable = [
        'encoded_image',
        'post_id'
    ];

    public function post(){
        return $this->belongsTo(Post::class);
    }
}
