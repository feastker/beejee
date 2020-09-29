var App = {
    tasktable: false,
    init: function() {

        this.tasktable = $('#task-table').DataTable({
            pageLength: 3,
            serverSide: true,
            bFilter: false,
            bInfo: false,
            pagingType: 'numbers',
            lengthChange: false,
            order: [],
            ajax:  {
                url: '?route=task',
                type: 'POST',
                data: {
                    action: 'get_list'
                }
            },
            columns: [
                // {data: 'id'},
                {data: 'username'},
                {data: 'mail'},
                {
                    data: 'text',
                    orderable: false,
                    render: function (data,type,row,) {

                        if(row.edited)
                            data += '<small class="text-danger">Отредактировано администратором</small>';

                        if(row.id)
                            data += '<a href="#" data-change-text="' + row.id + '">Изменить</a>';

                        return data;
                    }
                },
                {
                    data: 'status',
                    render: function (data,type,row) {

                        let badge = data == 0 ? '<span class="badge badge-warning">Не выполнена</span>' : '<span class="badge badge-success">Выполнена</span>';

                        if(row.id && data != 1)
                            badge += '<a href="#" data-change-status="' + row.id + '">Отметить</a>';

                        return badge;
                    }
                }
            ]
        } );

        $(document).on('submit','#add-task form',function(){

            App.send_form($(this),function(msg){

                let table = $('#task-table');
                let limit = table.data('limit');

                $('#add-task').modal('hide');

                App.tasktable.row.add(msg.task).draw();

            });

            return false;
        });

        $(document).on('submit','#auth form',function(){

            App.send_form($(this),function(msg){

                location.reload();
            });

            return false;
        });

        $(document).on('submit','#edit-task-text form',function(){

            App.send_form($(this),function(msg){

                $('#edit-task-text').modal('hide');
                App.tasktable.ajax.reload();
            });

            return false;
        });

        $(document).on('click','#exit-btn',function(){
            App.ajax({
                action: 'logout'
            },function(msg) {
                location.reload();
            },'?route=auth');

            return false;
        });

        $(document).on('click','[data-change-status]',function(){

            let $link = $(this);

            App.ajax({
                action: 'change_status',
                id: $(this).data('change-status')
            },function(msg) {
                App.toast(msg);

                if(msg.success) {
                    $link.parent().find('.badge').removeClass('badge-warning').addClass('badge-success').html('Выполнена');
                    $link.remove();
                }
            },'?route=task');

            return false;
        });

        $(document).on('click','[data-change-text]',function(){

            let $link = $(this);

            App.ajax({
                action: 'get_text',
                id: $(this).data('change-text')
            },function(msg) {
                if(msg.error)
                    App.toast(msg);
                else {
                    $window = $('#edit-task-text');
                    $window.find('[name="text"]').val(msg.text);
                    $window.find('[name="id"]').val(msg.id);
                    $window.modal('show');
                }

            },'?route=task');

            return false;
        });

    },
    send_form: function($form,callback = function(){}) {

        let form_data = $form.serializeArray();
        let json_data = {};
        $.map(form_data, function(element){
            json_data[element['name']] = element['value'];
        });

        let action = $form.attr('action');

        $form.find('.is-invalid').removeClass('is-invalid');

        App.ajax(json_data,function(msg){

            if(msg.error) {
                App.toast(msg);

                if(msg.fields) {
                    for(field_name of msg.fields) {
                        let field = $form.find('[name="' + field_name + '"]');
                        if(field.length)
                            field.addClass('is-invalid');
                    }
                }
            }
            else {
                if(msg.success)
                    App.toast(msg);

                $form.trigger("reset");

                callback(msg);
            }

        }, action != undefined ? action : '?');
    },
    ajax: function(data,callback = function(){},url = '?') {

        try {
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: data,
                success: callback
            });
        }
        catch(e) {

        }
    },
    toast: function(message) {
        if(message.success) {
            toastr.success(message.success,'Отлично!',{ positionClass: 'toast-bottom-right', containerId: 'toast-bottom-right' });
        }
        else if(message.error) {
            toastr.error(message.error,'Ошибка!',{ positionClass: 'toast-bottom-right', containerId: 'toast-bottom-right' });
        }
    }
};

App.init();