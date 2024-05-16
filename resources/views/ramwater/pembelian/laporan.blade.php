@extends('layouts.master')

@section('title')
    <i class="fa fa-file" aria-hidden="true"></i> <b>Laporan Pembelian</b>
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
    <div class="row" id="tbl-pembelian" style="display: none">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{-- <a class="btn btn-success btn-xs" id="btn-add-pembelian">Tambah Data</a> --}}
                </div>
                <div class="card-body">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Laporan Pembelian</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 table-responsive field">
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
    <div class="modal fade modal-transaksi" id="modal-pembelian" data-backdrop="static" data-keyboard="false" tabindex="-1"
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
            $('#modal-pembelian').on('hidden.bs.modal', function() {
                console.log('Modal Pembelian telah disembunyikan');
                $("#modal-pembelian").modal("hide");
                $('#pembelian-uraian').empty();
            });

            $("body").on("click", "#btn-add-pembelian-close", function() {
                $("#modal-pembelian").modal("hide");
                $('#pembelian-uraian').empty();
            }).on("click", "#btn-penjualan-show", function() {
                var rowData = $(this).data('row');

                var tableDetail = $("#modal-show-detail").DataTable({
                    info: false,
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

                var tableRiwayat = $("#modal-show-pembayaran").DataTable({
                    info: false,
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    bDestroy: true,
                    ajax: {
                        url: '{{ route('pembayaran.data') }}?nota_pembelian=' +
                            rowData
                            .nota_pembelian +
                            '',
                        data: {
                            nota_pembelian: rowData.nota_pembelian,
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

                $('#penjualan-show #modal-title').text('Pembelian Detail')
                $('#penjualan-show #modal-header').text('No Nota: ' + rowData.nota_pembelian)

                $('#section-riwayat-bayar #card-header').text('Riwayat Pembayaran')
                $('#penjualan-show').modal('show')

            }).on("click", "#btn-cari", function() {
                cariLaporan()
            });
        });

        function cariLaporan() {
            $('#tbl-pembelian').show();
            var formData = $('#form-cari').serializeArray();
            var cari = {};
            $.each(formData, function(index, field) {
                cari[field.name] = field.value;
            });
            var tableDetailPembelian = $("#table-pembelian-detail").DataTable({
                info: false,
                processing: true,
                serverSide: true,
                autoWidth: false,
                bDestroy: true,
                ajax: {
                    url: '{{ route('pembelian.detail.data') }}',
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
                                if (j === 5 || j === 6 || j === 7) {
                                    data.body[i][j] = data.body[i][j].toString().replace(/[.,]/g, '');
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
                            if (data == 1)
                                return '<span class="badge rounded-pill bg-primary">Tempo Aktif</span>';
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

                            var btn_show = '<a id="btn-penjualan-show" data-id="' + row.id +
                                '" data-row=\'' + row_data +
                                '\' class="btn btn-success btn-m" style="white-space: nowrap" show"><i class="fa fa-eye" aria-hidden="true"></i> Detail</a>';

                            return '<div style="white-space: nowrap;">' + btn_show + '</div>';
                        },
                    },
                ],
                columnDefs: [{
                    targets: [3, 4, 5, 6, 7, 9, 10],
                    searchable: false,
                    orderable: false
                }],
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
