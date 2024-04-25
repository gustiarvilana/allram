@extends('layouts.master')

@section('title')
    <i class="fa fa-cart-plus" aria-hidden="true"></i> <b>Penjualan</b>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row justify-content-center">
                        <div class="col-md-8 text-center">
                            {{-- Alert --}}
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                            {{-- /Alert --}}
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Pelanggan</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 table-responsive">
                                    <table class="table table-striped table-inverse" id="table-supplier">
                                        <thead>
                                            <tr>
                                                <th width="5%">No</th>
                                                <th>nama</th>
                                                <th>alamat</th>
                                                <th>no_tlp</th>
                                                <th><i class="fa fa-cart-plus" aria-hidden="true"></i> Penjualan</th>
                                                <th width="15%"><i class="fa fa-cogs" aria-hidden="true"></i> Pelanggan
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
    <div class="modal fade field" id="modal-penjualan" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-penjualan-title">Modal title</h5>
                    <button type="button" class="close btn-add-pembelian-close" id="btn-add-pembelian-close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
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

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <span>Upload Bukti Pembayaran</span>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col d-flex align-items-center justify-content-center">
                                            <div class="form-group">
                                                <label for="path_file">Upload Bukti Pembayaran</label>
                                                <input class="form-control path_file" type="file" name="path_file"
                                                    id="path_file">
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
                                    <span>Uraian Penjualan</span>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 table-responsive field">
                                            <table class="table table-striped" id="table-penjualan">
                                                <thead>
                                                    <tr>
                                                        <th>tgl_penjualan</th>
                                                        {{-- <th style="display: none">kd_pelanggan</th> --}}
                                                        <th>kd_channel</th>
                                                        <th>harga_total</th>
                                                        <th>nominal_bayar</th>
                                                        {{-- <th>sisa_bayar</th> --}}
                                                        {{-- <th>sts_angsuran</th> --}}
                                                        <th>total_galon</th>
                                                        <th>galon_kembali</th>
                                                        <th>sisa_galon</th>
                                                        <th>sts_galon</th>
                                                        <th>Kasbon?</th>
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
    @include('ramwater.penjualan.modal-pelanggan')
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            // $("#modal-pembelian").modal("show");
            // $("#modal-pembelian-title").text("Tambah Data");

            var tableSupplier = $("#table-supplier").DataTable({
                info: false,
                bPaginate: false,
                bLengthChange: false,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: '{{ route('pelanggan.data') }}',
                dom: 'Brtip',
                buttons: [{
                    text: "Tambah Pelanggan",
                    action: function() {
                        $('#modal-add .modal-title').html(
                            '<i class="fa fa-users" aria-hidden="true"></i> <b>Tambah Pelanggan</b>'
                        );
                        add_pelanggan();
                    }
                }],
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        shrotable: false
                    },
                    {
                        data: 'nama',
                        name: 'nama',
                        render: function(data, type, row) {
                            return data;
                        }
                    },
                    {
                        data: 'alamat',
                        name: 'alamat',
                        render: function(data, type, row) {
                            return data;
                        }
                    },
                    {
                        data: 'no_tlp',
                        name: 'no_tlp',
                        render: function(data, type, row) {
                            return data;
                        }
                    },
                    {
                        data: 'a.id',
                        render: function(data, type, row) {
                            var row_data = JSON.stringify(row);

                            var btn_input = '<a id="btn-pelanggan-input" data-id="' + row.id +
                                '" data-row=\'' + row_data +
                                '\' class="btn btn-success btn-xs mx-1 edit" style="white-space: nowrap;"><i class="fas fa-pencil-alt"></i> Input Penjualan</a>';

                            return '<div class="text-center">' + btn_input + '</div>';
                        },

                    },
                    {
                        data: 'a.id',
                        render: function(data, type, row) {
                            var row_data = JSON.stringify(row);

                            var btn_edit = '<a id="btn-pelanggan-edit" data-id="' + row.id +
                                '" data-row=\'' + row_data +
                                '\' class="btn btn-primary btn-xs mx-1 edit" style="white-space: nowrap;"><i class="fas fa-pencil-alt"></i> Edit</a>';

                            var btn_delete = '<a id="btn-pelanggan-delete" data-id="' + row.id +
                                '" data-row=\'' + row_data +
                                '\' class="btn btn-danger btn-xs mx-1 delete" style="white-space: nowrap;"><i class="fas fa-trash"></i> Hapus</a>';

                            // return '<div class="text-center" style="white-space: nowrap;">' +
                            //     btn_edit + ' ' + btn_delete +
                            //     '</div>';
                            return '<div>' + btn_edit + '<br><br>' + btn_delete + '</div>'
                        },

                    },
                ],
                columnDefs: [{
                    targets: [0, 4, 5],
                    searchable: false,
                    orderable: false,
                }, {
                    targets: [3, 4, 5],
                    className: 'text-center'
                }],
                initComplete: function() {
                    initializeColumnSearch(this);
                }

            });

            var tableDetail = $("#table-detail").DataTable({
                info: false,
                bPaginate: false,
                bLengthChange: false,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: '{{ route('produk.data') }}',
                dom: 'tip',
                buttons: [{
                    extend: "excel",
                    text: "Export Data",
                    className: "btn-excel",
                    action: function(e, dt, node, config) {
                        $.getJSON('#', function(
                            data) {
                            var result = data.map(function(row) {
                                return {
                                    fullname: row.fullname,
                                    group_name: row.group_name,
                                    satker: row.satker,
                                    active: (row.active == '0') ? 'Not Active' :
                                        (row.active == '1') ? 'Active' :
                                        'Unknown',
                                    username: row.username,
                                    email: row.email,
                                    phone: row.phone
                                };
                            });
                            downloadXLSX(result);
                        });
                    }
                }],
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
                                row.kd_produk + '">';
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
                            return '<input type="text" class="form-control money detail_qty_pesan" name="qty_pesan" id="detail_qty_pesan">';
                        }
                    },
                    {
                        data: 'qty_retur',
                        render: function(data, type, row) {
                            return '<input type="text" class="form-control money detail_qty_retur" name="qty_retur" id="detail_qty_retur">';
                        }
                    },
                    {
                        data: 'qty_bersih',
                        render: function(data, type, row) {
                            return '<input type="text" class="form-control money detail_qty_bersih" name="qty_bersih" id="detail_qty_bersih" readonly>';
                        }
                    },
                    {
                        data: 'kd_gudang',
                        render: function(data, type, row) {
                            var selectOptions = '<option value="">== Pilih Gudang ==</option>';

                            @foreach ($gudang as $item)
                                selectOptions +=
                                    '<option value="{{ $item->kd_gudang }}">{{ $item->nama }}</option>';
                            @endforeach

                            return '<select name="kd_gudang" id="detail_kd_gudang" class="form-control">' +
                                selectOptions +
                                '</select>';
                        }
                    },
                    {
                        data: 'harga_satuan',
                        render: function(data, type, row) {
                            var selectOptions = '<option value="">== Pilih Harga ==</option>';
                            var kd_produk = row.kd_produk; // Ambil nilai kd_produk dari row

                            @foreach ($hargas as $harga)
                                if ('{{ $harga->kd_produk }}' == kd_produk) {
                                    var formattedPrice = addCommas('{{ $harga->harga }}');
                                    selectOptions +=
                                        '<option value="{{ $harga->harga }}">' +
                                        '{{ $harga->ket_harga }} / ' + formattedPrice +
                                        '</option>';
                                }
                            @endforeach

                            return '<select name="harga_satuan" id="detail_harga_satuan" class="form-control detail_harga_satuan">' +
                                selectOptions +
                                '</select>';

                        }
                    },
                    {
                        data: 'harga_total',
                        render: function(data, type, row) {
                            return '<input type="text" class="form-control money detail_harga_total" name="harga_total" id="detail_harga_total" readonly>';
                        }
                    }
                ],
                columnDefs: [{
                        targets: [4, 5, 6, 7, 8],
                        searchable: false,
                        orderable: false
                    },
                    {
                        targets: [0, 1],
                        orderable: false
                    },
                    {
                        targets: [1, 2], // Indeks kolom yang ingin disembunyikan (dimulai dari 0)
                        readonly: false
                    }
                ],
                initComplete: function() {
                    initializeColumnSearch(this);
                }

            });

            $('#modal-pembelian').on('hidden.bs.modal', function() {
                console.log('Modal Pembelian telah disembunyikan');
                $("#modal-pembelian").modal("hide");
                $('#pembelian-uraian').empty();
                $('#penjualan-uraian').empty();
                $('.path_file').val('');
            });

            $('body').on('keyup', '#ur_total_galon,#ur_galon_kembali', function() {
                var sisa = $('#ur_total_galon').val() - $('#ur_galon_kembali').val();
                if (sisa < 0) {
                    $('#ur_galon_kembali').val('0');
                    alert("Galon terlalu banyak");
                }
                console.log(sisa);
                $('#ur_sisa_galon').val(sisa);
                if (sisa > 0) $('#ur_sts_galon').val('1');
                if (sisa = 0) $('#ur_sts_galon').val('0');
            });

            $("body").on("click", "#btn-add-pembelian", function() { //add-pembelian
                $("#modal-pembelian-title").text("Tambah Data");
                $("#modal-pembelian").modal("show");
            }).on("click", "#btn-add-pembelian-close", function() { //close-pembelian
                $("#modal-penjualan").modal("hide");
                $('#penjualan-uraian').empty();
            }).on("click", "#btn-add-pembelian-simpan", function() {
                var imageFile = $('#path_file')[0].files[0];

                var dataArrayDetail = [];
                $('#table-detail tbody tr').each(function() {
                    var hargaTotal = $(this).find('#detail_harga_total').val();

                    if (hargaTotal && parseFloat(hargaTotal) !== 0) {
                        var rowData = {
                            nama: $(this).find('#detail_nama').text(),
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
                    isKasbon: $('#penjualan-uraian #ur_is_kasbon').prop('checked') ? 1 : 0
                };


                var formData = new FormData();
                formData.append('_token', getCSRFToken());
                formData.append('path_file', imageFile);
                formData.append('dataArrayDetail', JSON.stringify(dataArrayDetail));
                formData.append('penjualanData', JSON.stringify(penjualanData));

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
                    `<p><strong>Total Keseluruhan:</strong> <b>${penjualanData.harga_total}</b></p>`;

                detailPembelianHTML += '</div>';

                Swal.fire({
                    title: 'Konfirmasi Pembelian',
                    html: detailPembelianHTML,
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                    cancelButtonText: 'Batal',
                    icon: 'question',
                    width: '80%',
                    scrollbarPadding: true,
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
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Sukses!',
                                        text: response.message,
                                    });
                                    $('#btn-add-pembelian-close').click()
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
            }).on("click", "#btn-pelanggan-edit", function() {
                var rowData = $(this).data('row');

                $('#modal-add #id').val(rowData.id)
                $('#modal-add #kd_pelanggan').val(rowData.kd_pelanggan)
                $('#modal-add #nama').val(rowData.nama)
                $('#modal-add #alamat').val(rowData.alamat)
                $('#modal-add #no_tlp').val(rowData.no_tlp)

                $('#modal-add .modal-title').html(
                    '<i class="fa fa-user" aria-hidden="true"></i> <b>Edit Pelanggan</b>');
                add_pelanggan();
            }).on("click", "#btn-pelanggan-input", function() { //btn_input_click
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
                    '<option value="{{ $channel->kd_channel }}">{{ $channel->ur_channel }}</option>' +
                    '@endforeach' +
                    '</select>' +
                    '</td>' +
                    '<td><input type="text" name="harga_total" id="ur_harga_total" class="form-control" readonly></td>' +
                    '<td><input type="text" name="nominal_bayar" id="ur_nominal_bayar" class="form-control money"></td>' +
                    '<input type="hidden" name="sisa_bayar" id="ur_sisa_bayar" class="form-control money" readonly>' +
                    '<input type="hidden" name="sts_angsuran" id="ur_sts_angsuran" class="form-control" readonly>' +
                    '<td><input type="text" name="total_galon" id="ur_total_galon" class="form-control"></td>' +
                    '<td><input type="text" name="galon_kembali" id="ur_galon_kembali" class="form-control"></td>' +
                    '<td><input type="text" name="sisa_galon" id="ur_sisa_galon" class="form-control" readonly></td>' +
                    '<td><input type="text" name="sts_galon" id="ur_sts_galon" class="form-control" readonly></td>' +
                    '<td><input type="checkbox" name="is_kasbon" id="ur_is_kasbon" class="form-control" style="width: 30px; height: 30px;"></td>' +

                    '<td>' +
                    '<select name="kd_sales" id="ur_kd_sales" class="form-control">' +
                    '<option value="">== Pilih Sales ==</option>' +
                    '@foreach ($saless as $sales)' +
                    '<option value="{{ $sales->nik }}">{{ $sales->nama }}</option>' +
                    '@endforeach' +
                    '</select>' +
                    '</td>' +

                    '<input type="hidden" name="opr_input" id="ur_opr_input" class="form-control" value="' +
                    {{ Auth::user()->nik }} + '">' +
                    '<input type="hidden" name="tgl_input" id="ur_tgl_input" class="form-control" value="' +
                    {{ date('Ymd') }} + '">' +
                    '</tr>';

                $('#penjualan-uraian').append(row);

                $("#modal-penjualan-title").text("Input Penjualan " + rowData.nama);
                $("#modal-penjualan").modal("show");
            }).on("click", "#btn-pelanggan-delete", function() {
                var deleteButton = $(this);
                var id = deleteButton.data('id');
                var url_delete = '{{ route('pelanggan.destroy', ['pelanggan' => ':id']) }}';
                url_delete = url_delete.replace(':id', id);

                // Use SweetAlert for confirmation
                Swal.fire({
                    title: 'Anda Yakin?',
                    text: 'Anda akan menghapus pelanggan ini!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    cancelButtonText: 'Tidak',
                    confirmButtonText: 'Ya'
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
                                    tableSupplier.ajax.reload();
                                    Swal.fire('Terhapus!', 'Data berhasil dihapus.',
                                        'success');
                                    return;
                                }
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
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
            }).on("keyup change", "#ur_nominal_bayar,.detail_harga_satuan", function() {
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
                    var currentRow = $(this).closest('tr');

                    var val_harga = getFloatValue(currentRow.find('#detail_harga_satuan'));
                    $('#detail_harga_satuan').on('blur', function() {
                        var currentInput = $(this);
                        var h_awal = $('#harga').text();
                        var cek = cek_harga(h_awal, val_harga);

                        // currentInput.val(addCommas(h_awal));
                    })

                    updateField(currentRow, 'detail_qty_bersih', ['#detail_qty_pesan', '#detail_qty_retur'],
                        function(qtyPesan, qtyRetur) {
                            return qtyPesan - (isNaN(qtyRetur) ? 0 : qtyRetur);
                        });

                    updateField(currentRow, 'detail_harga_total', ['#detail_qty_bersih',
                            '#detail_harga_satuan'
                        ],
                        function(qtyBersih, hargaSatuan) {
                            return qtyBersih * hargaSatuan;
                        });

                    updateTotal('#ur_harga_total', '.detail_harga_total');
                });
        });

        function add_pelanggan() {
            $('#modal-add').modal('show');
        }

        function cek_harga(harga, val) {
            if (val < harga) {
                return Swal.fire({
                    icon: "info",
                    title: 'Kurang Harga',
                    // text: response.message,
                });
            };
            if (val > harga) {
                return Swal.fire({
                    icon: "info",
                    title: 'Lebih Harga',
                    // text: response.message,
                });
            };
        }
    </script>
@endpush
