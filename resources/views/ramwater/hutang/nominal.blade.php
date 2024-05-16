@extends('layouts.master')

@section('title')
    <i class="fas fa-money-bill"></i> <b>Laporan Hutang Nominal</b>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-hearder"></div>
                <div class="card-body">
                    <form id="form-cari">
                        <div class="form-group">
                            <label>Date range:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                </div>
                                <input type="text" name="rTanggal" class="form-control float-right dateRange"
                                    id="rTanggal">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Pilih Supplier:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                    </span>
                                </div>
                                <select name="kd_supplier" id="kd_supplier" class="form-control">
                                    <option value="">Semua Supplier</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->kd_supplier }}">{{ $supplier->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Nota:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                    </span>
                                </div>
                                <input type="text" name="nota_pembelian" class="form-control float-right"
                                    id="nota_pembelian">
                            </div>
                        </div>
                    </form>
                    <div class="form-group">
                        <a class="btn btn-success btn-s float-right" id="btn-cari"><i class="fa fa-search"
                                aria-hidden="true"></i>
                            Cari</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="form-hutang" style="display: none">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{-- <a class="btn btn-success btn-xs" id="btn-add-pembelian">Tambah Data</a> --}}
                </div>
                <div class="card-body">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Laporan Pembayaran</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 table-responsive field">
                                    <table class="table table-striped table-inverse text-center"
                                        id="table-pembelian-laporan">
                                        <thead>
                                            <tr>
                                                {{-- <th width="5%">No</th> --}}
                                                <th>tgl_pembelian</th>
                                                <th>Supplier</th>
                                                <th>nota_pembelian</th>
                                                <th>harga_total</th>
                                                <th>nominal_bayar</th>
                                                <th>sisa_bayar</th>
                                                <th>sts_angsuran</th>
                                                <th>Faktur</th>
                                                <th width="15%"><i class="fa fa-cogs" aria-hidden="true"></i>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="3">Total:</th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade field" id="modal-pembelian" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-pembelian-title">Pembayaran title</h5>
                    <button type="button" class="close btn-close" id="btn-close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header card-success">
                                    <span>Uraian Pembelian</span>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 table-responsive">
                                            <table class="table table-striped" id="table-pembelian">
                                                <thead>
                                                    <tr>
                                                        <th>tgl_pembelian</th>
                                                        <th>Supplier</th>
                                                        <th>nota_pembelian</th>
                                                        <th>jns_pembelian</th>
                                                        <th>harga_total</th>
                                                        <th>nominal_bayar</th>
                                                        <th>sisa_bayar</th>
                                                        <th>sts_angsuran</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="pembelian-uraian"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header card-success">
                                    <span>Detail</span>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>nota_pembelian</th>
                                                        <th>tgl_pembayaran</th>
                                                        <th>angs_ke</th>
                                                        <th>nominal_bayar</th>
                                                        <th>channel_bayar</th>
                                                        <th>ket_bayar</th>
                                                        <th>File</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="table-detail-edit"> </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" id="btn-close">Close</button>
                </div>
            </div>
        </div>
    </div>

    @include('ramwater.pembelian.modal-show')
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#modal-pembelian').on('hidden.bs.modal', function() {
                console.log('Modal Pembelian telah disembunyikan');
                $("#modal-pembelian").modal("hide");
                $('#pembelian-uraian').empty();
                $('#table-detail-edit').empty();
                $('.path_file').val('');
            });

            $('body').on("click", "#btn-pembayaran-edit", function() {
                var rowData = $(this).data('row');

                var row =
                    '<tr>' +
                    '<td>' +
                    '<input type="hidden" name="id" id="ur_id" value="' + rowData.id +
                    '" class="form-control" readonly>' +
                    '<input type="text" name="tgl_pembelian" id="ur_tgl_pembelian" value="' + rowData
                    .tgl_pembelian + '" class="form-control" readonly>' +
                    '</td>' +
                    '<td>' +
                    '<div style="white-space: nowrap;"><span style="font-size: 16px; font-weight: bold;">' +
                    rowData.nama + '</span></div>' +
                    '</td>' +
                    '<td><input type="text" name="nota_pembelian" id="ur_nota_pembelian" class="form-control" value="' +
                    rowData.nota_pembelian + '" readonly></td>' +
                    '<input type="hidden" name="kd_supplier" id="ur_kd_supplier" value="' +
                    rowData
                    .kd_supplier + '" class="form-control">' +
                    '<td>' +
                    '<select name="jns_pembelian" id="ur_jns_pembelian" class="form-control" disabled="true">' +
                    '<option value="" ></option>' +
                    '<option value="tunai" ' + (rowData.jns_pembelian === 'tunai' ? 'selected' :
                        '') +
                    '>Tunai</option>' +
                    '<option value="tempo" ' + (rowData.jns_pembelian === 'tempo' ? 'selected' :
                        '') +
                    '>Tempo</option>' +
                    '</select>' +
                    '</td>' +
                    '<td><input type="text" name="harga_total" id="ur_harga_total" class="form-control money" value="' +
                    addCommas(rowData.harga_total) + '" readonly></td>' +
                    '<td><input type="text" name="nominal_bayar" id="ur_nominal_bayar" class="form-control money" value="' +
                    addCommas(rowData.nominal_bayar) + '" readonly></td>' +
                    '<td><input type="text" name="sisa_bayar" id="ur_sisa_bayar" class="form-control money" value="' +
                    addCommas(rowData.sisa_bayar) + '" readonly></td>' +
                    '<td><input type="text" name="sts_angsuran" id="ur_sts_angsuran" class="form-control money" value="' +
                    addCommas(rowData.sts_angsuran) + '" readonly></td>' +
                    '</tr>';
                $('#pembelian-uraian').append(row);

                $.ajax({
                    url: '{{ route('pembayaran.data') }}?nota_pembelian=' + rowData.nota_pembelian,
                    method: 'GET',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Loop through each object in the response array
                        response.forEach(function(item, index) {
                            // Create a new row with input fields filled with data from the response
                            var row =
                                '<tr>' +
                                '<td>' + (index + 1) + '</td>' + // No column
                                '<input type="hidden" name="id" id="bayar_id" class="form-control money" value="' +
                                item.id + '" readonly>' +
                                '<input type="hidden" name="update" id="bayar_update" class="form-control money" value="" readonly>' +
                                '<td><input type="text" name="nota" id="bayar_nota" class="form-control money" value="' +
                                item.nota + '" readonly></td>' +
                                '<td><input type="text" name="tgl_pembayaran" id="bayar_tgl_pembayaran" class="form-control money" value="' +
                                item.tgl + '" readonly></td>' +
                                '<td><input type="text" name="angs_ke" id="bayar_angs_ke" class="form-control money" value="' +
                                item.angs_ke + '" readonly></td>' +
                                '<td><input type="text" name="nominal_bayar" id="bayar_nominal_bayar" class="form-control money" value="' +
                                addCommas(item.nominal_bayar) + '" readonly></td>' +
                                '<td><input type="text" name="channel_bayar" id="bayar_channel_bayar" class="form-control money" value="' +
                                item.channel_bayar + '" readonly></td>' +
                                '<td><input type="text" name="ket_bayar" id="bayar_ket_bayar" class="form-control money" value="' +
                                item.ket_bayar + '" readonly></td>' +
                                '<input type="hidden" name="path_file" id="bayar_path_file" class="form-control" value="' +
                                item.path_file + '" readonly>' +
                                '<td><a href="{{ asset('') }}' + item.path_file +
                                '" target="_blank" class="a">' +
                                '<img src="{{ asset('') }}' + item.path_file +
                                '" alt="Faktur pembelian" style="width: 100px;height: 50px;border-radius: 5px;">' +
                                '</a></td>';

                            $('#table-detail-edit').append(row);
                        });

                        if (rowData.sts_angsuran != 4) { // if lunas

                        } else {
                            $('.modal .form-control').prop('disabled', true);
                        }
                    },
                    error: function(error) {
                        var errorMessage = "Terjadi kesalahan dalam operasi.";
                        if (error.responseJSON && error.responseJSON.message) {
                            errorMessage = error.responseJSON.message;
                        } else if (error.statusText) {
                            errorMessage = error.statusText;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Kesalahan!',
                            text: errorMessage,
                        });
                    }
                });
                $("#modal-pembelian").modal("show");
            }).on("click", "#btn-close", function() {
                $("#modal-pembelian").modal("hide");
                $('#pembelian-uraian').empty();
            }).on("click", "#btn-cari", function() {
                $('#form-hutang').show();
                var formData = $('#form-cari').serialize();

                var cari = {};
                formData.split('&').forEach(pair => {
                    var [key, value] = pair.split('=').map(decodeURIComponent);
                    cari[key] = value.trim();
                });

                var tableLaporanPembelian = $("#table-pembelian-laporan").DataTable({
                    info: false,
                    bPaginate: false,
                    bLengthChange: false,
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    bDestroy: true,
                    ajax: {
                        url: '{{ route('pembelian.detail.data') }}',
                        method: 'GET',
                        data: {
                            jns: 'hutang',
                            data: cari
                        }
                    },
                    dom: 'Brtip',
                    buttons: [{
                        extend: 'excel',
                        customizeData: function(data) {
                            // Menghapus titik atau koma dari kolom nilai_rk, nilai_rpd, dan nilai_realisasi
                            for (var i = 0; i < data.body.length; i++) {
                                for (var j = 0; j < data.body[i].length; j++) {
                                    if (j === 3 || j === 4 || j === 5) {
                                        data.body[i][j] = data.body[i][j].toString()
                                            .replace(/[.,]/g, '');
                                    }
                                }
                            }
                        }
                    }],
                    columns: [
                        // {
                        //     data: 'DT_RowIndex'
                        // },
                        {
                            data: 'tgl_pembelian',
                            name: 'a.tgl_pembelian',
                            render: function(data, type, row) {
                                var dataString = data.toString();

                                var year = dataString.substring(0, 4);
                                var month = dataString.substring(4, 6);
                                var day = dataString.substring(6, 8);
                                var formattedDate = year + '-' + month + '-' + day;

                                return formattedDate;
                            }
                        },
                        {
                            data: 'nama',
                            name: 'b.nama',
                            render: function(data, type, row) {
                                return '<div style="white-space: nowrap;"><span style="font-size: 16px; font-weight: bold;">' +
                                    data + '</span></div>';
                            }
                        },
                        {
                            data: 'nota_pembelian',
                            name: 'a.nota_pembelian',
                            render: function(data, type, row) {
                                return data;
                            }
                        },
                        {
                            data: 'harga_total',
                            name: 'a.harga_total',
                            render: function(data, type, row) {
                                return addCommas(data);
                            }
                        },
                        {
                            data: 'nominal_bayar',
                            name: 'a.nominal_bayar',
                            render: function(data, type, row) {
                                if (data == 0 || data == null) {

                                    return '0';
                                } else {
                                    return addCommas(data);
                                }
                            }
                        },
                        {
                            data: 'sisa_bayar',
                            name: 'a.sisa_bayar',
                            render: function(data, type, row) {
                                if (data == 0 || data == null) {

                                    return '0';
                                } else {
                                    return addCommas(data);
                                }
                            }
                        },
                        {
                            data: 'sts_angsuran',
                            name: 'a.sts_angsuran',
                            render: function(data, type, row) {
                                return data;
                            }
                        },
                        {
                            data: 'path_file',
                            name: 'a.path_file',
                            render: function(data, type, row) {
                                if (row.path_file) {
                                    return '<a href="{{ asset('') }}' + row.path_file +
                                        '" target="_blank" class="a">' +
                                        '<img src="{{ asset('') }}' + row.path_file +
                                        '" alt="Faktur pembelian" style="width: 100px;height: 50px;border-radius: 5px;">' +
                                        '</a>';
                                } else {
                                    return '-';
                                }
                            }
                        },

                        {
                            data: 'id',
                            name: 'a.id',
                            render: function(data, type, row) {
                                var row_data = JSON.stringify(row);

                                var btn_edit = '<a id="btn-pembayaran-edit" data-id="' + row
                                    .id +
                                    '" data-row=\'' + row_data +
                                    '\' class="btn btn-success btn-xs" style="white-space: nowrap" edit"><i class="fas fa-pencil-alt"></i></a>';

                                return '<div style="white-space: nowrap;">' + btn_edit +
                                    '</div>';
                            },
                        },
                    ],
                    footerCallback: function(row, data, start, end, display) {
                        var api = this.api();

                        // Menghitung total sum kolom harga_total
                        var hargaTotalTotal = api.column(3, {
                            page: 'current'
                        }).data().reduce(function(acc, curr) {
                            return acc + parseFloat(curr);
                        }, 0);

                        // Menghitung total sum kolom nominal_bayar
                        var nominalBayarTotal = api.column(4, {
                            page: 'current'
                        }).data().reduce(function(acc, curr) {
                            return acc + parseFloat(curr);
                        }, 0);

                        // Menghitung total sum kolom sisa_bayar
                        var sisaBayarTotal = api.column(5, {
                            page: 'current'
                        }).data().reduce(function(acc, curr) {
                            return acc + parseFloat(curr);
                        }, 0);

                        // Menampilkan total sum di footer
                        $(api.column(3).footer()).html(addCommas(hargaTotalTotal));
                        $(api.column(4).footer()).html(addCommas(nominalBayarTotal));
                        $(api.column(5).footer()).html(addCommas(sisaBayarTotal));
                    },
                    columnDefs: [{
                        targets: [3, 4, 5, 6, 7, 8],
                        searchable: false,
                        orderable: false
                    }],
                    initComplete: function() {
                        initializeColumnSearch(this);
                        setupHoverShapes(this, 7);
                    },
                });
            })
        });
    </script>
@endpush
