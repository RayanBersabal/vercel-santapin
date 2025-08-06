<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutPageSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'hero_title',
        'hero_subtitle',
        'hero_image_url',
        'about_paragraph',
        'about_image_url',
        'visi',
        'misi',
        'gallery',
    ];

    protected $casts = [
        'gallery' => 'json',
    ];
}
