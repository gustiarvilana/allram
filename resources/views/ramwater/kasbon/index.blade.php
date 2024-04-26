@extends('layouts.master')

@section('title')
    Data Kasbon
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-warning">
                <div class="card-header">
                    <a class="btn btn-success text-white" id="add_menu">Tambah Kasbon</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col table-responsive">
                            <table class="table table-striped table-inverse text-center field" id="table">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>nik</th>
                                        <th>tgl_kasbon</th>
                                        <th>jns_kasbon</th>
                                        <th>nota_penjualan</th>
                                        <th>nominal</th>
                                        <th>ket_kasbon</th>
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
    @include('ramwater.ops.form')
@endsection

@push('js')
    <script>
        let table;
        var url_add = '{{ route('ops.store') }}';
        var url_delete = '{{ route('ops.destroy', ['op' => ':id']) }}';
        var url_edit = '{{ route('ops.update', ['op' => ':id']) }}';

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
                        data: 'tgl_kasbon'
                    },
                    {
                        data: 'jns_kasbon'
                    },
                    {
                        data: 'nota_penjualan'
                    },
                    {
                        data: 'nominal'
                    },
                    {
                        data: 'ket_kasbon'
                    },
                    {
                        data: 'id',
                        render: function(data, type, row) {
                            var data = JSON.stringify(row);
                            return `
                            <div class="btn-group">
                                <button class="btn btn-sm btn-primary" id="user_menu-edit"  data-row='${data}' data-id='${row.id}' data-kd_menu='${row.kd_menu}' data-kd_parent='${row.kd_parent}' data-type='${row.type}' data-ur_menu_title='${row.ur_menu_title}' data-ur_menu_desc='${row.ur_menu_desc}' data-link_menu='${row.link_menu}' data-bg_color='${row.bg_color}' data-icon='${row.icon}' data-order='${row.order}' data-is_active='${row.is_active}'>Edit</button>
                                <button class="btn btn-sm btn-danger" id="user_menu-delete"  data-row='${data}' data-id='${row.id}' data-kd_menu='${row.kd_menu}' data-kd_parent='${row.kd_parent}' data-type='${row.type}' data-ur_menu_title='${row.ur_menu_title}' data-ur_menu_desc='${row.ur_menu_desc}' data-link_menu='${row.link_menu}' data-bg_color='${row.bg_color}' data-icon='${row.icon}' data-order='${row.order}' data-is_active='${row.is_active}'>Delete</button>
                            </div>
                        `;
                        }
                    }
                ],
                columnDefs: [{
                    targets: [2, 5, 6, 7, 8, 9, 10],
                    searchable: false,
                    orderable: false
                }],
                initComplete: function() {
                    initializeColumnSearch(this);
                    setupHoverShapes(this, 9);
                }
            });

            $('.modal').on('hidden.bs.modal', function() {
                $('#modal-form form')[0].reset();
                $('.select2').val('').trigger('change');
            });

            $('body').on('click', '#add_menu', function() {
                $('#modal-form').modal('show');
                $('#modal-form .modal-title').text('Tambah Ops');
            }).on('click', '#ops-add', function() {
                var imageFile = $('#path_file')[0].files[0];
                var data = {
                    id: $('form #id').val(),
                    tanggal: $('form #tanggal').val(),
                    satker: $('form #satker').val(),
                    nik: $('form #nik').val(),
                    kd_ops: $('form #kd_ops').val(),
                    jumlah: $('form #jumlah').val(),
                    harga: $('form #harga').val(),
                    total: $('form #total').val(),
                    keterangan: $('form #keterangan').val(),
                };

                var formData = new FormData();
                formData.append('_token', getCSRFToken());
                formData.append('path_file', imageFile);
                formData.append('data', JSON.stringify(data));

                $.ajax({
                    url: url_add,
                    method: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses!',
                                text: response.message,
                            });
                            $('.close').click();
                            table.ajax.reload();
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

            }).on('click', '#user_menu-edit', function() {
                var data_json = $(this).attr('data-row');
                var data = JSON.parse(data_json);

                $('#modal-form form')[0].reset();

                $('#modal-form [name=id]').val(data.id);
                $('#modal-form [name=tanggal]').val(data.tanggal);
                $('#modal-form [name=satker]').val(data.satker);
                $('#modal-form [name=nik]').val(data.nik).trigger("change");
                $('#modal-form [name=kd_ops]').val(data.kd_ops).trigger("change");
                $('#modal-form [name=jumlah]').val(addCommas(data.jumlah));
                $('#modal-form [name=harga]').val(addCommas(data.harga));
                $('#modal-form [name=total]').val(addCommas(data.total));
                $('#modal-form [name=keterangan]').val(data.keterangan);

                $('#modal-form .modal-title').text('Edit Ops');
                $('#modal-form').modal('show');
            }).on('click', '#user_menu-delete', function() {
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
                            $('.close').click();
                            table.ajax.reload();
                        },
                        error: function(errors) {
                            alert('Gagal Hapus data!');
                            return;
                        }
                    });
                }

            });
        });

        // function validate() {
        //     $('#modal-form').on('submit', function(e) {
        //         if (!e.preventDefault()) {
        //             $.ajax({
        //                 type: "POST",
        //                 url: $('#modal-form form').attr('action'),
        //                 data: $('#modal-form form').serialize(),
        //                 success: function(result) {
        //                     if (result.errors) {
        //                         $('.alert-danger').html('');

        //                         $.each(result.errors, function(key, value) {
        //                             $('.alert-danger').show();
        //                             $('.alert-danger').append('<li>' + value +
        //                                 '</li>');
        //                         });
        //                     } else {
        //                         $('#modal-form').modal('hide');
        //                         $('#table').DataTable().ajax.reload()
        //                     }
        //                 },
        //                 error: function(jqXHR, exception, request, status, error) {
        //                     var msg = ''
        //                     if (jqXHR.status === 0) {
        //                         msg = 'Not connect.\n Verify Network.';
        //                     } else if (jqXHR.status == 404) {
        //                         msg = 'Requested page not found. [404]';
        //                     } else if (jqXHR.status == 422666) {
        //                         msg = 'The given data was invalid.. [422]';
        //                     } else if (jqXHR.status == 500) {
        //                         msg = 'Internal Server Error [500].';
        //                     } else if (exception === 'parsererror') {
        //                         msg = 'Requested JSON parse failed.';
        //                     } else if (exception === 'timeout') {
        //                         msg = 'Time out error.';
        //                     } else if (exception === 'abort') {
        //                         msg = 'Ajax request aborted.';
        //                     } else {
        //                         msg = 'Uncaught Error.\n' + jqXHR.responseText;
        //                     }
        //                     $('.alert-danger').show();
        //                     $('.alert-danger').html(msg);
        //                     setTimeout(() => {
        //                         $('.alert-danger').hide();
        //                         $('.alert-danger').html('');
        //                     }, 5000);
        //                 },
        //             })
        //         }
        //     })
        // };
    </script>
@endpush
