<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocExpiredSetting extends Model
{
    use HasFactory;

    protected $fillable = ['primary_expiration_alert', 'secondary_expiration_alert'];    
    
}
