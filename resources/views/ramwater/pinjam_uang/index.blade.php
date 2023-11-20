@extends('layouts.master')

@section('title')
    Pending Uang
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-warning">
                <div class="card-header">
                    <a class="btn btn-success btn-xs text-white" id="add_menu">Tambah Pinjam Uang</a>
                </div>
                <div class="card-body">
                </div>
                <div class="row">
                    <div class="col-md-4 mx-5">
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="pinjam-history">
                                <label class="custom-control-label" for="pinjam-history">Riwayat Pinjam</label>
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
                                    <th>nik Sales</th>
                                    <th>nama Konsumen</th>
                                    <th>alamat</th>
                                    <th>hp</th>
                                    <th>jumlah</th>
                                    <th>Bayar Akhir</th>
                                    <th>Tgl Bayar</th>
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
    @include('ramwater.pinjam_uang.form')
@endsection

@push('js')
    <script>
        let table;
        var url_add = '{{ route('hutang.store') }}';
        var url_delete = '{{ route('hutang.destroy', ['hutang' => ':id']) }}';
        var url_edit = '{{ route('hutang.update', ['hutang' => ':id']) }}';
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
                    url: '{{ route('hutang.data') }}',
                    data: function(d) {
                        // d.tanggal = tanggal;
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

                            return row.nama_karyawan;
                        }
                    },
                    {
                        data: 'nama',
                    },
                    {
                        data: 'alamat',
                    },
                    {
                        data: 'hp',
                    },
                    {
                        data: 'jumlah',
                    },
                    {
                        data: 'bayar',
                        render: function(data, type, row) {

                            return formatRupiah(row.byr_akhir);
                        }
                    },
                    {
                        data: 'tgl_byr',
                    },
                    {
                        data: 'id',
                        render: function(data, type, row) {
                            return `
                            <div class="btn-group">
                                <button class="btn btn-sm btn-primary" id="pinjam-edit" data-id='${row.id}' data-id_parent='${row.id_parent}' data-tanggal='${row.tanggal}' data-nik='${row.nik}' data-nama='${row.nama}' data-jumlah='${row.jumlah}' data-sisa='${row.sisa}' data-alamat='${row.alamat}' data-hp='${row.hp}' data-bayar='${row.bayar}' data-tgl_kembali='${row.tgl_kembali}' data-sts='${row.sts}'>Edit</button>
                                <button class="btn btn-sm btn-warning" id="pinjam-bayar" data-id='${row.id}' data-id_parent='${row.id_parent}' data-tanggal='${row.tanggal}' data-nik='${row.nik}' data-nama='${row.nama}' data-jumlah='${row.jumlah}' data-sisa='${row.sisa}' data-alamat='${row.alamat}' data-hp='${row.hp}' data-bayar='${row.bayar}' data-tgl_kembali='${row.tgl_kembali}' data-sts='${row.sts}'>Bayar</button>
                                <button class="btn btn-sm btn-danger" id="pinjam-delete" data-id='${row.id}' data-id_parent='${row.id_parent}' data-tanggal='${row.tanggal}' data-nik='${row.nik}' data-nama='${row.nama}' data-jumlah='${row.jumlah}' data-sisa='${row.sisa}' data-alamat='${row.alamat}' data-hp='${row.hp}' data-bayar='${row.bayar}' data-tgl_kembali='${row.tgl_kembali}' data-sts='${row.sts}'>Delete</button>
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

            $('body').on('click', '#pinjam-history', function() {
                if ($('#pinjam-history').prop('checked')) {
                    riwayat = 1;
                    table.ajax.reload();
                } else {
                    riwayat = 0;
                    table.ajax.reload();
                }
            });


            $('body').on('click', '#add_menu', function() {
                $('#modal-uang').modal('show');
                $('#modal-uang .modal-title').text('Tambah pinjam');

                $('#modal-uang form')[0].reset();
                $('#modal-uang form').attr('action', url_add);
                $('#modal-uang [name=_method]').val('post');
            }).on('click', '#pinjam-edit', function() {
                var id = $(this).data('id');
                url_edit = url_edit.replace(':id', id);
                var tanggal = $(this).attr('data-tanggal').toString();
                var tgl = tanggal.replace(/(\d{4})(\d{2})(\d{2})/, "$1-$2-$3");

                $('#modal-uang').modal('show');
                $('#modal-uang .modal-title').text('Edit Datang');

                $('#modal-uang form')[0].reset();
                $('#modal-uang form').attr('action', url_edit);
                $('#modal-uang [name=_method]').val('put');

                $('#modal-uang [name=id]').val($(this).data('id'));
                $('#modal-uang [name=id_parent]').val($(this).data('id_parent'));
                $('#modal-uang [name=tanggal]').val(tgl);
                $('#modal-uang [name=nik]').val($(this).data('nik'));
                $('#modal-uang [name=nama]').val($(this).data('nama'));
                $('#modal-uang [name=jumlah]').val($(this).data('jumlah'));
                $('#modal-uang [name=alamat]').val($(this).data('alamat'));
                $('#modal-uang [name=hp]').val($(this).data('hp'));
                $('#modal-uang [name=bayar]').val($(this).data('bayar'));
                $('#modal-uang [name=tgl_kembali]').val($(this).data('tgl_kembali'));
                $('#modal-uang [name=sts]').val($(this).data('sts'));

            }).on('click', '#pinjam-bayar', function() {
                var id = $(this).data('id');
                url_edit = url_edit.replace(':id', id);
                var tanggal = $(this).attr('data-tanggal').toString();
                var tgl = tanggal.replace(/(\d{4})(\d{2})(\d{2})/, "$1-$2-$3");
                console.log(tgl);
                if (id != $(this).data('id_parent')) {
                    alert('Matikan History terlebih dahulu');
                    return;
                }

                $('#modal-uang').modal('show');
                $('#modal-uang .modal-title').text('Edit Datang');

                $('#modal-uang form')[0].reset();
                $('#modal-uang form').attr('action', url_edit);
                $('#modal-uang [name=_method]').val('put');

                $('#modal-uang [name=id_parent]').val($(this).data('id'));
                $('#modal-uang [name=tanggal]').val(tgl);
                $('#modal-uang [name=nik]').val($(this).data('nik'));
                $('#modal-uang [name=nama]').val($(this).data('nama'));
                $('#modal-uang [name=jumlah]').val($(this).data('sisa'));
                $('#modal-uang [name=alamat]').val($(this).data('alamat'));
                $('#modal-uang [name=hp]').val($(this).data('hp'));
                $('#modal-uang [name=bayar]').val($(this).data('bayar'));
                $('#modal-uang [name=tgl_kembali]').val($(this).data('tgl_kembali'));
                $('#modal-uang [name=sts]').val($(this).data('sts'));

            }).on('click', '#pinjam-delete', function() {
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
            $('#modal-uang').on('submit', function(e) {
                if (!e.preventDefault()) {
                    $.ajax({
                        type: "POST",
                        url: $('#modal-uang form').attr('action'),
                        data: $('#modal-uang form').serialize(),
                        success: function(result) {
                            if (result.errors) {
                                $('.alert-danger').html('');

                                $.each(result.errors, function(key, value) {
                                    $('.alert-danger').show();
                                    $('.alert-danger').append('<li>' + value +
                                        '</li>');
                                });
                            } else {
                                $('#modal-uang').modal('hide');
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
