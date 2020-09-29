<div class="modal fade" id="edit-task-text">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="?route=task">
                <div class="modal-header">
                    <h5 class="modal-title">Редактирвоание задачи</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>
                            Текст задачи
                            <textarea name="text" class="form-control"></textarea>
                        </label>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>

                    <input type="hidden" name="action" value="edit_task_text">
                    <input type="hidden" name="id" value="0">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>