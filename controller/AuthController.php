<?php

class AuthController extends Controller
{

    private $salt = 'pos7Rt_e';

    function hash($string)
    {
        return md5($this->salt . $string);
    }

    function auth()
    {
        $error_fields = false;
        if (!preg_match('/^[\w\-\s]+$/ui', $_POST['login'])) {
            $error_fields[] = 'login';
        }

        if (empty($_POST['password'])) {
            $error_fields[] = 'password';
        }

        if (!empty($error_fields)) {
            $this->error('Ошибка заполнения формы', [
                'fields' => $error_fields
            ]);
        }

        $password = $this->hash($_POST['password']);

        $admin = new Admin();
        if (!$admin->auth($_POST['login'], $password)) {
            $this->error('Неправильные реквизиты входа');
        }

        setcookie('admin_login', $_POST['login']);
        setcookie('admin_password', $password);

        $this->success('Вы успешно авторизовались. Через несколько секунд страница обновится до интерфейса администратора.');
    }

    function logout()
    {
        setcookie('admin_login', '');
        setcookie('admin_password', '');
        $this->success('Вы успешно вышли. Через мгновение интерфейс будет обновлен.');
    }
}