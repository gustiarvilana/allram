@extends('layouts.master')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">DataTable with default features</h3>
        </div>

        <div class="card-body">
            <table id="user_menu_table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Rendering engine</th>
                        <th>Browser</th>
                        <th>Platform(s)</th>
                        <th>Engine version</th>
                        <th>CSS grade</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    @endsection

    {{-- @push('js')
        <script>
            $(function() {
                var user_menu_table = $('#user_menu_table').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    ajax: '{{ url('/'). }}',
                    order: [],
                    dom: 'Bfrtip',
                    buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
                    columns: [{
                            data: 'no',
                            orderable: false
                        },
                        {
                            data: 'fullname'
                        },
                        {
                            data: 'group_name',
                            render: function(data, type, row) {
                                return row.group_name.toUpperCase();
                            }
                        },
                        {
                            data: 'satker'
                        },
                        {
                            data: 'active',
                            render: function(data, type, row) {
                                var data = JSON.stringify(row);
                                if (row.active == '0') {
                                    var p_active = '<p>Not Active</p>';
                                } else if (row.active == '1') {
                                    var p_active = '<p>Active</p>';
                                } else {
                                    var p_active = '<p>Unknow</p>';
                                }
                                return p_active;
                            }
                        },
                        {
                            data: 'username'
                        },
                        {
                            data: 'email'
                        },
                        {
                            data: 'phone'
                        },
                        {
                            data: 'user_id',
                            render: function(data, type, row) {
                                var data = JSON.stringify(row);
                                var btn_edit = '<a id="users_btn_edit" data-id="' + row.user_id +
                                    '" data-row=\'' + data + '\' class="btn btn-primary edit">Edit</a>';
                                var btn_delete = '<a id="users_btn_delete" data-id="' + row.user_id +
                                    '" data-row=\'' + data +
                                    '\' class="btn btn-danger delete">Delete</a>'

                                return btn_edit + ' ' + btn_delete;
                            }
                        },
                    ]
                })
            });
        </script>
    @endpush --}}
