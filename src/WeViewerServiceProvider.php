<?php

namespace Atifrazzaq\weviewer;

use Illuminate\Support\ServiceProvider;

class WeviewerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/weviewer.php', 'weViewer');
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'weViewer');
        
        $this->publishes([
            __DIR__.'/../config/weviewer.php' => config_path('weViewer.php'),
        ], 'config');
        
        // Auto-publish config if it doesn't exist
        if (!file_exists(config_path('weViewer.php'))) {
            $this->publishes([
                __DIR__.'/../config/weviewer.php' => config_path('weViewer.php'),
            ], 'weviewer-config');
        }
        
        $this->app['router']->aliasMiddleware('weviewer.enabled', \Atifrazzaq\weviewer\Http\Middleware\weviewerEnabled::class);
        
        \Illuminate\Pagination\Paginator::defaultView('pagination::bootstrap-4');
        \Illuminate\Pagination\Paginator::defaultSimpleView('pagination::simple-bootstrap-4');
    }
}