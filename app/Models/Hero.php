<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    protected $fillable = [
        'label',
        'title',
        'description',
        'video_text',
        'video_url',
        'button_text',
        'banner_title',
        'banner_text',
        'round_text',
        'image'
    ];
}
