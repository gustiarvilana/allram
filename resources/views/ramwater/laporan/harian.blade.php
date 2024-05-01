@extends('layouts.master')

@section('title')
    <i class="fas fa-money-bill"></i> <b>Laporan Hutang Nominal</b>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-hearder"></div>
                <div class="card-body">
                    <form id="form-cari" method="POST">
                        @csrf
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
    <div class="row container" id="form-hutang" style="display: block">
        <div class="card">
            <div class="card-header">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="page-header">
                                <i class="fas fa-globe"></i> RAM Water
                                <small class="float-right" id="tanggal">Date: 2/10/2014</small>
                            </h2>
                        </div>

                    </div>

                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            <address>
                                <br>
                                795 Folsom Ave, Suite 600<br>
                                San Francisco, CA 94107<br>
                                Phone: (804) 123-5432<br>
                                Email: <a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                                    data-cfemail="cda4a3aba28daca1a0acbeaca8a8a9beb9b8a9a4a2e3aea2a0">[email&#160;protected]</a>
                            </address>
                        </div>

                    </div>
                    <hr>

                    <h4>
                        <p>
                            <i class="nav-icon fas fa-th mt-2"></i>
                            Pemasukan Penjualan
                        </p>
                    </h4>
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped" id="tbl-produk">
                                <thead>
                                    <tr>
                                        <th>Nama Pelanggan</th>
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>Harga Satuan</th>
                                        <th>nama_sales</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>

                    <h4>
                        <p>
                            <i class="nav-icon fas fa-th mt-2"></i>
                            Detail Pembayaran
                        </p>
                    </h4>
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped" id="tbl-produk">
                                <thead>
                                    <tr>
                                        <th>Qty</th>
                                        <th>Product</th>
                                        <th>Serial #</th>
                                        <th>Description</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                    </div>

                    <h4>
                        <p>
                            <i class="nav-icon fas fa-th mt-2"></i>
                            Pemasukan Piutang
                        </p>
                    </h4>
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped" id="tbl-produk">
                                <thead>
                                    <tr>
                                        <th>Qty</th>
                                        <th>Product</th>
                                        <th>Serial #</th>
                                        <th>Description</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                    </div>

                    <hr>
                    <h4>
                        <p>
                            <i class="nav-icon fas fa-th mt-2"></i>
                            Pengeluaran
                        </p>
                    </h4>
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped" id="tbl-produk">
                                <thead>
                                    <tr>
                                        <th>Qty</th>
                                        <th>Product</th>
                                        <th>Serial #</th>
                                        <th>Description</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                    </div>


                    <div class="row mt-4">

                        <div class="col-6">
                            <p class="lead">Payment Methods:</p>
                            <img src="{{ asset('assets') }}/dist/img/credit/visa.png" alt="Visa">
                            <img src="{{ asset('assets') }}/dist/img/credit/mastercard.png" alt="Mastercard">
                            <img src="{{ asset('assets') }}/dist/img/credit/american-express.png" alt="American Express">
                            <img src="{{ asset('assets') }}/dist/img/credit/paypal2.png" alt="Paypal">
                            <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango
                                imeem plugg dopplr
                                jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                            </p>
                        </div>

                        <div class="col-6">
                            <p class="lead">Amount Due 2/22/2014</p>
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th style="width:50%">Subtotal:</th>
                                        <td>$250.30</td>
                                    </tr>
                                    <tr>
                                        <th>Tax (9.3%)</th>
                                        <td>$10.34</td>
                                    </tr>
                                    <tr>
                                        <th>Shipping:</th>
                                        <td>$5.80</td>
                                    </tr>
                                    <tr>
                                        <th>Total:</th>
                                        <td>$265.24</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row no-print">
                    <div class="col-12">
                        <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i
                                class="fas fa-print"></i>
                            Print</a>
                        <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                            Payment
                        </button>
                        <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                            <i class="fas fa-download"></i> Generate PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('body').on("click", "#btn-cari", function() {
                var formData = $('#form-cari').serializeArray();
                var cari = {};
                $.each(formData, function(index, field) {
                    cari[field.name] = field.value;
                });

                $.ajax({
                    url: '{{ route('laporan.harian.data') }}',
                    method: 'POST',
                    data: cari,
                    success: function(response) {
                        if (response.success) {
                            proccessView(response.data);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: response.message,
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = "Terjadi kesalahan dalam operasi.";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else if (xhr.statusText) {
                            errorMessage = xhr.statusText;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Kesalahan!',
                            text: errorMessage,
                        });
                    }
                });
            })
        });

        function proccessView(data) {
            console.log(data.penjualan);
            var tableBody = $('#tbl-produk tbody');

            // Kosongkan isi tabel sebelum menambahkan data baru
            tableBody.empty();
            // Looping data.penjualan
            data.penjualan.forEach(function(item) {
                // Buat baris baru untuk setiap item dalam data.penjualan
                var row = $('<tr>');

                // Tambahkan kolom-kolom sesuai dengan struktur tabel
                row.append($('<td>').text(item.nama_pelanggan));
                row.append($('<td>').text(item.nama));
                row.append($('<td>').text(item.qty_bersih));
                row.append($('<td>').text(item.harga_satuan));
                row.append($('<td>').text(item.nama_sales));
                row.append($('<td>').text(addCommas(item.harga_total)));

                // Tambahkan baris ke dalam tabel
                tableBody.append(row);
            });
        }
    </script>
@endpush
