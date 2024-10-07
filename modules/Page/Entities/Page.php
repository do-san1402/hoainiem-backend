<?php

namespace Modules\Page\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Page extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'page_id',
        'title',
        'page_slug',
        'description',
        'image_id',
        'galary_id',
        'video_url',
        'publishar_id',
        'seo_keyword',
        'seo_description',
        'publish_date',
        'reader_view',
        'releted_id',
        'status',
    ];

    public function publisher_user_info(){

        return $this->belongsTo(User::class, 'publishar_id', 'id');
    }

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

        // Assigning the ID to category_id as old database had category_id as primary_key
        self::created(function($model) {
            $model->page_id = $model->id;
            $model->save();
        });

        static::addGlobalScope('sortByLatest', function (Builder $builder) {
            $builder->orderByDesc('id');
        });

    }
}
