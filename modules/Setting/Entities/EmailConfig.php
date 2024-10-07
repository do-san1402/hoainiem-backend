<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class EmailConfig extends Model
{
    use HasFactory;    
    use LogsActivity;

    protected $guarded = [];    

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Setting (Email Config)')
            ->setDescriptionForEvent(fn(string $eventName) => "Email config {$eventName}")
            ->logAll();
    }
}
