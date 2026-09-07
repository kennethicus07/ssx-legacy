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
                    <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                        <b class="logo-icon ps-2 mt-1">
                            <img src="/assets/images/ssx-full-logo-white.png" alt="dashboard"
                                class="light-logo img-fluid" />
                        </b>
                        <!-- <span class="logo-text ms-2">
                            <img src="/assets/images/logo-text.png" alt="homepage" class="light-logo" />
                        </span> -->
                    </a>
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
                                href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <span class="text-white">{{ Auth::user()->name }}</span>&nbsp;&nbsp;<img
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
                                    href="{{ route('admin.my.accounts.change_password.index') }}"><i
                                        class="mdi mdi-account-key me-1 ms-1"></i> Change Password</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:;"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                        class="fa fa-power-off me-1 ms-1"></i> Logout</a>
                                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST"
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
                        @if (auth()->user()->can('view dashboard'))
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ route('admin.dashboard') }}" aria-expanded="false">
                                    <i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span>
                                </a>
                            </li>
                        @endif
                        @if (auth()->user()->can('view carousel'))
                            <li class="sidebar-item" id="nav-carousel">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link" id="subnav-carousel"
                                    href="{{ route('admin.carousel-banners.index') }}" aria-expanded="false">
                                    <i class="mdi mdi-file-image"></i><span class="hide-menu">Home Carousel
                                        Banners</span>
                                </a>
                            </li>
                        @endif
                          <li class="sidebar-item" id="nav-booth-system">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                id="subnav-b2b-system" href="https://b2b.sustainability.ph/" target="_blank"
                                aria-expanded="false">
                                <i class="mdi mdi-sync"></i><span class="hide-menu">B2B System</span>
                            </a>
                        </li>
                        <li class="sidebar-item" id="nav-registration">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" id="nav-registration-a"
                                href="javascript:void(0)" aria-expanded="false"><i
                                    class="mdi mdi-account-multiple"></i><span class="hide-menu">Registration
                                </span></a>
                            <ul aria-expanded="false" class="collapse first-level" id="nav-registration-ul">
                                @if (auth()->user()->can('view reg_suppliers'))
                                    <li class="sidebar-item" id="subnav-registration-suppliers-li">
                                        <a href="{{ route('admin.suppliers.registration') }}" class="sidebar-link"
                                            id="subnav-registration-suppliers-a"><i class="mdi mdi-account"></i><span
                                                class="hide-menu">Suppliers/Exhibitors </span></a>
                                    </li>
                                @endif
                                @if (auth()->user()->can('view reg_buyers'))
                                    <li class="sidebar-item" id="subnav-registration-buyers-li">
                                        <a href="{{ route('admin.buyers.registration') }}" class="sidebar-link"
                                            id="subnav-registration-buyers-a"><i
                                                class="mdi mdi-account-outline"></i><span
                                                class="hide-menu">Purchasers/Buyers
                                            </span></a>
                                    </li>
                                @endif
                               

                                <li class="sidebar-item" id="subnav-registration-conference-li">
                                    <a href="{{ route('admin.registration.delegates.index') }}" class="sidebar-link"
                                        id="subnav-registration-conference-a"><i
                                            class="mdi mdi-microphone-variant"></i><span class="hide-menu">Delegates
                                        </span></a>
                                </li>
                                <li class="sidebar-item" id="subnav-registration-sponsorship-li">
                                    <a href="{{ route('admin.sponsorship.registration') }}" class="sidebar-link"
                                        id="subnav-registration-conference-a"><i class="mdi mdi-trophy"></i><span
                                            class="hide-menu">Sponsorship
                                        </span></a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item" id="nav-booth-system">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                id="subnav-booth-system" href="{{ route('admin.booth-system.index') }}"
                                aria-expanded="false">
                                <i class="mdi mdi-store"></i><span class="hide-menu">Booth System</span>
                            </a>
                        </li>


                        <li class="sidebar-item" id="nav-codes">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" id="nav-registration-a"
                                href="javascript:void(0)" aria-expanded="false"><i
                                    class="mdi mdi-ticket-percent"></i><span class="hide-menu">Promo Codes
                                </span></a>
                                  <ul aria-expanded="false" class="collapse first-level" id="nav-registration-ul">
                                <li class="sidebar-item" id="subnav-registration-conference-li">
                                    <a href="{{ route('admin.promo-codes.users.index') }}" class="sidebar-link"
                                        id="subnav-registration-conference-a"><i
                                            class="mdi  mdi-ticket-account"></i><span class="hide-menu">Emails
                                        </span></a>
                                </li>
                            </ul>
                        </li>
                     @if (auth()->user()->can('view payments'))
                         <li class="sidebar-item" id="payments">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" id="nav-registration-a"
                                href="javascript:void(0)" aria-expanded="false"><i
                                    class="mdi mdi-receipt"></i><span class="hide-menu">Payments
                                </span></a>
                                <ul aria-expanded="false" class="collapse first-level" id="nav-payment-ul">
                                <li class="sidebar-item" id="subnav-payment-supplier-li">
                                    <a href="{{ route('admin.payments.suppliers.exhibitors.index') }}" class="sidebar-link"
                                        id="subnav-payment-supplier-a"><i
                                            class="mdi mdi-account"></i><span class="hide-menu">Supplier/Exhibitors
                                        </span></a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        <li class="sidebar-item" id="daily-sales-report">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" id="nav-daily-sales-report-a"
                                href="javascript:void(0)" aria-expanded="false"><i
                                    class="mdi mdi-chart-line"></i><span class="hide-menu">Daily Sales Report
                                </span></a>
                                  <ul aria-expanded="false" class="collapse first-level" id="nav-daily-sales-report-ul">
                                <li class="sidebar-item" id="subnav-daily-sales-report-li">
                                  <a href="{{ route('admin.daily-sales-report.sales-management.index') }}" class="sidebar-link"
                                        id="subnav-sales-management-a"><i
                                            class="mdi mdi-arrow-right"></i><span class="hide-menu">Sales Management
                                        </span></a>
                                   <a href="{{ route('admin.daily-sales-report.sales-activity.index') }}" class="sidebar-link"
                                        id="subnav-sales-activity-a"><i
                                            class="mdi mdi-arrow-right"></i><span class="hide-menu">General Summary
                                        </span></a>
                                        <a href="{{ route('admin.daily-sales-report.export-sales.index') }}" class="sidebar-link"
                                        id="subnav-export-sales-a"><i
                                            class="mdi mdi-arrow-right"></i><span class="hide-menu">Export Sales
                                        </span></a>
                                         <a href="{{ route('admin.daily-sales-report.domestic-sales.index') }}"  class="sidebar-link"
                                        id="subnav-domestic-sales-a"><i
                                            class="mdi mdi-arrow-right"></i><span class="hide-menu">Domestic Sales
                                        </span></a>
                                         <a href="{{ route('admin.daily-sales-report.retail-sales.index') }}" class="sidebar-link"
                                        id="subnav-retail-sales-a"><i
                                            class="mdi mdi-arrow-right"></i><span class="hide-menu">Retail Sales
                                        </span></a>
                                         <a href="{{ route('admin.daily-sales-report.inquiries.index') }}" class="sidebar-link"
                                        id="subnav-inquiries-a"><i
                                            class="mdi mdi-arrow-right"></i><span class="hide-menu">Inquiries
                                        </span></a>
                                </li>
                            </ul>
                        </li>
                
                        @if (auth()->user()->can('view articles') ||
                                auth()->user()->can('view sustainable') ||
                                auth()->user()->can('view intelligence') ||
                                auth()->user()->can('view ondemand'))
                            <li class="sidebar-item" id="nav-articles">
                                <a class="sidebar-link has-arrow waves-effect waves-dark" id="nav-articles-a"
                                    href="javascript:void(0)" aria-expanded="false"><i
                                        class="mdi mdi-newspaper"></i><span class="hide-menu">Articles </span></a>
                                <ul aria-expanded="false" class="collapse first-level" id="nav-articles-ul">
                                    @if (auth()->user()->can('view articles'))
                                        <li class="sidebar-item" id="subnav-news-articles-li">
                                            <a href="{{ route('admin.news-articles.index') }}" class="sidebar-link"
                                                id="subnav-news-articles-a"><i
                                                    class="mdi mdi-television-guide"></i><span class="hide-menu">News
                                                    & Articles </span></a>
                                        </li>
                                    @endif
                                    @if (auth()->user()->can('view intelligence'))
                                        <li class="sidebar-item" id="subnav-solutions-intelligence-li">
                                            <a href="{{ route('admin.articles.solutions-intelligence.index') }}"
                                                class="sidebar-link" id="subnav-solutions-intelligence-a"><i
                                                    class="mdi mdi-monitor"></i><span class="hide-menu">Solutions
                                                    Intelligence </span></a>
                                        </li>
                                    @endif
                                    @if (auth()->user()->can('view ondemand'))
                                        <li class="sidebar-item" id="subnav-ondemand-resources-li">
                                            <a href="{{ route('admin.articles.on-demand-resources.index') }}"
                                                class="sidebar-link" id="subnav-ondemand-resources-a"><i
                                                    class="mdi mdi-book-open"></i><span class="hide-menu">On-Demand
                                                    Resources</span></a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                        @if (auth()->user()->can('view enablers') || auth()->user()->can('view offers'))
                            <li class="sidebar-item" id="nav-export-enablers">
                                <a class="sidebar-link has-arrow waves-effect waves-dark" id="nav-export-enablers-a"
                                    href="javascript:void(0)" aria-expanded="false"><i
                                        class="mdi mdi-export"></i><span class="hide-menu">Business Solutions
                                        Services</span></a>
                                <ul aria-expanded="false" class="collapse first-level" id="nav-export-enablers-ul">
                                    @if (auth()->user()->can('view enablers'))
                                        <li class="sidebar-item" id="subnav-companies-li">
                                            <a href="{{ route('admin.export-enablers.companies.index') }}"
                                                class="sidebar-link" id="subnav-companies-a"><i
                                                    class="mdi mdi-factory"></i><span class="hide-menu">Companies
                                                </span></a>
                                        </li>
                                    @endif
                                    @if (auth()->user()->can('view offers'))
                                        <li class="sidebar-item" id="subnav-programs-offers-li">
                                            <a href="{{ route('admin.export-enablers.programs-offers.index') }}"
                                                class="sidebar-link" id="subnav-programs-offers-a"><i
                                                    class="mdi mdi-newspaper"></i><span class="hide-menu">Featured
                                                    Programs & Offers </span></a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                        @if (auth()->user()->can('view conference') || auth()->user()->can('view video'))
                            <li class="sidebar-item" id="nav-exhibitions">
                                <a class="sidebar-link has-arrow waves-effect waves-dark" id="nav-exhibitions-a"
                                    href="javascript:void(0)" aria-expanded="false"><i
                                        class="mdi mdi-theater"></i><span class="hide-menu">Exhibitions & Conferences
                                    </span></a>
                                <ul aria-expanded="false" class="collapse first-level" id="nav-exhibitions-ul">
                                    @if (auth()->user()->can('view conference'))
                                        <li class="sidebar-item" id="subnav-conferences-li">
                                            <a href="{{ route('admin.exhibitions-conferences.index') }}"
                                                class="sidebar-link" id="subnav-conferences-a"><i
                                                    class="mdi mdi-spotlight"></i><span class="hide-menu">Conferences
                                                </span></a>
                                        </li>
                                    @endif
                                    @if (auth()->user()->can('view video'))
                                        <li class="sidebar-item" id="subnav-videos-li">
                                            <a href="{{ route('admin.conferences-videos.index') }}"
                                                class="sidebar-link" id="subnav-videos-a"><i
                                                    class="mdi mdi-youtube-play"></i><span class="hide-menu">Youtube
                                                    Videos </span></a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                        @if (auth()->user()->can('view events'))
                            <li class="sidebar-item" id="nav-events">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link" id="subnav-events"
                                    href="{{ route('admin.events-activities.index') }}" aria-expanded="false">
                                    <i class="mdi mdi-calendar-today"></i><span class="hide-menu">Events &
                                        Activities</span>
                                </a>
                            </li>
                        @endif
                        @if (auth()->user()->can('view certifications'))
                            <li class="sidebar-item" id="nav-certifications">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    id="subnav-certifications" href="{{ route('admin.certifications.index') }}"
                                    aria-expanded="false">
                                    <i class="mdi mdi-certificate"></i><span class="hide-menu">Certifications</span>
                                </a>
                            </li>
                        @endif
                        @if (auth()->user()->can('view pages'))
                            <li class="sidebar-item" id="nav-pages">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link" id="subnav-pages"
                                    href="{{ route('admin.pages.index') }}" aria-expanded="false">
                                    <i class="mdi mdi-book-open"></i><span class="hide-menu">Pages</span>
                                </a>
                            </li>
                        @endif
                        @if (auth()->user()->can('view widgets'))
                            view seo <li class="sidebar-item" id="nav-widgets">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link" id="subnav-widgets"
                                    href="{{ route('admin.widgets.index') }}" aria-expanded="false">
                                    <i class="mdi mdi-chart-bubble"></i><span class="hide-menu">Widgets</span>
                                </a>
                            </li>
                        @endif
                        @if (auth()->user()->can(''))
                            <li class="sidebar-item" id="nav-meta-tags">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link" id="subnav-meta-tags"
                                    href="{{ route('admin.pages-meta-tags.index') }}" aria-expanded="false">
                                    <i class="mdi mdi-web"></i><span class="hide-menu">SEO Pages Meta Tags</span>
                                </a>
                            </li>
                        @endif
                        @if (auth()->user()->user_group === 1)
                            <li class="sidebar-item" id="nav-user-accounts">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link" id="subnav-user-accounts"
                                    href="{{ route('admin.user-accounts.index') }}" aria-expanded="false">
                                    <i class="mdi mdi-account-key"></i><span class="hide-menu">User Accounts</span>
                                </a>
                            </li>
                        @endif
                        @if (auth()->user()->user_group === 1)
                            <li class="sidebar-item" id="nav-cache">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link" id="subnav-cache"
                                    href="{{ route('admin.website.cache') }}" aria-expanded="false">
                                    <i class="mdi mdi-server"></i><span class="hide-menu">Website Cache</span>
                                </a>
                            </li>
                        @endif

                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <div class="page-wrapper" id="app-admin">
            @yield('content')
            <footer class="footer text-center">
                {{ env('APP_NAME') }} 2021.
            </footer>
        </div>
    </div>
    <script src="{{ mix('js/admin/ssx-vendors.js') }}"></script>
    <script src="{{ mix('js/admin/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ mix('js/admin/sparkline.js') }}"></script>
    <script src="{{ mix('js/admin/waves.js') }}"></script>
    <script src="{{ mix('js/admin/sidebarmenu.js') }}"></script>
    <script src="{{ mix('js/admin/custom.min.js') }}"></script>
    @stack('scripts')

</body>

</html>
