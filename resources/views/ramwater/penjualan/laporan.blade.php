@extends('layouts.master')

@section('title')
    <i class="fa fa-file" aria-hidden="true"></i> <b>Detail Penjualan</b>
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
                            <label>Pilih Sales:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                    </span>
                                </div>
                                <select name="nik" id="nik" class="form-control">
                                    <option value="">Pilih Sales</option>
                                    @foreach ($saless as $sales)
                                        <option value="{{ $sales->nik }}">{{ $sales->nama }}</option>
                                    @endforeach
                                </select>
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
                                {{-- <select name="kd_pelanggan" id="kd_pelanggan" class="form-control">
                                    <option value="">Pilih Pelanggan</option>
                                    @foreach ($pelanggans as $pelanggan)
                                        <option value="{{ $pelanggan->kd_pelanggan }}">{{ $pelanggan->nama }}</option>
                                    @endforeach
                                </select> --}}
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
                                <input type="text" name="nota_penjualan" class="form-control float-right"
                                    id="nota_penjualan">
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
    <div class="row" id="tbl-penjualan" style="display: none">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{-- <a class="btn btn-success btn-xs" id="btn-add-penjualan">Tambah Data</a> --}}
                </div>
                <div class="card-body">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Detail penjualan</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 table-responsive field">
                                    <table class="table table-striped table-inverse text-center"
                                        id="table-penjualan-detail">
                                        <thead>
                                            <tr>
                                                <th width="5%">No</th>
                                                <th>nota_penjualan</th>
                                                <th>Nama Pelanggan</th>
                                                <th>tgl_penjualan</th>
                                                <th>Sales</th>
                                                <th>harga_total</th>
                                                <th>nominal_bayar</th>
                                                <th>sisa_bayar</th>
                                                <th>sts_angsuran</th>
                                                <th>File</th>
                                                <th width="15%"><i class="fa fa-cogs" aria-hidden="true"></i>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="5">Total:</th>
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
                                                        {{-- <th>sisa_galon</th> --}}
                                                        {{-- <th>sts_galon</th> --}}
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
                                                        <th>nama</th>
                                                        <th>kd_produk</th>
                                                        <th>type</th>
                                                        <th>qty_pesan</th>
                                                        <th>qty_retur</th>
                                                        <th>qty_bersih</th>
                                                        <th>kd_gudang</th>
                                                        <th>harga_satuan</th>
                                                        <th>harga_total</th>
                                                    </tr>
                                                </thead>
                                                <tbody> </tbody>
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
                    {{-- <button class="btn btn-secondary btn-add-penjualan-simpan">Close</button> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade field" id="penjualan-show" tabindex="-1" role="dialog"
        aria-labelledby="penjualan-showTitle" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card card-success">
                        <div class="card-header">
                            <span id="modal-header"></span>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 table-responsive field">
                                    <table class="table table-bordered" id="modal-show-detail">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th>No</th>
                                                <th>nota_penjualan</th>
                                                <th>kd_produk</th>
                                                <th>qty_pesan</th>
                                                <th>qty_retur</th>
                                                <th>qty_bersih</th>
                                                <th>harga_satuan</th>
                                                <th>harga_total</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- rincian pembayaran --}}
                    <div class="card card-success" id="section-riwayat-bayar">
                        <div class="card-header">
                            <span id="card-header"></span>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 table-responsive field">
                                    <table class="table table-bordered" id="modal-show-pembayaran">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>nota</th>
                                                <th>tgl</th>
                                                <th>angs_ke</th>
                                                <th>nominal_bayar</th>
                                                <th>path_file</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#modal-penjualan').on('hidden.bs.modal', function() {
                console.log('Modal penjualan telah disembunyikan');
                $("#modal-penjualan").modal("hide");
                $('#penjualan-uraian').empty();
            });

            $("body").on("click", "#btn-add-penjualan", function() {
                $("#modal-penjualan-title").text("Tambah Data");
                $("#modal-penjualan").modal("show");
            }).on("click", "#btn-add-penjualan-close", function() {
                $("#modal-penjualan").modal("hide");
                $('#penjualan-uraian').empty();
            }).on("click", "#btn-add-penjualan-simpan", function() {
                var dataArrayDetail = [];
                $('#table-detail tbody tr').each(function() {
                    var hargaTotal = $(this).find('#detail_harga_total').val();

                    if (hargaTotal && parseFloat(hargaTotal) !== 0) {
                        var rowData = {
                            nama: $(this).find('#detail_nama').text(),
                            nota_penjualan: $(this).find('#detail_nota_penjualan').val(),
                            kd_produk: $(this).find('#detail_kd_produk').val(),
                            qty_pesan: $(this).find('#detail_qty_pesan').val(),
                            qty_retur: $(this).find('#detail_qty_retur').val(),
                            qty_bersih: $(this).find('#detail_qty_bersih').val(),
                            harga_satuan: $(this).find('#detail_harga_satuan').val(),
                            kd_gudang: $(this).find('#detail_kd_gudang').val(),
                            harga_total: hargaTotal,
                        };
                        dataArrayDetail.push(rowData);
                    }
                });

                var penjualanData = {
                    nota_penjualan: $('#penjualan-uraian #ur_nota_penjualan').val(),
                    tgl_penjualan: $('#penjualan-uraian #ur_tgl_penjualan').val(),
                    kd_pelanggan: $('#penjualan-uraian #ur_kd_pelanggan').val(),
                    kd_channel: $('#penjualan-uraian #ur_kd_channel').val(),
                    harga_total: $('#penjualan-uraian #ur_harga_total').val(),
                    nominal_bayar: $('#penjualan-uraian #ur_nominal_bayar').val(),
                    sisa_bayar: $('#penjualan-uraian #ur_sisa_bayar').val(),
                    sts_angsuran: $('#penjualan-uraian #ur_sts_angsuran').val(),
                    total_galon: $('#penjualan-uraian #ur_total_galon').val(),
                    galon_kembali: $('#penjualan-uraian #ur_galon_kembali').val(),
                    sisa_galon: $('#penjualan-uraian #ur_sisa_galon').val(),
                    sts_galon: $('#penjualan-uraian #ur_sts_galon').val(),
                    kd_sales: $('#penjualan-uraian #ur_kd_sales').val(),
                    opr_input: $('#penjualan-uraian #ur_opr_input').val(),
                    tgl_input: $('#penjualan-uraian #ur_tgl_input').val(),
                };

                var formData = new FormData();
                formData.append('_token', getCSRFToken());
                formData.append('dataArrayDetail', JSON.stringify(dataArrayDetail));
                formData.append('penjualanData', JSON.stringify(penjualanData));
                formData.append('jns', 'update');

                //
                var detailpenjualanHTML = '<div>';

                var detailpenjualanHTML = `
                    <table class="table table-striped" id="table-detail">
                        <thead style="background-color: #4CAF50; color: white; padding: 10px;">
                            <tr>
                                <th>nama</th>
                                <th>pesan</th>
                                <th>retur</th>
                                <th>bersih</th>
                                <th>kd_gudang</th>
                                <th>harga_satuan</th>
                                <th>harga_total</th>
                            </tr>
                        </thead>
                        <tbody>
                `;

                dataArrayDetail.forEach(function(rowData) {
                    detailpenjualanHTML += `
                        <tr>
                            <td>${rowData.nama}</td>
                            <td>${rowData.qty_pesan}</td>
                            <td>${rowData.qty_retur}</td>
                            <td>${rowData.qty_bersih}</td>
                            <td>${rowData.kd_gudang}</td>
                            <td>${rowData.harga_satuan}</td>
                            <td>${rowData.harga_total}</td>
                        </tr>
                    `;
                });

                detailpenjualanHTML += `
                        </tbody>
                    </table>
                `;

                // Menambahkan total keseluruhan
                detailpenjualanHTML +=
                    `<p><strong>Total Keseluruhan:</strong> <b>${penjualanData.harga_total}</b></p>`;

                detailpenjualanHTML += '</div>';

                Swal.fire({
                    title: 'Konfirmasi penjualan',
                    html: detailpenjualanHTML, // Menggunakan variabel detailpenjualanHTML
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Batal',
                    icon: 'question',
                    width: '80%', // Sesuaikan lebar sesuai kebutuhan

                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('penjualan.store') }}',
                            method: 'POST',
                            processData: false,
                            contentType: false,
                            data: formData,
                            success: function(response) {
                                if (response.success) {
                                    tableDetailpenjualan.ajax.reload();
                                    $('#btn-add-penjualan-close').click()
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Sukses!',
                                        text: response.message,
                                    });
                                    return;
                                }
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: response.message,
                                });

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
                    }
                });

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
                    '<td><input type="text" name="galon_kembali" id="ur_galon_kembali" class="form-control" value="' +
                    addCommas(rowData.galon_kembali) + '"></td>' +
                    '<input type="hidden" name="sisa_galon" id="ur_sisa_galon" class="form-control"  value="' +
                    addCommas(rowData.sisa_galon) + '" readonly>' +
                    '<input type="hidden" name="sts_galon" id="ur_sts_galon" class="form-control"  value="' +
                    rowData.sts_galon + '" readonly>' +

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
                $("#modal-penjualan-title").text("Update Data");

                var tableDetail = $("#table-detail  ").DataTable({
                    info: false,
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    bDestroy: true,
                    ajax: {
                        url: '{{ route('produk.data') }}?nota_penjualan=' + rowData.nota_penjualan,
                        data: {
                            nota_penjualan: rowData.nota_penjualan
                        },
                    },
                    // dom: 'Brtip',
                    dom: 'Brtip',
                    columns: [{
                            data: 'nama',
                            render: function(data, type, row) {
                                var row_data = JSON.stringify(row);
                                return '<div style="white-space: nowrap;"><span id="detail_nama" style="font-size: 16px; font-weight: bold;">' +
                                    data + '</span></div>';

                            }
                        },
                        {
                            data: 'kd_produk',
                            render: function(data, type, row) {
                                return '<input readonly type="text" class="form-control money detail_kd_produk" name="kd_produk" id="detail_kd_produk" value="' +
                                    data + '">';
                            }
                        },
                        {
                            data: 'type',
                            render: function(data, type, row) {
                                return data;
                            }
                        },
                        {
                            data: 'qty_pesan',
                            render: function(data, type, row) {
                                var value = (data !== null) ? data : 0;

                                return '<input type="text" class="form-control money detail_qty_pesan" name="qty_pesan" id="detail_qty_pesan" value="' +
                                    value + '">';
                            }
                        },
                        {
                            data: 'qty_retur',
                            render: function(data, type, row) {
                                var value = (data !== null) ? data : 0;

                                return '<input type="text" class="form-control money detail_qty_retur" name="qty_retur" id="detail_qty_retur" value="' +
                                    value + '">';
                            }
                        },
                        {
                            data: 'qty_bersih',
                            render: function(data, type, row) {
                                var value = (data !== null) ? data : 0;

                                return '<input type="text" class="form-control money detail_qty_bersih" name="qty_bersih" id="detail_qty_bersih" value="' +
                                    addCommas(value) + '" readonly>';
                            }
                        },
                        {
                            data: 'kd_gudang',
                            render: function(data, type, row) {
                                var value = (data !== null) ? data : 0;

                                return '<input type="text" class="form-control money detail_kd_gudang" name="kd_gudang" id="detail_kd_gudang" value="' +
                                    addCommas(value) + '" readonly>';
                            }
                        },
                        {
                            data: 'harga_satuan',
                            render: function(data, type, row) {
                                var value = (data !== null) ? data : 0;

                                return '<input type="text" class="form-control money detail_harga_satuan" name="harga_satuan" id="detail_harga_satuan" value="' +
                                    addCommas(value) + '">';
                            }
                        },
                        {
                            data: 'harga_total',
                            render: function(data, type, row) {
                                var value = (data !== null) ? data : 0;
                                return '<input type="text" class="form-control money detail_harga_total" name="harga_total" id="detail_harga_total" value="' +
                                    addCommas(value) + '" readonly>';
                            }
                        }
                    ],
                    columnDefs: [{
                            targets: [1, 2, 3, 4, 5, 6, 7, 8],
                            searchable: false,
                            orderable: false
                        },
                        {
                            targets: [0, 1],
                            orderable: false
                        },
                        {
                            // targets: [1, 2],
                            visible: false
                        }
                    ],
                    initComplete: function() {
                        initializeColumnSearch(this);
                    }
                });

                $("#modal-penjualan").modal("show");
            }).on("click", "#btn-penjualan-show", function() {
                var rowData = $(this).data('row');

                var tableDetail = $("#modal-show-detail").DataTable({
                    info: false,
                    bPaginate: false,
                    bLengthChange: false,
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    bDestroy: true,
                    ajax: {
                        url: '{{ route('penjualan.detail.detailData') }}?nota_penjualan=' +
                            rowData
                            .nota_penjualan +
                            '',
                        data: {
                            nota_penjualan: rowData.nota_penjualan
                        },
                    },
                    dom: 'Brtip',
                    buttons: [{
                        extend: 'excel',
                        customizeData: function(data) {
                            // Menghapus titik atau koma dari kolom nilai_rk, nilai_rpd, dan nilai_realisasi
                            for (var i = 0; i < data.body.length; i++) {
                                for (var j = 0; j < data.body[i].length; j++) {
                                    if (j === 5 || j === 6) {
                                        data.body[i][j] = data.body[i][j].toString()
                                            .replace(/[.,]/g, '');
                                    }
                                }
                            }
                        }
                    }],
                    columns: [{
                            data: 'DT_RowIndex'
                        },
                        {
                            data: 'nota_penjualan',
                            render: function(data, type, row) {
                                return row.nama;
                            }
                        },
                        {
                            data: 'kd_produk',
                            render: function(data, type, row) {
                                return row.nama;
                            }
                        },
                        {
                            data: 'qty_pesan',
                            render: function(data, type, row) {
                                return addCommas(data);
                            }
                        },
                        {
                            data: 'qty_retur',
                            render: function(data, type, row) {
                                return addCommas(data);
                            }
                        },
                        {
                            data: 'qty_bersih',
                            render: function(data, type, row) {
                                return addCommas(data);
                            }
                        },
                        {
                            data: 'harga_satuan',
                            render: function(data, type, row) {
                                return addCommas(data);
                            }
                        },
                        {
                            data: 'harga_total',
                            render: function(data, type, row) {
                                return addCommas(data);
                            }
                        },
                    ],
                    columnDefs: [{
                            targets: [0, 1, 2, 3, 4, 5, 6],
                            searchable: false,
                            orderable: false
                        },
                        {
                            targets: [0, 1],
                            orderable: false
                        },
                        {
                            // targets: [1, 2],
                            visible: false
                        }
                    ]
                });

                var tableRiwayat = $("#modal-show-pembayaran").DataTable({
                    info: false,
                    bPaginate: false,
                    bLengthChange: false,
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    bDestroy: true,
                    ajax: {
                        url: '{{ route('pembayaran.data') }}?nota_penjualan=' +
                            rowData
                            .nota_penjualan +
                            '',
                        data: {
                            nota_penjualan: rowData.nota_penjualan,
                            grid: 'data'
                        },
                    },
                    // dom: 'Brtip',
                    dom: 'tip',
                    columns: [{
                            data: 'DT_RowIndex'
                        },
                        {
                            data: 'nota',
                            render: function(data, type, row) {
                                console.log(data);
                                return row.nota;
                            }
                        },
                        {
                            data: 'tgl',
                            render: function(data, type, row) {
                                return row.tgl;
                            }
                        },
                        {
                            data: 'angs_ke',
                            render: function(data, type, row) {
                                return row.angs_ke;
                            }
                        },
                        {
                            data: 'nominal_bayar',
                            render: function(data, type, row) {
                                return addCommas(row.nominal_bayar);
                            }
                        },
                        {
                            data: 'path_file',
                            name: 'a.path_file',
                            render: function(data, type, row) {
                                return '<a href="{{ asset('') }}' + row.path_file +
                                    '" target="_blank" class="a">' +
                                    '<img src="{{ asset('') }}' + row.path_file +
                                    '" alt="Faktur pembelian" style="width: 100px;height: 50px;border-radius: 5px;">' +
                                    '</a>';
                            }
                        }
                    ],
                    // columnDefs: [{
                    //         targets: [0, 1, 2, 3, 4],
                    //         searchable: false,
                    //         orderable: false
                    //     },
                    //     {
                    //         targets: [0, 1],
                    //         orderable: false
                    //     },
                    //     {
                    //         // targets: [1, 2],
                    //         visible: false
                    //     }
                    // ],
                    // initComplete: function() {
                    //     initializeColumnSearch(this);
                    // }
                });

                $('#penjualan-show #modal-title').text('penjualan Detail')
                $('#penjualan-show #modal-header').text('No Nota: ' + rowData.nota_penjualan)

                $('#section-riwayat-bayar #card-header').text('Riwayat Pembayaran')
                $('#penjualan-show').modal('show')
            }).on("click", "#btn-penjualan-delete", function() {
                var deleteButton = $(this);
                var id = deleteButton.data('id');
                var url_delete = '{{ route('penjualan.destroy', ['penjualan' => ':id']) }}';
                url_delete = url_delete.replace(':id', id);

                // Use SweetAlert for confirmation
                Swal.fire({
                    title: 'Anda Yakin?',
                    text: 'Pastikan Produk masih di Gudang Utama!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    cancelButtonText: 'Tidak',
                    confirmButtonText: 'Ya, Produk masih di Gudang Utama!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url_delete,
                            type: 'DELETE',
                            data: {
                                _token: getCSRFToken(),
                            },
                            success: function(response) {
                                if (response.success) {
                                    tableDetailpenjualan.ajax.reload();
                                    Swal.fire('Terhapus!', 'Data berhasil dihapus.',
                                        'success');
                                    return;
                                }
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: response.message,
                                });

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
                    }
                });
            }).on("keyup", "#ur_nota_penjualan", function() {
                var text = $('#ur_nota_penjualan').val()

                $('.detail_nota_penjualan').val(text)
            }).on("keyup", "#ur_nominal_bayar,.detail_harga_satuan", function() {
                var nominal_bayar = getFloatValue($('#ur_nominal_bayar'))
                var harga_total = getFloatValue($('#ur_harga_total'))
                var sts_angsuran = '0';

                var total = harga_total - nominal_bayar;
                if (total > 0) {
                    sts_angsuran = '1';
                }

                $('#ur_sisa_bayar').val(addCommas(total))
                $('#ur_sts_angsuran').val(sts_angsuran)
            }).on("click", "#btn-cari", function() {
                cariLaporan()
            }).on("keyup change",
                ".detail_qty_pesan, .detail_qty_retur, .detail_qty_bersih, .detail_harga_satuan,.detail_harga_total,.ur_harga_total",
                function() {
                    // Mendapatkan baris terdekat
                    var currentRow = $(this).closest('tr');

                    // Update detail_qty_bersih berdasarkan detail_qty_pesan dan detail_qty_retur
                    updateField(currentRow, 'detail_qty_bersih', ['#detail_qty_pesan', '#detail_qty_retur'],
                        function(qtyPesan, qtyRetur) {
                            return qtyPesan - (isNaN(qtyRetur) ? 0 : qtyRetur);
                        });

                    // Update detail_harga_total berdasarkan detail_qty_bersih dan detail_harga_satuan
                    updateField(currentRow, 'detail_harga_total', ['#detail_qty_bersih',
                            '#detail_harga_satuan'
                        ],
                        function(qtyBersih, hargaSatuan) {
                            return qtyBersih * hargaSatuan;
                        });

                    // Update total pada ur_harga_total berdasarkan detail_harga_total
                    updateTotal('#ur_harga_total', '.detail_harga_total');
                });
            cariLaporan();
        });

        function cariLaporan() {
            $('#tbl-penjualan').show();
            var formData = $('#form-cari').serializeArray();
            var cari = {};
            $.each(formData, function(index, field) {
                cari[field.name] = field.value;
            });

            var tableDetailpenjualan = $("#table-penjualan-detail").DataTable({
                info: false,
                paging: false,
                bPaginate: false,
                bLengthChange: false,
                processing: true,
                serverSide: true,
                autoWidth: false,
                bDestroy: true,
                ajax: {
                    url: '{{ route('penjualan.detail.data') }}',
                    type: 'GET',
                    data: cari
                },
                dom: 'Brtip',
                buttons: [{
                    extend: 'excel',
                    customizeData: function(data) {
                        // Menghapus titik atau koma dari kolom nilai_rk, nilai_rpd, dan nilai_realisasi
                        for (var i = 0; i < data.body.length; i++) {
                            for (var j = 0; j < data.body[i].length; j++) {
                                if (j === 5 || j === 6) {
                                    data.body[i][j] = data.body[i][j].toString().replace(/[.,]/g, '');
                                }
                            }
                        }
                    }
                }],
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
                            return addCommas(data);
                        }
                    },
                    {
                        data: 'sisa_bayar',
                        name: 'a.sisa_bayar',
                        render: function(data, type, row) {
                            return addCommas(data);
                        }
                    },
                    {
                        data: 'sts_angsuran',
                        name: 'a.sts_angsuran',
                        render: function(data, type, row) {
                            if (data == 1)
                                return '<span class="badge rounded-pill bg-primary">Tempo Aktif</span>';
                            if (data == 3)
                                return '<span class="badge rounded-pill bg-info"><i class="fa fa-check-circle" aria-hidden="true"></i> Kasbon Sales</span>';
                            if (data == 4)
                                return '<span class="badge rounded-pill bg-success"><i class="fa fa-check-circle" aria-hidden="true"></i> Lunas</span>';
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
                                    '" alt="Bukti Pembayaran" style="width: 100px;height: 50px;border-radius: 5px;">' +
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

                            var btn_show = '<a id="btn-penjualan-show" data-id="' + row.id +
                                '" data-row=\'' + row_data +
                                '\' class="btn btn-success btn-xs" style="white-space: nowrap" show"><i class="fa fa-eye" aria-hidden="true"></i> Lihat</a>';

                            var btn_edit = '<a id="btn-penjualan-edit" data-id="' + row.id +
                                '" data-row=\'' + row_data +
                                '\' class="btn btn-primary btn-xs" style="white-space: nowrap" edit"><i class="fas fa-pencil-alt"></i> Edit</a>';

                            var btn_delete = '<a id="btn-penjualan-delete" data-id="' + row.id +
                                '" data-row=\'' + row_data +
                                '\' class="btn btn-danger btn-xs" style="white-space: nowrap;" delete"><i class="fas fa-trash-alt"> Hapus</a>';

                            // You can customize the buttons as needed

                            return '<div style="white-space: nowrap;">' + btn_show + '</div>';
                        },
                    },
                ],
                columnDefs: [{
                        targets: [0, 5, 6, 7, 8, 9, 10],
                        searchable: false,
                        orderable: false
                    },
                    {
                        targets: [5, 6, 7],
                        className: 'text-right'
                    }
                ],
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
        }
    </script>
@endpush
