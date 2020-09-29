<?php

class TaskController extends Controller
{

    function add_task()
    {

        $error_fields = false;
        if (!preg_match('/^[\w\-\s]+$/ui', $_POST['username'])) {
            $error_fields[] = 'username';
        }

        if (!preg_match('/^[\w\d\.\-\+]+@[\w\d\.\-\+]+\.[\w\d\.\-\+]+$/ui', $_POST['mail'])) {
            $error_fields[] = 'mail';
        }

        $text = htmlspecialchars($_POST['text']);
        if (empty($text)) {
            $error_fields[] = 'text';
        }

        if (!empty($error_fields)) {
            $this->error('Ошибка заполнения формы. ' . (!empty($_POST['mail']) && in_array('mail',
                    $error_fields) ? 'E-mail не валиден' : ''), [
                'fields' => $error_fields
            ]);
        }

        $data = [
            'username' => $_POST['username'],
            'mail' => $_POST['mail'],
            'text' => $text,
            'status' => 0
        ];
        $task_model = new Task();
        $data['id'] = $task_model->add($data);

        $this->success('Задача успешно создана', [
            'task' => $data,
            'count' => $task_model->getCount()
        ]);
    }

    function get_list()
    {
        $task_model = new Task();
        $page = $_POST['start'] / $_POST['length'] + 1;
        $page_limit = $_POST['length'];

        $task_quantity = $task_model->getCount();

        $sort_column_id = $_POST['order'][0]['column'];
        $sort_column_direction = $_POST['order'][0]['dir'];
        $sort_column = $_POST['columns'][$sort_column_id]['data'];
        $sort = !empty($sort_column) ? $sort_column . ' ' . $sort_column_direction : false;


        $columns = ['username', 'mail', 'text', 'status', 'edited'];
        if (!empty($this->view['is_admin'])) {
            $columns[] = 'id';
        }
        $tasks = $task_model->get($columns, [], $sort, ($page - 1) * $page_limit, $page_limit, true);

        $this->response([
            'draw' => $_POST['draw'],
            'data' => $tasks,
            'recordsTotal' => $task_quantity,
            'recordsFiltered' => $task_quantity
        ]);
    }

    private function init_task($id)
    {

        if (empty($this->view['is_admin'])) {
            $this->error('У вас недостаточно прав для этого действия.');
        }

        if (empty($id) || !is_numeric($id)) {
            $this->error('Ошибка работы системы. Был передан некорректный параметр.');
        }

        $task = new Task($id);
        if (!$task->exist()) {
            $this->error('Ошибка. Задача не найдена в базе');
        }

        return $task;
    }

    function change_status()
    {

        $task = $this->init_task($_POST['id']);

        if (!empty($task->getProp('status'))) {
            $this->error('Задача уже отмечена завершённой.');
        }

        $task->setProp('status', 1);

        $this->success('Задача отмечена выполненной');
    }

    function get_text()
    {

        $task = $this->init_task($_POST['id']);

        $this->success(false, [
            'text' => htmlspecialchars_decode($task->getProp('text')),
            'id' => $task->getProp('id')
        ]);
    }

    function edit_task_text()
    {

        $task = $this->init_task($_POST['id']);

        $text = htmlspecialchars($_POST['text']);
        if (empty($text)) {
            $error_fields[] = 'text';
        }

        if (!empty($error_fields)) {
            $this->error('Ошибка заполнения формы', [
                'fields' => $error_fields
            ]);
        }

        if ($task->getProp('text') != $text) {
            $task->setProp('text', $text);
            $task->setProp('edited', 1);

            $this->success('Текст задачи успешно изменён.');
        } else {
            $this->success('Текст задачи не изменился.');
        }

    }
}