<?php

namespace Modules\Setting\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityLog extends Model
{
    use HasFactory;

    protected $table = "activity_log";
    
    public function user(){
        return $this->belongsTo(User::class, 'causer_id', 'id')->select(['id', 'full_name']);
    }
}
