<?php

namespace Aethletic\App;

class Container
{
    public static $app;
    private static $is_init = false;

    public function __construct()
    {
        self::$is_init = true;
        return self::$app = $this;
    }

    public static function set($method, $call = null, $callback = null, $params = [])
    {
        self::isInit();

        if (func_num_args() == 1 && is_array($method)) {
            $array = $method;
            $method = $array['name'] ?? $array['method'];
            $call = $array['one_time'] ?? false;
            $callback = $array['callback'];
            $params = $array['params'];
            self::$app->$method = $call ? call_user_func_array($callback, $params) : $callback;
            return;
        }

        if (func_num_args() == 2 && !is_callable($callback)) {
            $callback = $call;
            $call = false;
        }

        if (func_num_args() == 3 && !is_callable($callback)) {
            $params = $callback;
            $callback = $call;
            $call = false;
        }

        self::$app->$method = $call ? call_user_func_array($callback, $params) : $callback;
    }

    public static function get($method, $params = [])
    {
        return sizeof($params) > 0 ? call_user_func_array(self::$app->$method, $params) : self::$app->$method;
    }

    public static function call($method, $params = [])
    {
        return call_user_func_array(self::$app->$method, $params);
    }

    public function __call($method, $args)
    {
        self::isInit();

        if (isset($this->$method)) {
            $func = $this->$method;
            return is_callable($func) ? call_user_func_array($func, $args) : $func;
        }
    }

    public static function __callStatic($method, $args)
    {
        self::isInit();

        if (isset(self::$app->$method)) {
            $func = self::$app->$method;
            return is_callable($func)  ? call_user_func_array($func, $args) : $func;
        }
    }

    private static function isInit()
    {
        if (!self::$is_init) {
            new self;
        }
    }
}
