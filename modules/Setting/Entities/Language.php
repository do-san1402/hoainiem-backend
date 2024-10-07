<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Language extends Model
{
    use HasFactory;    
    use LogsActivity;

    protected $fillable = ['title' , 'slug' , 'status'];  

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Setting (Language)')
            ->setDescriptionForEvent(fn(string $eventName) => "You have {$eventName} a language")
            ->logAll();
    }
}
