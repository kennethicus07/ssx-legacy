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
    <title>{{ env('APP_NAME') }} | CMS Admin</title>
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
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
        data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        <header class="topbar" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin5">

                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                            class="ti-menu ti-close"></i></a>
                </div>
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    <ul class="navbar-nav float-start me-auto">
                        <li class="nav-item d-none d-lg-block">
                            <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)"
                                data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a>
                        </li>
                    </ul>
                    <ul class="navbar-nav float-end">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic"
                                href="{{ route('supplier.dashboard') }}" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <span
                                    class="text-white">{{ Auth::guard('supplier')->user()->name ?? 'Supplier' }}</span>&nbsp;&nbsp;<img
                                    src="/assets/images/users/1.jpg" alt="user" class="rounded-circle"
                                    width="31" />
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end user-dd animated"
                                aria-labelledby="navbarDropdown">
                                <!-- <a class="dropdown-item" href="javascript:void(0)"><i class="mdi mdi-account me-1 ms-1"></i> My Profile</a>
                                <a class="dropdown-item" href="javascript:void(0)"><i class="mdi mdi-wallet me-1 ms-1"></i> My Balance</a>
                                <a class="dropdown-item" href="javascript:void(0)"><i class="mdi mdi-email me-1 ms-1"></i> Inbox</a>
                                <div class="dropdown-divider"></div>-->
                                <a class="dropdown-item"
                                    href="{{ route('supplier.my.accounts.change_password.index') }}"><i
                                        class="mdi mdi-account-key me-1 ms-1"></i>
                                    Change Password</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:;"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                        class="fa fa-power-off me-1 ms-1"></i> Logout</a>
                                <form id="logout-form" action="{{ route('supplier.logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                                <!-- <div class="dropdown-divider"></div>
                                <div class="ps-4 p-10">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-success btn-rounded text-white">View Profile</a>
                                </div> -->
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <aside class="left-sidebar" data-sidebarbg="skin5">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav" class="pt-4">
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ route('supplier.dashboard') }}" aria-expanded="false">
                                <i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ route('supplier.account-information') }}" aria-expanded="false">
                                <i class="mdi mdi-account-card-details"></i><span class="hide-menu">Account
                                    Information</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ route('supplier.products.index') }}" aria-expanded="false">
                                <i class="mdi mdi-cart"></i>
                                <span class="hide-menu">Products/Services</span>
                            </a>
                        </li>
                          <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="javascript:void(0)" aria-expanded="false">
                                <i class="mdi mdi-receipt"></i>
                                <span class="hide-menu">Payments</span>
                            </a>
                              <ul aria-expanded="false" class="collapse first-level" id="nav-registration-ul">
                                <li class="sidebar-item" id="subnav-payment-events-li">
                                    <a href="{{ route('supplier.payments.events.index') }}" class="sidebar-link"
                                        id="subnav-payment-events-a"><i
                                            class="mdi mdi-calendar"></i><span class="hide-menu">Events
                                        </span></a>
                                </li>
                            </ul>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="javascript:void(0)" aria-expanded="false">
                                <i class="mdi mdi-chart-line"></i>
                                <span class="hide-menu">Daily Sales Report</span>
                            </a>
                              <ul aria-expanded="false" class="collapse first-level" id="nav-registration-daily-sales-ul">
                                <li class="sidebar-item" id="subnav-daily-sales-report-li">
                                    <a href="{{ route('supplier.daily-sales-report.export-sales.index') }}" class="sidebar-link"
                                        id="subnav-daily-export-sales-a"><i
                                            class="mdi mdi-arrow-right"></i><span class="hide-menu">Export Sales
                                        </span></a>
                                           <a href="{{ route('supplier.daily-sales-report.domestic-sales.index') }}" class="sidebar-link"
                                        id="subnav-daily-domestic-sales-a"><i
                                            class="mdi mdi-arrow-right"></i><span class="hide-menu">Domestic Sales
                                        </span></a>
                                           <a href="{{ route('supplier.daily-sales-report.retail-sales.index')  }}" class="sidebar-link"
                                        id="subnav-daily-retail-sales-a"><i
                            class="mdi mdi-arrow-right"></i><span class="hide-menu">Retail Sales
                                        </span></a>
                                            <a href="{{ route('supplier.daily-sales-report.inquiries.index')  }}" class="sidebar-link"
                                        id="subnav-daily-inquiries-a"><i
                                            class="mdi mdi-arrow-right"></i><span class="hide-menu">Inquiries
                                        </span></a>
                                </li>
                            </ul>
                        </li>

                        {{-- <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ route('supplier.events') }}" aria-expanded="false">
                                <i class="mdi mdi-calendar"></i><span class="hide-menu">Events</span>
                            </a>
                        </li> --}}


                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <div class="page-wrapper" id="app-supplier">
            @yield('content')
            <footer class="footer text-center">
                {{ env('APP_NAME') }} 2021.
            </footer>
        </div>
    </div>
    <script src="{{ mix('js/supplier/app.js') }}"></script>
    <script src="{{ mix('js/admin/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ mix('js/admin/sparkline.js') }}"></script>
    <script src="{{ mix('js/admin/waves.js') }}"></script>
    <script src="{{ mix('js/admin/sidebarmenu.js') }}"></script>
    <script src="{{ mix('js/admin/custom.min.js') }}"></script>
    @stack('scripts')

</body>

</html>
