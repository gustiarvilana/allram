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
                    <div class="row col-md-12 table-responsive mb-3">
                        <div class="card card-primary">
                            <div class="card-header card-success">
                                <span>Produk</span>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Uraian</th>
                                            <th>merek</th>
                                            <th>type</th>
                                            <th>stok_all</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="pembelian-uraian"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row col-md-12 table-responsive">
                        <div class="card card-primary">
                            <div class="card-header card-success">
                                <span>Produk</span>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped" id="table-produk">
                                    <thead>
                                        <tr>
                                            <th>nama</th>
                                            <th>merek</th>
                                            <th>type</th>
                                            <th>stok_all</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        </tr>
                                    </tbody>
                                </table>
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
        let table;

        $(document).ready(function() {
            // $("#modal-pembelian").modal("show");
            // $("#modal-pembelian-title").text("Tambah Data");

            table = $("#table-supplier").DataTable({
                info: false,
                bPaginate: false,
                bLengthChange: false,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ordering: false,
                ajax: '{{ route('pembelian.data') }}',
                order: [],
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
                                '\' class="btn btn-primary edit">Input</a>';

                            return btn_input;
                        },
                    },
                ],
                columnDefs: [{
                    targets: [4],
                    searchable: false
                }],
                initComplete: function() {
                    initializeColumnSearch(this);
                }

            });

            // table = $("#table").DataTable({
            //     "paging": true,
            //     "lengthChange": false,
            //     "searching": false,
            //     "ordering": true,
            //     "info": true,
            //     "autoWidth": false,
            //     "responsive": true,
            // });

            table = $("#table-produk").DataTable({
                info: false,
                bPaginate: false,
                bLengthChange: false,
            });

            $("body").on("click", "#btn-add-pembelian", function() { //add-pembelian
                $("#modal-pembelian-title").text("Tambah Data");
                $("#modal-pembelian").modal("show");
            }).on("click", ".btn-add-pembelian-close", function() { //close-pembelian
                $("#modal-pembelian").modal("hide");
                // $('#pembelian-uraian').empty();
            }).on("click", "#btn-penjualan-input", function() { //btn_input_click
                var rowData = $(this).data('row');
                var row = '<tr>' +
                    '<td> <a href="#" class="id_ur">' + rowData.nama + '</a> </td>' +
                    '<td>' + rowData.kd_supplier + '</td>' +
                    '<td>' +
                    '<input type="text" class="form-control" name="" id="" aria-describedby="helpId" placeholder="" value="' +
                    rowData.notlp + '">' +
                    '</td>' +
                    '<td>' +
                    '<input type="text" class="form-control" name="" id="" aria-describedby="helpId" placeholder="" value="' +
                    rowData.notlp + '">' +
                    '</td>' +
                    '<td>' +
                    '<input type="text" class="form-control" name="" id="" aria-describedby="helpId" placeholder="" value="' +
                    rowData.notlp + '">' +
                    '</td>' +
                    '</tr>';

                $('#pembelian-uraian').append(row);

                $("#modal-pembelian-title").text("Tambah Data");
                $("#modal-pembelian").modal("show");
            }).on("click", ".id_ur", function() { //hapus next row
                $(this).closest('tr').nextAll().remove();
            });
        });
    </script>
@endpush
