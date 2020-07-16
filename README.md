# Container 📦
 Simple app container.

## Install
```
composer require aethletic/container
```

## Methods

### set()
Store data:
```php
$app->set(string $name, mixed $callback [, array $params]);
$app->set(string $name, bool $one_time = false, mixed $callback [, array $params = []);
```
Or pass one array of parameters:
```php
$app->set([
 'name' => 'methodName',
 'one_time' => true,
 'callback' => function ($a, $b) {
  return $a + $b;
 },
 'params' => [4, 6]
]);
```
`$callback` - It can be an `anonymous function`/`function`/`class`. It can also be the value of an array `variable`, `string`, `number`, etc.

`$one_time` - If `true`, then callback will be executed one time, else, callback will be executed every time when he called.

### get()
Get instance:
```php
$app->get(string $name [, array $params]);
```

### call()
Call instance:
```php
$app->call(string $name [, array $params]);
```

Or you can call as:
```php
$app->set('methodName', function ($param1, $param2) { 
 // code ...
});
$app->methodName('valueOfParam1', 'valueOfParam2');
```

## Note
You can use static and non-static methods.

```php
use Aethletic\App\Container as App;

require_once './vendor/autoload.php';

$app = new App;
$app->set('hello', 'world');

print_r(App::get('hello')); // world
```

## Examples:
```php 
use Aethletic\App\Container as App;

require_once './vendor/autoload.php';

$app = new App;
$app->set('db', $one_time = true, function() {
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

$app->db()->table('users')->select('id', '1337')->get();
```

```php
use Aethletic\App\Container as App;

require_once './vendor/autoload.php';

$app = new App;
$app->set('twig', $one_time = true, function () {
    $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/app/views');
    return new \Twig\Environment($loader, [
        'cache' => __DIR__ . '/storage/cache/twig',
        'auto_reload' => true,
        'debug' => true,
    ]);
});

echo $app->twig()->render('index.html', ['name' => 'Alex']);
```

```php
use Aethletic\App\Container as App;

require_once './vendor/autoload.php';

$app = new App;
$app->set('redis', $one_time = true, function () {
    $redis = new \Redis;
    $redis->connect('127.0.0.1');
    return $redis;
});

$app->redis()->set('hello', 'world');
```

## Util
Autoload files:
```php
use Aethletic\App\Bootstrap;

require_once './vendor/autoload.php';

Bootstrap::autoload([
  './app/controllers/*.php',
  './app/models/*.php',
  './app/helpers/*.php',
]);
```
