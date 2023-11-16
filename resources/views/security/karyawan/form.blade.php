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
                    <div class="form-group">
                        <label for="nik">nik</label>
                        <input type="text" class="form-control" name="nik" id="nik_karyawan"
                            value="{{ old('nik') }}">
                        @error('nik')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="nama">nama</label>
                        <input type="text" class="form-control" name="nama" id="nama"
                            value="{{ old('nama') }}">
                        @error('nama')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="satker">satker</label>
                        <input type="text" class="form-control" name="satker" id="satker"
                            value="{{ old('satker') }}">
                        @error('satker')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="jabatan">jabatan</label>
                        <input type="text" class="form-control" name="jabatan" id="jabatan"
                            value="{{ old('jabatan') }}">
                        @error('jabatan')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="alamat">alamat</label>
                        <input type="text" class="form-control" name="alamat" id="alamat"
                            value="{{ old('alamat') }}">
                        @error('alamat')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="jk">jk</label>
                        <input type="text" class="form-control" name="jk" id="jk"
                            value="{{ old('jk') }}">
                        @error('jk')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="ktp">ktp</label>
                        <input type="text" class="form-control" name="ktp" id="ktp"
                            value="{{ old('ktp') }}">
                        @error('ktp')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="no_hp">no_hp</label>
                        <input type="text" class="form-control" name="no_hp" id="no_hp"
                            value="{{ old('no_hp') }}">
                        @error('no_hp')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="reference">reference</label>
                        <input type="text" class="form-control" name="reference" id="reference"
                            value="{{ old('reference') }}">
                        @error('reference')
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
