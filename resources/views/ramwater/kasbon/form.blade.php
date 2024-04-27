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
            <form method="post" id="form-kasbon" class="form-horizontal">
                @csrf
                @method('')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <input type="hidden" name="id" id="id">

                                    <div class="form-group">
                                        <label for="tgl_kasbon">Tanggal</label>
                                        <input type="text" class="form-control" name="tgl_kasbon" id="tgl_kasbon"
                                            value="{{ date('Ymd') }}">
                                        @error('tgl_kasbon')
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
                                    <div class="form-group" style="display: none">
                                        <label for="jns_kasbon">jns_kasbon</label>
                                        <input type="text" class="form-control" name="jns_kasbon" id="jns_kasbon"
                                            value="1">
                                        @error('jns_kasbon')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="nominal">Nominal</label>
                                        <input type="text" class="form-control" name="nominal" id="nominal">
                                        @error('nominal')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="ket_kasbon">Keterangan</label>
                                        <input type="text" class="form-control" name="ket_kasbon" id="ket_kasbon">
                                        @error('ket_kasbon')
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
                <button class="btn btn-primary" id="kasbon-add">Simpan</button>
            </div>
        </div>

    </div>
</div>
