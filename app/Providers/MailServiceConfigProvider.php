<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class MailServiceConfigProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        if (\Schema::hasTable('email_configs')) {
            $mail = DB::table('email_configs')->first();
            if ($mail) 
            {
                $config = array(
                    'driver'     => $mail->protocol,
                    'host'       => $mail->smtp_host,
                    'port'       => $mail->smtp_port,
                    'from'       => array('address' => env('MAIL_FROM_ADDRESS', 'hello@hello.com'), 'name' => env('MAIL_FROM_NAME', 'testApp')),
                    'encryption' => env('MAIL_ENCRYPTION', 'tls'),
                    'username'   => $mail->smtp_user,
                    'password'   => $mail->smtp_pass,
                    'sendmail'   => '/usr/sbin/sendmail -bs',
                    'pretend'    => false,
                );
                Config::set('mail', $config);
            }
        }
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
