@extends('layouts.master')

@section('title')
    <i class="fa fa-file" aria-hidden="true"></i> <b>Laporan Pembayaran Penjualan</b>
@endsection

@section('content')
    <div class="row">
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
                                <div class="col-md-12 table-responsive">
                                    <table class="table table-striped table-inverse text-center"
                                        id="table-penjualan-laporan">
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
                                                <th>opr_input</th>
                                                <th>tgl_input</th>
                                                <th width="15%"><i class="fa fa-cogs" aria-hidden="true"></i>
                                                </th>
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
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal-penjualan" data-backdrop="static" data-keyboard="false" tabindex="-1"
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
                                                        <th>No</th>
                                                        <th>nota_penjualan</th>
                                                        <th>tgl_pembayaran</th>
                                                        <th>angs_ke</th>
                                                        <th>nominal_bayar</th>
                                                        <th>channel_bayar</th>
                                                        <th>ket_bayar</th>
                                                        <th>File</th>
                                                        <th><i class="fa fa-cog" aria-hidden="true"></i></th>
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

    @include('ramwater.penjualan.modal-show')
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            var tableLaporanpenjualan = $("#table-penjualan-laporan").DataTable({
                info: false,
                bPaginate: false,
                bLengthChange: false,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: '{{ route('penjualan.laporan.data') }}',
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
                            return data;
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
                            return data;
                        }
                    },
                    {
                        data: 'opr_input',
                        name: 'a.opr_input',
                        render: function(data, type, row) {
                            return data;
                        }
                    },
                    {
                        data: 'tgl_input',
                        name: 'a.tgl_input',
                        render: function(data, type, row) {
                            return data;
                        }
                    },
                    {
                        data: 'id',
                        name: 'a.id',
                        render: function(data, type, row) {
                            var row_data = JSON.stringify(row);

                            var btn_edit = '<a id="btn-penjualan-edit" data-id="' + row.id +
                                '" data-row=\'' + row_data +
                                '\' class="btn btn-primary btn-xs" style="white-space: nowrap" edit"><i class="fas fa-pencil-alt"></i> Edit</a>';

                            return '<div style="white-space: nowrap;">' + btn_edit + '</div>';
                        },
                    },
                ],
                columnDefs: [{
                        targets: [0, 5, 6, 7, 8, 9, 10, 11],
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
                }
            });

            $('#modal-penjualan').on('hidden.bs.modal', function() {
                console.log('Modal penjualan telah disembunyikan');
                $("#modal-penjualan").modal("hide");
                $('#penjualan-uraian').empty();
                $('#table-detail').empty();
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
                                    tableLaporanpenjualan.ajax.reload();
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
                                item.nota_penjualan + '" readonly></td>' +
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
                                '</a></td>' +
                                '<td style="white-space: nowrap;">' +
                                // Menggunakan white-space: nowrap; untuk menghindari wrap
                                '<a class="btn btn-success btn-xs btn-edit" style="margin-right: 5px;"><i class="fas fa-pencil-alt"></i></a>' +
                                '<a class="btn btn-danger btn-xs btn-hapus" style="margin-right: 5px;" ><i class="fa fa-trash" aria-hidden="true"></i></a>' +
                                '</td>' +
                                '</tr>';

                            $('#table-detail').append(row);
                        });

                        if (rowData.sts_angsuran != 4) {
                            var emptyRow =
                                '<tr>' +
                                '<td></td>' + // No column
                                '<td><input type="text" name="nota_pembelian" id="bayar_nota_pembelian" class="form-control bayar_nota_pembelian money" value="" disabled></td>' +
                                '<td><input type="text" name="tgl_pembayaran" id="bayar_tgl_pembayaran" class="form-control bayar_tgl_pembayaran money" value="' +
                                '{{ date('Ymd') }}' + '"></td>' +
                                '<td><input type="text" name="angs_ke" id="bayar_angs_ke" class="form-control bayar_angs_ke money" value="" disabled></td>' +
                                '<td><input type="text" name="nominal_bayar" id="bayar_nominal_bayar" class="form-control bayar_nominal_bayar money" value=""></td>' +
                                '<td>' +
                                '<select name="channel_bayar" id="bayar_channel_bayar" class="form-control bayar_channel_bayar">' +
                                '<option value="">Pilih Channel</option>' +
                                '@foreach ($channels as $channel)' +
                                '<option value="{{ $channel->kd_channel }}">{{ $channel->ur_channel }}</option>' +
                                '@endforeach' +
                                '</select>' +
                                '</td>' +
                                '<td><input type="text" name="ket_bayar" id="bayar_ket_bayar" class="form-control bayar_ket_bayar money" value=""></td>' +
                                '<td><a class="btn btn-danger btn-xs btn-hapus"><i class="fa fa-trash" aria-hidden="true"></i></a></td>' +
                                '</tr>';

                            $('#table-detail').append(emptyRow);
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

                $("#modal-penjualan").modal("show");
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
        });
    </script>
@endpush
