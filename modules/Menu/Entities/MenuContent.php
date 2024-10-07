<?php

namespace Modules\Menu\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuContent extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content_type',
        'content_id',
        'menu_position',
        'menu_level',
        'link_url',
        'slug',
        'parent_id',
        'menu_id',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'content_type'  => 'string',
        'content_id'    => 'integer',
        'menu_position' => 'integer',
        'menu_level'    => 'string',
        'link_url'      => 'string',
        'slug'          => 'string',
        'parent_id'     => 'integer',
        'menu_id'       => 'integer',
        'status'        => 'integer',
    ];

}
