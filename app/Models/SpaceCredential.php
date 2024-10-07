<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpaceCredential extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'secret',
        'region',
        'bucket',
        'url',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'type'   => 'string',
        'secret' => 'string',
        'region' => 'string',
        'bucket' => 'string',
        'url'    => 'string',
        'status' => 'integer',
    ];
}
