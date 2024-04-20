<!-- Modal -->
<div class="modal fade field" id="penjualan-show" tabindex="-1" role="dialog" aria-labelledby="penjualan-showTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-success">
                    <div class="card-header">
                        <span id="modal-header"></span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 table-responsive field">
                                <table class="table table-bordered" id="modal-show-detail">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th>No</th>
                                            <th>kd_produk</th>
                                            <th>qty_pesan</th>
                                            <th>qty_retur</th>
                                            <th>qty_bersih</th>
                                            <th>harga_satuan</th>
                                            <th>harga_total</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="save_penyerahan">Konfirmasi</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('body').on('click', '#save_penyerahan', function() {
        var rowData = $(this).data('row');
        // Use SweetAlert for confirmation
        Swal.fire({
            title: 'Konfirrmasi?',
            text: 'Pastikan Produk Sesuai dengan Jumlah Pembelian',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            cancelButtonText: 'Tidak',
            confirmButtonText: 'Ya!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('penjualan.penyerahanUpdate') }}',
                    type: 'POST',
                    data: {
                        nota_penjualan: rowData.nota_penjualan
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#penjualan-show').click();
                            $("#table-penjualan-laporan").DataTable().ajax.reload();
                            Swal.fire('Success!', 'Penyerahan Produk Terkonfirmasi.',
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
        });
    })
</script>
