$(document).ready(function () {

    $('#addButton').click(function (e) {
        $('#newName').val('');
        $('#newBody').val('');
    })

    $('#ajax-add').click(function (e) {
        e.preventDefault();
        $.ajax({
            url: "/lists",
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                title: $('#newName').val(),
                body: $('#newBody').val(),
            },
            success: function (data) {
                $('#addModal').modal('hide');
                $('#mytable').load('/lists #mytable');
            }
        });
    });

    $(document).on('click', '#ajax-edit', function (e) {
        let url = '/lists/' + $('#edit-identifier').attr('value');
        e.preventDefault();
        $.ajax({
            url: url,
            method: 'PUT',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                title: $('#editName').val(),
                body: $('#editBody').val()
            },
            success: function (result) {
                $('#editModal').modal('hide');
                $('#mytable').load('/lists #mytable');
            }
        });
    });

    $(document).on('click', '.btn', function () {
        if (this.id === 'view' + this.value) {
            let url = 'lists/' + this.value;
            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    let title = data['title'];
                    let body = data['body'];
                    $('#taskName').text(title);
                    $('#taskBody').text(body);
                }
            });
        }
    });

    $(document).on('click', '.btn', function () {
        if (this.id === 'edit' + this.value) {
            let url = 'lists/' + this.value + '/edit';
            let id = this.value;
            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    let title = data['title'];
                    let body = data['body'];
                    $('#editName').attr('value', title);
                    $('#editBody').val(body);
                    $('#edit-identifier').attr('value', id);
                }
            });
        }

    });

    $(document).on('click', '.btn', function () {
        if (this.id === 'delete' + this.value) {
            let url = 'lists/' + this.value;
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _method: 'delete',
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    $('#mytable').load('/lists #mytable');
                }
            });
        }
    });
});
