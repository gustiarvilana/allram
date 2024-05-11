@extends('layouts.master')

@section('title')
    Laporan OPS
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
                            <label>Pilih Kategori:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                    </span>
                                </div>
                                <select name="kd_jns_ops" class="form-control select2" style="width: 80%;">
                                    <option value="">Semua Kategori</option>
                                    @foreach ($jnsOpss as $jnsOps)
                                        <option value="{{ $jnsOps->kd_jns_ops }}">{{ $jnsOps->ur_jns_ops }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Ops:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-truck-loading    "></i>
                                    </span>
                                </div>
                                <select class="form-control select2" name="kd_ops" style="width: 80%;">
                                    <option value="">Semua Ops</option>
                                    @foreach ($opss as $ops)
                                        <option value="{{ $ops->kd_ops }}">{{ $ops->nama_ops }}</option>
                                    @endforeach
                                </select>
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
    <div class="row" id="tbl-ops" style="display: none">
        <div class="col-md-12">
            <div class="card card-warning">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col table-responsive">
                            <table class="table table-striped table-inverse text-center" id="table">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>tanggal</th>
                                        <th>Karyawan</th>
                                        <th>nama OPS</th>
                                        <th>total</th>
                                        <th>Tipe</th>
                                        <th>keterangan</th>
                                        <th>File</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot id="tfoot">
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
    @include('ramwater.ops.form')
@endsection

@push('js')
    <script>
        var url_add = '{{ route('ops.store') }}';
        var url_delete = '{{ route('ops.destroy', ['op' => ':id']) }}';
        var url_edit = '{{ route('ops.update', ['op' => ':id']) }}';

        $(document).ready(function() {
            $('.modal').on('hidden.bs.modal', function() {
                $('#modal-form form')[0].reset();
                $('.select2').val('').trigger('change');
            });

            $('body').on('click', '#add_menu', function() {
                $('#modal-form').modal('show');
                $('#modal-form .modal-title').text('Tambah Ops');
            }).on('click', '#ops-add', function() {
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
                formData.append('data', JSON.stringify(data));

                $.ajax({
                    url: url_add,
                    method: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(response) {
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

            }).on('click', '#btn-cari', function() {
                cariLaporan()
            });
        });

        function cariLaporan() {
            $('#tbl-ops').show();
            var formData = $('#form-cari').serializeArray();
            var cari = {};
            $.each(formData, function(index, field) {
                cari[field.name] = field.value;

                var table = $("#table").DataTable({
                    "dom": 'Bfrtip',
                    "paging": false,
                    "info": true,
                    "processing": true,
                    "responsive": false,
                    "lengthChange": true,
                    "autoWidth": true,
                    "searching": true,
                    "ordering": true,
                    "bDestroy": true,
                    buttons: [{
                        extend: 'excel',
                        customizeData: function(data) {
                            // Menghapus titik atau koma dari kolom nilai_rk, nilai_rpd, dan nilai_realisasi
                            for (var i = 0; i < data.body.length; i++) {
                                for (var j = 0; j < data.body[i].length; j++) {
                                    if (j === 4) {
                                        data.body[i][j] = data.body[i][j].toString().replace(
                                            /[.,]/g, '');
                                    }
                                }
                            }
                        }
                    }],
                    ajax: {
                        url: '{{ route('ops.data') }}',
                        type: 'GET',
                        data: cari
                    },
                    "columns": [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        shrotable: false
                    }, {
                        data: 'tanggal'
                    }, {
                        data: 'nama',
                        render: function(data, type, row) {
                            console.log(row);
                            var nama = data ? data : row.nik;
                            return addCommas(nama);
                        }
                    }, {
                        data: 'nama_ops'
                    }, {
                        data: 'total',
                        render: function(data, type, row) {
                            return addCommas(data);
                        }
                    }, {
                        data: 'tipe',
                        render: function(data, type, row) {
                            return data;
                        }
                    }, {
                        data: 'keterangan',
                        render: function(data, type, row) {
                            return data;
                            if (data.length > 20) {
                                return data.substr(0, 20) + '...';
                            } else {
                                return data;
                            }
                        }
                    }, {
                        data: 'path_file',
                        render: function(data, type, row) {
                            return '<a href="{{ asset('') }}' + row.path_file +
                                '" target="_blank" class="a">' +
                                '<img src="{{ asset('') }}' + row.path_file +
                                '" alt="File OPS" style="width: 100px;height: 50px;border-radius: 5px;">' +
                                '</a>';
                        }
                    }],
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

                        // Menyembunyikan footer jika filter kd_jenis tidak ada
                        if (cari['kd_jns_ops'] === undefined || cari['kd_jns_ops'] === null || cari[
                                'kd_jns_ops'] === '') {
                            $('#tfoot').hide();
                        } else {
                            $('#tfoot').show();
                        }
                    }
                });
            });
        }
    </script>
@endpush
