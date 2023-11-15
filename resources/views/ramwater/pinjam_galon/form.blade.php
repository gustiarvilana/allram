<div class="modal fade" id="modal-galon" data-backdrop="static" data-keyboard="false" tabindex="-1"
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
                    <input type="text" name="id">
                    <input type="text" name="id_parent">

                    <div class="form-group col-md-4">
                        <label for="tanggal">tanggal</label>
                        <input type="date" class="form-control" name="tanggal" id="tanggal"
                            value="{{ date('Y-m-d') }}" required>
                        @error('tanggal')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="nik">nik</label>
                        <select name="nik" id="nik" class="form-control">
                            <option value="">=== Pilih Karyawan ===</option>
                            @foreach (UserHelper::getKaryawanWater()->whereNotIn('kd_role', ['99', '1', '2']) as $karyawan)
                                <option value="{{ $karyawan->nik }}">{{ $karyawan->nama }}</option>
                            @endforeach
                        </select>
                        @error('nik')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="nama">nama Konsumen</label>
                        <input type="text" class="form-control money" name="nama" id="nama"
                            value="{{ old('nama') }}">
                        @error('nama')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="jumlah">Jumlah/Sisa</label>
                        <input type="text" class="form-control money" name="jumlah" id="jumlah"
                            value="{{ old('jumlah') }}">
                        @error('jumlah')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="alamat">alamat</label>
                        <input type="text" class="form-control money" name="alamat" id="alamat"
                            value="{{ old('alamat') }}">
                        @error('alamat')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="hp">hp</label>
                        <input type="text" class="form-control money" name="hp" id="hp"
                            value="{{ old('hp') }}">
                        @error('hp')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="bayar">bayar</label>
                        <input type="text" class="form-control money" name="bayar" id="bayar"
                            value="{{ old('bayar') }}">
                        @error('bayar')
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
