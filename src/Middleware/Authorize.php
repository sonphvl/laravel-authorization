<?php

namespace Sonphvl\Authorization\Middleware;

use Closure;

class Authorize
{
    public function handle($request, Closure $next)
    {
        $route = $request->route();

        if ($route) {
            // Get the controller and method associated with the current request
            $routeAction = $route->getAction();

            // Extract the controller and method from the route action
            list($controller, $method) = explode('@', $routeAction['controller']);

            dd($controller);
        }
        dump($route);
        return $next($request);
    }
}
