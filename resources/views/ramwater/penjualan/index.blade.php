@extends('layouts.master')

@section('title')
    Penjualan
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-warning">
                <div class="card-header">
                    <a class="btn btn-success btn-xs" id="add_menu">Tambah Penjualan</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col table-responsive">
                            <table class="table table-striped table-inverse text-center" id="table">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>nik</th>
                                        <th>kd_produk</th>
                                        <th>jumlah</th>
                                        <th>galon_kembali</th>
                                        <th>galon_diluar</th>
                                        <th>total_harga</th>
                                        <th>cash</th>
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
    @include('ramwater.penjualan.form')
    @include('ramwater.penjualan.form-galon')
@endsection

@push('js')
    <script>
        let table;
        let table_galon;
        var url_add = '{{ route('penjualan.store') }}';
        var url_delete = '{{ route('penjualan.destroy', ['penjualan' => ':id']) }}';
        var url_edit = '{{ route('penjualan.update', ['penjualan' => ':id']) }}';
        var url_save_galon = '{{ route('galon.store') }}';
        var url_delete_galon = '{{ route('galon.destroy', ['galon' => ':id']) }}';

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
                    url: '{{ route('penjualan.data') }}',
                },
                "columns": [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    shrotable: false
                }, {
                    data: 'nama_sales'
                }, {
                    data: 'nama_produk'
                }, {
                    data: 'jumlah'
                }, {
                    data: 'galon_kembali'
                }, {
                    data: 'galon_diluar',
                    render: function(data, type, row) {

                        return row.sum_galon;
                    }
                }, {
                    data: 'total_harga'
                }, {
                    data: 'cash'
                }, {
                    data: 'id',
                    render: function(data, type, row) {
                        var display = 'none';
                        if (row.jumlah != row.galon_kembali) {
                            display = 'block';
                        }
                        return `
                            <div class="btn-group">
                                <button class="btn btn-sm btn-warning" style="display:${display}" id="penjualan-galon" data-id='${row.id_penjualan}' data-tgl_penjualan='${row.tgl_penjualan}' data-nik='${row.nik}' data-kd_produk='${row.kd_produk}' data-jumlah='${row.jumlah}' data-galon_kembali='${row.galon_kembali}' data-galon_diluar='${row.galon_diluar}'data-total_harga='${row.total_harga}'data-cash='${row.cash}' > Pinjam</button>
                                <button class="btn btn-sm btn-primary" id="penjualan-edit" data-id='${row.id_penjualan}' data-tgl_penjualan='${row.tgl_penjualan}' data-nik='${row.nik}' data-kd_produk='${row.kd_produk}' data-jumlah='${row.jumlah}' data-galon_kembali='${row.galon_kembali}' data-galon_kembali='${row.galon_kembali}'data-galon_kembali='${row.galon_kembali}'data-galon_kembali='${row.galon_kembali}' data-galon_diluar='${row.galon_diluar}'data-total_harga='${row.total_harga}'data-cash='${row.cash}'> Edit</button>
                                <button class="btn btn-sm btn-danger" id="penjualan-delete" data-id='${row.id_penjualan}' data-tgl_penjualan='${row.tgl_penjualan}' data-nik='${row.nik}' data-kd_produk='${row.kd_produk}' data-jumlah='${row.jumlah}' data-galon_kembali='${row.galon_kembali}' data-galon_kembali='${row.galon_kembali}'data-galon_kembali='${row.galon_kembali}'data-galon_kembali='${row.galon_kembali}' data-galon_diluar='${row.galon_diluar}'data-total_harga='${row.total_harga}'data-cash='${row.cash}'> Delete</button>
                            </div>
                        `;
                    }

                }]
            });
            validate()

            $('body').on('click', '#add_menu', function() {
                $('#modal-form').modal('show');
                $('#modal-form .modal-title').text('Tambah Penjualan');

                $('#modal-form form')[0].reset();
                $('#modal-form form').attr('action', url_add);
                $('#modal-form [name=_method]').val('post');
            }).on('click', '#penjualan-edit', function() {
                var id = $(this).data('id');
                url_edit = url_edit.replace(':id', id);

                console.log();

                $('#modal-form').modal('show');
                $('#modal-form .modal-title').text('Edit Penjualan');

                $('#modal-form form')[0].reset();
                $('#modal-form form').attr('action', url_edit);
                $('#modal-form [name=_method]').val('put');

                $('#modal-form [name=id]').val($(this).data('id'));

                $('#modal-form [name=tgl_penjualan]').val($(this).data('tgl_penjualan'));
                $('#modal-form [name=nik]').val($(this).data('nik'));
                $('#modal-form [name=kd_produk]').val($(this).data('kd_produk'));
                $('#modal-form [name=jumlah]').val($(this).data('jumlah'));
                $('#modal-form [name=galon_kembali]').val($(this).data('galon_kembali'));
                $('#modal-form [name=galon_diluar]').val($(this).data('galon_diluar'));
                $('#modal-form [name=total_harga]').val($(this).data('total_harga'));
                $('#modal-form [name=cash]').val($(this).data('cash'));

            }).on('click', '#penjualan-delete', function() {
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

            }).on('click', '#penjualan-galon', function() {
                var id = $(this).data('id');
                url_edit = url_edit.replace(':id', id);

                $('#modal-galon').modal('show');
                $('#modal-galon form')[0].reset();
                $('#modal-galon .modal-title').text('Peminjam Galon');

                $('#modal-galon [name=_method]').val('post');
                $('#modal-galon [name=id]').val($(this).data('id'));

                table_galon = $("#table_galon").DataTable({
                    "dom": 'Bfrtip',
                    "info": true,
                    "processing": true,
                    "responsive": false,
                    "lengthChange": true,
                    "autoWidth": true,
                    "searching": true,
                    "ordering": true,
                    "bDestroy": true,
                    "buttons": [
                        // "copy",
                        // "csv",
                        // "excel",
                        // "pdf",
                        // "print",
                        // "colvis"
                    ],
                    "ajax": {
                        url: '{{ route('galon.data', ':id') }}'.replace(':id', id),
                    },
                    "columns": [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        shrotable: false
                    }, {
                        data: 'id'
                    }, {
                        data: 'nama'
                    }, {
                        data: 'jumlah'
                    }, {
                        data: 'id',
                        render: function(data, type, row) {
                            return `
                            <div class="btn-group">
                                <button class="btn btn-sm btn-primary" id="galon-edit" data-id='${row.id}'> Edit</button>
                                <button class="btn btn-sm btn-danger" id="galon-delete" data-id='${row.id}'> Delete</button>
                            </div>
                        `;
                        }

                    }]
                });

            }).on('click', '#save_galon', function() {
                $.ajax({
                    type: "POST",
                    url: url_save_galon,
                    data: $('#modal-galon form').serialize(),
                    success: function(result) {
                        if (result.errors) {
                            $('.alert-danger').html('');

                            $.each(result.errors, function(key, value) {
                                $('.alert-danger').show();
                                $('.alert-danger').append('<li>' + value +
                                    '</li>');
                            });
                        } else {
                            $('#modal-galon [name=nama]').val('');
                            $('#modal-galon [name=jumlah]').val('');
                            $("#table_galon").DataTable().ajax.reload()
                            $('#table').DataTable().ajax.reload();
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
            }).on('click', '#galon-edit', function() {
                var id = $(this).data('id');
                url_edit = url_edit.replace(':id', id);

                console.log();

                $('#modal-form').modal('show');
                $('#modal-form .modal-title').text('Edit Penjualan');

                $('#modal-form form')[0].reset();
                $('#modal-form form').attr('action', url_edit);
                $('#modal-form [name=_method]').val('put');

                $('#modal-form [name=id]').val($(this).data('id'));

                $('#modal-form [name=tgl_penjualan]').val($(this).data('tgl_penjualan'));
                $('#modal-form [name=nik]').val($(this).data('nik'));
                $('#modal-form [name=kd_produk]').val($(this).data('kd_produk'));
                $('#modal-form [name=jumlah]').val($(this).data('jumlah'));
                $('#modal-form [name=galon_kembali]').val($(this).data('galon_kembali'));
                $('#modal-form [name=galon_diluar]').val($(this).data('galon_diluar'));
                $('#modal-form [name=total_harga]').val($(this).data('total_harga'));
                $('#modal-form [name=cash]').val($(this).data('cash'));

            }).on('click', '#galon-delete', function(e) {
                console.log('sdfsf');
                var id = $(this).data('id');
                url_delete_galon = url_delete_galon.replace(':id', id);

                if (confirm('Yakin akan menghapus data terpilih?')) {
                    if (!e.preventDefault()) {
                        $.ajax({
                            url: url_delete_galon,
                            type: 'DELETE',
                            data: {
                                _token: $('[name=csrf-token]').attr('content')
                            },
                            success: function(response) {
                                $('#table_galon').DataTable().ajax.reload();
                                $('#table').DataTable().ajax.reload();
                            },
                            error: function(errors) {
                                // alert('Gagal Hapus data!');
                                // return;
                            }
                        });
                    }
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
