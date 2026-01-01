<?php

namespace Atifrazzaq\weviewer;

use Illuminate\Support\ServiceProvider;

class weviewerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/weviewer.php', 'weviewer');
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'weviewer');
        
        $this->publishes([
            __DIR__.'/../config/weviewer.php' => config_path('weviewer.php'),
        ], 'config');
        
        $this->app['router']->aliasMiddleware('weviewer.enabled', \Atifrazzaq\weviewer\Http\Middleware\weviewerEnabled::class);
        
        \Illuminate\Pagination\Paginator::defaultView('pagination::bootstrap-4');
        \Illuminate\Pagination\Paginator::defaultSimpleView('pagination::simple-bootstrap-4');
    }
}