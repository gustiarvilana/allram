<div class="modal fade" id="modal-form" data-backdrop="static" data-keyboard="false" tabindex="-1"
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
                    <input type="hidden" name="id">
                    <div class="form-group col-md-4">
                        <label for="tgl_datang">tgl_datang</label>
                        <input type="date" class="form-control" name="tgl_datang" id="tgl_datang"
                            value="{{ date('Y-m-d') }}" required>
                        @error('tgl_datang')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="nama">nama Depo</label>
                        <input type="text" class="form-control" name="nama" id="nama"
                            value="{{ old('nama') }}" required>
                        @error('nama')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="kd_produk">kd_produk</label>

                        <select name="kd_produk" id="kd_produk" class="form-control">
                            <option value="">Pilih Produk</option>
                            @foreach ($produks as $produk)
                                <option value="{{ $produk->kd_produk }}">{{ $produk->nama . ' / ' . $produk->type }}
                                </option>
                            @endforeach
                        </select>

                        @error('kd_produk')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="jumlah">jumlah</label>
                        <input type="text" class="form-control" name="jumlah" id="jumlah"
                            value="{{ old('jumlah') }}" required>
                        @error('jumlah')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="rb">rb</label>
                        <input type="text" class="form-control" name="rb" id="rb"
                            value="{{ old('rb') }}">
                        @error('rb')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="harga">harga</label>
                        <input type="text" class="form-control money" name="harga" id="harga"
                            value="{{ old('harga') }}">
                        @error('harga')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    {{-- <button class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
