<!DOCTYPE>
<html lang="ru">
<head>
    <title>BeeJee task tracker</title>

    <meta charset="utf-8">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
    <link rel="stylesheet" href="public/js/toast/toastr.css">
    <link rel="stylesheet" href="public/js/toast/toastr.style.css">

    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
<div class="container">
    <div id="wrapper">

        <div class="header">
            <div class="d-flex justify-content-between align-items-center">

                <div class="d-flex align-items-center">
                    <img src="public/img/logo.png" class="logo mr-2">
                    <button class="btn btn-success" data-toggle="modal" data-target="#add-task">
                        Добавить задачу
                    </button>
                </div>

                <? if($is_admin): ?>
                    <button class="btn btn-danger" id="exit-btn">
                        Выход
                    </button>
                <? else: ?>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#auth">
                        Авторизация
                    </button>
                <? endif; ?>
            </div>
        </div>

        <div class="body">
            <table id="task-table" class="table table-striped" data-limit="<?=$page_limit?>">
                <thead>
                <tr>
                    <th data-sort="username">Имя пользователя</th>
                    <th>E-mail</th>
                    <th>Текст задачи</th>
                    <th>Статус</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

        </div>

        <? include 'modal' . DIRECTORY_SEPARATOR . 'auth.php'; ?>
        <? include 'modal' . DIRECTORY_SEPARATOR . 'add_task.php'; ?>
        <? include 'modal' . DIRECTORY_SEPARATOR . 'edit_task_text.php'; ?>
    </div>

</div>



<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script src="public/js/toast/toastr.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
<script src="public/js/app.js"></script>

</body>
</html>