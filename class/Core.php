<?php

class Core
{

    static function init()
    {

        try {

            DB::connect();

            define('TEMPLATE_DIR', DIR . 'view' . DIRECTORY_SEPARATOR);

            $route = !empty($_GET['route']) ? $_GET['route'] : 'main';

            $controller_name = ucfirst($route) . 'Controller';
            if (class_exists($controller_name)) {
                $controller = new $controller_name();
            } else {
                throw new Exception('Контроллер ' . $controller_name . ' не найден');
            }


            $controller->render();


        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}