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
                        <label for="tanggal">tanggal</label>
                        <input type="date" class="form-control" name="tanggal" id="tanggal"
                            value="{{ date('Y-m-d') }}" required>
                        @error('tanggal')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="satker">satker</label>
                        <input type="text" class="form-control" name="satker" id="satker"
                            value="{{ UserHelper::getUser()->satker }}" readonly>
                        @error('satker')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="nik">nik</label>
                        <select name="nik" id="nik" class="form-control">
                            <option value="">=== Pilih Karyawan ===</option>
                            @foreach (UserHelper::getKaryawanWater()->whereNotIn('kd_role', ['1', '2', '99']) as $karyawan)
                                <option value="{{ $karyawan->nik }}">{{ $karyawan->nama }}</option>
                            @endforeach
                        </select>
                        @error('nik')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="kd_operasional">kd_operasional</label>
                        <select name="kd_operasional" id="kd_operasional" class="form-control">
                            <option value="">=== Pilih OPS ===</option>
                            @foreach ($ops as $item)
                                <option value="{{ $item->kd_operasional }}">{{ $item->nama_operasional }}</option>
                            @endforeach
                        </select>
                        @error('kd_operasional')
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
                        <label for="harga">harga</label>
                        <input type="text" class="form-control money" name="harga" id="harga"
                            value="{{ old('harga') }}" required>
                        @error('harga')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="keterangan">keterangan</label>
                        <input type="text" class="form-control" name="keterangan" id="keterangan"
                            value="{{ old('keterangan') }}" required>
                        @error('keterangan')
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
