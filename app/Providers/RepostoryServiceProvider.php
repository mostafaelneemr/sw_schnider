<?php

namespace App\Providers;

use App\Modules\Repositories\AdvRepostory;
use App\Modules\Interfaces\AdvRepostoryInterface;
use Illuminate\Support\ServiceProvider;

class RepostoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            AdvRepostoryInterface::class,
            AdvRepostory::class
        );
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
