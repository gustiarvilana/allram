@extends('layouts.master')

@section('title')
    Data Kasbon
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-warning">
                <div class="card-header">
                    <a class="btn btn-success text-white" id="btn-add">Tambah Kasbon</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col table-responsive">
                            <table class="table table-striped table-inverse text-center field" id="table">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Karyawan</th>
                                        <th>tgl_kasbon</th>
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
    @include('ramwater.kasbon.form')
@endsection

@push('js')
    <script>
        let table;

        $(document).ready(function() {
            table = $("#table").DataTable({
                "dom": 'Bfrtip',
                "info": true,
                "processing": true,
                "responsive": false,
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
                        data: 'nama'
                    },
                    {
                        data: 'tgl_kasbon'
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
                            var disabled = row.jns_kasbon == 3 ? 'disabled' : '';
                            return `
                            <div class="btn-group">
                                <button class="btn btn-sm btn-primary" ${disabled} id="btn-edit"  data-row='${data}' data-id='${row.id}' data-kd_menu='${row.kd_menu}' data-kd_parent='${row.kd_parent}' data-type='${row.type}' data-ur_menu_title='${row.ur_menu_title}' data-ur_menu_desc='${row.ur_menu_desc}' data-link_menu='${row.link_menu}' data-bg_color='${row.bg_color}' data-icon='${row.icon}' data-order='${row.order}' data-is_active='${row.is_active}'>Edit</button>
                                <button class="btn btn-sm btn-danger" ${disabled} id="btn-hapus"  data-row='${data}' data-id='${row.id}' data-kd_menu='${row.kd_menu}' data-kd_parent='${row.kd_parent}' data-type='${row.type}' data-ur_menu_title='${row.ur_menu_title}' data-ur_menu_desc='${row.ur_menu_desc}' data-link_menu='${row.link_menu}' data-bg_color='${row.bg_color}' data-icon='${row.icon}' data-order='${row.order}' data-is_active='${row.is_active}'>Delete</button>
                            </div>
                        `;
                        }
                    }
                ],
                columnDefs: [{
                    targets: [1, 2, 3, 4, 5, 6, ],
                    searchable: false,
                    orderable: false
                }],
                initComplete: function() {
                    initializeColumnSearch(this);
                }
            });

            $('.modal').on('hidden.bs.modal', function() {
                $('#modal-form form')[0].reset();
                $('.select2').val('').trigger('change');
            });

            $('body').on('click', '#btn-add', function() {
                $('#modal-form').modal('show');
                $('#modal-form .modal-title').text('Tambah Kasbon');
            }).on('click', '#btn-edit', function() {
                var data_json = $(this).attr('data-row');
                var data = JSON.parse(data_json);

                $('#modal-form form')[0].reset();

                $('#modal-form [name=id]').val(data.id);
                $('#modal-form [name=tgl_kasbon]').val(data.tgl_kasbon);
                $('#modal-form [name=nik]').val(data.nik).trigger("change");
                $('#modal-form [name=jns_kasbon]').val(data.jns_kasbon);
                $('#modal-form [name=nominal]').val(data.nominal);
                $('#modal-form [name=ket_kasbon]').val(data.ket_kasbon);

                $('#modal-form .modal-title').text('Edit Kasbon');
                $('#modal-form').modal('show');
            }).on('click', '#btn-hapus', function() {
                var id = $(this).data('id');
                var url_delete =
                    '{{ route('kasbon.destroy', ['kasbon' => ':id']) }}'; // Menggunakan 'kasbon' sebagai parameter
                url_delete = url_delete.replace(':id', id);

                if (confirm('Yakin akan menghapus data terpilih?')) {
                    $.ajax({
                        url: url_delete,
                        type: 'DELETE',
                        data: {
                            _token: $('[name=csrf-token]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                $('.close').click();
                                table.ajax.reload();
                                Swal.fire('Terhapus!', 'Data berhasil dihapus.',
                                    'success');
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

            }).on('click', '#kasbon-simpan', function() {
                var url_store = '{{ route('kasbon.store') }}'
                var formData = $('#form-kasbon').serialize();

                var cleanedData = {};
                formData.split('&').forEach(pair => {
                    var [key, value] = pair.split('=').map(decodeURIComponent);
                    cleanedData[key] = value.trim();
                });

                $.ajax({
                    url: url_store,
                    type: 'POST',
                    data: {
                        data: cleanedData,
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses!',
                                text: response.message,
                            });
                            table.ajax.reload();
                            $('.close').click()
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

            });
        });
    </script>
@endpush
