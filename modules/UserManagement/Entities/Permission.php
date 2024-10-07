<?php

namespace Modules\UserManagement\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\UserManagement\Entities\PerMenu;
use Illuminate\Database\Eloquent\Builder;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected static function boot()
    {
        parent::boot();


	    static::addGlobalScope('sortByLatest', function (Builder $builder) {
            $builder->orderByDesc('id');
        });
    }

    public function perMenu()
    {
        return $this->belongsTo(PerMenu::class);
    }
}
