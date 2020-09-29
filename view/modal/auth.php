<div class="modal fade" id="auth">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="?route=auth">
                <div class="modal-header">
                    <h5 class="modal-title">Авторизация</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                        <div class="form-group">
                            <label>
                                Логин
                                <input type="text" name="login" class="form-control">
                            </label>
                        </div>

                        <div class="form-group">
                            <label>
                                Пароль
                                <input type="password" name="password" class="form-control">
                            </label>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>

                    <input type="hidden" name="action" value="auth">
                    <button type="submit" class="btn btn-primary">Войти</button>
                </div>
            </form>
        </div>
    </div>
</div>