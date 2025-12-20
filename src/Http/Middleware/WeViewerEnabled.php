<?php

namespace Atifrazzaq\WeViewer\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class WeViewerEnabled
{
    public function handle(Request $request, Closure $next)
    {
        if (!config('weviewer.enabled', true)) {
            abort(404);
        }
        
        
         if (!Cookie::get('weviewer_authenticated')) {
             return redirect()->route('weviewer.login', ['redirect_url' => $request->fullUrl()]);
         }

        return $next($request);
    }
}