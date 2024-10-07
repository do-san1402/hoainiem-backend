<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Subscription extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'uuid',
        'subs_id',
        'name',
        'email',
        'phone',
        'category',
        'frequency',
        'number_of_news',
        'subs_auth_code',
        'payment_status',
        'social_sheare',
        'subscription_date',
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
            $model->subs_id = $model->id;
            $model->save();
        });

        static::addGlobalScope('sortByLatest', function (Builder $builder) {
            $builder->orderByDesc('id');
        });

    }
}
