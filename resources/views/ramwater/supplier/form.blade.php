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
            <form method="post" class="form-horizontal" id="form-produk">
                @csrf

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <input type="hidden" name="id" id="id">
                                    <div class="form-group">
                                        <label for="kd_supplier">kd_supplier</label>
                                        <input type="text" class="form-control" name="kd_supplier" id="kd_supplier">
                                        @error('kd_supplier')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="nama">nama</label>
                                        <input type="text" class="form-control" name="nama" id="nama">
                                        @error('nama')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="merek">merek</label>
                                        <input type="text" class="form-control" name="merek" id="merek">
                                        @error('merek')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat">alamat</label>
                                        <input type="text" class="form-control" name="alamat" id="alamat">
                                        @error('alamat')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="norek">norek</label>
                                        <input type="text" class="form-control" name="norek" id="norek">
                                        @error('norek')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_bank">nama_bank</label>
                                        <input type="text" class="form-control" name="nama_bank" id="nama_bank">
                                        @error('nama_bank')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_pemilik">nama_pemilik</label>
                                        <input type="text" class="form-control" name="nama_pemilik"
                                            id="nama_pemilik">
                                        @error('nama_pemilik')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_personal">nama_personal</label>
                                        <input type="text" class="form-control" name="nama_personal"
                                            id="nama_personal">
                                        @error('nama_personal')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="no_tlp">no_tlp</label>
                                        <input type="text" class="form-control" name="no_tlp" id="no_tlp">
                                        @error('no_tlp')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="kd_ops">kd_ops</label>
                                        <select name="kd_ops" id="kd_ops" class="form-control select2">
                                            <option value="">Pilih OPS</option>
                                            @foreach ($tOpss as $tOps)
                                                <option value="{{ $tOps->kd_ops }}">{{ $tOps->nama_ops }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                {{-- <button class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                <button class="btn btn-primary" id="simpan">Simpan</button>
            </div>
        </div>

    </div>
</div>
