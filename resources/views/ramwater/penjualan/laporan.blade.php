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
                            <table class="table table-striped table-bordered table-inverse text-center" id="perProduk">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Nama Sales</th>
                                        <th>Nama Produk</th>
                                        <th>jumlah </th>
                                        <th>Total </th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col table-responsive">
                            <table class="table table-striped table-bordered table-inverse text-center" id="table">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th rowspan="2"
                                            style="vertical-align: middle !important; text-align:center; font-size:12pt;">
                                            No</th>
                                        <th rowspan="2"
                                            style="vertical-align: middle !important; text-align:center; font-size:12pt;">
                                            Nama Sales</th>
                                        <th rowspan="2"
                                            style="vertical-align: middle !important; text-align:center; font-size:12pt;">
                                            jumlah Global</th>
                                        <th rowspan="2"
                                            style="vertical-align: middle !important; text-align:center; font-size:12pt;">
                                            Total Global</th>
                                        <th colspan="2"
                                            style="vertical-align: middle !important; text-align:center; font-size:12pt;">
                                            Hutang</th>
                                        <th rowspan="2"
                                            style="vertical-align: middle !important; text-align:center; font-size:12pt;">
                                            Kasbon Sales</th>
                                        <th rowspan="2"
                                            style="vertical-align: middle !important; text-align:center; font-size:12pt;">
                                            Cash</th>
                                        <th width="15%" rowspan="2"
                                            style="vertical-align: middle !important; text-align:center; font-size:12pt;">
                                            <i class="fa fa-cogs" aria-hidden="true"></i>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Uang Masuk</th>
                                        <th>Pending</th>
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
        @include('ramwater.penjualan.form-hutang')
        @include('ramwater.kasbon.form')
    @endsection

    @push('js')
        <script>
            var url_add = '{{ route('datangbarang.store') }}';
            var url_delete = '{{ route('datangbarang.destroy', ['datangbarang' => ':id']) }}';
            var url_edit = '{{ route('datangbarang.update', ['datangbarang' => ':id']) }}';
            let tanggal = $('#daterange').val();
            var url_save_hutang = '{{ route('hutang.store') }}';
            var url_delete_hutang = '{{ route('hutang.destroy', ['hutang' => ':id']) }}';
            var url_add_kasbon = '{{ route('kasbon.store') }}';
            var url_delete_kasbon = '{{ route('kasbon.destroy', ['kasbon' => ':id']) }}';
            var url_edit_kasbon = '{{ route('kasbon.update', ['kasbon' => ':id']) }}';

            $(document).ready(function() {
                var perProduk = $("#perProduk").DataTable({
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
                        url: '{{ route('penjualan.laporan.perProduk') }}',
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
                        data: 'nama_produk'
                    }, {
                        data: 'sum_jumlah'
                    }, {
                        data: 'sum_total'
                    }],
                    columnDefs: [{
                        targets: 3,
                        className: 'dt-body-right',
                        render: $.fn.dataTable.render.number('.', '.', 0, '')
                    }, {
                        targets: 4,
                        className: 'dt-body-right',
                        render: $.fn.dataTable.render.number('.', '.', 0, '')
                    }],
                });

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
                        },
                        {
                            data: 'nama_sales'
                        },
                        {
                            data: 'sum_jumlah'
                        },
                        {
                            data: 'sum_total'
                        },
                        {
                            data: 'uang_masuk',
                            render: function(data, type, row) {
                                return '<a id="uang-masuk" data-sales=' + row.nama_sales +
                                    ' data-tgl_penjualan=' + row.tgl_penjualan + ' data-nik=' + row
                                    .nik + '>' + row.bayar_total + '</a>';
                            }
                        },
                        {
                            data: 't_transfer',
                            render: function(data, type, row) {
                                return '<a id="pending" data-sales=' + row.nama_sales +
                                    ' data-tgl_penjualan=' + row.tgl_penjualan + ' data-nik=' + row
                                    .nik + '>' + row.hutang_total + '</a>';
                            }
                        },
                        {
                            data: 'kasbon_sales',
                            render: function(data, type, row) {
                                return formatRupiah(row.kasbon_sales);
                            }
                        },
                        {
                            data: 'cash',
                            render: function(data, type, row) {
                                return formatRupiah(row.cash - row.kasbon_sales);
                            }
                        },
                        {
                            data: 'id',
                            render: function(data, type, row) {
                                var display = 'none';
                                if (row.jumlah != row.galon_kembali) {
                                    display = 'block';
                                }
                                return `
                                    <div class="btn-group">
                                        <button class="btn btn-m btn-warning" id="kasbon-add" data-id='${row.id_penjualan}' data-sisa='${row.sisa}' data-terjual='${row.sum_jumlah}' data-tgl_penjualan='${row.tgl_penjualan}' data-nik='${row.nik}' data-kd_produk='${row.kd_produk}'  data-nama_produk='${row.nama_produk}' data-nama_sales='${row.nama_sales}' data-jumlah='${row.jumlah}' data-galon_kembali='${row.galon_kembali}' data-galon_diluar='${row.galon_diluar}'data-total_harga='${row.total_harga}'data-cash='${row.cash}' > Kasbon Sales</button>
                                        <a class="btn btn-m btn-success" style="display: block" id="penjualan-detail" > Simpan</a>
                                    </div>
                                `;
                                // <button class="btn btn-m btn-warning" id="penjualan-hutang" data-id='${row.id_penjualan}' data-sisa='${row.sisa}' data-terjual='${row.sum_jumlah}' data-tgl_penjualan='${row.tgl_penjualan}' data-nik='${row.nik}' data-kd_produk='${row.kd_produk}'  data-nama_produk='${row.nama_produk}' data-nama_sales='${row.nama_sales}' data-jumlah='${row.jumlah}' data-galon_kembali='${row.galon_kembali}' data-galon_diluar='${row.galon_diluar}'data-total_harga='${row.total_harga}'data-cash='${row.cash}' > Hutang</button>
                            }

                        }
                    ],
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
                    }, {
                        targets: 7,
                        className: 'dt-body-right',
                        render: $.fn.dataTable.render.number('.', '.', 0, '')
                    }, ],
                });

                validate()

                $('#daterange').on('change', function() {
                    tanggal = $('#daterange').val();
                    table.ajax.reload();
                    perProduk.ajax.reload();
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

                }).on('click', '#uang-masuk', function() {
                    var sales = $(this).data('sales');
                    $('#modal-hutang').modal('show');
                    $('#modal-hutang form')[0].reset();
                    $('#modal-hutang .modal-title').text('Uang Masuk');

                    $('#modal-hutang #form_hutang').hide();

                    console.log($(this).data('tgl_penjualan'));
                    console.log($(this).data('nik'));

                    $("#table_hutang").DataTable({
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
                            url: '{{ route('hutang.data') }}',
                            data: {
                                nik: $(this).data('nik'),
                                tanggal: $(this).data('tgl_penjualan'),
                            }
                        },
                        "columns": [{
                                data: 'DT_RowIndex',
                                searchable: false,
                                shrotable: false
                            },
                            {
                                data: 'tanggal'
                            },
                            {
                                data: 'nik'
                            },
                            {
                                data: 'nama'
                            },
                            {
                                data: 'alamat'
                            },
                            {
                                data: 'hp'
                            },
                            {
                                data: 'jumlah'
                            },
                            {
                                data: 'bayar'
                            },
                            {
                                data: 'id',
                                render: function(data, type, row) {
                                    return `
                            <div class="btn-group">
                                <a class="btn btn-sm btn-primary" id="hutang-edit" data-id='${row.id}' data-id_parent='${row.id_parent}' data-nama='${row.nama}' data-alamat='${row.alamat}' data-hp='${row.hp}' data-jumlah='${row.jumlah}' data-bayar='${row.bayar}' data-tanggal='${row.tanggal}'> Edit</a>
                                <a class="btn btn-sm btn-success" id="hutang-bayar" data-id='${row.id}' data-id_parent='${row.id_parent}' data-nama='${row.nama}' data-alamat='${row.alamat}' data-hp='${row.hp}' data-jumlah='${row.jumlah}' data-bayar='${row.bayar}' data-tanggal='${row.tanggal}'> Bayar</a>
                                <a class="btn btn-sm btn-danger" id="hutang-delete" data-id='${row.id}' data-id_parent='${row.id_parent}' data-nama='${row.nama}' data-alamat='${row.alamat}' data-hp='${row.hp}' data-jumlah='${row.jumlah}' data-bayar='${row.bayar}' data-tanggal='${row.tanggal}'> Delete</a>
                            </div>
                        `;
                                }

                            }
                        ],
                        "columnDefs": [{
                                targets: 5,
                                className: 'dt-body-right',
                                render: $.fn.dataTable.render.number('.', '.', 0, '')
                            },
                            {
                                targets: 6,
                                className: 'dt-body-right',
                                render: $.fn.dataTable.render.number('.', '.', 0, '')
                            },
                            {
                                targets: 7,
                                className: 'dt-body-right',
                                render: $.fn.dataTable.render.number('.', '.', 0, '')
                            },
                        ],
                    });

                }).on('click', '#pending', function() {
                    var sales = $(this).data('sales');
                    $('#modal-hutang').modal('show');
                    $('#modal-hutang form')[0].reset();
                    $('#modal-hutang .modal-title').text('Uang Masuk');

                    $('#modal-hutang #form_hutang').hide();

                    $("#table_hutang").DataTable({
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
                            url: '{{ route('hutang.data') }}',
                            data: {
                                nik: $(this).data('nik'),
                                tanggal: $(this).data('tgl_penjualan'),
                            }
                        },
                        "columns": [{
                                data: 'DT_RowIndex',
                                searchable: false,
                                shrotable: false
                            },
                            {
                                data: 'tanggal'
                            },
                            {
                                data: 'nik'
                            },
                            {
                                data: 'nama'
                            },
                            {
                                data: 'alamat'
                            },
                            {
                                data: 'hp'
                            },
                            {
                                data: 'jumlah'
                            },
                            {
                                data: 'bayar'
                            },
                            {
                                data: 'id',
                                render: function(data, type, row) {
                                    return `
                            <div class="btn-group">
                                <a class="btn btn-sm btn-primary" id="hutang-edit" data-id='${row.id}' data-id_parent='${row.id_parent}' data-nama='${row.nama}' data-alamat='${row.alamat}' data-hp='${row.hp}' data-jumlah='${row.jumlah}' data-bayar='${row.bayar}' data-tanggal='${row.tanggal}'> Edit</a>
                                <a class="btn btn-sm btn-success" id="hutang-bayar" data-id='${row.id}' data-id_parent='${row.id_parent}' data-nama='${row.nama}' data-alamat='${row.alamat}' data-hp='${row.hp}' data-jumlah='${row.jumlah}' data-bayar='${row.bayar}' data-tanggal='${row.tanggal}'> Bayar</a>
                                <a class="btn btn-sm btn-danger" id="hutang-delete" data-id='${row.id}' data-id_parent='${row.id_parent}' data-nama='${row.nama}' data-alamat='${row.alamat}' data-hp='${row.hp}' data-jumlah='${row.jumlah}' data-bayar='${row.bayar}' data-tanggal='${row.tanggal}'> Delete</a>
                            </div>
                        `;
                                }

                            }
                        ],
                        "columnDefs": [{
                                targets: 5,
                                className: 'dt-body-right',
                                render: $.fn.dataTable.render.number('.', '.', 0, '')
                            },
                            {
                                targets: 6,
                                className: 'dt-body-right',
                                render: $.fn.dataTable.render.number('.', '.', 0, '')
                            },
                            {
                                targets: 7,
                                className: 'dt-body-right',
                                render: $.fn.dataTable.render.number('.', '.', 0, '')
                            },
                        ],
                    });

                }).on('click', '#penjualan-hutang', function() {
                    $('#modal-hutang').modal('show');
                    $('#modal-hutang form')[0].reset();
                    $('#modal-hutang .modal-title').text('Input Hutang');

                    $('#modal-hutang [name=_method]').val('post');
                    $('#modal-hutang [name=nik]').val($(this).data('nik'));
                    $('#modal-hutang [name=tanggal]').val($(this).data('tgl_penjualan'));
                    $('#modal-hutang #alamat').show()
                    $('#modal-hutang #hp').show()

                    $("#table_hutang").DataTable({
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
                            url: '{{ route('hutang.data') }}',
                        },
                        "columns": [{
                                data: 'DT_RowIndex',
                                searchable: false,
                                shrotable: false
                            },
                            {
                                data: 'tanggal'
                            },
                            {
                                data: 'nik'
                            },
                            {
                                data: 'nama'
                            },
                            {
                                data: 'alamat'
                            },
                            {
                                data: 'hp'
                            },
                            {
                                data: 'jumlah'
                            },
                            {
                                data: 'bayar'
                            },
                            {
                                data: 'id',
                                render: function(data, type, row) {
                                    return `
                            <div class="btn-group">
                                <a class="btn btn-sm btn-primary" id="hutang-edit" data-id='${row.id}' data-id_parent='${row.id_parent}' data-nama='${row.nama}' data-alamat='${row.alamat}' data-hp='${row.hp}' data-jumlah='${row.jumlah}' data-bayar='${row.bayar}' data-tanggal='${row.tanggal}'> Edit</a>
                                <a class="btn btn-sm btn-success" id="hutang-bayar" data-id='${row.id}' data-id_parent='${row.id_parent}' data-nama='${row.nama}' data-alamat='${row.alamat}' data-hp='${row.hp}' data-jumlah='${row.jumlah}' data-bayar='${row.bayar}' data-tanggal='${row.tanggal}'> Bayar</a>
                                <a class="btn btn-sm btn-danger" id="hutang-delete" data-id='${row.id}' data-id_parent='${row.id_parent}' data-nama='${row.nama}' data-alamat='${row.alamat}' data-hp='${row.hp}' data-jumlah='${row.jumlah}' data-bayar='${row.bayar}' data-tanggal='${row.tanggal}'> Delete</a>
                            </div>
                        `;
                                }

                            }
                        ],
                        "columnDefs": [{
                                targets: 5,
                                className: 'dt-body-right',
                                render: $.fn.dataTable.render.number('.', '.', 0, '')
                            },
                            {
                                targets: 6,
                                className: 'dt-body-right',
                                render: $.fn.dataTable.render.number('.', '.', 0, '')
                            },
                            {
                                targets: 7,
                                className: 'dt-body-right',
                                render: $.fn.dataTable.render.number('.', '.', 0, '')
                            },
                        ],
                    });

                }).on('click', '#save_hutang', function() {
                    $.ajax({
                        type: "POST",
                        url: url_save_hutang,
                        data: $('#modal-hutang form').serialize(),
                        success: function(result) {
                            if (result.errors) {
                                $('.alert-danger').html('');

                                $.each(result.errors, function(key, value) {
                                    $('.alert-danger').show();
                                    $('.alert-danger').append('<li>' + value +
                                        '</li>');
                                });
                            } else {
                                $('#modal-hutang form')[0].reset();
                                $("#table_hutang").DataTable().ajax.reload()
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
                }).on('click', '#hutang-delete', function(e) {
                    var id = $(this).data('id');
                    url_delete_hutang = url_delete_hutang.replace(':id', id);

                    if (confirm('Yakin akan menghapus data terpilih?')) {
                        if (!e.preventDefault()) {
                            $.ajax({
                                url: url_delete_hutang,
                                type: 'DELETE',
                                responsive: true,
                                processing: true,
                                serverSide: true,
                                data: {
                                    _token: $('[name=csrf-token]').attr('content')
                                },
                                success: function(response) {
                                    $('#table_hutang').DataTable().ajax.reload();
                                    $('#table').DataTable().ajax.reload();
                                },
                                error: function(errors) {
                                    alert('Gagal Hapus data!');
                                    return;
                                }
                            });
                        }
                    }

                }).on('click', '#hutang-bayar', function() {
                    var nik = $('#modal-hutang [name=nik]').val();
                    $('#modal-hutang form')[0].reset();
                    $('#modal-hutang [name=nik]').val(nik);
                    $('#modal-hutang [name=tanggal]').val($(this).data('tanggal'))
                    $('#modal-hutang [name=id_parent]').val($(this).data('id_parent'))
                    $('#modal-hutang [name=nama]').val($(this).data('nama'))
                    $('#modal-hutang [name=alamat]').val($(this).data('alamat'))
                    $('#modal-hutang [name=hp]').val($(this).data('hp'))
                    $('#modal-hutang #jumlah').val($(this).data('jumlah'))
                    $('#modal-hutang [name=bayar]').val('')

                    $('#modal-hutang #bayar').show()
                }).on('click', '#hutang-edit', function() {
                    var nik = $('#modal-hutang [name=nik]').val();
                    $('#modal-hutang form')[0].reset();
                    $('#modal-hutang [name=nik]').val(nik);
                    $('#modal-hutang [name=tanggal]').val($(this).data('tanggal'))
                    $('#modal-hutang [name=id]').val($(this).data('id'))
                    $('#modal-hutang [name=id_parent]').val($(this).data('id_parent'))
                    $('#modal-hutang [name=nama]').val($(this).data('nama'))
                    $('#modal-hutang [name=alamat]').val($(this).data('alamat'))
                    $('#modal-hutang [name=hp]').val($(this).data('hp'))
                    $('#modal-hutang #jumlah').val($(this).data('jumlah'))
                    $('#modal-hutang [name=bayar]').val($(this).data('bayar'))

                    $('#modal-hutang #jumlah').show()
                }).on('click', '#kasbon-add', function() {
                    $('#modal-kasbon').modal('show');
                    $('#modal-kasbon .modal-title').text('Tambah Datang');

                    $('#modal-kasbon form')[0].reset();
                    $('#modal-kasbon [name=nik]').val($(this).data('nik'));
                    $('#modal-kasbon form').attr('action', url_add_kasbon);
                    $('#modal-kasbon [name=_method]').val('post');
                }).on('click', '#kasbon-edit', function() {
                    var id = $(this).data('id');
                    url_edit_kasbon = url_edit_kasbon.replace(':id', id);
                    var tanggal = $(this).attr('data-tanggal').toString();
                    var tgl = tanggal.replace(/(\d{4})(\d{2})(\d{2})/, "$1-$2-$3");

                    $('#modal-kasbon').modal('show');
                    $('#modal-kasbon .modal-title').text('Edit Datang');

                    $('#modal-kasbon form')[0].reset();
                    $('#modal-kasbon form').attr('action', url_edit_kasbon);
                    $('#modal-kasbon [name=_method]').val('put');

                    $('#modal-kasbon [name=id]').val($(this).data('id'));
                    $('#modal-kasbon [name=tanggal]').val(tgl);
                    $('#modal-kasbon [name=satker]').val($(this).data('satker'));
                    $('#modal-kasbon [name=nik]').val($(this).data('nik'));
                    $('#modal-kasbon [name=jumlah]').val($(this).data('jumlah'));
                    $('#modal-kasbon [name=bayar]').val($(this).data('bayar'));
                    $('#modal-kasbon [name=catatan]').val($(this).data('catatan'));

                }).on('click', '#kasbon-delete', function() {
                    var id = $(this).data('id');
                    url_delete_kasbon = url_delete.replace(':id', id);
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
                $('#modal-kasbon').on('submit', function(e) {
                    if (!e.preventDefault()) {
                        $.ajax({
                            type: "POST",
                            url: $('#modal-kasbon form').attr('action'),
                            data: $('#modal-kasbon form').serialize(),
                            success: function(result) {
                                if (result.errors) {
                                    $('.alert-danger').html('');

                                    $.each(result.errors, function(key, value) {
                                        $('.alert-danger').show();
                                        $('.alert-danger').append('<li>' + value +
                                            '</li>');
                                    });
                                } else {
                                    $('#modal-kasbon').modal('hide');
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
