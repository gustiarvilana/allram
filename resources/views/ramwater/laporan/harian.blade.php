@extends('layouts.master')

@section('title')
    <i class="fas fa-money-bill"></i> <b>Laporan Harian</b>
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
    <div class="row" id="form-laporan-harian" style="display: none">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h2 class="page-header">
                                    <i class="fas fa-globe"></i> RAM Water
                                    <small class="float-right" id="tanggal"></small>
                                </h2>
                            </div>
                        </div>

                        <div class="row invoice-info">
                            {{-- <div class="col-sm-4 invoice-col">
                                    <address>
                                        <br>
                                        795 Folsom Ave, Suite 600<br>
                                        San Francisco, CA 94107<br>
                                        Phone: (804) 123-5432<br>
                                        Email: <a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                                            data-cfemail="cda4a3aba28daca1a0acbeaca8a8a9beb9b8a9a4a2e3aea2a0">[email&#160;protected]</a>
                                    </address>
                                </div> --}}

                        </div>
                        <hr>

                        <div class="pemasukan">
                            <h4>
                                <p>
                                    <i class="nav-icon fas fa-th mt-2"></i>
                                    Pemasukan
                                </p>
                            </h4>

                            <div class="ml-4">
                                <h4>
                                    <p>
                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                        Penjualan
                                    </p>
                                </h4>
                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table class="table table-striped" id="tbl-produk">
                                            <thead>
                                                <tr>
                                                    <th>Nama Sales</th>
                                                    <th>Product</th>
                                                    <th>Harga Satuan</th>
                                                    <th>Qty</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="ml-4">
                                <h4>
                                    <p>
                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                        </i> Piutang
                                    </p>
                                </h4>
                                <div class="row">
                                    <div class="col-12 table-responsive">
                                        <table class="table table-striped" id="tbl-piutang">
                                            <thead>
                                                <tr>
                                                    <th>Nama</th>
                                                    <th>Nota Penjualan</th>
                                                    <th>Angs-Ke</th>
                                                    <th>Nominal</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="pengeluaran">
                            <hr>
                            <h4>
                                <p>
                                    <i class="nav-icon fas fa-th mt-2"></i>
                                    Pengeluaran
                                </p>
                            </h4>
                            <div class="ml-4">
                                <div class="row">
                                    <h4>
                                        <p>
                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                            Pending
                                        </p>
                                    </h4>
                                    <div class="col-12 table-responsive">
                                        <table class="table table-striped" id="tbl-pending">
                                            <thead>
                                                <tr>
                                                    <th>Nama Pelanggan</th>
                                                    <th>Product</th>
                                                    <th>Total Harga</th>
                                                    <th>Total Pending</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>

                                </div>

                                <div class="row">
                                    <h4>
                                        <p>
                                            <i class="fa fa-circle" aria-hidden="true"></i>
                                            OPS
                                        </p>
                                    </h4>
                                    <div class="col-12 table-responsive">
                                        <table class="table table-striped" id="tbl-pengeluaran">
                                            <thead>
                                                <tr>
                                                    <th>Nama OPS</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">

                            <div class="col-6">
                                {{-- <p class="lead">Payment Methods:</p>
                                    <img src="{{ asset('assets') }}/dist/img/credit/visa.png" alt="Visa">
                                    <img src="{{ asset('assets') }}/dist/img/credit/mastercard.png" alt="Mastercard">
                                    <img src="{{ asset('assets') }}/dist/img/credit/american-express.png" alt="American Express">
                                    <img src="{{ asset('assets') }}/dist/img/credit/paypal2.png" alt="Paypal">
                                    <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                        Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango
                                        imeem plugg dopplr
                                        jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                                    </p> --}}
                            </div>

                            <div class="col-6">
                                {{-- <p class="lead">Amount Due 2/22/2014</p> --}}
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th>Total Pemasukan</th>
                                            <td id="totalPemasukan">$10.34</td>
                                        </tr>
                                        <tr>
                                            <th>Total Pengeluaran</th>
                                            <td id="totalPengeluaran">$5.80</td>
                                        </tr>
                                        <tr>
                                            <th style="width:50%">Saldo:</th>
                                            <td id="saldo">$250.30</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row no-print">
                        <div class="col-12">
                            <a href="#" rel="noopener" target="_blank" class="btn btn-default btn_print"><i
                                    class="fas fa-print"></i>
                                Print</a>

                            {{-- <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                                <i class="fas fa-download"></i> Generate PDF
                            </button> --}}
                        </div>
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
                            $('#tanggal').text('Tanggal: ' + formatRangeTgl(cari['rTanggal']));

                            var totalpenjualan = laporanPenjualan(response.data);

                            var totalpenjualanPending = laporanPenjualanPending(response.data);

                            var totalBayarPiutang = laporanPiutang(response.data
                                .bayarPiutang);

                            var totalPengeluaranAll = laporanPengeluaran(response.data);

                            var totalPemasukan = totalpenjualan + totalBayarPiutang;

                            $('#totalPemasukan').css({
                                'font-weight': 'bold',
                                'font-size': '20px'
                            }).text('Rp. ' + addCommas(totalPemasukan));

                            $('#totalPengeluaran').css({
                                'font-weight': 'bold',
                                'font-size': '20px'
                            }).text('Rp. ' + addCommas(totalPengeluaranAll +
                                totalpenjualanPending));

                            $('#saldo').css({
                                'font-weight': 'bold',
                                'font-size': '20px'
                            }).text('Rp. ' + addCommas(totalPemasukan -
                                (totalPengeluaranAll + totalpenjualanPending)));

                            $('#form-laporan-harian').show();
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

            $('body').on('click', '.btn_print', function() {
                printElement('form-laporan-harian');
            });
        });

        function printElement(elemId) {
            var printContents = document.getElementById(elemId).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }



        function formatRangeTgl(rTanggal) {
            var tanggalSplit = rTanggal.split(' - ');

            var tanggalAwal = new Date(tanggalSplit[0]);
            var tanggalAkhir = new Date(tanggalSplit[1]);

            var tanggalAwalFormatted = tanggalAwal.toLocaleDateString('id-ID', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            var tanggalAkhirFormatted = tanggalAkhir.toLocaleDateString(
                'id-ID', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });

            return tanggalAwalFormatted + ' - ' + tanggalAkhirFormatted;
        }

        function laporanPenjualan(data) {
            var tableBody = $('#tbl-produk tbody');
            var totalJualProduk = 0;

            // Kosongkan isi tabel sebelum menambahkan data baru
            tableBody.empty();
            // Looping data.penjualan
            data.penjualan.forEach(function(item) {
                // Buat baris baru untuk setiap item dalam data.penjualan
                var row = $('<tr>');

                // Tambahkan kolom-kolom sesuai dengan struktur tabel
                row.append($('<td>').text(item.nama_pelanggan));
                row.append($('<td>').text(item.nama));
                row.append($('<td>').text(addCommas(item.harga_satuan)).css('font-weight', 'bold'));
                row.append($('<td>').text(item.total_qty)).css('font-weight', 'bold');
                row.append($('<td class="text-right">').text(addCommas(item.total_nominal)));

                totalJualProduk += parseInt(item.total_nominal);
                tableBody.append(row);
            });

            if (totalJualProduk) {
                var totalRow = $('<tr>').css({
                    'font-weight': 'bold',
                    'font-size': '20px'
                });
                totalRow.append(
                    $('<td class="text-center" colspan="4">').text('Total Penjualan'),
                    $('<td class="text-right">').text(addCommas(totalJualProduk)).css('border-top', '2px solid black')
                );

                tableBody.append(totalRow);
            }
            return totalJualProduk;
        }

        function laporanPenjualanPending(data) {

            var tableBody = $('#tbl-pending tbody');
            var totalJualProduk = 0;

            // Kosongkan isi tabel sebelum menambahkan data baru
            tableBody.empty();
            // Looping data.penjualan
            data.pending.forEach(function(item) {
                if (item.sisa_bayar != '0') {

                    var row = $('<tr>');
                    row.append($('<td>').text(item.nama_pelanggan));
                    row.append($('<td>').text(item.nama));
                    row.append($('<td class="text-right">').text(addCommas(item.total_nominal)));
                    row.append($('<td class="text-right">').text(addCommas(item.sisa_bayar)));

                    totalJualProduk += parseInt(item.total_nominal);
                    tableBody.append(row);
                }
            });

            if (totalJualProduk) {
                var totalRow = $('<tr>').css({
                    'font-weight': 'bold',
                    'font-size': '20px'
                });
                totalRow.append(
                    $('<td class="text-center" colspan="3">').text('Total Pending'),
                    $('<td class="text-right">').text(addCommas(totalJualProduk)).css('border-top', '2px solid black')
                );

                tableBody.append(totalRow);
            }
            return totalJualProduk;
        }

        function laporanPiutang(data) {
            var tableBodyTunai = $('#tbl-piutang tbody');
            var totalPiutangTunai = 0;

            tableBodyTunai.empty();
            data.forEach(function(item) {
                var row = $('<tr>');

                row.append($('<td>').text(item.nama));
                row.append($('<td>').text(item.nota_penjualan));
                row.append($('<td>').text(item.angs_ke));
                row.append($('<td class="text-right">').text(addCommas(item.total_bayar)));

                totalPiutangTunai += parseInt(item.total_bayar);
                tableBodyTunai.append(row);
            });

            if (totalPiutangTunai) {
                var totalRow = $('<tr>').css({
                    'font-weight': 'bold',
                    'font-size': '20px'
                });
                totalRow.append(
                    $('<td class="text-center" colspan="3">').text('Total Piutang'),
                    $('<td class="text-right">').text(addCommas(totalPiutangTunai)).css('border-top',
                        '2px solid black')
                );
                tableBodyTunai.append(totalRow);
            }
            return totalPiutangTunai;
        }

        function laporanPengeluaran(data) {
            var tableBody = $('#tbl-pengeluaran tbody');
            var totalPengeluaran = 0;

            tableBody.empty();
            data.pengeluaran.forEach(function(item) {

                var row = $('<tr>');

                row.append($('<td>').text(item.nama));
                row.append($('<td>').text(item.nota_penjualan));
                row.append($('<td>').text(item.nik));
                row.append($('<td class="text-right">').text(addCommas(item.total_nominal)));

                totalPengeluaran += parseInt(item.total_nominal);
                tableBody.append(row);
            });

            if (totalPengeluaran) {
                var totalRow = $('<tr>').css({
                    'font-weight': 'bold',
                    'font-size': '20px'
                });
                totalRow.append(
                    $('<td class="text-center" colspan="3">').text('Total Pengeluaran'),
                    $('<td class="text-right">').text(addCommas(totalPengeluaran)).css('border-top', '2px solid black')
                );
                tableBody.append(totalRow);
            }
            return totalPengeluaran;
        }
    </script>
@endpush
