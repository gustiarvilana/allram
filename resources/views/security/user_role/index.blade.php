@extends('layouts.master')

@section('title')
    User Role
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-warning">
                <div class="card-header">
                    <a class="btn btn-success btn-xs" id="add_menu">Tambah Data</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col table-responsive">
                            <table class="table table-striped table-inverse text-center" id="table">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>kd_role</th>
                                        <th>ur_role</th>
                                        <th width="15%"><i class="fa fa-cogs" aria-hidden="true"></i></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('security.user_role.form')
    @include('security.user_role.input-user')
@endsection

@push('js')
    <script>
        let table;
        var url_add = '{{ route('user_role.store') }}';
        var url_delete = '{{ route('user_role.destroy', ['user_role' => ':id']) }}';
        var url_update = '{{ route('user_role.update', ['user_role' => ':id']) }}';
        var url_add_user = '{{ route('user.store') }}';

        $(document).ready(function() {
            table = $("#table").DataTable({
                "dom": 'Bfrtip',
                "info": true,
                "processing": true,
                "responsive": false,
                "lengthChange": true,
                "autoWidth": true,
                "searching": true,
                "ordering": true,
                "buttons": [
                    // "copy",
                    // "csv",
                    // "excel",
                    // "pdf",
                    // "print",
                    // "colvis"
                ],
                "ajax": {
                    url: '{{ route('user_role.data') }}',
                },
                "columns": [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    shrotable: false
                }, {
                    data: 'kd_role'
                }, {
                    data: 'ur_role'
                }, {
                    data: 'id',
                    render: function(data, type, row) {
                        return `
                            <div class="btn-group">
                                <button class="btn btn-sm btn-warning" id="user_role-add_user" data-id='${row.id}' data-kd_role='${row.kd_role}' data-ur_role='${row.ur_role}'>Menu</button>
                                <button class="btn btn-sm btn-primary" id="user_role-edit" data-id='${row.id}' data-kd_role='${row.kd_role}' data-ur_role='${row.ur_role}'>Edit</button>
                                <button class="btn btn-sm btn-danger" id="user_role-delete" data-id='${row.id}' data-kd_role='${row.kd_role}' data-ur_role='${row.ur_role}'>Delete</button>
                            </div>
                        `;
                    }
                }]
            });
            validate()

            $('body').on('click', '#add_menu', function() {
                $('#modal-form').modal('show');
                $('#modal-form .modal-title').text('Tambah Data');

                $('#modal-form form')[0].reset();
                $('#modal-form form').attr('action', url_add);
                $('#modal-form [name=_method]').val('post');
            }).on('click', '#user_role-edit', function() {
                var id = $(this).data('id');
                url_update = url_update.replace(':id', id);

                $('#modal-form').modal('show');
                $('#modal-form .modal-title').text('Edit Data');

                $('#modal-form form')[0].reset();
                $('#modal-form form').attr('action', url_update);
                $('#modal-form [name=_method]').val('put');

                $('#modal-form [name=id]').val($(this).data('id'));
                $('#modal-form [name=kd_role]').val($(this).data('kd_role'));
                $('#modal-form [name=ur_role]').val($(this).data('ur_role'));

            }).on('click', '#user_role-delete', function() {
                var id = $(this).data('id');
                url_delete = url_delete.replace(':id', id);

                if (confirm('Yakin akan menghapus data terpilih?')) {
                    $.ajax({
                        url: url_delete,
                        type: 'DELETE',
                        data: {
                            _token: $('[name=csrf-token]').attr('content')
                        },
                        success: function(response) {
                            $('#table').DataTable().ajax.reload();
                        },
                        error: function(errors) {
                            alert('Gagal Hapus data!');
                            return;
                        }
                    });
                }

            }).on('click', '#user_role-add_user', function() {
                $('#modal-input-user').modal('show');
                $('#modal-input-user .modal-title').text('Tambah Data');

                $('#modal-input-user form')[0].reset();
                $('#modal-input-user form').attr('action', url_add_user);
                $('#modal-input-user [name=_method]').val('post');

                $('#modal-input-user [name=id]').val($(this).data('id_user'));
                $('#modal-input-user [name=name]').val($(this).data('name'));
                $('#modal-input-user [name=nik]').val($(this).data('nik_user_role'));
                $('#modal-input-user [name=username]').val($(this).data('username'));
                $('#modal-input-user [name=phone]').val($(this).data('phone'));
                $('#modal-input-user [name=kd_role]').val($(this).data('kd_role'));
                $('#modal-input-user [name=active]').val($(this).data('active'));
                $('#modal-input-user [name=email]').val($(this).data('email'));
                $('#modal-input-user [name=password]').val($(this).data('pwd'));

            });
        });

        function validate() {
            $('#modal-form').on('submit', function(e) {
                if (!e.preventDefault()) {
                    $.ajax({
                        type: "POST",
                        url: $('#modal-form form').attr('action'),
                        data: $('#modal-form form').serialize(),
                        success: function(result) {
                            if (result.errors) {
                                $('.alert-danger').html('');

                                $.each(result.errors, function(key, value) {
                                    $('.alert-danger').show();
                                    $('.alert-danger').append('<li>' + value +
                                        '</li>');
                                });
                            } else {
                                $('#modal-form').modal('hide');
                                $('#table').DataTable().ajax.reload()
                            }
                        },
                        error: function(jqXHR, exception, request, status, error) {
                            var msg = ''
                            if (jqXHR.status === 0) {
                                msg = 'Not connect.\n Verify Network.';
                            } else if (jqXHR.status == 404) {
                                msg = 'Requested page not found. [404]';
                            } else if (jqXHR.status == 422666) {
                                msg = 'The given data was invalid.. [422]';
                            } else if (jqXHR.status == 500) {
                                msg = 'Internal Server Error [500].';
                            } else if (exception === 'parsererror') {
                                msg = 'Requested JSON parse failed.';
                            } else if (exception === 'timeout') {
                                msg = 'Time out error.';
                            } else if (exception === 'abort') {
                                msg = 'Ajax request aborted.';
                            } else {
                                msg = 'Uncaught Error.\n' + jqXHR.responseText;
                            }
                            $('.alert-danger').show();
                            $('.alert-danger').html(msg);
                            setTimeout(() => {
                                $('.alert-danger').hide();
                                $('.alert-danger').html('');
                            }, 5000);
                        },
                    })
                }
            })
        };
    </script>
@endpush
