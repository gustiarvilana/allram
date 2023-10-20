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
                        <label for="kd_menu">kd_menu</label>
                        <input type="text" class="form-control" name="kd_menu" id="kd_menu"
                            value="{{ old('kd_menu') }}">
                        @error('kd_menu')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="kd_parent">kd_parent</label>
                        <input type="text" class="form-control" name="kd_parent" id="kd_parent"
                            value="{{ old('kd_parent') }}">
                        @error('kd_parent')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="type">type</label>
                        <input type="text" class="form-control" name="type" id="type"
                            value="{{ old('type') }}">
                        @error('type')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="ur_menu_title">ur_menu_title</label>
                        <input type="text" class="form-control" name="ur_menu_title" id="ur_menu_title"
                            value="{{ old('ur_menu_title') }}">
                        @error('ur_menu_title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="ur_menu_desc">ur_menu_desc</label>
                        <input type="text" class="form-control" name="ur_menu_desc" id="ur_menu_desc"
                            value="{{ old('ur_menu_desc') }}">
                        @error('ur_menu_desc')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="link_menu">link_menu</label>
                        <input type="text" class="form-control" name="link_menu" id="link_menu"
                            value="{{ old('link_menu') }}">
                        @error('link_menu')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="bg_color">bg_color</label>
                        <input type="text" class="form-control" name="bg_color" id="bg_color"
                            value="{{ old('bg_color') }}">
                        @error('bg_color')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="icon">icon</label>
                        <input type="text" class="form-control" name="icon" id="icon"
                            value="{{ old('icon') }}">
                        @error('icon')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="order">order</label>
                        <input type="text" class="form-control" name="order" id="order"
                            value="{{ old('order') }}">
                        @error('order')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="is_active">is_active</label>
                        <input type="text" class="form-control" name="is_active" id="is_active"
                            value="{{ old('is_active') }}">
                        @error('is_active')
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
