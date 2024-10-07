<?php

namespace Modules\Archive\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MaxArchiveSetting extends Model
{
    use HasFactory, SoftDeletes;

    // Specify the primary key field
    protected $primaryKey = 'category_id';

    // Indicate that the primary key is not auto-incrementing
    public $incrementing = false;

    // Specify the type of the primary key
    protected $keyType = 'integer'; // 'integer' if it's an integer

    protected $fillable = [
        'category_id',
        'uuid',
        'max_archive',
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
            $builder->orderByDesc('category_id');
        });

    }
}
