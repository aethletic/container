# Container 📦
 Simple container.

## Install
```
composer require aethletic/container
```

## Example
As non-static:
```php
use Aethletic\Container\Container;

$app = new Container();

$app->register('route', function() {
    return new \Bramus\Router\Router();
});

$app->route->get('/', function () {
    echo 'ok!';
});
```

As static:
```php
use Aethletic\Container\Container as App;

App::register('route', function() {
    return new \Bramus\Router\Router();
});

App::route()->get('/', function () {
    echo 'ok!';
});
```

Autoload files:
```php
use Aethletic\Container\Bootstrap;

Bootstrap::autoload([
    __DIR__ . '/app/controllers/*.php',
    __DIR__ . '/app/models/*.php',
    __DIR__ . '/app/helpers/*.php',
]);
```

Other examples:
```php 
$app->register('db', function() {
    $factory = new \Database\Connectors\ConnectionFactory();
    return $factory->make(array(
        'driver'    => 'mysql',
        'host'      => 'localhost',
        'username'  => 'root',
        'password'  => 'password',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'lazy'      => true,
    ));
});
```

```php
$app->register('twig', function() {
    $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/app/views');
    return new \Twig\Environment($loader, [
        'cache' => __DIR__ . '/storage/cache/twig',
        'auto_reload' => true,
        'debug' => true,
    ]);
});
```
