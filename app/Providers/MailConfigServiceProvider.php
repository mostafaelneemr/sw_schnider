<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        $settings = array_column( Setting::get( ['name', 'value'] )->toArray(), 'value', 'name' );
        config()->set( 'mail', array_merge( config( 'mail' ), [
            'port' => !empty( $settings['MAIL_PORT'] ) ? $settings['MAIL_PORT'] : '587',
            'username' => !empty( $settings['MAIL_USERNAME'] ) ? $settings['MAIL_USERNAME'] : env( 'MAIL_USERNAME' ),
            'password' => !empty( $settings['MAIL_PASSWORD'] ) ? $settings['MAIL_PASSWORD'] : env( 'MAIL_PASSWORD' ),
            'host' => !empty( $settings['MAIL_HOST'] ) ? $settings['MAIL_HOST'] : 'mail.atech-automation.com',
            'driver' => !empty( $settings['MAIL_DRIVER'] ) ? $settings['MAIL_DRIVER'] : 'smtp',
            'from' => [
                'address' => !empty( $settings['MAIL_FROM_ADDRESS'] ) ? $settings['MAIL_FROM_ADDRESS'] : 'hello@example.com',
                'name' => !empty( $settings['MAIL_FROM_NAME'] ) ? $settings['MAIL_FROM_NAME'] : 'Mailer',
            ]
        ] ) );
       (new \Illuminate\Mail\MailServiceProvider(app()))->register();
      
//        \Illuminate\Support\Facades\Artisan::call( 'config:clear' );
    // \Illuminate\Support\Facades\Artisan::call( 'config:cache' );
//  dd( config()->get( 'mail'));
    }
}
