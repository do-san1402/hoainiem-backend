<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appsetting extends Model
{
    use HasFactory,SoftDeletes;

    // Explicitly define the table name
    protected $table = 'app_settings';

    protected $fillable = [
        'uuid',
        'website_title',
        'footer_text',
        'copy_right',
        'time_zone',
        'ltl_rtl',
        'logo',
        'footer_logo',
        'favicon',
        'app_logo',
        'mobile_menu_image',
        'newstriker_status',
        'share_status',
        'preloader_status',
        'speed_optimization',
        'captcha',
        'version',
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
