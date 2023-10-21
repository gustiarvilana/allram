<div class="modal fade" id="modal-input-user" data-backdrop="static" data-keyboard="false" tabindex="-1"
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

                    <div class="row">
                        <div class="col">
                            <input type="hidden" name="kd_role" id="kd_role">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Menu</th>
                                        <th>:</th>
                                        <th id="txt_menu"></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col table-responsive">
                            <table class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Menu</th>
                                        <th>Type</th>
                                        <th><i class="fa fa-check" aria-hidden="true"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($UserMenu as $key => $menu)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $menu->ur_menu_title }}</td>
                                            <td>{{ $menu->type }}</td>
                                            <td><input type="checkbox" data-kd_menu="{{ $menu->kd_menu }}"
                                                    data-kd_parent="{{ $menu->kd_parent }}" id="user_role-box"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <a class="btn btn-primary" id="user_role-box-simpan">simpan</a>
                </div>
            </div>
        </form>
    </div>
</div>
