<?php

namespace Modules\Reporter\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Reporter extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'uuid',
        'reporter_id',
        'user_id',
        'email',
        'mobile',
        'password',
        'name',
        'nick_name',
        'pen_name',
        'sex',
        'blood',
        'birth_date',
        'photo',
        'address_one',
        'address_two',
        'about',
        'city',
        'state',
        'country',
        'zip',
        'verification_id_no',
        'verification_type',
        'user_type',
        'login_time',
        'logout_time',
        'ip',
        'status',
        'post_ap_status',
        'department_id',
        'designation',
    ];

    protected static function boot()
    {
        parent::boot();
        if (Auth::check()) {
            self::creating(function ($model) {
                $model->uuid = (string) Str::uuid();
                $model->created_by = Auth::id();
            });

            self::created(function ($model) {
                $model->reporter_id = str_pad($model->id, 6, 0, STR_PAD_LEFT);
                $model->save();
            });

            self::updating(function ($model) {
                $model->updated_by = Auth::id();
            });
        }
    }
}
