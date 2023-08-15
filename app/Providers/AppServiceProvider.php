<?php

namespace App\Providers;

use App\Auth\ApiAuth;
use App\Auth\DBSessionAuth;
use App\Models\Sensor;
use App\Models\Setting;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;
use Tenancy\Identification\Contracts\ResolvesTenants;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->resolving( ResolvesTenants::class, function (ResolvesTenants $resolver) {
            $resolver->addModel( Staff::class );

            return $resolver;
        } );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        if(env('REDIRECT_HTTPS')) {
            $this->app['request']->server->set( 'HTTPS', true );
        }

        set_time_limit( 0 );
        Schema::defaultStringLength( 191 );

        // DBSessionAuth Auth Provider
        Auth::extend( 'DBSessionAuth', function ($app, $name, array $config) {
            $providerData = config( 'auth.providers.' . $config['provider'] );
            return new DBSessionAuth( $providerData['model'], $name );
        } );

        Auth::extend( 'ApiAuth', function ($app, $name, array $config) {
            $providerData = config( 'auth.providers.' . $config['provider'] );
            return new ApiAuth( $providerData['model'], $name );
        } );

  
    }
}
