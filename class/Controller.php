<?php

class Controller
{

    protected $template;
    protected $view = [];

    function __construct()
    {

        $admin_model = new Admin();
        if (!empty($_COOKIE['admin_login']) && !empty($_COOKIE['admin_password']) && $admin_model->auth($_COOKIE['admin_login'],
                $_COOKIE['admin_password'])) {
            $this->view['is_admin'] = true;
        }


        if (!empty($_POST['action'])) {
            if (method_exists($this, $_POST['action'])) {
                $this->{$_POST['action']}();
            } else {
                throw new Exception('Не найден обработчик для действия ' . $_POST['action']);
            }
        }

    }

    function render()
    {

        extract($this->view, EXTR_SKIP);

        $template = !empty($this->template) ? str_replace('.', DIRECTORY_SEPARATOR, $this->template) : 'layout';

        ob_start();

        $filename = TEMPLATE_DIR . $template . '.php';
        if (file_exists($filename)) {
            include $filename;
        } else {
            throw new Exception('Не найден шаблон ' . $template);
        }

        die(ob_get_clean());
    }

    function error($message, $data = [])
    {
        $this->response([
                'error' => $message
            ] + $data);
    }

    function success($message, $data = [])
    {
        $this->response([
                'success' => $message
            ] + $data);
    }

    function response($data)
    {
        header('Content-Type: application/json');
        die(json_encode($data));
    }
}