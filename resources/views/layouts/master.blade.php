<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RAM Armalia</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/fontawesome-free/css/all.min.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('assets') }}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets') }}/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    {{-- <link rel="stylesheet" href="{{ asset('assets') }}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css"> --}}
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/summernote/summernote-bs4.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="{{ asset('assets') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

    {{-- SweetAlert2 --}}
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        #ajax-wait {
            display: none;
            position: fixed;
            z-index: 1999
        }

        body {
            font-size: 12px;
        }

        .main-sidebar {
            background-color: #333 !important
        }

        .popup {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            padding: 10px;
            z-index: 1;
        }

        .a {
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            display: inline-block;
        }

        .img {
            width: 400px;
            height: 200px;
            border-radius: 5px;
        }

        .field .form-control {
            width: auto;
        }

        .select2 {
            width: 100%;
            height: 100%;
        }
    </style>

</head>

@php
    use App\Helpers\MenuHelper;
    use App\Helpers\UserHelper;

    $currentUrl = request()->path();
    $urlSegments = explode('/', $currentUrl);
    $parentUrl = implode('/', array_slice($urlSegments, 0, 2));

    $kd_parent = Session::get('kd_home_parent');
    $user = auth()->user();
    $role = $user->getRole();
    $menus = MenuHelper::getMenusByRole($role, $kd_parent)->where('kd_parent', '!=', null);
