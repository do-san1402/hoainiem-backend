<?php

namespace Modules\Archive\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NewsArchive extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'news_id',
        'encode_title',
        'seo_title',
        'stitle',
        'title',
        'news',
        'image',
        'image_base_url',
        'videos',
        'podcust_id',
        'image_alt',
        'image_title',
        'reporter',
        'page',
        'reference',
        'ref_date',
        'post_by',
        'update_by',
        'time_stamp',
        'post_date',
        'publish_date',
        'last_update',
        'is_latest',
        'reader_hit',
        'status',
    ];
    

    protected static function boot()
    {
        parent::boot();
        if(Auth::check()){
            self::creating(function($model) {
                $model->uuid = (string) Str::uuid();
                $model->created_by = Auth::id();
            });

            self::updating(function($model) {
                $model->updated_by = Auth::id();
            });

            self::deleted(function($model){
                $model->updated_by = Auth::id();
                $model->save();
            });
        }

        static::addGlobalScope('sortByLatest', function (Builder $builder) {
            $builder->orderByDesc('id');
        });

    }
}
