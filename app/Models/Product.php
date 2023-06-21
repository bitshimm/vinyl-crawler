<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'website',
        'product_url',
        'tilda_uid',
        'code',
        'brand',
        'description',
        'category',
        'title',
        'text',
        'photo',
        'seo_title',
        'seo_descr',
        'seo_keywords',
        'price',
        'video',
        'text_product_card',
        'track_list',
    ];
}
