<div class="modal fade" id="modal-hutang" data-backdrop="static" data-keyboard="false" tabindex="-1"
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
                    <div id="form_hutang">
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="id_parent" id="id_parent">

                        <div class="form-group" style="display: block" id="tanggal">
                            <label for="tanggal">tanggal </label>
                            <input type="text" class="form-control" name="tanggal" id="tanggal" readonly>
                            @error('tanggal')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group" style="display: block" id="nik">
                            <label for="nik">nik </label>
                            <input type="text" class="form-control" name="nik" id="nik">
                            @error('nik')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group" style="display: block" id="nama">
                            <label for="nama">Nama </label>
                            <input type="text" class="form-control" name="nama" id="nama">
                            @error('nama')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group" style="display: block" id="alamat">
                            <label for="alamat">Alamat </label>
                            <input type="text" class="form-control" name="alamat">
                            @error('alamat')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group" style="display: block" id="hp">
                            <label for="hp">Hp</label>
                            <input type="text" class="form-control" name="hp">
                            @error('hp')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group" id="jumlah">
                            <label for="jumlah">jumlah Pinjam </label>
                            <input type="text" class="form-control money" name="jumlah" id="jumlah"
                                value="{{ old('jumlah') }}">
                            @error('jumlah')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group" style="display: none" id="bayar">
                            <label for="bayar">Bayar</label>
                            <input type="text" class="form-control money" name="bayar" id="bayar"
                                value="{{ old('bayar') }}">
                            @error('bayar')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="card-header">
                            <a class="btn btn-success float-right" id="save_hutang">Simpan</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col table-responsive">
                            <div class="card-body">
                                <table class="table table-bordered table-striped" id="table_hutang">
                                    <thead>
                                        <tr>
                                            <th width="5%">No</th>
                                            <th>Tanggal</th>
                                            <th>Sales</th>
                                            <th>nama</th>
                                            <th>alamat</th>
                                            <th>Telepon</th>
                                            <th>Sisa Pinjam</th>
                                            <th>bayar</th>
                                            <th width="25%"><i class="fa fa-cogs" aria-hidden="true"></i></th>
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
