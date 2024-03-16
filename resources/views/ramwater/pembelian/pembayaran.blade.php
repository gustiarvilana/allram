@extends('layouts.master')

@section('title')
    <i class="fas fa-money-bill"></i> <b>Laporan Pembayaran</b>
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
                                <div class="col-md-12 table-responsive">
                                    <table class="table table-striped table-inverse text-center"
                                        id="table-pembelian-laporan">
                                        <thead>
                                            <tr>
                                                {{-- <th width="5%">No</th> --}}
                                                <th>Supplier</th>
                                                <th>nota_pembelian</th>
                                                <th>tgl_pembelian</th>
                                                <th>kd_supplier</th>
                                                <th>jns_pembelian</th>
                                                <th>harga_total</th>
                                                <th>nominal_bayar</th>
                                                <th>sisa_bayar</th>
                                                <th>sts_angsuran</th>
                                                <th>opr_input</th>
                                                <th>tgl_input</th>
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
    <div class="modal fade" id="modal-pembelian" data-backdrop="static" data-keyboard="false" tabindex="-1"
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
                                    <span>Upload Faktur</span>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col d-flex align-items-center justify-content-center">
                                            <div class="form-group">
                                                <label for="path_file">Upload Faktur</label>
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
                ajax: '{{ route('pembelian.laporan.data') }}',
                dom: 'Brtip',
                buttons: [
                    'copy', 'excel', 'pdf'
                ],
                columns: [
                    // {
                    //     data: 'DT_RowIndex'
                    // },
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
                        data: 'tgl_pembelian',
                        name: 'a.tgl_pembelian',
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
                        data: 'opr_input',
                        name: 'a.opr_input',
                        render: function(data, type, row) {
                            return data;
                        }
                    },
                    {
                        data: 'tgl_input',
                        name: 'a.tgl_input',
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
                    targets: [0, 5, 6, 7, 8, 9, 10, 11, 12],
                    searchable: false,
                    orderable: false
                }],
                initComplete: function() {
                    initializeColumnSearch(this);
                    setupHoverShapes(this, 11);
                }
            });

            $('#modal-pembelian').on('hidden.bs.modal', function() {
                console.log('Modal Pembelian telah disembunyikan');
                $("#modal-pembelian").modal("hide");
                $('#pembelian-uraian').empty();
                $('#table-detail-edit').empty();
                $('.path_file').val('');
            });

            $('body').on("click", "#btn-add-pembayaran", function() {
                $("##modal-pembayaran-title").text("Tambah Data");
                $("##modal-pembayaran").modal("show");
            }).on("click", "#btn-add-pembayaran-close", function() {
                $("#modal-pembelian").modal("hide");
                $('#pembelian-uraian').empty();
            }).on("click", "#btn-pembayaran-simpan", function() {
                var imageFile = $('#path_file')[0].files[0];

                var dataArrayDetail = [];
                $('#table-detail-edit tr').each(function() {

                    var rowData = {
                        id: $(this).find('#bayar_id').val(),
                        update: $(this).find('#bayar_update').val(),
                        nota_pembelian: $(this).find('#bayar_nota_pembelian').val(),
                        tgl_pembayaran: $(this).find('#bayar_tgl_pembayaran').val(),
                        angs_ke: $(this).find('#bayar_angs_ke').val(),
                        nominal_bayar: $(this).find('#bayar_nominal_bayar').val(),
                        channel_bayar: $(this).find('#bayar_channel_bayar').val(),
                        ket_bayar: $(this).find('#bayar_ket_bayar').val(),
                        path_file: $(this).find('#bayar_path_file').val(),

                    };
                    dataArrayDetail.push(rowData);

                });

                var pembelianData = {
                    id: $('#table-pembelian #ur_id').val(),
                    nota_pembelian: $('#table-pembelian #ur_nota_pembelian').val(),
                    tgl_pembelian: $('#table-pembelian #ur_tgl_pembelian').val(),
                    kd_supplier: $('#table-pembelian #ur_kd_supplier').val(),
                    jns_pembelian: $('#table-pembelian #ur_jns_pembelian').val(),
                    harga_total: $('#table-pembelian #ur_harga_total').val(),
                    nominal_bayar: $('#table-pembelian #ur_nominal_bayar').val(),
                    sisa_bayar: $('#table-pembelian #ur_sisa_bayar').val(),
                    sts_angsuran: $('#table-pembelian #ur_sts_angsuran').val(),
                    path_file: $('#path_file').val(),
                };
                var formData = new FormData();
                formData.append('_token', getCSRFToken());
                formData.append('path_file', imageFile);
                formData.append('dataArrayDetail', JSON.stringify(dataArrayDetail));
                formData.append('pembelianData', JSON.stringify(pembelianData));

                // formData.forEach(function(value, key) {
                //     console.log(key, value);
                // });

                $.ajax({
                    url: '{{ route('pembayaran.store') }}',
                    method: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            tableLaporanPembelian.ajax.reload();
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

            }).on("click", "#btn-pembayaran-edit", function() {
                var rowData = $(this).data('row');

                var row =
                    '<tr>' +
                    '<td>' +
                    '<input type="hidden" name="id" id="ur_id" value="' + rowData.id +
                    '" class="form-control" readonly>' +
                    '<input type="text" name="tgl_pembelian" id="ur_tgl_pembelian" value="' + rowData
                    .tgl_pembelian + '" class="form-control" readonly>' +
                    '</td>' +
                    '<td>' +
                    '<div style="white-space: nowrap;"><span style="font-size: 16px; font-weight: bold;">' +
                    rowData.nama + '</span></div>' +
                    '</td>' +
                    '<td><input type="text" name="nota_pembelian" id="ur_nota_pembelian" class="form-control" value="' +
                    rowData.nota_pembelian + '" readonly></td>' +
                    '<input type="hidden" name="kd_supplier" id="ur_kd_supplier" value="' +
                    rowData
                    .kd_supplier + '" class="form-control">' +
                    '<td>' +
                    '<select name="jns_pembelian" id="ur_jns_pembelian" class="form-control" disabled="true">' +
                    '<option value="" ></option>' +
                    '<option value="tunai" ' + (rowData.jns_pembelian === 'tunai' ? 'selected' :
                        '') +
                    '>Tunai</option>' +
                    '<option value="tempo" ' + (rowData.jns_pembelian === 'tempo' ? 'selected' :
                        '') +
                    '>Tempo</option>' +
                    '</select>' +
                    '</td>' +
                    '<td><input type="text" name="harga_total" id="ur_harga_total" class="form-control money" value="' +
                    addCommas(rowData.harga_total) + '" readonly></td>' +
                    '<td><input type="text" name="nominal_bayar" id="ur_nominal_bayar" class="form-control money" value="' +
                    addCommas(rowData.nominal_bayar) + '" readonly></td>' +
                    '<td><input type="text" name="sisa_bayar" id="ur_sisa_bayar" class="form-control money" value="' +
                    addCommas(rowData.sisa_bayar) + '" readonly></td>' +
                    '<td><input type="text" name="sts_angsuran" id="ur_sts_angsuran" class="form-control money" value="' +
                    addCommas(rowData.sts_angsuran) + '" readonly></td>' +
                    '</tr>';
                $('#pembelian-uraian').append(row);

                $.ajax({
                    url: '{{ route('pembayaran.data') }}?nota_pembelian=' + rowData.nota_pembelian,
                    method: 'GET',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Loop through each object in the response array
                        response.forEach(function(item, index) {
                            // Create a new row with input fields filled with data from the response
                            var row =
                                '<tr>' +
                                '<td>' + (index + 1) + '</td>' + // No column
                                '<input type="hidden" name="id" id="bayar_id" class="form-control money" value="' +
                                item.id + '" readonly>' +
                                '<input type="hidden" name="update" id="bayar_update" class="form-control money" value="" readonly>' +
                                '<td><input type="text" name="nota_pembelian" id="bayar_nota_pembelian" class="form-control money" value="' +
                                item.nota_pembelian + '" readonly></td>' +
                                '<td><input type="text" name="tgl_pembayaran" id="bayar_tgl_pembayaran" class="form-control money" value="' +
                                item.tgl + '" readonly></td>' +
                                '<td><input type="text" name="angs_ke" id="bayar_angs_ke" class="form-control money" value="' +
                                item.angs_ke + '" readonly></td>' +
                                '<td><input type="text" name="nominal_bayar" id="bayar_nominal_bayar" class="form-control money" value="' +
                                addCommas(item.nominal_bayar) + '" readonly></td>' +
                                '<td><input type="text" name="channel_bayar" id="bayar_channel_bayar" class="form-control money" value="' +
                                item.channel_bayar + '" readonly></td>' +
                                '<td><input type="text" name="ket_bayar" id="bayar_ket_bayar" class="form-control money" value="' +
                                item.ket_bayar + '" readonly></td>' +
                                '<input type="hidden" name="path_file" id="bayar_path_file" class="form-control" value="' +
                                item.path_file + '" readonly>' +
                                '<td><a href="{{ asset('') }}' + item.path_file +
                                '" target="_blank" class="a">' +
                                '<img src="{{ asset('') }}' + item.path_file +
                                '" alt="Faktur pembelian" style="width: 100px;height: 50px;border-radius: 5px;">' +
                                '</a></td>' +
                                '<td style="white-space: nowrap;">' +
                                // Menggunakan white-space: nowrap; untuk menghindari wrap
                                '<a class="btn btn-success btn-xs btn-edit" style="margin-right: 5px;"><i class="fas fa-pencil-alt"></i></a>' +
                                '<a class="btn btn-danger btn-xs btn-hapus" style="margin-right: 5px;" ><i class="fa fa-trash" aria-hidden="true"></i></a>' +
                                '</td>' +
                                '</tr>';

                            $('#table-detail-edit').append(row);
                        });

                        if (rowData.sts_angsuran != 4) {
                            var emptyRow =
                                '<tr>' +
                                '<td></td>' + // No column
                                '<td><input type="text" name="nota_pembelian" id="bayar_nota_pembelian" class="form-control bayar_nota_pembelian money" value="" disabled></td>' +
                                '<td><input type="text" name="tgl_pembayaran" id="bayar_tgl_pembayaran" class="form-control bayar_tgl_pembayaran money" value="' +
                                '{{ date('Ymd') }}' + '"></td>' +
                                '<td><input type="text" name="angs_ke" id="bayar_angs_ke" class="form-control bayar_angs_ke money" value="" disabled></td>' +
                                '<td><input type="text" name="nominal_bayar" id="bayar_nominal_bayar" class="form-control bayar_nominal_bayar money" value=""></td>' +
                                '<td>' +
                                '<select name="channel_bayar" id="bayar_channel_bayar" class="form-control bayar_channel_bayar">' +
                                '<option value="">Pilih Channel</option>' +
                                '@foreach ($channels as $channel)' +
                                '<option value="{{ $channel->kd_channel }}">{{ $channel->ur_channel }}</option>' +
                                '@endforeach' +
                                '</select>' +
                                '</td>' +
                                '<td><input type="text" name="ket_bayar" id="bayar_ket_bayar" class="form-control bayar_ket_bayar money" value=""></td>' +
                                '<td><a class="btn btn-danger btn-xs btn-hapus"><i class="fa fa-trash" aria-hidden="true"></i></a></td>' +
                                '</tr>';

                            $('#table-detail-edit').append(emptyRow);
                        }
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
                $("#modal-pembelian").modal("show");
            });

            $('#table-detail-edit').on('click', '.btn-hapus', function() {
                // Simpan referensi ke tombol yang diklik
                var tombolHapus = $(this);
                var id = tombolHapus.closest('tr').find('#bayar_id').val();

                if (id) {
                    // Tampilkan SweetAlert untuk konfirmasi
                    Swal.fire({
                        title: 'Konfirmasi Admin',
                        text: 'Masukkan password admin untuk melanjutkan:',
                        input: 'password',
                        inputAttributes: {
                            autocapitalize: 'off',
                            placeholder: 'Password admin'
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Konfirmasi',
                        cancelButtonText: 'Batal',
                        showLoaderOnConfirm: true,
                        preConfirm: (password) => {
                            // Disini Anda bisa melakukan validasi password admin
                            // Misalnya, dengan mengirimkan request ke server untuk memeriksa kecocokan password admin

                            // Contoh validasi sederhana, ganti dengan validasi sesuai kebutuhan Anda
                            if (password !== 'passwordadmin') {
                                Swal.showValidationMessage('Password admin salah');
                            }
                        }
                    }).then((result) => {
                        // Jika pengguna mengonfirmasi, hapus baris
                        if (result.isConfirmed) {
                            if (id) {
                                penjualanDestroy(id)
                            }
                            tombolHapus.closest('tr').remove();
                        }
                    });
                } else {
                    tombolHapus.closest('tr').remove();
                }

            }).on('click', '.btn-edit', function() {
                var data = $(this);
                var id = data.closest('tr').find('#bayar_id').val();

                data.closest('tr').find('#bayar_update').val(id);

                data.closest('tr').find('#bayar_tgl_pembayaran').removeAttr('readonly');
                data.closest('tr').find('#bayar_nominal_bayar').removeAttr('readonly');
            });
        });

        function penjualanDestroy(id) {
            var url = '{{ route('pembayaran.destroy', ['pembayaran' => ':pembayaran']) }}';
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
