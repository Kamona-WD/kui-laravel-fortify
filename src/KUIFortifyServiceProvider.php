<?php

namespace KUIFortify;

use Illuminate\Support\ServiceProvider;
use KUIFortify\Console\InstallCommand;

class KUIFortifyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->commands([
            InstallCommand::class
        ]);
    }

    public function register()
    {
        //
    }
}
