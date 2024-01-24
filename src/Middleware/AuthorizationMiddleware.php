<?php

namespace Sonphvl\Authorization\Middleware;

use Closure;

class AuthorizationMiddleware
{
    public function handle($request, Closure $next)
    {
        // Get the controller and method associated with the current request
        // $routeAction = $request->route()->getAction();

        // Extract the controller and method from the route action
        // list($controller, $method) = explode('@', $routeAction['controller']);
        // dump($routeAction);
        return $next($request);
    }
}
