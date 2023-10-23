@extends('layouts.master')

@section('title')
    Datang Barang
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-warning">
                <div class="card-header">
                    <a class="btn btn-success btn-xs" id="add_menu">Tambah Barang</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col table-responsive">
                            <table class="table table-striped table-inverse text-center" id="table">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>tgl_datang</th>
                                        <th>nama</th>
                                        <th>kd_produk</th>
                                        <th>jumlah</th>
                                        <th>rb</th>
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
    @include('ramwater.datang_barang.form')
@endsection

@push('js')
    <script>
        let table;
        var url_add = '{{ route('datangbarang.store') }}';
        var url_delete = '{{ route('datangbarang.destroy', ['datangbarang' => ':id']) }}';
        var url_edit = '{{ route('datangbarang.update', ['datangbarang' => ':id']) }}';

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
                    url: '{{ route('datangbarang.data') }}',
                },
                "columns": [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    shrotable: false
                }, {
                    data: 'tgl_datang'
                }, {
                    data: 'nama'
                }, {
                    data: 'nama_produk'
                }, {
                    data: 'jumlah'
                }, {
                    data: 'rb'
                }, {
                    data: 'id',
                    render: function(data, type, row) {
                        return `
                            <div class="btn-group">
                                <button class="btn btn-sm btn-primary" id="datangbarang-edit" data-id='${row.id}' data-tgl_datang='${row.tgl_datang}' data-nama='${row.nama}' data-kd_produk='${row.kd_produk}' data-jumlah='${row.jumlah} 'data-rb='${row.rb}'>Edit</button>
                                <button class="btn btn-sm btn-danger" id="datangbarang-delete" data-id='${row.id}' data-tgl_datang='${row.tgl_datang}' data-nama='${row.nama}' data-kd_produk='${row.kd_produk}' data-jumlah='${row.jumlah} 'data-rb='${row.rb}'>Delete</button>
                            </div>
                        `;
                    }
                }]
            });
            validate()

            $('body').on('click', '#add_menu', function() {
                $('#modal-form').modal('show');
                $('#modal-form .modal-title').text('Tambah Datang');

                $('#modal-form form')[0].reset();
                $('#modal-form form').attr('action', url_add);
                $('#modal-form [name=_method]').val('post');
            }).on('click', '#datangbarang-edit', function() {
                var id = $(this).data('id');
                url_edit = url_edit.replace(':id', id);

                console.log();

                $('#modal-form').modal('show');
                $('#modal-form .modal-title').text('Edit Datang');

                $('#modal-form form')[0].reset();
                $('#modal-form form').attr('action', url_edit);
                $('#modal-form [name=_method]').val('put');

                $('#modal-form [name=id]').val($(this).data('id'));
                $('#modal-form [name=tgl_datang]').val($(this).data('tgl_datang'));
                $('#modal-form [name=nama]').val($(this).data('nama'));
                $('#modal-form [name=kd_produk]').val($(this).data('kd_produk'));
                $('#modal-form [name=jumlah]').val($(this).data('jumlah'));
                $('#modal-form [name=rb]').val($(this).data('rb'));

            }).on('click', '#datangbarang-delete', function() {
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
