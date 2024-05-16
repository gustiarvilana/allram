@extends('layouts.master')

@section('title')
    User Menu
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-warning">
                <div class="card-header">
                    <a class="btn btn-success btn-xs" id="add_menu">Tambah Menu</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col table-responsive">
                            <table class="table table-striped table-inverse text-center" id="table">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>kd_menu</th>
                                        <th>kd_parent</th>
                                        <th>type</th>
                                        <th>ur_menu_title</th>
                                        <th>ur_menu_desc</th>
                                        <th>link_menu</th>
                                        <th>bg_color</th>
                                        <th>icon</th>
                                        <th>order</th>
                                        <th>is_active</th>
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
    @include('security.user_menu.form')
@endsection

@push('js')
    <script>
        let table;
        var url_add = '{{ route('user_menu.store') }}';
        var url_delete = '{{ route('user_menu.destroy', ['user_menu' => ':id']) }}';
        var url_edit = '{{ route('user_menu.update', ['user_menu' => ':id']) }}';

        $(document).ready(function() {
            table = $("#table").DataTable({
                "dom": 'Bfrtip',
                "info": true,
                "processing": true,
                "responsive": false,
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
                    url: '{{ route('user_menu.data') }}',
                },
                "columns": [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    shrotable: false
                }, {
                    data: 'kd_menu'
                }, {
                    data: 'kd_parent'
                }, {
                    data: 'type'
                }, {
                    data: 'ur_menu_title'
                }, {
                    data: 'ur_menu_desc'
                }, {
                    data: 'link_menu'
                }, {
                    data: 'bg_color'
                }, {
                    data: 'icon'
                }, {
                    data: 'order'
                }, {
                    data: 'is_active'
                }, {
                    data: 'id',
                    render: function(data, type, row) {
                        return `
                            <div class="btn-group">
                                <button class="btn btn-sm btn-primary" id="user_menu-edit" data-id='${row.id}' data-kd_menu='${row.kd_menu}' data-kd_parent='${row.kd_parent}' data-type='${row.type}' data-ur_menu_title='${row.ur_menu_title}' data-ur_menu_desc='${row.ur_menu_desc}' data-link_menu='${row.link_menu}' data-bg_color='${row.bg_color}' data-icon='${row.icon}' data-order='${row.order}' data-is_active='${row.is_active}'>Edit</button>
                                <button class="btn btn-sm btn-danger" id="user_menu-delete" data-id='${row.id}' data-kd_menu='${row.kd_menu}' data-kd_parent='${row.kd_parent}' data-type='${row.type}' data-ur_menu_title='${row.ur_menu_title}' data-ur_menu_desc='${row.ur_menu_desc}' data-link_menu='${row.link_menu}' data-bg_color='${row.bg_color}' data-icon='${row.icon}' data-order='${row.order}' data-is_active='${row.is_active}'>Delete</button>
                            </div>
                        `;
                    }
                }]
            });
            validate()

            $('body').on('click', '#add_menu', function() {
                $('#modal-form').modal('show');
                $('#modal-form .modal-title').text('Tambah Menu');

                $('#modal-form form')[0].reset();
                $('#modal-form form').attr('action', url_add);
                $('#modal-form [name=_method]').val('post');
            }).on('click', '#user_menu-edit', function() {
                var id = $(this).data('id');
                url_edit = url_edit.replace(':id', id);

                console.log();

                $('#modal-form').modal('show');
                $('#modal-form .modal-title').text('Edit Menu');

                $('#modal-form form')[0].reset();
                $('#modal-form form').attr('action', url_edit);
                $('#modal-form [name=_method]').val('put');

                $('#modal-form [name=id]').val($(this).data('id'));
                $('#modal-form [name=kd_menu]').val($(this).data('kd_menu'));
                $('#modal-form [name=kd_parent]').val($(this).data('kd_parent'));
                $('#modal-form [name=type]').val($(this).data('type'));
                $('#modal-form [name=ur_menu_title]').val($(this).data('ur_menu_title'));
                $('#modal-form [name=ur_menu_desc]').val($(this).data('ur_menu_desc'));
                $('#modal-form [name=link_menu]').val($(this).data('link_menu'));
                $('#modal-form [name=bg_color]').val($(this).data('bg_color'));
                $('#modal-form [name=icon]').val($(this).data('icon'));
                $('#modal-form [name=order]').val($(this).data('order'));
                $('#modal-form [name=is_active]').val($(this).data('is_active'));

            }).on('click', '#user_menu-delete', function() {
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
