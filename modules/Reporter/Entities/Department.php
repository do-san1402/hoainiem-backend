<?php

namespace Modules\Reporter\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Department extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'department_name',
    ];

    protected static function boot()
    {
        parent::boot();
        if (Auth::check()) {
            self::creating(function ($model) {
                $model->created_by = Auth::id();
            });

            self::updating(function ($model) {
                $model->updated_by = Auth::id();
            });
        }
    }
}
