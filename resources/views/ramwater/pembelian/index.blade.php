@extends('layouts.master')

@section('title')
    Pembelian
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
                            <h3 class="card-title">Supplier</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 table-responsive">
                                    <table class="table table-striped table-inverse" id="table-supplier">
                                        <thead>
                                            <tr>
                                                {{-- <th width="5%">No</th> --}}
                                                <th>Supplier</th>
                                                <th>merek</th>
                                                <th>alamat</th>
                                                <th>no_tlp</th>
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
    <div class="modal fade" id="modal-pembelian" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-pembelian-title">Modal title</h5>
                    <button type="button" class="close btn-add-pembelian-close">
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
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Supplier</th>
                                                        <th>nota_pembelian</th>
                                                        <th>tgl_pembelian</th>
                                                        <th>kd_supplier</th>
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
                                            <table class="table table-striped" id="table-produk">
                                                <thead>
                                                    <tr>
                                                        <th>nama</th>
                                                        <th>nota_pembelian</th>
                                                        <th>kd_produk</th>
                                                        <th>type</th>
                                                        <th>qty_pesan</th>
                                                        <th>qty_retur</th>
                                                        <th>qty_bersih</th>
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
                    <button class="btn btn-secondary btn-add-pembelian-close">Close</button>
                </div>
            </div>
        </div>
    </div>
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
                ajax: '{{ route('pembelian.data') }}',
                dom: 'Brtip',
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
                columns: [
                    // {
                    //     data: 'DT_RowIndex',
                    //     searchable: false,
                    //     shrotable: false
                    // },
                    {
                        data: 'nama',
                        render: function(data, type, row) {
                            return data;
                        }
                    },
                    {
                        data: 'merek',
                        render: function(data, type, row) {
                            return data;
                        }
                    },
                    {
                        data: 'alamat',
                        render: function(data, type, row) {
                            return data;
                        }
                    },
                    {
                        data: 'no_tlp',
                        render: function(data, type, row) {
                            return data;
                        }
                    },
                    {
                        data: 'id',
                        render: function(data, type, row) {
                            var row_data = JSON.stringify(row);

                            var btn_input = '<a id="btn-penjualan-input" data-id="' + row.id +
                                '" data-row=\'' + row_data +
                                '\' class="btn btn-primary btn-xs edit"><i class="fas fa-pencil-alt"></i> Input Beli</a>';

                            return btn_input;
                        },
                    },
                ],
                columnDefs: [{
                    targets: [4],
                    searchable: false,
                    orderable: false
                }],
                initComplete: function() {
                    initializeColumnSearch(this);
                }

            });

            var tableProduk = $("#table-produk").DataTable({
                info: false,
                bPaginate: false,
                bLengthChange: false,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: '{{ route('produk.data') }}',
                dom: 'Brtip',
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
                            return '<a href="#" class="_produk" data-row=\'' + row_data + '\'>' +
                                data + '</a>';
                        }
                    },
                    {
                        data: 'nota_pembelian',
                        render: function(data, type, row) {
                            return '<input type="text" class="form-control money detail_nota_pembelian" name="nota_pembelian" id="detail_nota_pembelian" value="' +
                                row.nota_pembelian + '">';
                        }
                    },
                    {
                        data: 'kd_produk',
                        render: function(data, type, row) {
                            return '<input type="text" class="form-control money detail_kd_produk" name="kd_produk" id="detail_kd_produk" value="' +
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
                        data: 'harga_satuan',
                        render: function(data, type, row) {
                            return '<input type="text" class="form-control money detail_harga_satuan" name="harga_satuan" id="detail_harga_satuan">';
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
                        // targets: [1, 2], // Indeks kolom yang ingin disembunyikan (dimulai dari 0)
                        visible: false
                    }
                ],
                initComplete: function() {
                    initializeColumnSearch(this);
                }

            });

            $("body").on("click", "#btn-add-pembelian", function() { //add-pembelian
                $("#modal-pembelian-title").text("Tambah Data");
                $("#modal-pembelian").modal("show");
            }).on("click", ".btn-add-pembelian-close", function() { //close-pembelian
                $("#modal-pembelian").modal("hide");
                $('#pembelian-uraian').empty();
            }).on("click", "#btn-penjualan-input", function() { //btn_input_click
                var rowData = $(this).data('row');
                var row =
                    '<tr>' +
                    '<td> <input type="text" name="" id="" value="' + rowData.nama +
                    '" disabled> </td>' +
                    '<td> <input type="text" name="nota_pembelian" id="ur_nota_pembelian" class="form-control"></td>' +
                    '<td> <input type="text" name="tgl_pembelian" id="ur_tgl_pembelian" value="' +
                    {{ date('Ymd') }} + '" class="form-control"></td>' +
                    '<td> <input type="text" name="kd_supplier" id="ur_kd_supplier" value="' + rowData
                    .kd_supplier + '" class="form-control"></td>' +
                    '<td> <input type="text" name="jns_pembelian" id="ur_jns_pembelian" class="form-control"></td>' +
                    '<td> <input type="text" name="harga_total" id="ur_harga_total" class="form-control money" readonly></td>' +
                    '<td> <input type="text" name="nominal_bayar" id="ur_nominal_bayar" class="form-control money"></td>' +
                    '<td> <input type="text" name="sisa_bayar" id="ur_sisa_bayar" class="form-control money" readonly></td>' +
                    '<td> <input type="text" name="sts_angsuran" id="ur_sts_angsuran" class="form-control money" readonly></td>' +
                    '</tr>';


                $('#pembelian-uraian').append(row);

                $("#modal-pembelian-title").text("Tambah Data");
                // $("#ur_harga_total").prop("readonly", true);
                $("#modal-pembelian").modal("show");
            }).on("click", ".ur_supplier", function() { //hapus next row
                $(this).closest('tr').nextAll().remove();
            }).on("click", "._produk", function() { //pilih produk
                var rowData = $(this).data('row');
                console.log(rowData);
            }).on("keyup", "#ur_nota_pembelian", function() { //pilih produk
                var text = $('#ur_nota_pembelian').val()

                $('.detail_nota_pembelian').val(text)
            }).on("keyup", "#ur_nominal_bayar", function() {
                var nominal_bayar = getFloatValue($('#ur_nominal_bayar'))
                var harga_total = getFloatValue($('#ur_harga_total'))
                var sts_angsuran = '0';

                var total = harga_total - nominal_bayar;
                if (total > 0) {
                    sts_angsuran = '1';
                }

                $('#ur_sisa_bayar').val(addCommas(total))
                $('#ur_sts_angsuran').val(sts_angsuran)
            }).on("blur click",
                "#detail_qty_pesan, #detail_qty_retur, #detail_qty_bersih, #detail_harga_satuan,#detail_harga_total",
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
