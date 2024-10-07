<?php

namespace Modules\UserManagement\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Role extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [];

    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Role')
            ->setDescriptionForEvent(fn(string $eventName) => "You have {$eventName} a Role")
            ->logAll();
    }
}
