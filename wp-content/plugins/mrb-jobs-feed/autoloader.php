<?php

namespace MrB;

/**
 * Autoloads Plugin classes using WordPress convention.
 *
 * @author Carl Alexander
 */
class Autoloader
{
    public function __construct()
    {
        spl_autoload_register(array($this, 'autoload'));
    }

    public function autoload($classname)
    {
         // project-specific namespace prefix
        $prefix = __NAMESPACE__.'\\';

        // base directory for the namespace prefix
        $base_dir = __DIR__.'/';

        // Ignore classes that don't use the prefix
        $len = strlen($prefix);
        if (strncmp($prefix, $classname, $len) !== 0) {
            return;
        }

        // get the relative class name
        $relative_class = substr($classname, $len);
        $relative_class = str_replace('_', '-', strtolower($relative_class));

        // replace the namespace prefix with the base directory, replace namespace
        // separators with directory separators in the relative class name, append
        // with .php
        $file = $base_dir.str_replace('\\', DIRECTORY_SEPARATOR, $relative_class).'.php';

        // if the file exists, require it
        if (file_exists($file)) {
            require $file;
        } else if (strpos($classname, 'MrB\App') !== false) {
            $tail = str_replace(['MrB\App\\', '\\'], ['', '/'], $classname);
            $file = str_replace(strtolower($tail), $tail, $file);

            if (file_exists($file)) {
                require $file;
            }
        }
    }
}

new Autoloader();
