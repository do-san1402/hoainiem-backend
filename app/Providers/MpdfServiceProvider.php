<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Mpdf\Mpdf;

class MpdfServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('mpdf', function ($app) {
            $mpdf = new Mpdf([
                'default_font' => 'Arial',
                'fontDir' => storage_path('app/public/fonts/'),
                'fontdata' => [
                    'Arial' => [
                        'R' => 'arial.ttf',
                        'B' => 'arialbd.ttf',
                    ],
                    'SolaimanLipi' => [
                        'R' => 'solaimanlipi.ttf',
                        'B' => 'solaimanlipi.ttf',
                    ],
                    // Add more font families as needed
                ],
            ]);

            return $mpdf;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
