<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use Modules\Category\Entities\Category;
use Modules\Reporter\Entities\Reporter;

class NewsMst extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'news_id',
        'encode_title',
        'seo_title',
        'stitle',
        'title',
        'large_image',
        'title',
        'news',
        'image',
        'image_base_url',
        'image_alt',
        'image_title',
        'videos',
        'podcust_id',
        'image_alt',
        'reporter',
        'page',
        'reference',
        'ref_date',
        'post_by',
        'reporter_id',
        'update_by',
        'time_stamp',
        'post_date',
        'publish_date',
        'last_update',
        'is_latest',
        'reader_hit',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'news_id'        => 'string',
        'encode_title'   => 'string',
        'seo_title'      => 'string',
        'stitle'         => 'string',
        'title'          => 'string',
        'large_image'    => 'string',
        'title'          => 'string',
        'news'           => 'string',
        'image'          => 'string',
        'image_base_url' => 'string',
        'image_alt'      => 'string',
        'image_title'    => 'string',
        'videos'         => 'string',
        'podcust_id'     => 'integer',
        'image_alt'      => 'string',
        'reporter'       => 'string',
        'page'           => 'string',
        'reference'      => 'string',
        'ref_date'       => 'date',
        'post_by'        => 'string',
        'reporter_id'    => 'integer',
        'update_by'      => 'string',
        'time_stamp'     => 'integer',
        'post_date'      => 'date',
        'publish_date'   => 'date',
        'last_update'    => 'datetime',
        'is_latest'      => 'integer',
        'reader_hit'     => 'integer',
        'status'         => 'integer',
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
     * Post Reporter
     *
     * @return BelongsTo
     */
    public function reporterBy(): BelongsTo
    {
        return $this->belongsTo(Reporter::class, 'reporter_id', 'id');
    }

    /**
     * Category
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'page', 'slug');
    }

    /**
     * Photo Library
     *
     * @return BelongsTo
     */
    public function photoLibrary(): BelongsTo
    {
        return $this->belongsTo(PhotoLibrary::class, 'image', 'actual_image_name');
    }

    /**
     * Other News Position
     *
     * @return hasOne
     */
    public function otherNewsPosition(): HasOne
    {
        return $this->hasOne(NewsPosition::class, 'news_id', 'news_id')->where('page', '!=', 'home');
    }

    /**
     * Home News Position
     *
     * @return HasOne
     */
    public function homeNewsPosition(): HasOne
    {
        return $this->hasOne(NewsPosition::class, 'news_id', 'news_id')->where('page', 'home');
    }

    /**
     * Schema Post
     *
     * @return HasOne
     */
    public function schemaPost(): HasOne
    {
        return $this->hasOne(SchemaPost::class, 'news_id', 'news_id');
    }

    /**
     * Post Tag
     *
     * @return HasMany
     */
    public function postTags(): HasMany
    {
        return $this->hasMany(PostTag::class, 'news_id', 'news_id');
    }

    /**
     * Post Seo On Page
     *
     * @return hasOne
     */
    public function postSeoOnpage(): HasOne
    {
        return $this->hasOne(PostSeoOnpage::class, 'news_id', 'news_id');
    }

}
