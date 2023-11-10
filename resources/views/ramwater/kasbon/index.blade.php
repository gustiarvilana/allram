@extends('layouts.master')

@section('title')
    Kasbon
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-warning">
                <div class="card-header">
                    <a class="btn btn-success btn-xs" id="add_menu">Tambah Barang</a>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-4 text-center">
                            <div class="form-group">
                                <label for="">Tanggal Kasbon</label>
                            </div>
                            <input type="date" name="tanggal" id="tanggal" class="form-control"
                                value="{{ date('Y-m-d') }}">
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
                                    <th>Bayar Akhir</th>
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
    @include('ramwater.kasbon.form')
@endsection

@push('js')
    <script>
        let table;
        var url_add = '{{ route('kasbon.store') }}';
        var url_delete = '{{ route('kasbon.destroy', ['kasbon' => ':id']) }}';
        var url_edit = '{{ route('kasbon.update', ['kasbon' => ':id']) }}';
        var tanggal = $('#tanggal').val();

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
                    url: '{{ route('kasbon.data') }}',
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
                        data: 'bayar',
                        render: function(data, type, row) {

                            return formatRupiah(row.byr_akhir);
                        }
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
                                <button class="btn btn-sm btn-primary" id="kasbon-edit" data-id='${row.id}' data-tanggal='${row.tanggal}' data-satker='${row.satker}' data-nik='${row.nik}' data-jumlah='${row.jumlah}' data-bayar='${row.bayar}' data-catatan='${row.catatan}' >Edit</button>
                                <button class="btn btn-sm btn-danger" id="kasbon-delete" data-id='${row.id}' data-tanggal='${row.tanggal}' data-satker='${row.satker}' data-nik='${row.nik}' data-jumlah='${row.jumlah}' data-bayar='${row.bayar}' data-catatan='${row.catatan}' >Delete</button>
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

            $('body').on('click', '#add_menu', function() {
                $('#modal-kasbon').modal('show');
                $('#modal-kasbon .modal-title').text('Tambah Datang');

                $('#modal-kasbon form')[0].reset();
                $('#modal-kasbon form').attr('action', url_add);
                $('#modal-kasbon [name=_method]').val('post');
            }).on('click', '#kasbon-edit', function() {
                var id = $(this).data('id');
                url_edit = url_edit.replace(':id', id);
                var tanggal = $(this).attr('data-tanggal').toString();
                var tgl = tanggal.replace(/(\d{4})(\d{2})(\d{2})/, "$1-$2-$3");
                console.log(tgl);


                $('#modal-kasbon').modal('show');
                $('#modal-kasbon .modal-title').text('Edit Datang');

                $('#modal-kasbon form')[0].reset();
                $('#modal-kasbon form').attr('action', url_edit);
                $('#modal-kasbon [name=_method]').val('put');

                $('#modal-kasbon [name=id]').val($(this).data('id'));
                $('#modal-kasbon [name=tanggal]').val(tgl);
                $('#modal-kasbon [name=satker]').val($(this).data('satker'));
                $('#modal-kasbon [name=nik]').val($(this).data('nik'));
                $('#modal-kasbon [name=jumlah]').val($(this).data('jumlah'));
                $('#modal-kasbon [name=bayar]').val($(this).data('bayar'));
                $('#modal-kasbon [name=catatan]').val($(this).data('catatan'));

            }).on('click', '#kasbon-delete', function() {
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
            $('#modal-kasbon').on('submit', function(e) {
                if (!e.preventDefault()) {
                    $.ajax({
                        type: "POST",
                        url: $('#modal-kasbon form').attr('action'),
                        data: $('#modal-kasbon form').serialize(),
                        success: function(result) {
                            if (result.errors) {
                                $('.alert-danger').html('');

                                $.each(result.errors, function(key, value) {
                                    $('.alert-danger').show();
                                    $('.alert-danger').append('<li>' + value +
                                        '</li>');
                                });
                            } else {
                                $('#modal-kasbon').modal('hide');
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
