<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Kalnoy\Nestedset\NestedSet;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Schema::macro('nestedSet', function () {
            NestedSet::columns($this);
        });

        \Illuminate\Support\Facades\App::setLocale('en');
    }
}
