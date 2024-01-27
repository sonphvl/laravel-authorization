# About

This package provides a simple implementation for authorization base on Laravel Gate.

## Implementation

### 1. Install the package

This command will install the package:

```bash
composer require sonphvl/authorization
```

This command will publish migrations files and run the migrations:

```bash
php artisan authorization:install
```

### 2. Publish assets (optional)

If you want to publish assets for editing, run the following commands

```bash
php artisan vendor:publish --tag=authorization-middleware
php artisan vendor:publish --tag=authorization-config
```

### 3. Register the Service Provider

Open config/app.php and add your service provider to the providers array.

```bash
'providers' => [
    // Other Package Service Providers...
    Sonphvl\Authorization\AuthorizationServiceProvider::class,

    //Application Service Providers
],
```

### 4. Apply Authorizable trait

Add Authorizable trait to your Authenticatable model such as User model

```bash
namespace App\Models;

// Others imported classes
use Sonphvl\Authorization\Traits\Authorizable; //Add this line

class User extends Authenticatable
{
    use Authorizable; //Add this line

    //Your model content
}
```

### 5. Manage roles and permissions

You can map the roles and permissions at "/authorization":

```bash
route('authorization.index')
```

### 6. Apply

Once you installed the package, a middleware alias named "authorize" is automatically registered.

#### About Authorize Middleware

When you apply the middleware, default permission name used is concatenated with route prefix, lowercase of controller name prefix and action name.
For example, consider the following route:

```bash
Route::prefix('admin')->group(function () {
    Route::get('/users', [UserController::class, 'index']);
});
```

In the example route above, the package will call the following:

```bash
$controller->authorize('admin-user-index');
```

To customize the controller name prefix, add this line to your controller:

```bash
public $authorizePrefix = 'alternative';
```

By this, the package will call the following:

```bash
$controller->authorize('admin-alternative-index');
```

#### Apply to middleware groups

To apply "authorize" middleware to middleware groups, add this to your application .env

```bash
AUTHORIZATION_MIDDLEWARE_GROUPS=web,api
```

When middleware groups are registered, add this to your controller to ignore any function:

```bash
public $ignoredAutoAuthorize = ['index']; //To ignore index function from authorization
```

#### Apply to routes

To apply for a single route

```bash
Route::get('/users', [UserController::class, 'index'])->middleware(['authorize']);
```

To apply for multiple routes

```bash
Route::middleware(['authorize'])->group(function () {
    Route::get('/', function () {
        // Uses first & second middleware...
    });

    Route::get('/user/profile', function () {
        // Uses first & second middleware...
    });
});
```

#### Manually apply to a specific function

To authorize a function, add this line at the top of your controller function:

```bash
class UserController extends Controller
{
    public function index()
    {
        $this->authorize('permission-name'); //Add this line

        //The rest of the function
    }
}
```

## License

This package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
