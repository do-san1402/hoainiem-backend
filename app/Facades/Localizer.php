<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Localizer extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Actions\Localizer::class;
    }
}
