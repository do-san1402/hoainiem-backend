<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upazila extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'district_id',
        'name',
        'bn_name',
        'url',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'district_id' => 'integer',
        'name'        => 'string',
        'bn_name'     => 'string',
        'url'         => 'string',
    ];
}
