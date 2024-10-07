<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Setting\Entities\Country;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Currency extends Model
{
    use HasFactory;
        use LogsActivity;

    protected $fillable = ['country_id', 'symbol', 'title' , 'status'];
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Setting (Currency)')
            ->setDescriptionForEvent(fn(string $eventName) => "You have {$eventName} a currency")
            ->logAll();
    }
    public function country(){
        return $this->belongsTo(Country::class);
    }
}
