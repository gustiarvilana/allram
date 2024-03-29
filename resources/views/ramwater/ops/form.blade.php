<div class="modal fade" id="modal-form" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="alert alert-danger" style="display:none"></div>

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="post" class="form-horizontal">
                @csrf
                @method('')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <input type="hidden" name="id" id="id">
                                    <div class="form-group">
                                        <label for="tanggal">tanggal</label>
                                        <input type="text" class="form-control" name="tanggal" id="tanggal"
                                            value="{{ date('Ymd') }}">
                                        @error('tanggal')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group" style="display: none">
                                        <label for="satker">satker</label>
                                        <input type="text" class="form-control" name="satker" id="satker"
                                            value="ramwater">
                                        @error('satker')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="nik">Karyawan</label>
                                        <div class="col-md-8">
                                            <select name="nik" id="nik" class="form-control select2">
                                                <option value="">== Pilih Pegawai ==</option>
                                                @foreach ($pegawais as $pegawai)
                                                    <option value="{{ $pegawai->nik }}">{{ $pegawai->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('nik')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="kd_ops">OPS</label>
                                        <div class="col-md-8">
                                            <select name="kd_ops" id="kd_ops" class="form-control select2">
                                                <option value="">== Pilih Ops ==</option>
                                                @foreach ($opss as $ops)
                                                    <option value="{{ $ops->kd_ops }}">{{ $ops->nama_ops }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('kd_ops')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="jumlah">Jumlah</label>
                                        <input type="text" class="form-control money" name="jumlah" id="jumlah"
                                            value="{{ old('jumlah') }}">
                                        @error('jumlah')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="harga">Harga</label>
                                        <input type="text" class="form-control money" name="harga" id="harga"
                                            value="{{ old('harga') }}">
                                        @error('harga')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="total">Total</label>
                                        <input type="text" class="form-control money" name="total" id="total"
                                            readonly>
                                        @error('total')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="keterangan">Keterangan</label>
                                        <input type="text" class="form-control" name="keterangan" id="keterangan"
                                            value="{{ old('keterangan') }}">
                                        @error('keterangan')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="id">
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                {{-- <button class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                <button class="btn btn-primary" id="ops-add">Simpan</button>
            </div>
        </div>

    </div>
</div>

<script>
    $('body').on('change', '#jumlah,#harga', function() {
        var jumlah = getFloatValue($('#jumlah'));
        var harga = getFloatValue($('#harga'));
        var total = harga * jumlah;

        total > 0 ? $('#total').val(addCommas(total)) : $('#total').val('0')
    })
</script>
