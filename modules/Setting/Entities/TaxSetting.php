<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class TaxSetting extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = [
        'tax_number',
        'tax_name',
        'tax_percentage',
        'tax_group_id'
    ];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Setting (Tax)')
            ->setDescriptionForEvent(fn (string $eventName) => "Tax setting {$eventName}")
            ->logAll();
    }
}
