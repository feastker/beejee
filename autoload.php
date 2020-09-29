<?php
spl_autoload_register(
    function ($class) {

        $folders = ['class','controller','model'];

        foreach ($folders as $folder) {
            $file = DIR . $folder . DIRECTORY_SEPARATOR . $class . '.php';

            if (is_readable($file)) {
                require $file;
                return true;
            }
        }

        return false;
    }
);