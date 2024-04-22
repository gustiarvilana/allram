@extends('layouts.master')

@section('title')
    <i class="fas fa-money-bill"></i> <b>Laporan Pembayaran Pembelian</b>
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
                                                <th>kd_supplier</th>
                                                <th>jns_pembelian</th>
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
                    <button type="button" class="close btn-add-pembayaran-close" id="btn-add-pembayaran-close">
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

                                        {{-- <div class="col d-flex flex-column align-items-center">
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
                                        </div> --}}

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
                                                        <th><i class="fa fa-cog" aria-hidden="true"></i></th>
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
                    <button class="btn btn-success btn-pembayaran-simpan" id="btn-pembayaran-simpan"><i
                            class="fas fa-save"></i>
                        Simpan</button>
                    <button class="btn btn-secondary" id="btn-add-pembayaran-close">Close</button>
                </div>
            </div>
        </div>
    </div>

    @include('ramwater.pembelian.modal-show')
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            var tableLaporanPembelian = $("#table-pembelian-laporan").DataTable({
                info: false,
                bPaginate: false,
                bLengthChange: false,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax: '{{ route('pembelian.detail.data') }}',
                dom: 'Brtip',
                buttons: [
                    'copy', 'excel', 'pdf'
                ],
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

                            var btn_edit = '<a id="btn-pembayaran-edit" data-id="' + row.id +
                                '" data-row=\'' + row_data +
                                '\' class="btn btn-success btn-xs" style="white-space: nowrap" edit"><i class="fas fa-pencil-alt"></i></a>';

                            return '<div style="white-space: nowrap;">' + btn_edit + '</div>';
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
        });

        function pembayaranDestroy(id) {
            var url = '{{ route('pembelian.pembayaran.destroy', ['id' => ':pembayaran']) }}';
            url = url.replace(':pembayaran', id);

            $.ajax({
                url: url,
                method: 'DELETE',
                processData: false,
                contentType: false,
                data: {
                    'id': id,
                },
                success: function(response) {
                    if (response.success) {
                        $("#table-pembelian-laporan").DataTable().ajax.reload();
                        $('#btn-add-pembayaran-close').click()
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
    </script>
@endpush
