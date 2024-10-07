<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePagePosition extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cat_name',
        'slug',
        'max_news',
        'category_id',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'cat_name'    => 'string',
        'slug'        => 'string',
        'max_news'    => 'string',
        'category_id' => 'integer',
        'status'      => 'integer',
    ];
}
