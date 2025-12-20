<?php

namespace Atifrazzaq\WeViewer\Providers;

use Illuminate\Support\ServiceProvider;

class WeViewerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/weViewer.php', 'weviewer');
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'weViewer');
        
        $this->publishes([
            __DIR__.'/../../config/weViewer.php' => config_path('weViewer.php'),
        ], 'config');
        
        $this->app['router']->aliasMiddleware('weviewer.enabled', \Atifrazzaq\WeViewer\Http\Middleware\WeViewerEnabled::class);
        

        
        \Illuminate\Pagination\Paginator::defaultView('pagination::bootstrap-4');
        \Illuminate\Pagination\Paginator::defaultSimpleView('pagination::simple-bootstrap-4');
    }
}