<?php

namespace Purpozed2;

class Autoload {

    public function __construct() {
        set_include_path(plugin_dir_path(__FILE__));
        spl_autoload_extensions('.php');
        spl_autoload_register(__CLASS__ . '::autoload');
    }

    public static function autoload($class) {
        if(strpos($class, __NAMESPACE__ . '\\') === 0) {
            include_once(WP_PLUGIN_DIR . '/' . str_replace('\\', '/', strtolower($class))  . '.php');
        }
    }
}

new \Purpozed2\Autoload;