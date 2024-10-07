<?php

namespace Modules\UserManagement\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Permission;


class PerMenu extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'id',
        'uuid',
        'parentmenu_id',
        'lable',
        'menu_name',

    ];

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


            self::deleted(function($model){
                $model->updated_by = Auth::id();
                $model->save();
            });


        }

	    static::addGlobalScope('sortByLatest', function (Builder $builder) {
            $builder->orderByDesc('id');
        });
    }

    public function permission()
    {
        return $this->hasMany(Permission::class);
    }
    //sub menu
    public function subMenu()
    {
        return $this->hasMany(PerMenu::class,'parentmenu_id')->with('permission','childMenu');
    }

    //child menu
    public function childMenu()
    {
        return $this->hasMany(PerMenu::class,'parentmenu_id')->with('permission');
    }

}
