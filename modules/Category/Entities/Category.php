<?php

namespace Modules\Category\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\Archive\Entities\MaxArchiveSetting;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'category_id',
        'category_name',
        'slug',
        'menu',
        'position',
        'parents_id',
        'category_imgae',
        'img_status',
        'category_type',
        'description',
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

        // Assigning the ID to category_id as old database had category_id as primary_key
        self::created(function($model) {
            $model->category_id = $model->id;
            $model->save();
        });

        static::addGlobalScope('sortByLatest', function (Builder $builder) {
            $builder->orderByDesc('id');
        });

    }

    public function maxArchiveSetting()
    {
        return $this->hasOne(MaxArchiveSetting::class, 'category_id', 'category_id');
    }
}
