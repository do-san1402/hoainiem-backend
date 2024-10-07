<?php

namespace Modules\Setting\Entities;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Country extends Model
{
    use HasFactory, SoftDeletes;
    use LogsActivity;

    protected $fillable = ['country_name', 'country_code', 'is_active'];
        
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Setting (Country)')
            ->setDescriptionForEvent(fn(string $eventName) => "You have {$eventName} a country")
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
    }
    
}
