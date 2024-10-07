<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'division_id',
        'name',
        'bn_name',
        'lat',
        'lon',
        'url',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'division_id' => 'integer',
        'name'        => 'string',
        'bn_name'     => 'string',
        'lat'         => 'string',
        'lon'         => 'string',
        'url'         => 'string',
    ];
}
