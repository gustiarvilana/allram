<div class="modal fade" id="modal-detail" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="alert alert-danger" style="display:none"></div>
        <form action="" method="post" class="form-horizontal">
            @csrf
            @method('')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">

                    <div class="form-group" style="display: none">
                        <label for="id_penjualan">id_penjualan </label>
                        <input type="text" class="form-control" name="id_penjualan" id="id_penjualan">
                        @error('id_penjualan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group" style="display: block">
                        <label for="nama">Nama </label>
                        <input type="text" class="form-control" name="nama" id="nama">
                        @error('nama')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="jumlah">Jumlah </label>
                        <input type="text" class="form-control money" name="jumlah" id="jumlah"
                            value="{{ old('jumlah') }}">
                        @error('jumlah')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="sisa">sisa </label>
                        <input type="text" class="form-control" name="sisa" id="sisa"
                            value="{{ old('sisa') }}">
                        @error('sisa')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga </label>
                        <input type="text" class="form-control money" name="harga" id="harga"
                            value="{{ old('harga') }}">
                        @error('harga')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="ket">Keterangan </label>
                        <textarea name="ket" id="ket" rows="1" class="form-control" value="{{ old('ket') }}"></textarea>
                        @error('ket')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col table-responsive">
                            <div class="card-header">
                                <a class="btn btn-success float-right" id="save_detail">Simpan</a>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-striped" id="table_detail">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th>id</th>
                                            <th>nama</th>
                                            <th>jumlah</th>
                                            <th>harga</th>
                                            <th>Total</th>
                                            <th>Keterangan</th>
                                            <th width="15%"><i class="fa fa-cogs" aria-hidden="true"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{-- <button class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                    {{-- <button class="btn btn-primary">Simpan</button> --}}
                </div>
            </div>
        </form>
    </div>
</div>
