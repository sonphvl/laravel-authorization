<?php

namespace Sonphvl\Authorization\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authorize
{
    public function handle(Request $request, Closure $next): Response
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
