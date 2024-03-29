@extends('layouts.master')

@section('title')
    <i class="fa fa-file" aria-hidden="true"></i> <b>Detail Pembelian</b>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{-- <a class="btn btn-success btn-xs" id="btn-add-pembelian">Tambah Data</a> --}}
                </div>
                <div class="card-body">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Detail Pembelian</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 table-responsive">
                                    <table class="table table-striped table-inverse text-center"
                                        id="table-pembelian-detail">
                                        <thead>
                                            <tr>
                                                {{-- Tgl. Pembelian, Supplier, Nota, Jns Pembelian, Total Harga, Jml Dibayar, Sisa, Status, File_nota --}}
                                                {{-- <th width="5%">No</th> --}}
                                                <th>tgl_pembelian</th>
                                                <th>Supplier</th>
                                                <th>nota_pembelian</th>
                                                <th>kd_supplier</th>
                                                <th>jns_pembelian</th>
                                                <th>harga_total</th>
                                                <th>nominal_bayar</th>
                                                <th>sisa_bayar</th>
                                                <th>sts_angsuran</th>
                                                <th>File Nota</th>
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
    <div class="modal fade field" id="modal-pembelian" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-pembelian-title">Modal title</h5>
                    <button type="button" class="close btn-add-pembelian-close" id="btn-add-pembelian-close">
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
                                <div class="card-header">
                                    <span>Upload Faktur</span>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col d-flex align-items-center justify-content-center">
                                            <div class="form-group">
                                                <label for="path_file">Upload Faktur</label>
                                                <input class="form-control" type="file" name="path_file" id="path_file">
                                            </div>
                                        </div>
                                        <div class="col d-flex flex-column align-items-center">
                                            <div class="row">
                                                <div class="col text-center" id="image-container">
                                                    <a href="{{ asset('storage/path_file/ramwater-pembelian.jpg') }}"
                                                        target="_blank" class="a">
                                                        <img src="{{ asset('storage/path_file/ramwater-pembelian.jpg') }}"
                                                            alt="Faktur pembelian" class="img">
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col text-center">
                                                    <a class="btn btn-success"
                                                        href="{{ asset('storage/path_file/ramwater-pembelian.jpg') }}"
                                                        id="download-btn" download>
                                                        <i class="fa fa-download" aria-hidden="true"></i> Download
                                                    </a>
                                                </div>
                                            </div>
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
                    <button class="btn btn-success btn-add-pembelian-simpan" id="btn-add-pembelian-simpan"><i
                            class="fas fa-save"></i>
                        Simpan</button>
                    {{-- <button class="btn btn-secondary btn-add-pembelian-simpan">Close</button> --}}
                </div>
            </div>
        </div>
    </div>

    @include('ramwater.pembelian.modal-show')
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            var tableDetailPembelian = $("#table-pembelian-detail").DataTable({
                info: false,
                bPaginate: false,
                bLengthChange: false,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: '{{ route('pembelian.detail.data') }}',
                dom: 'Brtip',
                // buttons: [
                //     'copy', 'excel', 'pdf'
                // ],
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
                        data: 'kd_supplier',
                        name: 'a.kd_supplier',
                        render: function(data, type, row) {
                            return data;
                        }
                    },
                    {
                        data: 'jns_pembelian',
                        name: 'a.jns_pembelian',
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
                            return '<a href="{{ asset('') }}' + row.path_file +
                                '" target="_blank" class="a">' +
                                '<img src="{{ asset('') }}' + row.path_file +
                                '" alt="Faktur pembelian" style="width: 100px;height: 50px;border-radius: 5px;">' +
                                '</a>';
                        }
                    },

                    {
                        data: 'id',
                        name: 'a.id',
                        render: function(data, type, row) {
                            var row_data = JSON.stringify(row);

                            var btn_show = '<a id="btn-penjualan-show" data-id="' + row.id +
                                '" data-row=\'' + row_data +
                                '\' class="btn btn-success btn-xs" style="white-space: nowrap" show"><i class="fa fa-eye" aria-hidden="true"></i> Lihat Beli</a>';

                            var btn_edit = '<a id="btn-penjualan-edit" data-id="' + row.id +
                                '" data-row=\'' + row_data +
                                '\' class="btn btn-primary btn-xs" style="white-space: nowrap" edit"><i class="fas fa-pencil-alt"></i> Edit Beli</a>';

                            var btn_delete = '<a id="btn-penjualan-delete" data-id="' + row.id +
                                '" data-row=\'' + row_data +
                                '\' class="btn btn-danger btn-xs" style="white-space: nowrap;" delete"><i class="fas fa-trash-alt"> Delete</a>';

                            // You can customize the buttons as needed

                            return '<div style="white-space: nowrap;">' + btn_show + ' ' +
                                btn_edit + ' ' + btn_delete + '</div>';
                            // return '<div style="white-space: nowrap;">' + btn_show + ' ' + '</div>';
                        },
                    },
                ],
                columnDefs: [{
                    targets: [3, 4, 5, 6, 7, 9, 10],
                    searchable: false,
                    orderable: false
                }],
                initComplete: function() {
                    initializeColumnSearch(this);
                    setupHoverShapes(this, 11);
                }
            });

            $('#modal-pembelian').on('hidden.bs.modal', function() {
                console.log('Modal Pembelian telah disembunyikan');
                $("#modal-pembelian").modal("hide");
                $('#pembelian-uraian').empty();
            });

            $("body").on("click", "#btn-add-pembelian", function() {
                $("#modal-pembelian-title").text("Tambah Data");
                $("#modal-pembelian").modal("show");
            }).on("click", "#btn-add-pembelian-close", function() {
                $("#modal-pembelian").modal("hide");
                $('#pembelian-uraian').empty();
            }).on("click", "#btn-add-pembelian-simpan", function() {
                var imageFile = $('#path_file')[0].files[0];

                var dataArrayDetail = [];
                $('#table-detail tbody tr').each(function() {
                    var hargaTotal = $(this).find('#detail_harga_total').val();

                    if (hargaTotal && parseFloat(hargaTotal) !== 0) {
                        var rowData = {
                            nama: $(this).find('#detail_nama').text(),
                            nota_pembelian: $(this).find('#detail_nota_pembelian').val(),
                            kd_produk: $(this).find('#detail_kd_produk').val(),
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

                var pembelianData = {
                    nota_pembelian: $('#table-pembelian #ur_nota_pembelian').val(),
                    tgl_pembelian: $('#table-pembelian #ur_tgl_pembelian').val(),
                    kd_supplier: $('#table-pembelian #ur_kd_supplier').val(),
                    jns_pembelian: $('#table-pembelian #ur_jns_pembelian').val(),
                    harga_total: $('#table-pembelian #ur_harga_total').val(),
                    nominal_bayar: $('#table-pembelian #ur_nominal_bayar').val(),
                    sisa_bayar: $('#table-pembelian #ur_sisa_bayar').val(),
                    sts_angsuran: $('#table-pembelian #ur_sts_angsuran').val(),
                };

                var formData = new FormData();
                formData.append('_token', getCSRFToken());
                formData.append('path_file', imageFile);
                formData.append('dataArrayDetail', JSON.stringify(dataArrayDetail));
                formData.append('pembelianData', JSON.stringify(pembelianData));
                formData.append('jns', 'update');

                //
                var detailPembelianHTML = '<div>';

                var detailPembelianHTML = `
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
                    detailPembelianHTML += `
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

                detailPembelianHTML += `
                        </tbody>
                    </table>
                `;

                // Menambahkan total keseluruhan
                detailPembelianHTML +=
                    `<p><strong>Total Keseluruhan:</strong> <b>${pembelianData.harga_total}</b></p>`;

                detailPembelianHTML += '</div>';

                Swal.fire({
                    title: 'Konfirmasi Pembelian',
                    html: detailPembelianHTML, // Menggunakan variabel detailPembelianHTML
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Batal',
                    icon: 'question',
                    width: '80%', // Sesuaikan lebar sesuai kebutuhan

                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('pembelian.store') }}',
                            method: 'POST',
                            processData: false,
                            contentType: false,
                            data: formData,
                            success: function(response) {
                                if (response.success) {
                                    tableDetailPembelian.ajax.reload();
                                    $('#btn-add-pembelian-close').click()
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
                    '<td><input type="text" name="tgl_pembelian" id="ur_tgl_pembelian" value="{{ date('Ymd') }}" class="form-control"></td>' +
                    '<td>' +
                    '<div style="white-space: nowrap;"><span style="font-size: 16px; font-weight: bold;">' +
                    rowData.nama + '</span></div>' +
                    '</td>' +
                    '<td><input type="text" name="nota_pembelian" id="ur_nota_pembelian" class="form-control" value="' +
                    rowData.nota_pembelian + '"></td>' +
                    '<input type="hidden" name="kd_supplier" id="ur_kd_supplier" value="' + rowData
                    .kd_supplier + '" class="form-control">' +
                    '<td>' +
                    '<select name="jns_pembelian" id="ur_jns_pembelian" class="form-control">' +
                    '<option value=""></option>' +
                    '<option value="tunai" ' + (rowData.jns_pembelian === 'tunai' ? 'selected' : '') +
                    '>Tunai</option>' +
                    '<option value="tempo" ' + (rowData.jns_pembelian === 'tempo' ? 'selected' : '') +
                    '>Tempo</option>' +
                    '</select>' +
                    '</td>' +
                    '<td><input type="text" name="harga_total" id="ur_harga_total" class="form-control money" value="' +
                    addCommas(rowData.harga_total) + '" readonly></td>' +
                    '<td><input type="text" name="nominal_bayar" id="ur_nominal_bayar" class="form-control money" value="' +
                    addCommas(rowData.nominal_bayar) + '"></td>' +
                    '<td><input type="text" name="sisa_bayar" id="ur_sisa_bayar" class="form-control money" value="' +
                    addCommas(rowData.sisa_bayar) + '" readonly></td>' +
                    '<td><input type="text" name="sts_angsuran" id="ur_sts_angsuran" class="form-control money" value="' +
                    addCommas(rowData.sts_angsuran) + '" readonly></td>' +
                    '</tr>';
                $('#pembelian-uraian').append(row);

                var pathFile = "{{ asset('/') }}" + rowData.path_file;
                $('#image-container a').attr('href', pathFile);
                $('#image-container img').attr('src', pathFile);
                $('#download-btn').attr('href', pathFile);
                $("#modal-pembelian-title").text("Update Data");

                var tableDetail = $("#table-detail  ").DataTable({
                    info: false,
                    bPaginate: false,
                    bLengthChange: false,
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    bDestroy: true,
                    ajax: {
                        url: '{{ route('produk.data') }}?nota_pembelian=' + rowData.nota_pembelian +
                            '',
                        data: {
                            nota_pembelian: rowData.nota_pembelian
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
                            targets: [1, 2, 3, 4, 5, 6, 7],
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

                $("#modal-pembelian").modal("show");
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
                        url: '{{ route('pembelian.detail.detailData') }}?nota_pembelian=' +
                            rowData
                            .nota_pembelian +
                            '',
                        data: {
                            nota_pembelian: rowData.nota_pembelian
                        },
                    },
                    // dom: 'Brtip',
                    dom: 'tip',
                    columns: [{
                            data: 'DT_RowIndex'
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
                        {
                            data: 'kd_gudang',
                            render: function(data, type, row) {
                                return data;
                            }
                        },
                    ],
                    columnDefs: [{
                            targets: [0, 1, 2, 3, 4, 5, 6, 7],
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

                $('#penjualan-show #modal-title').text('Pembelian Detail')
                $('#penjualan-show #modal-header').text('No Nota: ' + rowData.nota_pembelian)
                $('#penjualan-show').modal('show')
            }).on("click", "#btn-penjualan-delete", function() {
                var deleteButton = $(this);
                var id = deleteButton.data('id');
                var url_delete = '{{ route('pembelian.destroy', ['pembelian' => ':id']) }}';
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
                                    tableDetailPembelian.ajax.reload();
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
            }).on("keyup", "#ur_nota_pembelian", function() {
                var text = $('#ur_nota_pembelian').val()

                $('.detail_nota_pembelian').val(text)
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
