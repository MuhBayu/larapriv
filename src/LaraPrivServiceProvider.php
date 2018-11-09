<?php

namespace MuhBayu\LaraPriv;

use Illuminate\Support\ServiceProvider;

class LaraPrivServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
      $this->mergeConfigFrom(
         __DIR__.'/Config/larapriv.php', 'larapriv'
      );
      $this->loadRoutesFrom(__DIR__.'/routes.php');
      $this->loadMigrationsFrom(__DIR__.'/../migrations');

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
      require_once(__DIR__.'/LaraPriv.php');
    }
}
