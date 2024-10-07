<?php
use Modules\Setting\Entities\Application;

if (!function_exists('canAdd')) {
    function canAdd(){
       return Application::count();
    }
}
