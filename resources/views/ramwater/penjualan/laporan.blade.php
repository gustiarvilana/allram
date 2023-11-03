@extends('layouts.master')

@section('title')
    Laporan Penjualan
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-success">
                <div class="card-header">
                    {{-- <a class="btn btn-success btn-xs" id="add_menu">Tambah Barang</a> --}}
                </div>
                <div class="card-body">
                    <div class="row mb-2 justify-content-center">
                        <div class="col-md-4 text-center">
                            <!-- Date range -->
                            <div class="form-group">
                                <label>Date range:</label>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control float-right" id="daterange">
                                </div>
                                <!-- /.input group -->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col table-responsive">
                            <table class="table table-striped table-inverse text-center" id="table">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Sales</th>
                                        <th>jumlah Global</th>
                                        <th>Total Global</th>
                                        <th>Cash</th>
                                        <th>Transfer</th>
                                        <th>Selisih</th>
                                        <th>Stor</th>
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
        @include('ramwater.datang_barang.form')
    @endsection

    @push('js')
        <script>
            var url_add = '{{ route('datangbarang.store') }}';
            var url_delete = '{{ route('datangbarang.destroy', ['datangbarang' => ':id']) }}';
            var url_edit = '{{ route('datangbarang.update', ['datangbarang' => ':id']) }}';
            let tanggal = $('#daterange').val();

            $(document).ready(function() {
                var table = $("#table").DataTable({
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
                        "excel",
                        // "pdf",
                        // "print",
                        // "colvis"
                    ],
                    "ajax": {
                        url: '{{ route('penjualan.laporan.data') }}',
                        data: function(d) {
                            d.tanggal = tanggal;
                        }
                    },
                    "columns": [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        shrotable: false
                    }, {
                        data: 'nama_sales'
                    }, {
                        data: 'sum_jumlah'
                    }, {
                        data: 'sum_total'
                    }, {
                        data: 't_cash'
                    }, {
                        data: 't_transfer'
                    }, {
                        data: 't_selisih',
                        render: function(data, type, row) {
                            return formatRupiah(row.sum_total - row.t_cash);
                        }
                    }, {
                        data: 'id',
                        render: function(data, type, row) {
                            return `
                            <form action="" method="post">
                                <div class="form-group">
                                <input type="text"
                                    class="form-control money" name="cash" id="cash" placeholder="Cash Sales">
                                </div>
                            </form>
                            `;
                        }

                    }, {
                        data: 'id',
                        render: function(data, type, row) {
                            var display = 'none';
                            if (row.jumlah != row.galon_kembali) {
                                display = 'block';
                            }
                            return `
                        <div class="btn-group">
                            <button class="btn btn-m btn-info" style="display: block" id="penjualan-detail" data-id='${row.id_penjualan}'  data-terjual='${row.sum_jumlah}' data-tgl_penjualan='${row.tgl_penjualan}' data-nik='${row.nik}' data-kd_produk='${row.kd_produk}'  data-nama_produk='${row.nama_produk}' data-nama_sales='${row.nama_sales}' data-jumlah='${row.jumlah}' data-galon_kembali='${row.galon_kembali}' data-galon_diluar='${row.galon_diluar}'data-total_harga='${row.total_harga}'data-cash='${row.cash}' > Simpan</button>
                        </div>
                    `;
                        }

                    }],
                    columnDefs: [{
                        targets: 3,
                        className: 'dt-body-right',
                        render: $.fn.dataTable.render.number('.', '.', 0, '')
                    }, {
                        targets: 4,
                        className: 'dt-body-right',
                        render: $.fn.dataTable.render.number('.', '.', 0, '')
                    }, {
                        targets: 5,
                        className: 'dt-body-right',
                        render: $.fn.dataTable.render.number('.', '.', 0, '')
                    }, {
                        targets: 6,
                        className: 'dt-body-right',
                        render: $.fn.dataTable.render.number('.', '.', 0, '')
                    }, ],
                });

                validate()

                $('#daterange').on('change', function() {
                    tanggal = $('#daterange').val();
                    table.ajax.reload();
                })

                $('body').on('click', '#add_menu', function() {
                    $('#modal-form').modal('show');
                    $('#modal-form .modal-title').text('Tambah Datang');

                    $('#modal-form form')[0].reset();
                    $('#modal-form form').attr('action', url_add);
                    $('#modal-form [name=_method]').val('post');
                }).on('click', '#datangbarang-edit', function() {
                    var id = $(this).data('id');
                    url_edit = url_edit.replace(':id', id);
                    var tgl_datang = $(this).attr('data-tgl_datang').toString();
                    var tgl = tgl_datang.replace(/(\d{4})(\d{2})(\d{2})/, "$1-$2-$3");
                    console.log(tgl);


                    $('#modal-form').modal('show');
                    $('#modal-form .modal-title').text('Edit Datang');

                    $('#modal-form form')[0].reset();
                    $('#modal-form form').attr('action', url_edit);
                    $('#modal-form [name=_method]').val('put');

                    $('#modal-form [name=id]').val($(this).data('id'));
                    $('#modal-form [name=tgl_datang]').val(tgl);
                    $('#modal-form [name=nama]').val($(this).data('nama'));
                    $('#modal-form [name=kd_produk]').val($(this).data('kd_produk'));
                    $('#modal-form [name=jumlah]').val($(this).data('jumlah'));
                    $('#modal-form [name=rb]').val($(this).data('rb'));
                    $('#modal-form [name=harga]').val($(this).data('harga'));

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
