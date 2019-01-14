# LaraPriv

Simple Privileges Roles for Laravel

## Installation
This package can be used in Laravel 5.7 or higher.

You can install the package via composer:

``` bash
composer require muhbayu/larapriv
```

In Laravel 5.5 or higher the service provider will automatically get registered. In older versions of the framework just add the service provider in `config/app.php` file:

```php
'providers' => [
    // ...
	MuhBayu\LaraPriv\LaraPrivServiceProvider::class,
];
```

You can publish Provider:
``` bash
php artisan vendor:publish --provider="MuhBayu\LaraPriv\LaraPrivServiceProvider"
```

After the migration has been published you can create the privilege role- and permission-tables by running the migrations:

``` bash
php artisan migrate
```

Then, in `app/Http/Kernel.php`, register the middlewares:
```php
protected $routeMiddleware = [
    // ...
	'privileges.roles' => \MuhBayu\LaraPriv\Middleware\RolesPermission::class,
];
```

## Documentation
**_Coming soon_**
