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
                            <label>Pilih Karyawan:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                    </span>
                                </div>
                                <select name="nik" id="nik" class="form-control">
                                    <option value="">Pilih Sales</option>
                                    @foreach ($karyawans as $karyawan)
                                        <option value="{{ $karyawan->nik }}">{{ $karyawan->nama }}</option>
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
                                                {{-- <th width="5%">No</th> --}}
                                                <th>nik</th>
                                                <th>tgl_kasbon</th>
                                                <th>jns_kasbon</th>
                                                <th>nota_penjualan</th>
                                                <th>nominal</th>
                                                <th>ket_kasbon</th>
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

    @include('ramwater.kasbon.modal-show')
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
            }).on("click", "#btn-penjualan-show", function() {
                var rowData = $(this).data('row');

                var formData = $('#form-cari').serializeArray();
                var cari = {};
                $.each(formData, function(index, field) {
                    cari[field.name] = field.value;
                });

                var tableDetail = $("#modal-show-detail").DataTable({
                    info: false,
                    paging: false,
                    bPaginate: false,
                    bLengthChange: false,
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    bDestroy: true,
                    ajax: {
                        url: '{{ route('kasbon.laporan.data') }}',
                        type: 'GET',
                        data: {
                            jns: 'detail',
                            data: cari,
                        }
                    },
                    dom: 'Brtip',
                    buttons: [
                        'copy', 'excel', 'pdf'
                    ],
                    columns: [
                        // {
                        //     data: 'DT_RowIndex',
                        //     searchable: false,
                        //     shrotable: false
                        // },

                        {
                            data: 'nik',
                            render: function(data, type, row) {
                                console.log(row);
                                return data;
                            }
                        },
                        {
                            data: 'tgl_kasbon',
                            render: function(data, type, row) {
                                return data;
                            }
                        },
                        {
                            data: 'jns_kasbon',
                            render: function(data, type, row) {
                                return data;
                            }
                        },
                        {
                            data: 'nota_penjualan',
                            render: function(data, type, row) {
                                return data;
                            }
                        },
                        {
                            data: 'sum_nominal',
                            render: function(data, type, row) {
                                return data;
                            }
                        },
                        {
                            data: 'ket_kasbon',
                            render: function(data, type, row) {
                                return data;
                            }
                        },

                        {
                            data: 'id',
                            render: function(data, type, row) {
                                var row_data = JSON.stringify(row);

                                var btn_show = '<a id="btn-penjualan-show" data-id="' + row
                                    .id +
                                    '" data-row=\'' + row_data +
                                    '\' class="btn btn-success btn-xs" style="white-space: nowrap" show"><i class="fa fa-eye" aria-hidden="true"></i> Lihat</a>';

                                var btn_edit = '<a id="btn-penjualan-edit" data-id="' + row
                                    .id +
                                    '" data-row=\'' + row_data +
                                    '\' class="btn btn-primary btn-xs" style="white-space: nowrap" edit"><i class="fas fa-pencil-alt"></i> Edit</a>';

                                var btn_delete = '<a id="btn-penjualan-delete" data-id="' +
                                    row.id +
                                    '" data-row=\'' + row_data +
                                    '\' class="btn btn-danger btn-xs" style="white-space: nowrap;" delete"><i class="fas fa-trash-alt"> Hapus</a>';

                                // You can customize the buttons as needed

                                return '<div style="white-space: nowrap;">' + btn_show +
                                    '</div>';
                            },
                        },
                    ],
                    columnDefs: [{
                            targets: [0, 5],
                            searchable: false,
                            orderable: false
                        },
                        {
                            targets: [5],
                            className: 'text-right'
                        }
                    ],
                    footerCallback: function(row, data, start, end, display) {
                        var api = this.api();

                        // Menghitung total sum kolom harga_total
                        var hargaTotalTotal = api.column(4, {
                            page: 'current'
                        }).data().reduce(function(acc, curr) {
                            return acc + parseFloat(curr);
                        }, 0);

                        // Menampilkan total sum di footer
                        $(api.column(4).footer()).html(addCommas(hargaTotalTotal));
                    }
                });

                $('#penjualan-show #modal-title').text('penjualan Detail')
                $('#penjualan-show #modal-header').text('No Nota: ' + rowData.nota_penjualan)
                $('#penjualan-show').modal('show')
            }).on("click", "#btn-cari", function() {
                cariLaporan()
            });
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
                    url: '{{ route('kasbon.laporan.data') }}',
                    type: 'GET',
                    data: cari
                },
                dom: 'Brtip',
                buttons: [
                    'copy', 'excel', 'pdf'
                ],
                columns: [
                    // {
                    //     data: 'DT_RowIndex',
                    //     searchable: false,
                    //     shrotable: false
                    // },

                    {
                        data: 'nik',
                        render: function(data, type, row) {
                            console.log(row);
                            return data;
                        }
                    },
                    {
                        data: 'tgl_kasbon',
                        render: function(data, type, row) {
                            return data;
                        }
                    },
                    {
                        data: 'jns_kasbon',
                        render: function(data, type, row) {
                            return data;
                        }
                    },
                    {
                        data: 'nota_penjualan',
                        render: function(data, type, row) {
                            return data;
                        }
                    },
                    {
                        data: 'sum_nominal',
                        render: function(data, type, row) {
                            return data;
                        }
                    },
                    {
                        data: 'ket_kasbon',
                        render: function(data, type, row) {
                            return data;
                        }
                    },

                    {
                        data: 'id',
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
                        targets: [0, 5],
                        searchable: false,
                        orderable: false
                    },
                    {
                        targets: [5],
                        className: 'text-right'
                    }
                ],
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();

                    // Menghitung total sum kolom harga_total
                    var hargaTotalTotal = api.column(4, {
                        page: 'current'
                    }).data().reduce(function(acc, curr) {
                        return acc + parseFloat(curr);
                    }, 0);

                    // Menampilkan total sum di footer
                    $(api.column(4).footer()).html(addCommas(hargaTotalTotal));
                }
            });
        }
    </script>
@endpush
