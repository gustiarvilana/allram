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
                    <div class="row justify-content-center">
                        <div class="col-md-4 text-center">
                            <div class="form-group">
                                <label for="">Tanggal Penjualan</label>
                            </div>
                            <input type="date" name="tanggal" id="tanggal" class="form-control"
                                value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col text-center table-responsive">
                            <table class="table table-striped table-bordered table-inverse text-center" id="table">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Tanggal</th>
                                        <th>Sales</th>
                                        <th>kd_produk</th>
                                        <th>jumlah Bawa</th>
                                        <th>sisa</th>
                                        <th>galon_kembali</th>
                                        <th>total_terjual</th>
                                        <th>total_harga</th>
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
    @include('ramwater.penjualan.form-detail')
    @include('ramwater.penjualan.form-hutang')
@endsection

@push('js')
    <script>
        var tanggal = $('#tanggal').val();
        var url_add = '{{ route('penjualan.store') }}';
        var url_delete = '{{ route('penjualan.destroy', ['penjualan' => ':id']) }}';
        var url_edit = '{{ route('penjualan.update', ['penjualan' => ':id']) }}';
        var url_save_galon = '{{ route('galon.store') }}';
        var url_delete_galon = '{{ route('galon.destroy', ['galon' => ':id']) }}';
        var url_save_detail = '{{ route('penjualandetail.store') }}';
        var url_delete_penjualandetail = '{{ route('penjualandetail.destroy', ['penjualandetail' => ':id']) }}';
        var url_save_hutang = '{{ route('hutang.store') }}';
        var url_delete_hutang = '{{ route('hutang.destroy', ['hutang' => ':id']) }}';

        $(document).ready(function() {
            $("#table").DataTable({
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
                    data: function(d) {
                        d.tanggal = tanggal;
                    }
                },
                "columns": [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    shrotable: false
                }, {
                    data: 'tgl_penjualan',
                    "render": function(data, type, full, meta) {
                        // Mengonversi format tanggal
                        if (type === 'display' || type === 'filter') {
                            var year = data.slice(0, 4);
                            var month = data.slice(4, 6);
                            var day = data.slice(6, 8);
                            return year + '-' + month + '-' + day;
                        }
                        return data;
                    }
                }, {
                    data: 'nama_sales'
                }, {
                    data: 'nama_produk'
                }, {
                    data: 'jumlah'
                }, {
                    data: 'sisa',
                    render: function(data, type, row) {
                        return row.sisa;
                    }
                }, {
                    data: 'galon_kembali'
                }, {
                    data: 'sum_jumlah',
                    render: function(data, type, row) {

                        return row.sum_jumlah;
                    }
                }, {
                    data: 'sum_detail',
                    render: function(data, type, row) {
                        return formatRupiah(row.sum_detail);
                    }
                }, {
                    data: 'id',
                    render: function(data, type, row) {
                        return `
                        <div class="btn-group">
                            <button class="btn btn-m btn-info" style="display: block" id="penjualan-detail" data-id='${row.id_penjualan}' data-sisa='${row.sisa}' data-terjual='${row.sum_jumlah}' data-tgl_penjualan='${row.tgl_penjualan}' data-nik='${row.nik}' data-kd_produk='${row.kd_produk}'  data-nama_produk='${row.nama_produk}' data-nama_sales='${row.nama_sales}' data-jumlah='${row.jumlah}' data-galon_kembali='${row.galon_kembali}' data-galon_diluar='${row.galon_diluar}'data-total_harga='${row.total_harga}'data-cash='${row.cash}' > Detail</button>
                            <button class="btn btn-m btn-warning" id="penjualan-galon" data-id='${row.id_penjualan}' data-sisa='${row.sisa}' data-terjual='${row.sum_jumlah}' data-tgl_penjualan='${row.tgl_penjualan}' data-nik='${row.nik}' data-kd_produk='${row.kd_produk}'  data-nama_produk='${row.nama_produk}' data-nama_sales='${row.nama_sales}' data-jumlah='${row.jumlah}' data-galon_kembali='${row.galon_kembali}' data-galon_diluar='${row.galon_diluar}'data-total_harga='${row.total_harga}'data-cash='${row.cash}' > Galon</button>
                            <button class="btn btn-m btn-warning" id="penjualan-hutang" data-id='${row.id_penjualan}' data-sisa='${row.sisa}' data-terjual='${row.sum_jumlah}' data-tgl_penjualan='${row.tgl_penjualan}' data-nik='${row.nik}' data-kd_produk='${row.kd_produk}'  data-nama_produk='${row.nama_produk}' data-nama_sales='${row.nama_sales}' data-jumlah='${row.jumlah}' data-galon_kembali='${row.galon_kembali}' data-galon_diluar='${row.galon_diluar}'data-total_harga='${row.total_harga}'data-cash='${row.cash}' > Hutang</button>
                            <button class="btn btn-m btn-primary" id="penjualan-edit" data-id='${row.id_penjualan}' data-sisa='${row.sisa}' data-terjual='${row.sum_jumlah}' data-tgl_penjualan='${row.tgl_penjualan}' data-nik='${row.nik}' data-kd_produk='${row.kd_produk}'  data-nama_produk='${row.nama_produk}' data-nama_sales='${row.nama_sales}' data-jumlah='${row.jumlah}' data-galon_kembali='${row.galon_kembali}' data-galon_kembali='${row.galon_kembali}'data-galon_kembali='${row.galon_kembali}'data-galon_kembali='${row.galon_kembali}' data-galon_diluar='${row.galon_diluar}'data-total_harga='${row.total_harga}'data-cash='${row.cash}'> Edit</button>
                            <button class="btn btn-m btn-danger" id="penjualan-delete" data-id='${row.id_penjualan}' data-sisa='${row.sisa}' data-terjual='${row.sum_jumlah}' data-tgl_penjualan='${row.tgl_penjualan}' data-nik='${row.nik}' data-kd_produk='${row.kd_produk}'  data-nama_produk='${row.nama_produk}' data-nama_sales='${row.nama_sales}' data-jumlah='${row.jumlah}' data-galon_kembali='${row.galon_kembali}' data-galon_kembali='${row.galon_kembali}'data-galon_kembali='${row.galon_kembali}'data-galon_kembali='${row.galon_kembali}' data-galon_diluar='${row.galon_diluar}'data-total_harga='${row.total_harga}'data-cash='${row.cash}'> Delete</button>
                        </div>
                    `;
                    }

                }],
                "columnDefs": [{
                        targets: 7,
                        className: 'dt-body-right',
                        render: $.fn.dataTable.render.number('.', '.', 0, '')
                    },
                    {
                        targets: 8,
                        className: 'dt-body-right',
                        render: $.fn.dataTable.render.number('.', '.', 0, '')
                    },
                ],
            });
            validate()

            $('#tanggal').on('change', function() {
                tanggal = $('#tanggal').val();
                $('#table').DataTable().ajax.reload();
            })

            $('#modal-detail [name=sisa]').on('change', function() {
                // val($(this).data('jumlah'))
                var jumlah = $('#modal-detail [name=jumlah]').val();
                var sisa = $('#modal-detail [name=sisa]').val();

                $('#modal-detail [name=jumlah]').val(jumlah - sisa);
            });

            $('body').on('click', '#add_menu', function() {
                $('#modal-form #cash').hide()
                $('#modal-form #transfer').hide()
                $('#modal-form').modal('show');
                $('#modal-form .modal-title').text('Tambah Penjualan');

                $('#modal-form form')[0].reset();
                $('#modal-form form').attr('action', url_add);
                $('#modal-form [name=_method]').val('post');
            }).on('click', '#penjualan-edit', function() {
                var id = $(this).data('id');
                url_edit = url_edit.replace(':id', id);

                $('#modal-form').modal('show');
                $('#modal-form .modal-title').text('Edit Penjualan');

                $('#modal-form form')[0].reset();
                $('#modal-form form').attr('action', url_edit);
                $('#modal-form [name=_method]').val('put');

                $('#modal-form [name=id]').val($(this).data('id'));
                $('#modal-form #cash').show()
                $('#modal-form #transfer').show()

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
                            $('#table').DataTable().ajax.reload();
                            return;
                        }
                    });
                }

            }).on('click', '#penjualan-galon', function() {
                $('#modal-galon').modal('show');
                $('#modal-galon form')[0].reset();
                $('#modal-galon .modal-title').text('Peminjam Galon');

                $('#modal-galon [name=_method]').val('post');
                $('#modal-galon [name=nik]').val($(this).data('nik'));
                $('#modal-galon [name=tanggal]').val($(this).data('tgl_penjualan'));
                $('#modal-galon #alamat').show()
                $('#modal-galon #hp').show()

                $("#table_galon").DataTable({
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
                        url: '{{ route('galon.data') }}',
                    },
                    "columns": [{
                            data: 'DT_RowIndex',
                            searchable: false,
                            shrotable: false
                        }, {
                            data: 'tanggal',
                            "render": function(data, type, full, meta) {
                                // Mengonversi format tanggal
                                if (data != null) {
                                    if (type === 'display' || type === 'filter') {
                                        var dateString = data.toString();
                                        var year = dateString.slice(0, 4);
                                        var month = dateString.slice(4, 6);
                                        var day = dateString.slice(6, 8);
                                        return year + '-' + month + '-' + day;
                                    }
                                }
                                return data;
                            }
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
                                <a class="btn btn-sm btn-primary" id="galon-edit" data-id='${row.id}' data-id_parent='${row.id_parent}' data-nama='${row.nama}' data-alamat='${row.alamat}' data-hp='${row.hp}' data-jumlah='${row.jumlah}' data-bayar='${row.bayar}' data-tanggal='${row.tanggal}'> Edit</a>
                                <a class="btn btn-sm btn-success" id="galon-bayar" data-id='${row.id}' data-id_parent='${row.id_parent}' data-nama='${row.nama}' data-alamat='${row.alamat}' data-hp='${row.hp}' data-jumlah='${row.jumlah}' data-bayar='${row.bayar}' data-tanggal='${row.tanggal}'> Bayar</a>
                                <a class="btn btn-sm btn-danger" id="galon-delete" data-id='${row.id}' data-id_parent='${row.id_parent}' data-nama='${row.nama}' data-alamat='${row.alamat}' data-hp='${row.hp}' data-jumlah='${row.jumlah}' data-bayar='${row.bayar}' data-tanggal='${row.tanggal}'> Delete</a>
                            </div>
                        `;
                            }

                        }
                    ]
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
                var nik = $('#modal-galon [name=nik]').val();
                $('#modal-galon form')[0].reset();
                $('#modal-galon [name=nik]').val(nik);
                $('#modal-galon [name=tanggal]').val($(this).data('tanggal'))
                $('#modal-galon [name=id]').val($(this).data('id'))
                $('#modal-galon [name=id_parent]').val($(this).data('id_parent'))
                $('#modal-galon [name=nama]').val($(this).data('nama'))
                $('#modal-galon [name=alamat]').val($(this).data('alamat'))
                $('#modal-galon [name=hp]').val($(this).data('hp'))
                $('#modal-galon #jumlah').val($(this).data('jumlah'))
                $('#modal-galon [name=bayar]').val($(this).data('bayar'))

                $('#modal-galon #jumlah').show()

            }).on('click', '#galon-bayar', function() {
                var nik = $('#modal-galon [name=nik]').val();
                $('#modal-galon form')[0].reset();
                $('#modal-galon [name=nik]').val(nik);
                $('#modal-galon [name=tanggal]').val($(this).data('tanggal'))
                $('#modal-galon [name=id_parent]').val($(this).data('id_parent'))
                $('#modal-galon [name=nama]').val($(this).data('nama'))
                $('#modal-galon [name=alamat]').val($(this).data('alamat'))
                $('#modal-galon [name=hp]').val($(this).data('hp'))
                $('#modal-galon #jumlah').val($(this).data('jumlah'))
                $('#modal-galon [name=bayar]').val('')

                $('#modal-galon #bayar').show()
            }).on('click', '#galon-delete', function(e) {
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

            }).on('click', '#penjualan-detail', function() {
                var id = $(this).data('id');
                var nama_produk = $(this).data('nama_produk');
                var nama_sales = $(this).data('nama_sales');

                url_edit = url_edit.replace(':id', id);

                $('#modal-detail').modal('show');
                $('#modal-detail form')[0].reset();
                $('#modal-detail .modal-title').text('Penjualan detail => ' + nama_sales + ' => ' +
                    nama_produk);
                $('#modal-detail [name=nama]').val('KONS ' + $(this).data('nama_sales'));
                $('#modal-detail [name=jumlah]').val(($(this).data('jumlah') - $(this).data('sisa')) - $(
                    this).data('terjual'));

                $('#modal-detail [name=_method]').val('post');
                $('#modal-detail [name=id_penjualan]').val(id);

                table_detail = $("#table_detail").DataTable({
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
                        url: '{{ route('penjualandetail.data', ':id') }}'.replace(':id', id),
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
                        data: 'harga'
                    }, {
                        data: 'total'
                    }, {
                        data: 'ket'
                    }, {
                        data: 'id',
                        render: function(data, type, row) {
                            return `
                        <div class="btn-group">
                            <button class="btn btn-sm btn-primary" id="penjualandetail-edit" data-id='${row.id}' data-id_penjualan='${row.id_penjualan}' data-nama='${row.nama}' data-jumlah='${row.jumlah}'  data-harga='${row.harga}' data-ket='${row.ket}'> Edit</button>
                            <button class="btn btn-sm btn-danger" id="penjualandetail-delete" data-id='${row.id}' data-id_penjualan='${row.id_penjualan}' data-nama='${row.nama}' data-jumlah='${row.jumlah}'  data-harga='${row.harga}' data-ket='${row.ket}'> Delete</button>
                        </div>
                    `;
                        }

                    }],
                    "columnDefs": [{
                            targets: 3,
                            className: 'dt-body-right',
                            render: $.fn.dataTable.render.number('.', '.', 0, '')
                        },
                        {
                            targets: 4,
                            className: 'dt-body-right',
                            render: $.fn.dataTable.render.number('.', '.', 0, '')
                        },
                        {
                            targets: 5,
                            className: 'dt-body-right',
                            render: $.fn.dataTable.render.number('.', '.', 0, '')
                        },
                    ],
                });

            }).on('click', '#save_detail', function() {
                $.ajax({
                    type: "POST",
                    url: url_save_detail,
                    data: $('#modal-detail form').serialize(),
                    success: function(result) {
                        if (result.errors) {
                            $('.alert-danger').html('');

                            $.each(result.errors, function(key, value) {
                                $('.alert-danger').show();
                                $('.alert-danger').append('<li>' + value +
                                    '</li>');
                            });
                        } else {
                            $('#modal-detail [name=nama]').val('');
                            $('#modal-detail [name=jumlah]').val('');
                            $('#modal-detail [name=sisa]').val('');
                            $('#modal-detail [name=harga]').val('');
                            $('#modal-detail [name=ket]').val('');
                            $("#table_detail").DataTable().ajax.reload()
                            $('#table').DataTable().ajax.reload();
                            alert('Input Berhasil');
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
            }).on('click', '#penjualandetail-edit', function(e) {
                if (!e.preventDefault()) {
                    if (!e.preventDefault()) {
                        var id = $(this).data('id');
                        var id_penjualan = $(this).data('id_penjualan');
                        var nama = $(this).data('nama');
                        var jumlah = $(this).data('jumlah');
                        var ket = $(this).data('ket');
                        var harga = $(this).data('harga');

                        $('#modal-detail #id').val(id)
                        $('#modal-detail #id_penjualan').val(id_penjualan)
                        $('#modal-detail #nama').val(nama)
                        $('#modal-detail #jumlah').val(jumlah)
                        $('#modal-detail #harga').val(harga)
                        $('#modal-detail #ket').val(ket)

                    }
                }

            }).on('click', '#penjualandetail-delete', function(e) {
                var id = $(this).data('id');
                url_delete_penjualandetail = url_delete_penjualandetail.replace(':id', id);

                if (confirm('Yakin akan menghapus data terpilih?')) {
                    if (!e.preventDefault()) {
                        $.ajax({
                            url: url_delete_penjualandetail,
                            type: 'DELETE',
                            data: {
                                _token: $('[name=csrf-token]').attr('content')
                            },
                            success: function(response) {
                                $('#table_detail').DataTable().ajax.reload();
                                $('#table').DataTable().ajax.reload();
                            },
                            error: function(errors) {
                                // alert('Gagal Hapus data!');
                                // return;
                            }
                        });
                    }
                }

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
                var nik = $('#modal-galon [name=nik]').val();
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
                var nik = $('#modal-galon [name=nik]').val();
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
