<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
     protected $fillable = [
        'user_id',
        'user_name',
        'unique_id',
        'user_email',
        'post_title',
        'post_img_path',
        'post_vid_path',
        'post_pdf_path',
        'post_song_path',
        'category',
        'link',
        'post_intro',
        'post_body',
        'post_ending',
        'post_views',
        'date',
    ];
}
