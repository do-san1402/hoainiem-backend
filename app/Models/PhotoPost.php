<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Category\Entities\Category;

class PhotoPost extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'stitle',
        'title',
        'details',
        'reporter',
        'category',
        'post_by',
        'update_by',
        'meta_keyword',
        'meta_description',
        'status',
        'timestamp',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'stitle'           => 'string',
        'title'            => 'string',
        'details'          => 'string',
        'reporter'         => 'string',
        'category'         => 'string',
        'post_by'          => 'integer',
        'update_by'        => 'integer',
        'meta_keyword'     => 'string',
        'meta_description' => 'string',
        'status'           => 'integer',
        'timestamp'        => 'integer',
    ];

    /**
     * Post Category
     *
     * @return BelongsTo
     */
    public function postCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category', 'slug');
    }

    /**
     * Post User
     *
     * @return BelongsTo
     */
    public function postByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'post_by', 'id');
    }

    /**
     * Photo Post Details
     *
     * @return HasMany
     */
    public function photoPostDetails(): HasMany
    {
        return $this->hasMany(PhotoPostDetail::class, 'post_id', 'id');
    }
}
