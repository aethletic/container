<?php

namespace Aethletic\Container;

class Container
{
    public static $app;
    private static $events = [];

    public function __construct()
    {
        return self::$app = $this;
    }

    public function register($varName, $callback)
    {
        self::$events[$varName] = $callback();
        $this->$varName = $callback();
        return;
    }

    public static function app()
    {
        return self::$app;
    }

    public static function __callStatic($name, $params = null) {
        return self::$app->$name;
    }
}
