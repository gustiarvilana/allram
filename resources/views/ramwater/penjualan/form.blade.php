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

                    <div class="form-group" style="display: none">
                        <label for="tgl_penjualan">tgl_penjualan </label>
                        <input type="text" class="form-control" name="tgl_penjualan" id="tgl_penjualan"
                            value="{{ date('Ymd') }}">
                        @error('tgl_penjualan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nik">nik</label>
                        <select name="nik" id="nik" class="form-control">
                            <option value="">=== Pilih Sales ===</option>
                            @foreach ($sales as $sls)
                                <option value="{{ $sls->nik }}">{{ $sls->nama }}</option>
                            @endforeach
                        </select>
                        @error('nama')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="kd_produk">kd_produk</label>
                        <select name="kd_produk" id="kd_produk" class="form-control">
                            <option value="">=== Pilih Produk ===</option>
                            @foreach ($produks as $produk)
                                <option value="{{ $produk->kd_produk }}">{{ $produk->nama }}</option>
                            @endforeach
                        </select>
                        @error('kd_produk')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="jumlah">jumlah </label>
                        <input type="text" class="form-control" name="jumlah" id="jumlah"
                            value="{{ old('jumlah') }}" required>
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
                        <label for="galon_kembali">galon_kembali</label>
                        <input type="text" class="form-control" name="galon_kembali" id="galon_kembali"
                            value="{{ old('galon_kembali') }}">
                        @error('galon_kembali')
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