@endphp

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">

        <div id='ajax-wait'>
            <img alt='loading...'
                src='//4.bp.blogspot.com/-M1GL94ukmSw/We41R8CWTfI/AAAAAAAAGnw/cIVHpqsywN85zcfFpNMGexHHmFGHJbKzQCLcBGAs/s0000/loading-x.gif'
                width='32' height='32' />
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">
                    <div class="nav-link">
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-info btn-xs">
                                <i class="fas fa-sign-out-alt"></i>
                                Logout</button>
                        </form>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="brand-link">
                <img src="{{ asset('assets') }}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">{{ Auth::user()->name }}</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar mt-4">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        @include('layouts.sidemenu')
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>@yield('title')</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                <li class="breadcrumb-item active">@yield('title')</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">

                <!-- Default box -->
                @yield('content')
                <!-- /.card -->

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.2.0
            </div>
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
            reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <div id="popup" class="popup"></div>


    <!-- jQuery -->
    <script src="{{ asset('assets') }}/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('assets') }}/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="{{ asset('assets') }}/plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="{{ asset('assets') }}/plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    {{-- <script src="{{ asset('assets') }}/plugins/jqvmap/jquery.vmap.min.js"></script> --}}
    {{-- <script src="{{ asset('assets') }}/plugins/jqvmap/maps/jquery.vmap.usa.js"></script> --}}
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('assets') }}/plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('assets') }}/plugins/moment/moment.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Include Date Range Picker -->
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('assets') }}/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="{{ asset('assets') }}/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    {{-- <script src="{{ asset('assets') }}/plugins/overlayScrollbars/js/jquery.overlayScrhartollbars.min.js"></script> --}}
    <!-- AdminLTE App -->
    <script src="{{ asset('assets') }}/dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    {{-- <script src="{{ asset('assets') }}/dist/js/demo.js"></script> --}}
    <!-- AdminLTE @yield('title', 'title belum diisi') demo (This is only for demo purposes) -->
    {{-- <script src="{{ asset('assets') }}/dist/js/pages/dashboard.js"></script> --}}
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('assets') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/jszip/jszip.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- Select2 -->
    <script src="{{ asset('assets') }}/plugins/select2/js/select2.full.min.js"></script>
    <script src="{{ asset('assets') }}/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>

    {{-- sweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var errorAlerts = document.querySelectorAll('.alert');

            if (errorAlerts.length > 0) {
                setTimeout(function() {
                    errorAlerts.forEach(function(alert) {
                        alert.style.transition = 'opacity 1s';
                        alert.style.opacity = '0';

                        setTimeout(function() {
                            alert.style.display = 'none';
                        }, 1000);
                    });
                }, 5000);
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            //Initialize Select2 Elements
            $('.select2').select2({
                theme: 'bootstrap4'
            })

            //Date range picker
            $('.dateRange').daterangepicker()
            //Date range picker with time picker
            $('.dateRangetime').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                locale: {
                    format: 'MM/DD/YYYY hh:mm A'
                }
            })

            $('body').on('keyup', '.money', function() {
                var nilai1 = this.value.replace(/[^a-z0-9\s]/gi, '');
                var nilai = addCommas(nilai1);
                $(this).val(nilai).trigger("change");
            }).on('click', function() {
                var newCsrfToken = '{{ csrf_token() }}';
                $('meta[name="csrf-token"]').attr('content', newCsrfToken);
            });

            $('#daterange').daterangepicker()

            $("input[data-bootstrap-switch]").each(function() {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            })

            setupCSRFToken();
        });

        $(document).ajaxStart(function() {
            $("#ajax-wait").css({
                left: ($(window).width() - 32) / 2 + "px", // 32 = lebar gambar
                top: ($(window).height() - 32) / 2 + "px", // 32 = tinggi gambar
                display: "block"
            })
        }).ajaxComplete(function() {
            $("#ajax-wait").fadeOut();
        });

        function addCommas(nStr) {
            if (nStr) {
                nStr += '';
                x = nStr.split(',');
                x1 = x[0];
                x2 = x.length > 1 ? ',' + x[1] : '';
                var rgx = /(\d+)(\d{3})/;
                while (rgx.test(x1)) {
                    x1 = x1.replace(rgx, '$1' + '.' + '$2');
                }
                return x1 + x2;
            } else {
                return "";
            }
        }

        function formatRupiah(number) {
            return Math.trunc(number).toLocaleString('id-ID');
        }

        function initializeColumnSearch(table) {
            // Hapus semua elemen input pencarian sebelum membuat yang baru
            var api = table.api();
            var container = api.table().container ? api.table().container() : api.fnSettings()
                .nTable; // Periksa versi dan gunakan pemanggilan yang sesuai

            $(container).find('.input-group').remove();

            table.api().columns().every(function() {
                var column = this;
                var title = column.header().textContent;
                var wrapper = document.createElement('div');
                $(wrapper).addClass('input-group');

                var input = document.createElement('input');
                $(input).addClass('form-control');
                input.placeholder = 'Search ' + title;

                var clearBtn = document.createElement('button');
                $(clearBtn).addClass('btn btn-outline-secondary input-group-text');
                clearBtn.type = 'button';
                clearBtn.innerHTML = '&times;';

                $(wrapper).append(input);
                // $(wrapper).append(clearBtn);

                $(column.header()).append(wrapper);

                if (!column.settings()[0].aoColumns[column.index()].bSearchable) {
                    // Sembunyikan input pencarian jika kolom tidak dapat dicari
                    $(wrapper).hide();
                }

                $(clearBtn).on('click', function() {
                    $(input).val('');
                    column.search('').draw();
                });

                $(input).on('keyup change', function(e) {
                    if (e.keyCode == 13) {
                        if (column.search() !== this.value) {
                            column.search(this.value).draw();
                        }
                    }
                });
            });
        }

        // generate csrf
        $('body').on('blur keyup', '.money', function() {
            var nilai1 = this.value.replace(/[^a-z0-9\s]/gi, '');
            var nilai = addCommas(nilai1);
            var input = $(this)
            input.val(nilai).trigger("change");

            $('.money').each(function() {
                var cek = $(this).val();
                if (parseInt(cek) < 0) {
                    input.val('').trigger("change");
                    $(this).val('').trigger("change");
                    alert("Input Salah!");
                }
            });

        });

        // Fungsi untuk memperbarui nilai field berdasarkan field-field lainnya
        function updateField(row, fieldId, sourceIds, calculateFunction) {
            // Mengumpulkan nilai dari field-field sumber
            var values = sourceIds.map(function(id) {
                return getFloatValue(row.find(id));
            });

            // Menghitung nilai baru menggunakan fungsi kalkulasi
            var total = calculateFunction.apply(null, values);

            // Menyimpan nilai baru ke dalam field target
            row.find('#' + fieldId).val(addCommas(total));
        }

        // Fungsi untuk menghitung dan memperbarui total dari field-field tertentu
        function updateTotal(totalFieldId, itemClass) {
            // Menghitung total dari field-field dengan kelas tertentu
            var total = 0;
            $(itemClass).each(function() {
                total += getFloatValue($(this));
            });

            // Menyimpan nilai total ke dalam field total
            $(totalFieldId).val(addCommas(total));
        }

        // Fungsi untuk mendapatkan nilai float dari elemen input dengan memperhatikan pemisah ribuan
        function getFloatValue(element) {
            return parseFloat(element.val().replace(/\./g, '')) || 0;
        }

        // Fungsi untuk menambahkan pemisah ribuan pada angka
        // function addCommas(number) {
        //     return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        // }


        // Fungsi untuk mendapatkan token CSRF dari meta tag dalam HTML
        function getCSRFToken() {
            return $('meta[name="csrf-token"]').attr('content');
        }

        // Fungsi untuk mengatur token CSRF dalam header setiap permintaan AJAX
        function setupCSRFToken() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': getCSRFToken()
                }
            });
        }

        function setupHoverShapes(table, cell) {
            // Tambahkan event mouseover dan mouseout
            table.on('mouseover', 'td', function() {
                var colIdx = $(table).DataTable().column($(this).index()).index();
                var cellData = $(table).DataTable().cell(this).data();

                // Cek apakah mouseover pada kolom 'nota_pembelian'
                if (colIdx === cell) {
                    if (isImagePath(cellData)) {
                        showPopup(this, '<img src="{{ asset('') }}' + cellData +
                            '" alt="Faktur pembelian" style="width: 500px;height: 250px;border-radius: 5px;">'
                        );
                    } else {
                        showPopup(this, 'Data Kolom: ' + '<span>' + cellData + '</span>');
                    }
                }
            });

            function isImagePath(value) {
                if (value) {
                    return value.endsWith('.jpg') || value.endsWith('.jpeg') || value.endsWith('.png') || value.endsWith(
                        '.gif');
                }
            }

            // Tambahkan event mouseout untuk menutup shapes atau popup
            table.on('mouseout', function() {
                hidePopup();
                // hideTimeout = setTimeout(function() {}, 8000); // Adjust the delay time as needed
            });

            function showPopup(element, content) {
                var popup = $('#popup');
                popup.html(content);

                // Get the mouse position
                var mouseX = event.clientX;
                var mouseY = event.clientY;

                // Set the popup position above the cursor
                var leftPosition = mouseX - 600
                var topPosition = mouseY - popup.height();

                // Check if the popup exceeds the right edge of the screen
                if (leftPosition + popup.width() > $(window).width()) {
                    leftPosition = $(window).width() - popup.width();
                }

                // Check if the popup exceeds the top edge of the screen
                if (topPosition < 0) {
                    topPosition = 5;
                }

                popup.css({
                    display: 'block',
                    left: leftPosition + 'px',
                    top: topPosition + 'px'
                });
            }

            function hidePopup() {
                var popup = $('#popup');
                popup.css('display', 'none');
            }
        }
    </script>



    @stack('js')

</body>

</html>
