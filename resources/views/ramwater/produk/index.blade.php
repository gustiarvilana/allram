@extends('layouts.master')

@section('title')
    Data Produk
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-warning">
                <div class="card-header">
                    <a class="btn btn-success text-white" id="add_menu">Tambah Produk</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col table-responsive">
                            <table class="table table-striped table-inverse text-center field" id="table">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>nama</th>
                                        <th>merek</th>
                                        <th>type</th>
                                        <th>kd_supplier</th>
                                        <th>Stok Gudang 1</th>
                                        <th>Stok Gudang 2</th>
                                        <th>Total Stok</th>
                                        <th>OPS</th>
                                        <th>harga_beli</th>
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
    @include('ramwater.produk.form')
    @include('ramwater.produk.form-harga')
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
                "lengthChange": true,
                "autoWidth": true,
                "searching": true,
                "ordering": true,
                "ajax": {
                    url: '{{ route('produk.data') }}',
                    data: function(d) {
                        d.satker = 'ramwater'
                    }
                },
                "columns": [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        shrotable: false
                    },
                    {
                        data: 'nama',
                        render: function(data, type, row) {
                            return '<div style="white-space: nowrap;">' + data + '</div>';
                        }
                    },
                    {
                        data: 'merek'
                    },
                    {
                        data: 'type'
                    },
                    {
                        data: 'kd_supplier'
                    },
                    {
                        data: 'stok_gudang_1'
                    },
                    {
                        data: 'stok_gudang_2'
                    },
                    {
                        data: 'stok_all'
                    },
                    {
                        data: 'kd_ops'
                    },
                    {
                        data: 'harga_beli',
                        render: function(data, type, row) {
                            return addCommas(data);
                        }
                    },
                    {
                        data: 'id',
                        render: function(data, type, row) {
                            var data = JSON.stringify(row);
                            return `
                            <div class="btn-group">
                                <button class="btn btn-sm btn-success" id="harga_jual"  data-row='${data}' data-id='${row.id}' data-kd_menu='${row.kd_menu}' data-kd_parent='${row.kd_parent}' data-type='${row.type}' data-ur_menu_title='${row.ur_menu_title}' data-ur_menu_desc='${row.ur_menu_desc}' data-link_menu='${row.link_menu}' data-bg_color='${row.bg_color}' data-icon='${row.icon}' data-order='${row.order}' data-is_active='${row.is_active}'> Harga Jual</button>
                                <button class="btn btn-sm btn-primary" id="user_menu-edit"  data-row='${data}' data-id='${row.id}' data-kd_menu='${row.kd_menu}' data-kd_parent='${row.kd_parent}' data-type='${row.type}' data-ur_menu_title='${row.ur_menu_title}' data-ur_menu_desc='${row.ur_menu_desc}' data-link_menu='${row.link_menu}' data-bg_color='${row.bg_color}' data-icon='${row.icon}' data-order='${row.order}' data-is_active='${row.is_active}'> Edit</button>
                                <button class="btn btn-sm btn-danger" id="user_menu-delete"  data-row='${data}' data-id='${row.id}' data-kd_menu='${row.kd_menu}' data-kd_parent='${row.kd_parent}' data-type='${row.type}' data-ur_menu_title='${row.ur_menu_title}' data-ur_menu_desc='${row.ur_menu_desc}' data-link_menu='${row.link_menu}' data-bg_color='${row.bg_color}' data-icon='${row.icon}' data-order='${row.order}' data-is_active='${row.is_active}'> Delete</button>
                            </div>
                        `;
                        }
                    }
                ],
                // columnDefs: [{
                //     targets: [2, 5, 6, 7, 8, 9, 10],
                //     searchable: false,
                //     orderable: false
                // }],
                // initComplete: function() {
                //     initializeColumnSearch(this);
                //     setupHoverShapes(this, 9);
                // }
            });

            $('.modal').on('hidden.bs.modal', function() {
                $('#modal-form form')[0].reset();
                $('.select2').val('').trigger('change');
            });

            $('body').on('click', '#add_menu', function() {
                $('#modal-form').modal('show');
                $('#modal-form .modal-title').text('Tambah Ops');
            }).on('click', '#user_menu-edit', function() {
                var data_json = $(this).attr('data-row');
                var data = JSON.parse(data_json);

                $('#modal-form form')[0].reset();

                $('#modal-form [name=id]').val(data.id);
                $('#modal-form [name=kd_produk]').val(data.kd_produk);
                $('#modal-form [name=nama]').val(data.nama);
                $('#modal-form [name=merek]').val(data.merek);
                $('#modal-form [name=type]').val(data.type);
                $('#modal-form [name=kd_supplier]').val(data.kd_supplier);
                $('#modal-form [name=kd_ops]').val(data.kd_ops);
                $('#modal-form [name=harga_beli]').val(data.harga_beli);

                $('#modal-form .modal-title').text('Edit Produk');
                $('#modal-form').modal('show');
            }).on('click', '#user_menu-delete', function() {
                var id = $(this).data('id');
                var url_delete = "{{ route('produk.destroy', ['produk' => ':id']) }}".replace(':id',
                    id);

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

            }).on('click', '#simpan', function() {
                var formData = new FormData($('#form-produk')[0]);
                var input = Object.fromEntries(formData);
                $.ajax({
                    processData: false,
                    contentType: false,
                    url: '{{ route('produk.store') }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses!',
                                text: response.message,
                            });
                            $('.close').click()
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
            });

            $('body').on('click', '#harga_jual', function() {
                $('#modal-form-harga').modal('show');
                $('#modal-form-harga .modal-title').text('Harga jual');
            })
        });
    </script>
@endpush
