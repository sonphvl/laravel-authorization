<?php

namespace Sonphvl\Authorization;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use Sonphvl\Authorization\Models\Permission;

class AuthorizationServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Your package registration logic here
    }

    public function boot()
    {
        //Declare authorization middleware
        $router = $this->app['router'];
        $router->aliasMiddleware('authorization', Middleware\AuthorizationMiddleware::class);

        // Publish migrations
        $this->publishes([
            __DIR__ . '/database/migrations' => database_path('migrations'),
        ], 'authorization-migrations');

        // Load migrations from the package
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        // Load models from the package
        $this->loadModelsFrom(__DIR__ . '/Models');

        // Load routes from the package
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        // Load views from the package
        $this->loadViewsFrom(__DIR__ . '/views', 'authorization');

        // Register middleware as global middleware
        // $kernel = $this->app->make(Kernel::class);
        // $kernel->pushMiddleware(Middleware\AuthorizationMiddleware::class);

        // Your package boot logic here
        if (!$this->app->runningInConsole() || $this->app->runningUnitTests()) {
            $argv = Request::server('argv', null);
            if (!$argv || !($argv[0] == 'artisan' && Str::contains($argv[1], 'migrate'))) {
                $allPermissions = Permission::all();
                foreach ($allPermissions as $permission) {
                    if ($permission instanceof Permission) {
                        Gate::define($permission->name, function (User $user, Model $model = null) use ($permission) {
                            return $user->hasPermission($permission->name)
                                ? Response::allow()
                                : Response::deny(__('permission.unauthorized', ['permission' => $permission->display_name]));
                        });
                    }
                }
            }
        }
    }

    public function loadModelsFrom($path)
    {
        foreach (glob($path . '/*.php') as $modelFile) {
            $modelClass = 'Sonphvl\\Authorization\\Models\\' . basename($modelFile, '.php');

            if (class_exists($modelClass)) {
                $this->app->bind($modelClass, $modelClass);
            }
        }
    }
}
