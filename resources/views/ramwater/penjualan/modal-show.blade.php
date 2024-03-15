<!-- Modal -->
<div class="modal fade" id="penjualan-show" tabindex="-1" role="dialog" aria-labelledby="penjualan-showTitle"
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
                            <div class="col-md-12 table-responsive">
                                <table class="table table-bordered" id="modal-show-detail">
                                    <thead>
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
                {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
