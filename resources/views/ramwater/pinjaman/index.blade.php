@extends('layouts.master')

@section('title')
    Pinjaman
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-warning">
                <div class="card-header">
                    <a class="btn btn-success btn-xs text-white" id="add_menu">Tambah Pinjaman</a>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-4 text-center">
                            <div class="form-group">
                                <label for="">Tanggal Pinjaman</label>
                            </div>
                            <input type="date" name="tanggal" id="tanggal" class="form-control"
                                value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mx-5">
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="pinjaman-history">
                                <label class="custom-control-label" for="pinjaman-history">Riwayat Pembayaran</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col table-responsive">
                        <table class="table table-striped table-inverse text-center" id="table">
                            <thead class="thead-inverse">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>tanggal</th>
                                    <th>nik</th>
                                    <th>jumlah</th>
                                    <th>jml_angs</th>
                                    <th>Bayar Akhir</th>
                                    <th>Tgl Bayar</th>
                                    <th>catatan</th>
                                    <th width="15%"><i class="fa fa-cogs" aria-hidden="true"></i></th>
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
    @include('ramwater.pinjaman.form')
@endsection

@push('js')
    <script>
        let table;
        var url_add = '{{ route('pinjaman.store') }}';
        var url_delete = '{{ route('pinjaman.destroy', ['pinjaman' => ':id']) }}';
        var url_edit = '{{ route('pinjaman.update', ['pinjaman' => ':id']) }}';
        var tanggal = $('#tanggal').val();
        var riwayat = 0;

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
                    url: '{{ route('pinjaman.data') }}',
                    data: function(d) {
                        d.tanggal = tanggal;
                        d.riwayat = riwayat;
                    }
                },
                "columns": [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        shrotable: false
                    },
                    {
                        data: 'tanggal'
                    },
                    {
                        data: 'nik',
                        render: function(data, type, row) {

                            return row.nama;
                        }
                    },
                    {
                        data: 'jumlah',
                    },
                    {
                        data: 'jml_angs',
                    },
                    {
                        data: 'bayar',
                        render: function(data, type, row) {

                            return formatRupiah(row.byr_akhir);
                        }
                    },
                    {
                        data: 'tgl_byr'
                    },
                    {
                        data: 'catatan',
                        render: function(data, type, row) {
                            return row.catatan_akhir;
                        }
                    },
                    {
                        data: 'id',
                        render: function(data, type, row) {
                            return `
                            <div class="btn-group">
                                <button class="btn btn-sm btn-primary" id="pinjaman-edit" data-id='${row.id}' data-id_parent='${row.id_parent}' data-tanggal='${row.tanggal}' data-satker='${row.satker}' data-nik='${row.nik}' data-jumlah='${row.jumlah}' data-sisa='${row.sisa}' data-jml_angs='${row.jml_angs}' data-bayar='${row.bayar}' data-catatan='${row.catatan} data-catatan_akhir='${row.catatan_akhir}' >Edit</button>
                                <button class="btn btn-sm btn-warning" id="pinjaman-bayar" data-id='${row.id}' data-id_parent='${row.id_parent}' data-tanggal='${row.tanggal}' data-satker='${row.satker}' data-nik='${row.nik}' data-jumlah='${row.jumlah}' data-sisa='${row.sisa}' data-jml_angs='${row.jml_angs}' data-bayar='${row.bayar}' data-catatan='${row.catatan} data-catatan_akhir='${row.catatan_akhir}' >Bayar</button>
                                <button class="btn btn-sm btn-danger" id="pinjaman-delete" data-id='${row.id}' data-id_parent='${row.id_parent}' data-tanggal='${row.tanggal}' data-satker='${row.satker}' data-nik='${row.nik}' data-jumlah='${row.jumlah}' data-sisa='${row.sisa}' data-jml_angs='${row.jml_angs}' data-bayar='${row.bayar}' data-catatan='${row.catatan} data-catatan_akhir='${row.catatan_akhir}' >Delete</button>
                            </div>
                        `;
                        }
                    }
                ],
                columnDefs: [{
                        targets: 3,
                        className: 'dt-body-right',
                        render: $.fn.dataTable.render.number('.', '.', 0, '')
                    },
                    {
                        targets: 4,
                        className: 'dt-body-right',
                        render: $.fn.dataTable.render.number('.', '.', 0, '')
                    },
                ],
            });
            validate()

            $('#tanggal').on('change', function() {
                tanggal = $('#tanggal').val();
                table.ajax.reload();
            })

            $('body').on('click', '#pinjaman-history', function() {
                if ($('#pinjaman-history').prop('checked')) {
                    riwayat = 1;
                    table.ajax.reload();
                } else {
                    riwayat = 0;
                    table.ajax.reload();
                }
            });

            $('body').on('click', '#add_menu', function() {
                $('#modal-pinjaman').modal('show');
                $('#modal-pinjaman .modal-title').text('Tambah Datang');

                $('#modal-pinjaman form')[0].reset();
                $('#modal-pinjaman form').attr('action', url_add);
                $('#modal-pinjaman [name=_method]').val('post');
                $('#modal-pinjaman #bayar').hide();
            }).on('click', '#pinjaman-edit', function() {
                var id = $(this).data('id');
                url_edit = url_edit.replace(':id', id);
                var tanggal = $(this).attr('data-tanggal').toString();
                var tgl = tanggal.replace(/(\d{4})(\d{2})(\d{2})/, "$1-$2-$3");

                $('#modal-pinjaman').modal('show');
                $('#modal-pinjaman .modal-title').text('Edit Pinjaman');

                $('#modal-pinjaman form')[0].reset();
                $('#modal-pinjaman form').attr('action', url_edit);
                $('#modal-pinjaman [name=_method]').val('put');

                $('#modal-pinjaman [name=id]').val($(this).data('id'));
                $('#modal-pinjaman [name=id_parent]').val($(this).data('id_parent'));
                $('#modal-pinjaman [name=tanggal]').val(tgl);
                $('#modal-pinjaman [name=satker]').val($(this).data('satker'));
                $('#modal-pinjaman [name=nik]').val($(this).data('nik'));
                $('#modal-pinjaman [name=jml_angs]').val($(this).data('jml_angs'));
                $('#modal-pinjaman [name=jumlah]').val($(this).data('jumlah'));
                $('#modal-pinjaman [name=bayar]').val($(this).data('bayar'));
                $('#modal-pinjaman [name=catatan]').val($(this).data('catatan'));

            }).on('click', '#pinjaman-bayar', function() {
                var id = $(this).data('id');
                url_edit = url_edit.replace(':id', id);
                var tanggal = $(this).attr('data-tanggal').toString();
                var tgl = tanggal.replace(/(\d{4})(\d{2})(\d{2})/, "$1-$2-$3");

                if (id != $(this).data('id_parent')) {
                    alert('Matikan History terlebih dahulu');
                    return;
                }
                $('#modal-pinjaman').modal('show');
                $('#modal-pinjaman .modal-title').text('Pinjaman Bayar');

                $('#modal-pinjaman form')[0].reset();
                $('#modal-pinjaman form').attr('action', url_edit);
                $('#modal-pinjaman [name=_method]').val('put');

                $('#modal-pinjaman [name=id_parent]').val($(this).data('id'));
                $('#modal-pinjaman [name=tanggal]').val(tgl);
                $('#modal-pinjaman [name=satker]').val($(this).data('satker'));
                $('#modal-pinjaman [name=nik]').val($(this).data('nik'));
                $('#modal-pinjaman [name=jml_angs]').val($(this).data('jml_angs'));
                $('#modal-pinjaman [name=jumlah]').val($(this).data('sisa'));
                $('#modal-pinjaman [name=bayar]').val($(this).data('bayar'));
                $('#modal-pinjaman [name=catatan]').val($(this).data('catatan_akhir'));

            }).on('click', '#pinjaman-delete', function() {
                var id = $(this).data('id');
                url_delete = url_delete.replace(':id', id);
                if (confirm('Yakin akan menghapus data terpilih?')) {
                    $.ajax({
                        url: url_delete,
                        type: 'DELETE',
                        data: {
                            _token: $('[name=csrf-token]').attr('content')
                        },
                        success: function(response) {
                            $('#table').DataTable().ajax.reload();
                        },
                        error: function(errors) {
                            alert('Gagal Hapus data!');
                            return;
                        }
                    });
                }

            });
        });

        function validate() {
            $('#modal-pinjaman').on('submit', function(e) {
                if (!e.preventDefault()) {
                    $.ajax({
                        type: "POST",
                        url: $('#modal-pinjaman form').attr('action'),
                        data: $('#modal-pinjaman form').serialize(),
                        success: function(result) {
                            if (result.errors) {
                                $('.alert-danger').html('');

                                $.each(result.errors, function(key, value) {
                                    $('.alert-danger').show();
                                    $('.alert-danger').append('<li>' + value +
                                        '</li>');
                                });
                            } else {
                                $('#modal-pinjaman').modal('hide');
                                $('#table').DataTable().ajax.reload()
                            }
                        },
                        error: function(jqXHR, exception, request, status, error) {
                            var msg = ''
                            if (jqXHR.status === 0) {
                                msg = 'Not connect.\n Verify Network.';
                            } else if (jqXHR.status == 404) {
                                msg = 'Requested page not found. [404]';
                            } else if (jqXHR.status == 422666) {
                                msg = 'The given data was invalid.. [422]';
                            } else if (jqXHR.status == 500) {
                                msg = 'Internal Server Error [500].';
                            } else if (exception === 'parsererror') {
                                msg = 'Requested JSON parse failed.';
                            } else if (exception === 'timeout') {
                                msg = 'Time out error.';
                            } else if (exception === 'abort') {
                                msg = 'Ajax request aborted.';
                            } else {
                                msg = 'Uncaught Error.\n' + jqXHR.responseText;
                            }
                            $('.alert-danger').show();
                            $('.alert-danger').html(msg);
                            setTimeout(() => {
                                $('.alert-danger').hide();
                                $('.alert-danger').html('');
                            }, 5000);
                        },
                    })
                }
            })
        };
    </script>
@endpush
