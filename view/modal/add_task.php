<div class="modal fade" id="add-task">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="?route=task">
                <div class="modal-header">
                    <h5 class="modal-title">Создание задачи</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                        <div class="form-group">
                            <label>
                                Имя пользователя
                                <input type="text" name="username" class="form-control">
                            </label>
                        </div>

                        <div class="form-group">
                            <label>
                                E-mail
                                <input type="text" name="mail" class="form-control">
                            </label>
                        </div>

                        <div class="form-group">
                            <label>
                                Текст задачи
                                <textarea name="text" class="form-control"></textarea>
                            </label>
                        </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>

                    <input type="hidden" name="action" value="add_task">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>