@extends('layouts.master')

@section('title')
    Monitoring
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info">
                <div class="card-header">
                    {{--  --}}
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-4 text-center">
                            <!-- Date range -->
                            <div class="form-group">
                                <label>Date range:</label>

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="far fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control float-right" id="daterange">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col table-responsive">
                        <table class="table table-striped table-bordered table-inverse text-center" id="table">
                            <thead class="thead-inverse">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>NIK</th>
                                    <th>Karyawan</th>
                                    <th>Jabatan</th>
                                    <th>jml Penjualan</th>
                                    <th>Ins Penjualan</th>
                                    <th>Pnj Member</th>
                                    <th>Ins Member</th>
                                    <th>Pot Kasbon</th>
                                    <th>Pot Pinjaman</th>
                                    <th>Total Pendapatan</th>
                                    <th width="10%"><i class="fa fa-cogs" aria-hidden="true"></i></th>
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
    @include('ramwater.kasbon.form')
@endsection

@push('js')
    <script>
        let table;
        let tanggal = $('#daterange').val();

        $(document).ready(function() {
            table = $("#table").DataTable({
                "dom": 'Bfrtip',
                "info": true,
                "processing": true,
                "responsive": false,
                "lengthChange": true,
                "autoWidth": true,
                "searching": true,
                "ordering": true,
                "buttons": [
                    // "copy",
                    // "csv",
                    // "excel",
                    // "pdf",
                    // "print",
                    // "colvis"
                ],
                "ajax": {
                    url: '{{ route('ramwater.dashboard.monitoring.monitoring_data') }}',
                    data: function(d) {
                        d.tanggal = tanggal;
                    }
                },
                "columns": [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        shrotable: false
                    },
                    {
                        data: 'nik'
                    },
                    {
                        data: 'nama'
                    },
                    {
                        data: 'jabatan'
                    },
                    {
                        data: 'jml_penjualan',
                        render: function(data, type, row) {
                            if (row.jabatan == 'Manager') {
                                return formatRupiah(row.glb_penjualan);
                            } else {
                                return formatRupiah(row.jml_penjualan);
                            }
                        }
                    },
                    {
                        data: 'ins_penjualan',
                        render: function(data, type, row) {
                            if (row.jabatan == 'Manager') {
                                return formatRupiah(row.glb_ins_penjualan);
                            } else {
                                return formatRupiah(row.ins_penjualan);
                            }
                        }
                    },
                    {
                        data: 'jml_member',
                    },
                    {
                        data: 'ins_member',
                    },
                    {
                        data: 'pot_kasbon'
                    },
                    {
                        data: 'pot_pinjaman'
                    },
                    {
                        data: 'total_pendapatan',
                    },

                    {
                        data: 'id',
                        render: function(data, type, row) {
                            return `
                            <div class="btn-group">
                                <button class="btn btn-sm btn-danger" id="kasbon-delete" data-id='${row.id}' data-id_parent='${row.id_parent}' data-tanggal='${row.tanggal}' data-satker='${row.satker}' data-nik='${row.nik}' data-jumlah='${row.jumlah}' data-sisa='${row.sisa}' data-bayar='${row.bayar}' data-catatan='${row.catatan}' data-catatan_akhir='${row.catatan_akhir}' >Print</button>
                            </div>
                        `;
                        }
                    }
                ],
                columnDefs: [{
                        targets: 4,
                        className: 'dt-body-right',
                        render: $.fn.dataTable.render.number('.', '.', 0, '')
                    },
                    {
                        targets: 5,
                        className: 'dt-body-right',
                        render: $.fn.dataTable.render.number('.', '.', 0, '')
                    },
                    {
                        targets: 6,
                        className: 'dt-body-right',
                        render: $.fn.dataTable.render.number('.', '.', 0, '')
                    },
                    {
                        targets: 7,
                        className: 'dt-body-right',
                        render: $.fn.dataTable.render.number('.', '.', 0, '')
                    },
                    {
                        targets: 8,
                        className: 'dt-body-right',
                        render: $.fn.dataTable.render.number('.', '.', 0, '')
                    },
                    {
                        targets: 9,
                        className: 'dt-body-right',
                        render: $.fn.dataTable.render.number('.', '.', 0, '')
                    },
                    {
                        targets: 10,
                        className: 'dt-body-right',
                        render: $.fn.dataTable.render.number('.', '.', 0, '')
                    },
                ],
            });
            $('#daterange').on('change', function() {
                tanggal = $('#daterange').val();
                table.ajax.reload();
            })
        });
    </script>
@endpush
