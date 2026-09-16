<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="robots" content="noindex,nofollow" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME') }} | Buyer Portal</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favico.png') }}" />
    <link href="{{ mix('css/admin/ssx.css') }}" rel="stylesheet">
    @stack('styles')
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
        data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        
        <!-- Topbar Header -->
        <header class="topbar" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin5">
                    <a class="navbar-brand" href="{{ route('buyer.dashboard') }}">
                        <b class="logo-icon ps-2 mt-1">
                            <img src="/assets/images/ssx-full-logo-white.png" alt="dashboard"
                                class="light-logo img-fluid" />
                        </b>
                    </a>
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                            class="ti-menu ti-close"></i></a>
                </div>
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    <!-- Left Sidebar Toggler -->
                    <ul class="navbar-nav float-start me-auto">
                        <li class="nav-item d-none d-lg-block">
                            <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)"
                                data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a>
                        </li>
                    </ul>
                    <!-- Right User Profile Dropdown -->
                    <ul class="navbar-nav float-end">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic"
                                href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <span class="text-white">{{ Auth::user()->name ?? 'Buyer Account' }}</span>&nbsp;&nbsp;<img
                                    src="/assets/images/users/1.jpg" alt="user" class="rounded-circle"
                                    width="31" />
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end user-dd animated"
                                aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('buyer.account') }}"><i
                                        class="mdi mdi-account-cog me-1 ms-1"></i> My Account Management</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:;"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                        class="fa fa-power-off me-1 ms-1"></i> Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- Left Sidebar Navigation -->
        <aside class="left-sidebar" data-sidebarbg="skin5">
            <div class="scroll-sidebar">
                <nav class="sidebar-nav">
                    <ul id="sidebarnav" class="pt-4">
                        
                        <!-- Dashboard -->
                        <li class="sidebar-item" id="nav-buyer-dashboard">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ route('buyer.dashboard') }}" aria-expanded="false">
                                <i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Buyer Dashboard</span>
                            </a>
                        </li>

                        <!-- My Account Management -->
                        <li class="sidebar-item" id="nav-buyer-account">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ route('buyer.account') }}" aria-expanded="false">
                                <i class="mdi mdi-account-cog"></i><span class="hide-menu">My Account Management</span>
                            </a>
                        </li>

                        <!-- Events Management -->
                        <li class="sidebar-item" id="nav-buyer-events">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ route('buyer.events') }}" aria-expanded="false">
                                <i class="mdi mdi-calendar-blank"></i><span class="hide-menu">Events Management</span>
                            </a>
                        </li>

                        <!-- Bookmark Feature -->
                        <li class="sidebar-item" id="nav-buyer-bookmarks">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ route('buyer.bookmarks') }}" aria-expanded="false">
                                <i class="mdi mdi-star"></i><span class="hide-menu">Bookmark Feature</span>
                            </a>
                        </li>

                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Page Wrapper / Content Area -->
        <div class="page-wrapper" id="app-buyer">
            <div class="container-fluid">
                <!-- Session Success Alert -->
                @if(session('status_success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="mdi mdi-check-circle me-2"></i>{{ session('status_success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>

            <footer class="footer text-center">
                {{ env('APP_NAME') }} Buyer Portal &copy; {{ date('Y') }}.
            </footer>
        </div>

    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script src="{{ mix('js/admin/ssx-vendors.js') }}"></script>
    <script src="{{ mix('js/admin/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ mix('js/admin/sparkline.js') }}"></script>
    <script src="{{ mix('js/admin/waves.js') }}"></script>
    <script src="{{ mix('js/admin/sidebarmenu.js') }}"></script>
    <script src="{{ mix('js/admin/custom.min.js') }}"></script>
    @stack('scripts')
</body>

</html>