<?php

namespace App\Providers;

use App\Models\Option;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

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
        $this->bootViews();
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

    /**
     * Sharing Data With All Views
     */
    public function bootViews()
    {
        View::composer('*', function ($view) {
            // Share logo url to all views
            $logo = Option::where('name', 'logo')->first('value');
            $logo = $logo->value ?? null;
            $view->with('logo', $logo);
        });
    }
}
