<?php

namespace Modules\Localize\Entities;

use App\Traits\WithCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory, WithCache;

    protected static $cacheKey = '__languages__';

    protected $guarded = [];
}
