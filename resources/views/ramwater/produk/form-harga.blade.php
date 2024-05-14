<div class="modal fade" id="modal-form-harga" data-backdrop="static" data-keyboard="false"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="alert alert-danger" style="display:none"></div>

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" class="form-horizontal" id="form-harga-jual">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <input type="hidden" name="id" id="id">
                                    <input type="hidden" name="kd_harga" id="kd_harga">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="kd_produk">kd_produk</label>
                                                <select name="kd_produk" id="kd_produk" class="form-control select2">
                                                    <option value="">Pilih Produk</option>
                                                    @foreach ($produks as $produk)
                                                        <option value="{{ $produk->kd_produk }}">{{ $produk->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="ket_harga">ket_harga</label>
                                                <input type="text" class="form-control" name="ket_harga"
                                                    id="ket_harga">
                                                @error('ket_harga')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="harga">harga</label>
                                                <input type="text" class="form-control" name="harga"
                                                    id="harga">
                                                @error('harga')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="satuan">satuan</label>
                                                <input type="text" class="form-control" name="satuan"
                                                    id="satuan">
                                                @error('satuan')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <a class="btn btn-success float-right" id="simpan-harga"> Simpan</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-success">
                                <div class="card-header">
                                    {{-- <a class="btn btn-success text-white" id="add_menu">Tambah Produk</a> --}}
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col table-responsive">
                                            <table class="table table-striped table-bordered nowarp"
                                                id="table-harga-jual">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Produk</th>
                                                        <th>Keterangan</th>
                                                        <th>Harga</th>
                                                        <th>Satuan</th>
                                                        <th><i class="fa fa-cogs" aria-hidden="true"></i></th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="id">
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                {{-- <button class="btn btn-primary" id="simpan">Simpan</button> --}}
            </div>
        </div>

    </div>
</div>
