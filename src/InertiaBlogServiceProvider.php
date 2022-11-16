<?php

namespace Xiso\FormHandler;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class InertiaBlogServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->routes();
    }

    public function routes(){
//        Route::group(['prefix' => ''])
    }
}
