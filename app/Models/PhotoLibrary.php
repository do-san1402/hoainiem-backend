<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PhotoLibrary extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'disk',
        'image_base_url',
        'actual_image_name',
        'picture_name',
        'thumb_image',
        'large_image',
        'title',
        'category',
        'reference',
        'time_stamp',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'uuid'              => 'string',
        'disk'              => 'string',
        'image_base_url'    => 'string',
        'actual_image_name' => 'string',
        'picture_name'      => 'string',
        'thumb_image'       => 'string',
        'large_image'       => 'string',
        'title'             => 'string',
        'category'          => 'integer',
        'reference'         => 'string',
        'time_stamp'        => 'integer',
        'status'            => 'integer',
    ];

    /**
     * The boot method to generate UUIDs for new records.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }

        });
    }

}
