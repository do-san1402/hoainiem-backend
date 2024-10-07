<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Modules\Reporter\Entities\Reporter;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_name',
        'full_name',
        'email',
        'password',
        'profile_image',
        'cover_image',
        'signature',
        'user_type_id',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
            self::creating(function($model) {
                $model->uuid = (string) Str::uuid();
            });


        static::addGlobalScope('sortByLatest', function (Builder $builder) {
            $builder->orderByDesc('id');
        });
    }


    public function admin(){
        if($this->user_type_id == 1){
         return true;
        } else {
         return false;
        }
    }

    //user all role
    public function userRole(){
        return $this->belongsToMany(Role::class,'model_has_roles','model_id','role_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('User')
            ->dontLogIfAttributesChangedOnly(['remember_token']);
    }

    public function getActivityDescriptionForEvent(string $eventName): string
    {
        if ($eventName === 'created') {
            return 'User registered';
        }
        if ($eventName === 'updated') {
            return 'User profile updated';
        }
        if ($eventName === 'deleted') {
            return 'User deleted';
        }
        if ($eventName === 'Login') {
            return 'User logged in';
        }
        if ($eventName === 'Logout') {
            return 'User logged out';
        }

        return '';
    }

    public function reporter(){
        return $this->hasOne(Reporter::class);
    }
}
