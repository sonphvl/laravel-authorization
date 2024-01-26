# About

This package provides a simple implementation for authorization base on Laravel Gate.

## Implementation

1; Install the package
This command will install the package and publish migrations.

```bash
composer require sonphvl/authorization:dev-main
```

If the migrations are not published, please run the following commands

```bash
php artisan vendor:publish --tag=authorization-migrations
php artisan migrate
```

2; Register the Service Provider
Open config/app.php and add your service provider to the providers array.

```bash
'providers' => [
    // Other Package Service Providers...
    Sonphvl\Authorization\AuthorizationServiceProvider::class,

    //Application Service Providers
],
```

3; Apply Authorizable trait
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

4; Apply the authorization to your functions
Apply the authorization to any functions you want to be authorized

```bash
class UserController extends Controller
{
    /**
     * Show all application users.
     */
    public function index(): View
    {
        $this->authorize('index-users'); //Add this line

        return view('user.index', [
            'users' => DB::table('users')->paginate(15)
        ]);
    }
}
```

5; Setting roles and permissions
You can map the roles and permissions at "/authorization":

```bash
route('authorization.index')
```

## License

This package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
