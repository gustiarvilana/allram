<!-- Modal -->
<div class="modal fade field" id="modal-add" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('pelanggan.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-success">
                                <div class="card-header">
                                    {{-- <h3 class="card-title">Collapsable</h3> --}}
                                </div>
                                <div class="card-body">
                                    <div class="form-row my-2" style="display: none">
                                        <div class="col-md-4">
                                            <label for="id">id</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="id" class="form-control" id="id"
                                                placeholder="id">
                                        </div>
                                    </div>
                                    <div class="form-row my-2" style="display: none">
                                        <div class="col-md-4">
                                            <label for="kd_pelanggan">kd_pelanggan</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="kd_pelanggan" class="form-control"
                                                id="kd_pelanggan" placeholder="kd_pelanggan" value="0">
                                        </div>
                                    </div>
                                    <div class="form-row my-2">
                                        <div class="col-md-4">
                                            <label for="nama">Nama</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="nama" class="form-control" id="nama"
                                                placeholder="nama">
                                        </div>
                                    </div>
                                    <div class="form-row my-2">
                                        <div class="col-md-4">
                                            <label for="alamat">Alamat</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="alamat" class="form-control" id="alamat"
                                                placeholder="alamat">
                                        </div>
                                    </div>
                                    <div class="form-row my-2" style="display: none">
                                        <div class="col-md-4">
                                            <label for="kd_kec">kd_kec</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="kd_kec" class="form-control" id="kd_kec"
                                                placeholder="kd_kec" value="0">
                                        </div>
                                    </div>
                                    <div class="form-row my-2" style="display: none">
                                        <div class="col-md-4">
                                            <label for="kd_kel">kd_kel</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="kd_kel" class="form-control" id="kd_kel"
                                                placeholder="kd_kel" value="0">
                                        </div>
                                    </div>
                                    <div class="form-row my-2" style="display: none">
                                        <div class="col-md-4">
                                            <label for="kd_kota">kd_kota</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="kd_kota" class="form-control" id="kd_kota"
                                                placeholder="kd_kota" value="0">
                                        </div>
                                    </div>
                                    <div class="form-row my-2" style="display: none">
                                        <div class="col-md-4">
                                            <label for="kd_pos">kd_pos</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="kd_pos" class="form-control" id="kd_pos"
                                                placeholder="kd_pos" value="0">
                                        </div>
                                    </div>
                                    <div class="form-row my-2">
                                        <div class="col-md-4">
                                            <label for="no_tlp">Ho Hp</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="no_tlp" class="form-control" id="no_tlp"
                                                placeholder="no_tlp">
                                        </div>
                                    </div>
                                    <div class="form-row my-2" style="display: none">
                                        <div class="col-md-4">
                                            <label for="opr_input">opr_input</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="opr_input" class="form-control"
                                                id="opr_input" placeholder="opr_input"
                                                value="{{ Auth::User()->nik }}">
                                        </div>
                                    </div>
                                    <div class="form-row my-2" style="display: none">
                                        <div class="col-md-4">
                                            <label for="tgl_input">tgl_input</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input type="text" name="tgl_input" class="form-control"
                                                id="tgl_input" placeholder="tgl_input" value="{{ date('Ymd') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary ml-auto"><i class="fas fa-save"></i>
                            Simpan</button>
                        {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                    </div>
                </div>
            </form>
        </div>
