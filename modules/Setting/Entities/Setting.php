<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Setting extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'event',
        'details',
    ];

    protected static function boot()
    {
        parent::boot();
        if(Auth::check()){
            self::creating(function($model) {
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
