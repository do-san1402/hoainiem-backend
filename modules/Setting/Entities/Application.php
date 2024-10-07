<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Picture;
use Modules\Setting\Entities\Currency;
use Modules\Setting\Entities\Language;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Application extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'currency_id',
        'currency_title',
        'title',
        'phone',
        'email',
        'logo',
        'favicon',
        'sidebar_logo',
        'sidebar_collapsed_logo',
        'login_image',
        'address',
        'website',
        'prefix',
        'tax_no',
        'fixed_date',
        'rtl_ltr',
        'language_id',
        'footer_text',
        'negative_amount_symbol',
        'floating_number',
        'status',
        'state_income_tax',
        'soc_sec_npf_tax',
        'employer_contribution',
        'icf_amount',
        'footer_logo',
        'app_logo',
        'mobile_menu_image',
        'time_zone',
        'copy_right',
        'newstriker_status',
        'preloader_status',
        'speed_optimization'
    ];
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('Setting (Application)')
            ->setDescriptionForEvent(fn(string $eventName) => "Application {$eventName}")
            ->logAll();
    }
    public function picture(){
        return $this->morphOne(Picture::class, 'imageable');
    }

    public function currency(){
        return $this->belongsTo(Currency::class);
    }

    public function language(){
        return $this->belongsTo(Language::class);
    }

}
