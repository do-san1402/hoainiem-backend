<?php

namespace Modules\Menu\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'position',
        'style',
        'status',
        'mobile_status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'name'          => 'string',
        'position'      => 'string',
        'style'         => 'string',
        'status'        => 'integer',
        'mobile_status' => 'integer',
    ];

}
