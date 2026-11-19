<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Prabhat Printing Press | @yield('title')</title>
    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/fontawesome-free/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/dropzone/min/dropzone.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin-assets/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/datetimepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/css/datepicker.css') }}">
    @php
        // Cache-buster; tolerate hosts where public_path() isn't the web root.
        $ppCss = public_path('admin-assets/css/premium.css');
        $ppCssVer = is_file($ppCss) ? filemtime($ppCss) : '2';
    @endphp
    <link rel="stylesheet" href="{{ asset('admin-assets/css/premium.css') }}?v={{ $ppCssVer }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        @php
            $ppUser = Auth::user();
            $ppInitials = collect(preg_split('/\s+/', trim($ppUser->name)))
                ->filter()->take(2)->map(fn($w) => mb_strtoupper(mb_substr($w, 0, 1)))->implode('');
        @endphp
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item">
                    <a class="nav-link pp-icon-btn" data-widget="pushmenu" href="#" role="button"
                        aria-label="Toggle sidebar"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-block">
                    <div class="pp-topbar-title">
                        <strong>@yield('title')</strong>
                        <span>{{ now()->format('l, d F Y') }}</span>
                    </div>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto align-items-center">
                <li class="nav-item mr-2 d-none d-md-block">
                    <a class="nav-link pp-icon-btn" data-widget="fullscreen" href="#" role="button"
                        aria-label="Fullscreen">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link pp-user-chip" data-toggle="dropdown" href="#" aria-label="Account menu">
                        <span class="pp-avatar">{{ $ppInitials }}</span>
                        <span class="pp-user-name d-none d-md-inline">{{ $ppUser->name }}</span>
                        <i class="fas fa-chevron-down text-muted d-none d-md-inline" style="font-size:.65rem"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <div class="pp-dropdown-head">
                            <span class="pp-avatar pp-avatar-lg">{{ $ppInitials }}</span>
                            <div>
                                <strong>{{ $ppUser->name }}</strong>
                                <small>{{ $ppUser->email }}</small>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            <i class="fas fa-user mr-2"></i> Profile
                        </a>
                        <a href="{{ route('profile.changePassword') }}" class="dropdown-item">
                            <i class="fas fa-lock mr-2"></i> Change Password
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" class="dropdown-item text-danger"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="fas fa-sign-out-alt mr-2"></i> Log Out
                            </a>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        @include('layouts.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <span><strong>Prabhat Printing Press</strong> &middot; &copy; 2023&ndash;{{ date('Y') }} All rights
                reserved.</span>
            <span>Order &amp; Accounts Management</span>
        </footer>

    </div>
    <!-- ./wrapper -->
    <!-- jQuery -->
    <script src="{{ asset('admin-assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('admin-assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('admin-assets/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('admin-assets/js/demo.js') }}"></script>
    <script src="{{ asset('admin-assets/js/common.js') }}"></script>
    <script src="{{ asset('admin-assets/js/form-sanitization.js') }}"></script>

    <script src="{{ asset('admin-assets/plugins/summernote/summernote.min.js') }}"></script>

    <script src="{{ asset('admin-assets/plugins/dropzone/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin-assets/js/datetimepicker.js') }}"></script>
    <script src="{{ asset('admin-assets/js/datepicker.js') }}"></script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $('.summernote').summernote({
                height: '300px'
            });
        });

        $(document).ready(function() {
            $('.js-datetimepicker').datetimepicker({
                // options here
                format: 'Y-m-d H:i:s',
            });

            // $('.js-datepicker').datetimepicker({
            //     // options here
            //     format: 'Y-m-d',
            // });

            $('.js-datepicker').datepicker({
                dateFormat: 'yy-mm-dd'
            });

            $('.js-filterdatepicker').datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>

    @yield('script')
</body>

</html>
