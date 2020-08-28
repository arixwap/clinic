<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        $this->bootLocalizeRoute();
    }

    /**
     * Localizing Language Route Resource URL
     */
    public function bootLocalizeRoute()
    {
        Route::resourceVerbs([
            'create' => __('create'),
            'edit' => __('edit')
        ]);
    }
}
