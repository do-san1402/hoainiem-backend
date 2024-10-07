<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PhotoPostDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id',
        'title',
        'image',
        'image_base_url',
        'photo_reference',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'post_id'         => 'integer',
        'title'           => 'string',
        'image'           => 'string',
        'image_base_url'  => 'string',
        'photo_reference' => 'string',
    ];

    /**
     * Photo Library
     *
     * @return BelongsTo
     */
    public function photoLibrary(): BelongsTo
    {
        return $this->belongsTo(PhotoLibrary::class, 'image', 'actual_image_name');
    }
}
