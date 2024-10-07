<?php

namespace Modules\UserManagement\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PasswordSetting extends Model
{
    use HasFactory,softDeletes;
    use LogsActivity;

    protected $fillable = ['min_length','max_lifetime','password_complexcity','password_history','lock_out_duration','session_idle_logout_time','is_active'];
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Password Setting')
            ->setDescriptionForEvent(fn(string $eventName) => "Password Setting {$eventName}")
            ->logAll();
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
        }

        static::addGlobalScope('sortByLatest', function (Builder $builder) {
            $builder->orderByDesc('id');
        });
    }
}
