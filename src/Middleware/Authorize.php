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
            $controllerInstance = app()->make($controller);
            $ignoredFunctions = $controllerInstance->ignoredAutoAuthorize ?? [];
            if (!in_array($method, $ignoredFunctions)) {
                $prefix = strtolower($routeAction['prefix']);
                $controllerName = last(explode("\\", $controller));
                $controllerModel = $controllerInstance->authorizePrefix ?? strtolower(str_replace('Controller', '', $controllerName));
                $permissionName = implode('-', array_filter([$prefix, $controllerModel, $method]));
                $controllerInstance->authorize($permissionName);
            }
        }

        return $next($request);
    }
}
