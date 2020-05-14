<?php

namespace Aethletic\Container;

class Bootstrap
{
    public static function autoload($filesPathArray)
    {
        foreach ($filesPathArray as $filePath) {
            if (is_dir($filePath)) {
                foreach (glob($filePath) as $file) {
                    require_once $file;
                }
            } else {
                require_once $filePath;
            }
        }
    }
}
