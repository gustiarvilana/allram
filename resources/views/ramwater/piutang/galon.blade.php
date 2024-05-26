@extends('layouts.master')

@section('title')
    <i class="fa fa-file" aria-hidden="true"></i> <b>Laporan Piutang Galon</b>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-hearder"></div>
                <div class="card-body">
                    <form id="form-cari">
                        <div class="form-group" style="display: none">
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
                            <label>Nota:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-file" aria-hidden="true"></i>
                                    </span>
                                </div>
                                <input type="text" name="nota_penjualan" class="form-control float-right"
                                    id="nota_penjualan">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Pilih Pelanggan:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                    </span>
                                </div>
                                <input type="text" name="nama" class="form-control float-right" id="nama">
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
                    {{-- <a class="btn btn-success btn-xs" id="btn-add-penjualan">Tambah Data</a> --}}
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
                                        id="table-penjualan-laporan">
                                        <thead>
                                            <tr>
                                                <th width="5%">No</th>
                                                <th>nota_penjualan</th>
                                                <th>Nama Pelanggan</th>
                                                <th>tgl_penjualan</th>
                                                <th>Sales</th>
                                                <th>total_galon</th>
                                                <th>galon_kembali</th>
                                                <th>sisa_galon</th>
                                                <th>sts_galon</th>
                                                <th width="15%"><i class="fa fa-cogs" aria-hidden="true"></i>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="4">Total:</th>
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
    <div class="modal fade field" id="modal-penjualan" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-penjualan-title">Modal title</h5>
                    <button type="button" class="close btn-add-penjualan-close" id="btn-add-penjualan-close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header card-success">
                                    <span>Uraian penjualan</span>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 table-responsive">
                                            <table class="table table-striped" id="table-penjualan">
                                                <thead>
                                                    <tr>
                                                        <th>tgl_penjualan</th>
                                                        {{-- <th style="display: none">kd_pelanggan</th> --}}
                                                        <th>kd_channel</th>
                                                        <th>harga_total</th>
                                                        <th>nominal_bayar</th>
                                                        <th>sisa_bayar</th>
                                                        <th>sts_angsuran</th>
                                                        <th>total_galon</th>
                                                        <th>galon_kembali</th>
                                                        <th>sisa_galon</th>
                                                        <th>sts_galon</th>
                                                        <th>kd_sales</th>
                                                        {{-- <th>opr_input</th> --}}
                                                        {{-- <th>tgl_input</th> --}}
                                                    </tr>
                                                </thead>
                                                <tbody id="penjualan-uraian"></tbody>
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
                                            <table class="table table-striped" id="table-detail">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>nota_penjualan</th>
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
                    <button class="btn btn-success btn-add-penjualan-simpan" id="btn-add-penjualan-simpan"><i
                            class="fas fa-save"></i>
                        Simpan</button>
                    <button class="btn btn-secondary" class="close btn btn-secondary btn-add-penjualan-close"
                        id="btn-add-penjualan-close">Close</button>

                </div>
            </div>
        </div>
    </div>

    @include('ramwater.penjualan.modal-show')
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('.modal .form-control').prop('disabled', true);

            $('#table-detail-edit').on('click', '.btn-edit', function() {
                var data = $(this);
                var id = data.closest('tr').find('#bayar_id').val();

                data.closest('tr').find('#bayar_update').val(id);

                data.closest('tr').find('#bayar_tgl_pembayaran').removeAttr('readonly');
                data.closest('tr').find('#bayar_nominal_bayar').removeAttr('readonly');
                $('#btn-add-penjualan-simpan').show();

            });

            $('#modal-penjualan').on('hidden.bs.modal', function() {
                console.log('Modal penjualan telah disembunyikan');
                $("#modal-penjualan").modal("hide");
                $('#penjualan-uraian').empty();
                $('#table-detail-edit').empty();
            });

            $("body").on("click", "#btn-add-penjualan-close", function() {
                $("#modal-penjualan").modal("hide");
                $('#penjualan-uraian').empty();
            }).on("click", "#btn-penjualan-edit", function() {
                var rowData = $(this).data('row');

                var row =
                    '<tr>' +
                    '<td><input type="text" name="tgl_penjualan" id="ur_tgl_penjualan" class="form-control" value="' +
                    {{ date('Ymd') }} + '"></td>' +
                    '<input type="hidden" name="kd_pelanggan" id="ur_kd_pelanggan" class="form-control" value="' +
                    rowData.kd_pelanggan + '">' +
                    '<td>' +
                    '<select name="kd_channel" id="ur_kd_channel" class="form-control">' +
                    '<option value="">== Pilih Channel ==</option>' +
                    '@foreach ($channels as $channel)' +
                    '<option value="{{ $channel->kd_channel }}" ' + (rowData.kd_pelanggan ==
                        '{{ $channel->kd_channel }}' ? 'selected' : '') +
                    '>{{ $channel->ur_channel }}</option>' +
                    '@endforeach' +
                    '</select>' +
                    '</td>' +
                    '<td><input type="text" name="harga_total" id="ur_harga_total" class="form-control" value="' +
                    addCommas(rowData.harga_total) + '" readonly></td>' +
                    '<td><input type="text" name="nominal_bayar" id="ur_nominal_bayar" class="form-control money" value="' +
                    addCommas(rowData.nominal_bayar) + '"></td>' +
                    '<td><input type="text" name="sisa_bayar" id="ur_sisa_bayar" class="form-control money" value="' +
                    addCommas(rowData.sisa_bayar) + '" readonly></td>' +
                    '<td><input type="text" name="sts_angsuran" id="ur_sts_angsuran" class="form-control" value="' +
                    rowData.sts_angsuran + '" readonly></td>' +
                    '<td><input type="text" name="total_galon" id="ur_total_galon" class="form-control" value="' +
                    addCommas(rowData.total_galon) + '"></td>' +
                    '<td><input type="text" name="galon_kembali" id="ur_galon_kembali" class="form-control" value=""></td>' +
                    '<td><input type="text" name="sisa_galon" id="ur_sisa_galon" class="form-control"  value="' +
                    addCommas(rowData.sisa_galon) + '" readonly></td>' +
                    '<td><input type="text" name="sts_galon" id="ur_sts_galon" class="form-control"  value="' +
                    rowData.sts_galon + '" readonly></td>' +

                    '<td>' +
                    '<select name="kd_sales" id="ur_kd_sales" class="form-control">' +
                    '<option value="">== Pilih Sales ==</option>' +
                    '@foreach ($saless as $sales)' +
                    '<option value="{{ $sales->nik }}" ' + (rowData.kd_sales == '{{ $sales->nik }}' ?
                        'selected' : '') + '>{{ $sales->nama }}</option>' +
                    '@endforeach' +
                    '</select>' +
                    '</td>' +

                    '<input type="hidden" name="opr_input" id="ur_opr_input" class="form-control" value="' +
                    {{ Auth::user()->nik }} + '">' +
                    '<input type="hidden" name="nota_penjualan" id="ur_nota_penjualan" class="form-control" value="' +
                    rowData.nota_penjualan + '">' +
                    '<input type="hidden" name="tgl_input" id="ur_tgl_input" class="form-control" value="' +
                    {{ date('Ymd') }} + '">' +
                    '</tr>';

                $('#penjualan-uraian').append(row);

                var pathFile = "{{ asset('/') }}" + rowData.path_file;
                $('#image-container a').attr('href', pathFile);
                $('#image-container img').attr('src', pathFile);
                $('#download-btn').attr('href', pathFile);
                $("#modal-penjualan-title").text("Detail Pembayaran");

                $.ajax({
                    url: '{{ route('penjualan.pembayaran.data') }}?nota_penjualan=' + rowData
                        .nota_penjualan,
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
                                '<td><input type="text" name="nota_penjualan" id="bayar_nota_penjualan" class="form-control money" value="' +
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

                            $('#table-detail').append(row);
                        });

                        if (rowData.sts_angsuran != 4) {
                            $('#btn-add-penjualan-simpan').show();
                        } else {
                            $('#btn-add-penjualan-simpan').hide();
                            $('.modal .form-control').prop('readonly', true);
                            $('.modal #ur_kd_sales').prop('disabled', true);
                            $('.modal #ur_kd_channel').prop('disabled', true);
                            $('.modal #path_file').prop('disabled', true);
                        }

                        if (rowData.sts_galon != 4) {
                            $('.modal #ur_galon_kembali').prop('readonly', false);
                            $('#btn-add-penjualan-simpan').show();
                        } else {
                            $('.modal #ur_galon_kembali').prop('disabled', true);
                            $('.modal #ur_total_galon').prop('disabled', true);
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

                $('.modal .form-control').prop('disabled', true);
                $("#modal-penjualan").modal("show");
            }).on("click", "#btn-cari", function() {
                $('#form-hutang').show();
                var formData = $('#form-cari').serialize();

                var cari = {};
                formData.split('&').forEach(pair => {
                    var [key, value] = pair.split('=').map(decodeURIComponent);
                    cari[key] = value.trim();
                });

                var tableLaporanpenjualan = $("#table-penjualan-laporan").DataTable({
                    info: false,
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    bDestroy: true,
                    ajax: {
                        url: '{{ route('penjualan.detail.data') }}',
                        method: 'GET',
                        data: {
                            jns: 'hutangGalon',
                            data: cari
                        }
                    },
                    dom: 'Brtip',
                    buttons: [
                        'copy', 'excel', 'pdf'
                    ],
                    columns: [{
                            data: 'DT_RowIndex'
                        },

                        {
                            data: 'nota_penjualan',
                            name: 'a.nota_penjualan',
                            render: function(data, type, row) {
                                return data;
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
                            data: 'tgl_penjualan',
                            name: 'a.tgl_penjualan',
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
                            data: 'nama_sales',
                            name: 'nama_sales',
                            render: function(data, type, row) {
                                return '<div style="white-space: nowrap;"><span style="font-size: 16px; font-weight: bold;">' +
                                    data + '</span></div>';
                            }
                        },
                        {
                            data: 'total_galon',
                            name: 'a.total_galon',
                            render: function(data, type, row) {
                                return addCommas(data);
                            }
                        },
                        {
                            data: 'galon_kembali',
                            name: 'a.galon_kembali',
                            render: function(data, type, row) {
                                return addCommas(data);
                            }
                        },
                        {
                            data: 'sisa_galon',
                            name: 'a.sisa_galon',
                            render: function(data, type, row) {
                                return addCommas(data);
                            }
                        },
                        {
                            data: 'sts_galon',
                            name: 'a.sts_galon',
                            render: function(data, type, row) {
                                if (data == '1')
                                    return '<span class="badge badge-primary">Aktif</span>';
                                return data;
                            }
                        },
                        {
                            data: 'id',
                            name: 'a.id',
                            render: function(data, type, row) {
                                var row_data = JSON.stringify(row);

                                var btn_edit = '<a id="btn-penjualan-edit" data-id="' + row
                                    .id +
                                    '" data-row=\'' + row_data +
                                    '\' class="btn btn-primary btn-xs" style="white-space: nowrap" edit"><i class="fa fa-eye" aria-hidden="true"></i> Detail</a>';

                                return '<div style="white-space: nowrap;">' + btn_edit +
                                    '</div>';
                            },
                        },
                    ],
                    columnDefs: [{
                            targets: [0, 5, 6, 7, 8, 9],
                            searchable: false,
                            orderable: false
                        },
                        {
                            targets: [5, 6, 7],
                            className: 'text-right'
                        }
                    ],
                    initComplete: function() {
                        initializeColumnSearch(this);
                        // setupHoverShapes(this, 11);
                    },
                    footerCallback: function(row, data, start, end, display) {
                        var api = this.api();

                        // Menghitung total sum kolom harga_total
                        var hargaTotalTotal = api.column(5, {
                            page: 'current'
                        }).data().reduce(function(acc, curr) {
                            return acc + parseFloat(curr);
                        }, 0);

                        // Menghitung total sum kolom nominal_bayar
                        var nominalBayarTotal = api.column(6, {
                            page: 'current'
                        }).data().reduce(function(acc, curr) {
                            return acc + parseFloat(curr);
                        }, 0);

                        // Menghitung total sum kolom sisa_bayar
                        var sisaBayarTotal = api.column(7, {
                            page: 'current'
                        }).data().reduce(function(acc, curr) {
                            return acc + parseFloat(curr);
                        }, 0);

                        // Menampilkan total sum di footer
                        $(api.column(5).footer()).html(addCommas(hargaTotalTotal));
                        $(api.column(6).footer()).html(addCommas(nominalBayarTotal));
                        $(api.column(7).footer()).html(addCommas(sisaBayarTotal));
                    }
                });
            })

            $("body #btn-cari").click();
        });
    </script>
@endpush
