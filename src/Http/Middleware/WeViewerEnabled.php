<?php

namespace Atifrazzaq\weviewer\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class weviewerEnabled
{
    public function handle(Request $request, Closure $next)
    {
        if (!config('weViewer.enabled', true)) {
            abort(404);
        }
        
        // Ensure session is started
        if (!$request->hasSession()) {
            $request->setLaravelSession(app('session')->driver());
        }
        
        // Start session if not already started
        if (!Session::isStarted()) {
            Session::start();
        }
        
        if (!Session::get('weviewer_authenticated')) {
            return redirect()->route('weviewer.login', ['redirect_url' => $request->fullUrl()]);
        }

        return $next($request);
    }
}