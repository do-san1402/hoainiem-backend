<?php

namespace App\Providers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadHelpers();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blueprint::macro('updateCreatedBy', function () {
            $this->foreignId('created_by')->nullable();
            $this->foreignId('updated_by')->nullable();
        });

        Paginator::useBootstrapFive();
        Schema::defaultStringLength(191);

        Blade::include('backend.layouts.forms.form-control-input', 'input');
        Blade::include('backend.layouts.forms.form-control-radio', 'radio');
        Blade::include('backend.layouts.forms.form-control-select', 'select');
        Blade::include('backend.layouts.forms.form-control-textarea', 'textarea');
        Blade::include('backend.layouts.forms.image-with-preview', 'imageWithPreview');
        Blade::include('backend.layouts.forms.image-with-preview', 'imageWithPreview2');

    }

    protected function loadHelpers()
    {
        foreach (glob(__DIR__ . '/../Helpers/*.php') as $filename) {
            require_once $filename;
        }
    }
}
