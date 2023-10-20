@extends('layouts.master')

@section('title')
    Karyawan
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
                                        <th>nik</th>
                                        <th>nama</th>
                                        <th>alamat</th>
                                        <th>jk</th>
                                        <th>ktp</th>
                                        <th>no_hp</th>
                                        <th>Referensi</th>
                                        <th>username</th>
                                        <th>phone</th>
                                        <th>kd_role</th>
                                        <th>active</th>
                                        <th>email</th>
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
    @include('security.karyawan.form')
    @include('security.karyawan.input-user')
@endsection

@push('js')
    <script>
        let table;
        var url_add = '{{ route('karyawan.store') }}';
        var url_delete = '{{ route('karyawan.destroy', ['karyawan' => ':id']) }}';
        var url_edit = '{{ route('karyawan.update', ['karyawan' => ':id']) }}';

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
                    url: '{{ route('karyawan.data') }}',
                },
                "columns": [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    shrotable: false
                }, {
                    data: 'nik_karyawan'
                }, {
                    data: 'nama'
                }, {
                    data: 'alamat'
                }, {
                    data: 'jk'
                }, {
                    data: 'ktp'
                }, {
                    data: 'no_hp'
                }, {
                    data: 'reference'
                }, {
                    data: 'username'
                }, {
                    data: 'phone'
                }, {
                    data: 'kd_role'
                }, {
                    data: 'active'
                }, {
                    data: 'email'
                }, {
                    data: 'id',
                    render: function(data, type, row) {
                        return `
                            <div class="btn-group">
                                <button class="btn btn-sm btn-warning" id="karyawan-add_user" data-id='${row.id}' data-nik='${row.nik}' data-nama='${row.nama}' data-alamat='${row.alamat}' data-jk='${row.jk}' data-ktp='${row.ktp}' data-no_hp='${row.no_hp}' data-reference='${row.reference}' data-created_at='${row.created_at}' data-updated_at='${row.updated_at}' data-name='${row.name}' data-username='${row.username}' data-phone='${row.phone}' data-pwd='${row.pwd}' data-kd_role='${row.kd_role}' data-active='${row.active}' data-email='${row.email}' data-nik_karyawan='${row.nik_karyawan}' data-id_karyawan='${row.id_karyawan}' data-id_user='${row.id_user}'>User</button>
                                <button class="btn btn-sm btn-primary" id="karyawan-edit" data-id='${row.id}' data-nik='${row.nik}' data-nama='${row.nama}' data-alamat='${row.alamat}' data-jk='${row.jk}' data-ktp='${row.ktp}' data-no_hp='${row.no_hp}' data-reference='${row.reference}' data-created_at='${row.created_at}' data-updated_at='${row.updated_at}' data-name='${row.name}' data-username='${row.username}' data-phone='${row.phone}' data-pwd='${row.pwd}' data-kd_role='${row.kd_role}' data-active='${row.active}' data-email='${row.email}' data-nik_karyawan='${row.nik_karyawan}' data-id_karyawan='${row.id_karyawan}' data-id_user='${row.id_user}'>Edit</button>
                                <button class="btn btn-sm btn-danger" id="karyawan-delete" data-id='${row.id}' data-nik='${row.nik}' data-nama='${row.nama}' data-alamat='${row.alamat}' data-jk='${row.jk}' data-ktp='${row.ktp}' data-no_hp='${row.no_hp}' data-reference='${row.reference}' data-created_at='${row.created_at}' data-updated_at='${row.updated_at}' data-name='${row.name}' data-username='${row.username}' data-phone='${row.phone}' data-pwd='${row.pwd}' data-kd_role='${row.kd_role}' data-active='${row.active}' data-email='${row.email}' data-nik_karyawan='${row.nik_karyawan}' data-id_karyawan='${row.id_karyawan}' data-id_user='${row.id_user}'>Delete</button>
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
            }).on('click', '#karyawan-edit', function() {
                var id = $(this).data('id_karyawan');
                url_edit = url_edit.replace(':id', id);

                console.log();

                $('#modal-form').modal('show');
                $('#modal-form .modal-title').text('Edit Data');

                $('#modal-form form')[0].reset();
                $('#modal-form form').attr('action', url_edit);
                $('#modal-form [name=_method]').val('put');

                $('#modal-form [name=id]').val($(this).data('id_karyawan'));
                $('#modal-form [name=nik]').val($(this).data('nik_karyawan'));
                $('#modal-form [name=nama]').val($(this).data('nama'));
                $('#modal-form [name=alamat]').val($(this).data('alamat'));
                $('#modal-form [name=jk]').val($(this).data('jk'));
                $('#modal-form [name=ktp]').val($(this).data('ktp'));
                $('#modal-form [name=no_hp]').val($(this).data('no_hp'));
                $('#modal-form [name=reference]').val($(this).data('reference'));

            }).on('click', '#karyawan-delete', function() {
                var id = $(this).data('id_karyawan');
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

            }).on('click', '#karyawan-add_user', function() {
                $('#modal-input-user').modal('show');
                $('#modal-input-user .modal-title').text('Tambah Data');

                $('#modal-input-user form')[0].reset();
                $('#modal-input-user form').attr('action', url_add);
                $('#modal-input-user [name=_method]').val('post');
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
