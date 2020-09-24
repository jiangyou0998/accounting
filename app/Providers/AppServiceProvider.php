<?php

namespace App\Providers;

use App\Models\Menu;
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
        if (config('app.debug')) {
            $this->app->register('VIACreative\SudoSu\ServiceProvider');
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //導航欄傳遞數據
        view()->composer('layouts._nav', function ($view) {
            $menus = Menu::with('allChildrenMenu')->get();
            $view->with('menus', $menus);
        });
    }
}
