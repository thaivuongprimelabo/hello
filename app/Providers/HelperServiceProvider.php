<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use File;

class HelperServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        foreach (File::allFiles(app_path() . '/Http/Helpers/') as $partial) {
            require_once $partial->getPathname();
        }
    }

}
