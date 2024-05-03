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
                                        <label for="kd_produk">kd_produk</label>
                                        <input type="text" class="form-control" name="kd_produk" id="kd_produk">
                                        @error('kd_produk')
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
                                        <label for="type">type</label>
                                        <input type="text" class="form-control" name="type" id="type">
                                        @error('type')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="kd_supplier">kd_supplier</label>
                                        <select name="kd_supplier" id="kd_supplier" class="form-control select2">
                                            <option value="">Pilih Supplier</option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->kd_supplier }}">{{ $supplier->nama }}
                                                </option>
                                            @endforeach
                                        </select>
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
                                    <div class="form-group">
                                        <label for="harga_beli">harga_beli</label>
                                        <input type="text" class="form-control" name="harga_beli" id="harga_beli">
                                        @error('harga_beli')
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
                <button class="btn btn-primary" id="simpan">Simpan</button>
            </div>
        </div>

    </div>
</div>

<script>
    $('body').on('click', '#simpan', function() {

        var formData = new FormData($('#form-produk')[0]);
        var input = Object.fromEntries(formData);

        $.ajax({
            processData: false,
            contentType: false,
            url: '{{ route('produk.store') }}',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: response.message,
                    });
                    $('.close').click()
                    table.ajax.reload();
                    return;
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: response.message,
                });
            },
            error: function(error) {
                var errorMessage = "Terjadi kesalahan dalam operasi.";

                if (error.responseJSON && error.responseJSON.message) {
                    errorMessage = error.responseJSON.message;
                } else if (error.statusText) {
                    errorMessage = error.statusText;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan!',
                    text: errorMessage,
                });
            }
        });
    })
</script>
