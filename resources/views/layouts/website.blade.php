<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favico.png') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="facebook-domain-verification" content="b8xjf1swa5ks1u22wqfko2qjc2i4p7" />
    @metas
    @if (env('APP_ENV') === 'production')
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-156674052-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'UA-156674052-1');
        </script>

        <!-- Global site tag (gtag.js) - Google Analytics GA4 -->
        {{-- <script async src="https://www.googletagmanager.com/gtag/js?id=G-J5YZW4BPL9"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-J5YZW4BPL9');
    </script> --}}
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-M5Q70RPRSW"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'G-M5Q70RPRSW');
        </script>

        <!-- Meta Pixel Code -->
        <script>
            ! function(f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function() {
                    n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '471572287872220');
            fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
                src="https://www.facebook.com/tr?id=471572287872220&ev=PageView&noscript=1" /></noscript>
        <!-- End Meta Pixel Code -->

        <!-- Twitter universal website tag code -->
        <script>
            ! function(e, t, n, s, u, a) {
                e.twq || (s = e.twq = function() {
                        s.exe ? s.exe.apply(s, arguments) : s.queue.push(arguments);
                    }, s.version = '1.1', s.queue = [], u = t.createElement(n), u.async = !0, u.src =
                    '//static.ads-twitter.com/uwt.js',
                    a = t.getElementsByTagName(n)[0], a.parentNode.insertBefore(u, a))
            }(window, document, 'script');
            // Insert Twitter Pixel ID and Standard Event data below
            twq('init', 'o7f6q');
            twq('track', 'PageView');
        </script>
        <!-- End Twitter universal website tag code -->
    @endif
    <link href="{{ mix('css/website/ssx-vendors.css') }}" rel="stylesheet">
    <style>
        /* MAINTENANCE MODAL START */
        /* nav.navbar {
                z-index: 997 !important;
            }

            .overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 998;
            }
            
            .modal {
                display: none;
                position: fixed;
                z-index: 999;
                overflow: hidden;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 60vw;
                max-height: 600px;
                background-color: #fff;
                box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
                border-radius: 8px;
            }

            .modal-content {
                display: flex;
                flex-direction: column;
                width: 100%;
                height: 100%;
            }

            .modal-body {
                padding: 1rem;
                overflow-y: auto;
                max-height: 575px;
            }
            
            .close {
                position: absolute;
                top: 15px;
                right: 20px;
                color: #333;
                font-size: 30px;
                font-weight: bold;
                cursor: pointer;
                z-index: 999;
            }

            @media (max-width: 992px) {
                .modal {
                    width: 80%;
                }

                .modal-logo {
                    width: 150px;
                }
            } */
        /* MAINTENANCE MODAL END */

        /* SECURITY */
  /* SECURITY ADVISORY MODAL */
.security-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.65);
    z-index: 9998;
}

.security-modal {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 92%;
    max-width: 760px;
    max-height: 88vh;
    overflow: hidden;
    background: #fff;
    border-radius: 14px;
    z-index: 9999;
    box-shadow: 0 15px 45px rgba(0,0,0,.25);
    border-top: 8px solid #b22222;
}

.security-modal-content {
    position: relative;
    height: 100%;
}

.security-modal-body {
    padding: 40px;
    overflow-y: auto;
    max-height: 88vh;
}

.security-logo {
    width: 220px;
    max-width: 100%;
}

.security-close {
    position: absolute;
    top: 14px;
    right: 18px;
    border: none;
    background: transparent;
    font-size: 34px;
    line-height: 1;
    cursor: pointer;
    color: #555;
    z-index: 10;
}

.security-title {
    font-size: 30px;
    font-weight: 800;
    color: #b22222;
    margin-bottom: 10px;
}

.security-subtitle {
    font-size: 18px;
    font-weight: 600;
    color: #222;
    line-height: 1.5;
}

.security-section {
    margin-top: 28px;
}

.security-section h5 {
    color: #b22222;
    font-weight: 700;
    margin-bottom: 10px;
}

.security-modal p,
.security-modal li {
    color: #333;
    line-height: 1.8;
    font-size: 15px;
}

.security-modal ul {
    padding-left: 20px;
}

@media (max-width: 768px) {

    .security-modal {
        width: 95%;
        max-height: 90vh;
    }

    .security-modal-body {
        padding: 24px;
    }

    .security-title {
        font-size: 24px;
    }

    .security-subtitle {
        font-size: 16px;
    }

    .security-logo {
        width: 170px;
    }
}
        /* SECURITY END */

        /* Mobile / default */
        .custom-dropdown {
            margin-right: 3rem;
            /* me-5 equivalent */
        }

        /* Large screens and up (Bootstrap lg = 992px) */
        @media (min-width: 992px) {
            .custom-dropdown {
                margin-right: 0;
                margin-left: -160px;
            }
        }

        .custom-link {
            color: #9daa39;
            text-decoration: underline;
            background-color: transparent;
        }

        .custom-link:hover,
        .custom-link:focus {
            color: #9daa39;
            text-decoration: underline;
            background-color: transparent;
        }
    </style>
    @stack('styles')
    <link href="{{ mix('css/website/ssx.css') }}" rel="stylesheet">
    <link href="{{ mix('css/website/ssx-custom.css') }}" rel="stylesheet">
</head>

<body>
    <!-- MAINTENANCE MODAL START -->
    <!-- <div id="overlay" class="overlay"></div>
            <div id="imageModal" class="modal">
                <div class="modal-content">
                    <div class="modal-body">
                        <span class="close">&times;</span>
                        <div class="container p-4">
                        <div class="row mb-5">
                            <div class="col-12">
                                <img class="modal-logo" width="250" src="https://citem.gov.ph/img/cLogo/CITEM_full_xs.png" alt="">
                            </div>
                        </div>
                        <div class="row mb-4 text-center">
                            <div class="col-12">
                                <span style="font-family: 'Montserrat', sans-serif; font-weight: bold; font-size: 23px;">CITEM ADVISORY</span>
                            </div>
                            <div class="col-12">
                                14 NOVEMBER 2024
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <p>To Our Valued Stakeholders,</p>
                                <p>It has come to our attention that unauthorized individuals and entities have been falsely claiming to sell the list of trade buyers for events organized by the Center for International Trade Expositions and Missions (CITEM), such as IFEX Philippines, Manila FAME, and other projects.</p>
                                <p>Please be advised that:
                                    <ol>
                                        <li><strong>CITEM does not sell nor disclose the list of trade buyers</strong> to any third party. All participant information is handled with strict confidentiality in compliance with data privacy laws and agency's commitment to ethical business practices.</li>
                                        <li>Any offers or communications claiming to sell trade buyer lists for CITEM-organized events are fraudulent and unauthorized. These scammers aim to deceive and exploit stakeholders for personal gain.</li>
                                        <li>To verify the authenticity of any communication or inquiry related to CITEM events, please contact CITEM through our official channels:
                                            <ul style="list-style-type:disc">
                                                <li><strong>Website:</strong> <a href="https://citem.gov.ph" target="_blank">CITEM Official Website</a></li>
                                                <li><strong>Email:</strong> <a href="mailto:info@citem.com.ph">info@citem.com.ph</a></li>
                                                <li><strong>Phone:</strong> <a href="tel:+63288312201">+63 (02) 8831-2201</a></li>
                                            </ul>
                                        </li>
                                    </ol>
                                </p>
                                <p>
                                    <span style="font-family: 'Montserrat', sans-serif; font-weight: bold;">What You Can Do:</span>
                                    <ul style="list-style-type:disc">
                                        <li><strong>Do not engage with nor respond to these scammers.</strong> Avoid sharing any personal or financial information.</li>
                                        <li>Report suspicious communications to CITEM through the contact details above.</li>
                                        <li>Regularly check updates on CITEM’s official website and social media channels.</li>
                                    </ul>
                                </p>
                                <p>CITEM remains committed to safeguarding the interests of its stakeholders and promoting secure and trustworthy interactions. Your vigilance and cooperation are essential in combating fraudulent activities.</p>
                                <p>Thank you for your continued trust and support.</p>
                                <br>
                                <p><strong><span style="font-family: 'Montserrat', sans-serif; font-weight: bold;">Center for International Trade Expositions and Missions</span></strong></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-instruct text-center">
                    <small style="color: #C5C5C5;">Scroll up or down to view</small>
                </div>
            </div>
            
                
        </div> -->
    <!-- MAINTENANCE MODAL END -->
<!-- SECURITY ADVISORY MODAL START -->
<div id="securityOverlay" class="security-overlay"></div>

<div id="securityAdvisoryModal" class="security-modal">
    <div class="security-modal-content">

        <button type="button" class="security-close">
            &times;
        </button>

        <div class="security-modal-body">

            <div class="text-center mb-4">
                <img
                    class="security-logo"
                    src="https://citem.gov.ph/img/cLogo/CITEM_full_xs.png"
                    alt="CITEM Logo">
            </div>

            <div class="text-center mb-4">
                <h2 class="security-title">
                    PUBLIC ADVISORY
                </h2>

                <p class="security-subtitle">
                Beware of Unauthorized Communications, Data Selling, Solicitations, and Monetary Requests
                </p>
            </div>

            <p>
              CITEM advises all exhibitors, buyers, suppliers, service providers, partners, stakeholders, and the public to remain vigilant against unauthorized individuals, groups, or third-party entities falsely claiming to represent CITEM and its official programs and events.
              <br>
              <br>
These unauthorized communications may be sent through email, calls, SMS/text messages, social media, messaging applications, websites, or other digital channels. They may involve the alleged selling, distribution, or unauthorized access to CITEM data, databases, or contact lists. They may also involve solicitations, donation requests, sponsorship offers, payment instructions, or other monetary requests using the name of CITEM, its officials, personnel, events, or partners.
            </p>

            <p class="mt-4">
             Please be reminded:
            </p>

            <div class="security-section">
                <h5>Verify the Source</h5>

                <p>
                    Official CITEM communications are sent only through verified official channels and corporate email domains, including <strong>@citem.com.ph</strong>.
                </p>
            </div>

            <div class="security-section">
                <h5>Protect Your Information</h5>
                <p>
                  CITEM does not authorize any individual, third-party entity, or unofficial representative to sell, distribute, share, or provide access to its official data, databases, contact lists, or stakeholder information.
                </p>
            </div>

            <div class="security-section">
                <h5>Do Not Send Payments Through Unverified Channels.</h5>
                <p>
                  CITEM does not authorize donations, sponsorship payments, direct fund transfers, e-wallet payments, or other monetary transactions through personal accounts or unofficial channels.
                </p>
            </div>

            <div class="security-section">
                <h5>Do Not Engage</h5>
                <p>Do not click links, download attachments, reply, provide information, or make payments in response to suspicious communications.</p>
                {{-- <ul>
                    <li>Do not click any links</li>
                    <li>Do not download attachments</li>
                    <li>Do not reply to the sender</li>
                    <li>Do not make any payment</li>
                </ul> --}}
            </div>

            <div class="security-section">
                <h5>Report and Verify</h5>

                <p>
                    If you receive any suspicious communication claiming to be connected with CITEM, please verify directly with your official project focal point or through CITEM’s official communication channels.
                </p>
            </div>

            <p class="mt-4">
               Thank you for your continued cooperation and vigilance.
            </p>

            {{-- <p class="mt-4 mb-0">
                <strong>
                    Center for International Trade Expositions and Missions
                </strong>
            </p> --}}

        </div>
    </div>
</div>
<!-- SECURITY ADVISORY MODAL END -->


    <header>
        <nav class="navbar navbar-expand-lg sticky-top navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('home') }}"><img src="/assets/images/ssx-logo.png"
                        alt="SSX Logo"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                    aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        {{-- <li class="nav-item dropdown">
                            <a class="nav-link"
                                style="border: 1px solid #9daa39; background-color: #9daa39; color: #FFF !important; border-radius: 15px; padding: 8px 15px !important;"
                                aria-current="page" href="{{ route('events-activities.showInfo') }}" id="nav-events"
                                role="button" aria-expanded="false">
                                SSX Conference 2025
                            </a>
                        </li> --}}
                        <li class="nav-item dropdown">
                            {{-- <a class="nav-link dropdown-toggle" aria-current="page"
                                href="{{ route('events-activities.index') }}" id="nav-events" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Events & Activities
                            </a> --}}
                            <a class="nav-link dropdown-toggle" aria-current="page" href="" id="nav-events"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Events & Activities
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="nav-events">
                                {{-- <li><a class="dropdown-item" href="{{ route('events-activities.index') }}">Featured Partner Events</a></li>
                                <li><a class="dropdown-item" href="{{ route('events-activities.index') }}#global-initiatives">Global Initiatives</a></li>
                                <li><a class="dropdown-item" href="{{ route('events-activities.index') }}#webinars">Webinars</a></li>
                                <li><a class="dropdown-item" href="{{ route('events-activities.index') }}#local-highlights">Local Highlights</a></li>
                                <li><a class="dropdown-item" href="{{ route('events-activities.index') }}#on-demand-resources">On-Demand Resources</a></li> --}}

                                <li><a class="dropdown-item"
                                        href="{{ route('events-activities.conference_and_exhibition') }}">SSX
                                        Conference & Exhibition</a></li>
                                {{-- <li><a class="dropdown-item" href="{{ route('events-activities.sdg_asia_2025') }}">SDG
                                        Asia 2025
                                    </a></li> --}}
                                {{-- <li><a class="dropdown-item"
                                        href="{{ route('events-activities.sdg_asia_2025') }}">SDGAsia 2026 Participation
                                    </a></li> --}}
                                <li><a class="dropdown-item"
                                        href="{{ route('events-activities.sdg_asia_2026') }}">SDG Asia Taiwan 2026
                                    </a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="{{ route('about-us') }}" id="nav-about"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                About
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="nav-about">
                                <li><a class="dropdown-item" href="{{ route('about-us') }}">About SSX</a></li>
                                <li><a class="dropdown-item" href="{{ route('about-us') }}">Event Components</a></li>
                                <li><a class="dropdown-item" href="{{ route('about-us') }}">Partners</a></li>
                                <li><a class="dropdown-item" href="{{ route('about-us') }}">Organizers</a></li>
                                <li><a class="dropdown-item" href="{{ route('about-us') }}#contactUs">Contact Us</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="nav-solutions" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <!-- Solutions -->
                                Directory
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="nav-solutions">
                                <li><a class="dropdown-item" href="{{ route('solutions.directories.suppliers') }}">
                                        <!-- Marketplace -->
                                        Suppliers/Exhibitors
                                    </a></li>
                                <li><a class="dropdown-item"
                                        href="{{ route('solutions.sustainable.index') }}">Sustainable Solutions</a>
                                </li>
                                <!-- <li><a class="dropdown-item" href="{{ route('solutions.intelligence.index') }}">Solutions Intelligence</a></li> -->
                            </ul>
                        </li>
                        {{-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="nav-services" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Services
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item"
                                        href="{{ route('services.export-enablers.index') }}">Business Solutions
                                        Services</a></li>
                                <!-- <li><a class="dropdown-item" href="{{ route('services.export-enablers.index') }}">Partnership Opportunities</a></li> -->
                            </ul>
                        </li> --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="nav-articles" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Resources & News
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="nav-articles">
                                {{-- <li><a class="dropdown-item" href="{{ route('news-articles.index') }}">Webinars</a></li> --}}
                                <li><a class="dropdown-item" href="{{ route('news-articles.index') }}">News &
                                        Articles</a></li>
                                <li><a class="dropdown-item"
                                        href="{{ route('solutions.intelligence.index') }}">Solutions Intelligence</a>
                                </li>
                                {{-- <li><a class="dropdown-item"
                                        href="{{ route('resources-news.digital-exhibition-conference-2022.index') }}">Digital
                                        Exhibition & Conference 2022</a>
                                    
                                    </li> --}}
                                <li><a class="dropdown-item"
                                        style="
           pointer-events: none;
           cursor: default;
           background-color: transparent;
       ">
                                        Past SSX Conference Videos
                                    </a>
                                </li>

                                <li>
                                    <ul class="dropdown-menu-list mb-2">
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('resources-news.digital-exhibition-conference-2022.index') }}">
                                                Digital Exhibition & Conference 2025
                                            </a>
                                        </li>
                                    </ul>
                                </li>


                                {{-- <li><a class="dropdown-item" href="{{ route('news-articles.index') }}">Ambisyon Natin
                                        2040</a></li> --}}
                                {{-- <li><a class="dropdown-item"
                                        href="https://www.sec.gov.ph/wp-content/uploads/2019/10/2019MCNo04.pdf"
                                        target="_blank">SEC Sustainability Reporting Guidelines</a></li> --}}
                                {{-- <li><a class="dropdown-item" href="{{ route('certifications.index') }}">Glossary of
                                        Certifications</a></li> --}}
                            </ul>
                        </li>
                    </ul>
                    @auth('web')
                        <span class="navbar-text">
                            <a href="javascript:;" class="lightgreen" id="nav-search"><i class="fas fa-search"></i></a>
                            <a href="javascript:;" class="black"><i class="fas fa-user"></i></a>
                            <span class="fs-12 fw-bold text-dark">{{ auth()->user()->name }}</span> | <a
                                href="javascript:;"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </span>
                    @endauth
                    @auth('supplier')
                        <span class="navbar-text">
                            <a href="javascript:;" class="lightgreen" id="nav-search"><i class="fas fa-search"></i></a>
                            <a href="{{ route('supplier.dashboard') }}" class="black"><i class="fas fa-user"></i>
                                <span class="fs-12 fw-bold text-dark">{{ auth('supplier')->user()->name }}</span></a> |
                            <a href="javascript:;"
                                onclick="event.preventDefault(); document.getElementById('logout-web-form').submit();">Logout</a>
                            <form id="logout-web-form" action="{{ route('supplier.logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </span>
                    @endauth
                    {{-- @guest
                        <div class="d-flex justify-content-start align-items-center navbar-text">
                            <a href="javascript:;" class="lightgreen" id="nav-search"><i class="fas fa-search"></i></a>
                            <a href="{{ route('auth.index') }}">Login</a> |
                            <div class="dropdown ms-1" style="margin-top: -2px !important;">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Register
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink"
                                    style="margin-left: -100px !important;">
                                    <li><a class="dropdown-item" href="{{ env('SUPPLIER_REG_LINK') }}">Register as a
                                            Supplier</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="{{ env('PURCHASER_REG_LINK') }}">Register as a
                                            Purchaser</a></li>
                                </ul>
                            </div>
                        </div>
                    @endguest --}}
                    {{-- Guest (only if no one is logged in) --}}
                    @guest('web')
                        @guest('supplier')
                            <div class="d-flex justify-content-start align-items-center navbar-text">
                                <a href="javascript:;" class="lightgreen" id="nav-search"><i class="fas fa-search"></i></a>
                                <a href="{{ route('auth.index') }}">Login</a> |
                                <div class="dropdown ms-1" style="margin-top: -2px !important;">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Register
                                    </a>
                                    <ul class="dropdown-menu custom-dropdown" aria-labelledby="dropdownMenuLink">
                                        <li><a class="dropdown-item" href="{{ route('registration.supplier.email.validation') }}">Register as a
                                                Supplier/Exhibitor</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="{{route('registration.buyer.email.validation') }}">Register as a
                                                Purchaser/Buyer</a></li>
                                          <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="{{ route('conference.registration') }}">Register as a
                                                Conference Delegate</a></li>
                                    </ul>
                                </div>
                            </div>
                        @endguest
                    @endguest
                </div>
            </div>
        </nav>
        <div class="searchbox_container beige-bg section" id="searchBox">
            <div class="content">
                <div class="searchbox">
                    <div class="text"><input type="text" placeholder="Search" id="txt_search"></div>
                    <div class="button"><button class="Search" id="btnSearch">SEARCH</button></div>
                </div>
            </div>
        </div>
    </header>
    <div id="app-website">
        <main>
            @yield('content')
            <div class="modal fade" id="popup-login" tabindex="-1" aria-labelledby="Login" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content popup">
                        <div class="modal-header border-0">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row justify-content-md-center">
                                <div class="col-12">
                                    <div class="login-holder">
                                        <div class="content registration-form p-0 mt-0">
                                            <h1>Log in to your account.</h1>
                                            <popup-login-form></popup-login-form>
                                            <h4>Don't have an account?</h4>
                                            <div class="flex link-border">
                                                <a href="{{ env('SUPPLIER_REG_LINK') }}"
                                                    class="lightgreen_btn arrow_btn">Register as a
                                                    Supplier/Exhibitor</a>
                                                <a href="{{ env('PURCHASER_REG_LINK') }}"
                                                    class="orange_btn arrow_btn">Register as a Purchaser/Buyer</a>
                                            </div>
                                            <h4>Join the Event!</h4>
                                            <div class="flex link-border">
                                                <a href="javascript:;" id="btnAttendee"
                                                    class="maroon_btn arrow_btn">Register as an Attendee</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if (
                !Route::is(
                    'registration.buyer.steps',
                    'auth.index',
                    'registration.supplier',
                    'registration.buyer',
                    'auth.forgot.password',
                    'registration.supplier.intro',
                    'registration.buyer.intro',
                    'conforme.handle.response',
                    'registration.buyer.thankyou','conference.registration'))
                <popup-subscription-form></popup-subscription-form>
            @endif
            <div class="modal fade" id="attendee_modal" tabindex="-1" aria-labelledby="Attendee"
                aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="embed-responsive embed-responsive-16by9 hopin-container"
                                id="78xxj9F2YYW2WeH0uksj5N0hC"></div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer>
            <div class="section footer bg-white" id="footer">
                <div class="content footer-nav-holder">
                    <div class="double flex">
                        <div class="left">
                            <div class="image">
                                <img src="/assets/images/ssx-full-logo.png" alt="...">
                            </div>
                            <subscription-form></subscription-form>
                        </div>
                        <div class="right">
                            <div class="footer-nav">
                                <div class="nav-set">
                                    <h4>EVENTS & ACTIVITIES</h4>
                                    {{-- <p>Featured Partner Events</p>
                                    <p>Global Initiatives</p>
                                    <p>Webinars</p>
                                    <p>Local Highlights</p>
                                    <p>On-Demand Resources</p> --}}
                                    <p><a class="custom-link"
                                            href="{{ route('events-activities.conference_and_exhibition') }}">SSX
                                            Conference & Exhibition</a></p>
                                    <p><a class="custom-link"
                                            href="{{ route('events-activities.sdg_asia_2026') }}">SDG Asia Taiwan 2026</a></p>
                                </div>
                                <div class="nav-set">
                                    <h4>About</h4>
                                    <p><a class="custom-link" href="{{ route('about-us') }}">About SSX</a></p>
                                    <p><a class="custom-link" href="{{ route('about-us') }}">Event Components</a></p>
                                    <p><a class="custom-link" href="{{ route('about-us') }}">Partners</a></p>
                                    <p><a class="custom-link" href="{{ route('about-us') }}">Organizers</a></p>
                                    <p><a class="custom-link" href="{{ route('about-us') }}#contactUs">Contact Us</a>
                                    </p>
                                </div>
                                <!-- <div class="nav-set">
                                    <h4>SOLUTIONS</h4>
                                    <p>Directory</p>
                                    <p>Sustainable Solutions</p>
                                    <p>Solutions Intelligence</p>
                                </div>
                                <div class="nav-set">
                                    <h4>SERVICES</h4>
                                    <p>Export Enablers Directory</p>
                                    <p>Partnership Opportunities</p>
                                </div> -->
                                <div class="nav-set">
                                    <h4>RESOURCES & NEWS</h4>
                                    <p> <a class="custom-link" href="{{ route('news-articles.index') }}">News &
                                            Articles</a></p>
                                    <p><a class="custom-link"
                                            href="{{ route('solutions.intelligence.index') }}">Solutions
                                            Intelligence</a></p>
                                    <p>Past SSX Conference Videos</p>
                                    <ul class="list-unstyled p-0">
                                        <li class="d-flex">
                                            <p> <a class="dropdown-item " style="padding-top: 0px;"
                                                    href="{{ route('resources-news.digital-exhibition-conference-2022.index') }}">
                                                    <span>–</span> <span class="custom-link">Digital Exhibition &
                                                        Conference 2025</span>
                                                </a></p>
                                        </li>
                                    </ul>

                                    {{-- <p>Ambisyon Natin 2040</p>
                                    <p>SEC Sustainability Reporting Guidelines</p>
                                    <p>Glossary of Certifications</p> --}}
                                </div>
                                <!-- <div class="nav-set">
                                    <h4>REGISTER</h4>
                                    <p>Exhibitor</p>
                                    <p>Buyer</p>
                                    <p>Event Attendee</p>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content footnote">
                    <div class="double flex-rev">
                        <div class="left logo-holder">
                            <div class="image"><img src="/assets/images/dti-citem-logo-black.png" alt="">
                            </div>
                        </div>
                        <div class="right">
                            <p>Sustainability Solutions Exchange. Copyright 2021. <a
                                    href="{{ route('privacy_policy') }}">Privacy Policy</a>.
                                <a href="#">Cookie Policy</a>. For inquiries or concerns, email us at <a
                                    href="mailto:sustainabilityexpo@citem.com.ph">sustainabilityexpo@citem.com.ph</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <div class="cookie-holder" id="cookieConsent">
        <div class="container">
            <h2>Cookies &amp; Privacy</h2>
            <div class="row">
                <div class="col-9">
                    <p>Our website uses tools, such as cookies, to enable essential services and functionality on our
                        site and collect data on how visitors interacts with our site, products, and services to make
                        your browsing experience better. By using our site you agree to our use of cookies.</p>
                </div>
                <div class="col-3 align-self-center">
                    <div class="button_holder">
                        <button class="cookie_btn">Accept Cookies</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ mix('js/website/ssx-vendors.js') }}"></script>
    <script src="{{ mix('js/website/ssx.js') }}"></script>
    @stack('scripts')
    <script>
        $(document).ready(function() {

            //   MAINTENANCE MODAL START
            // Check if the modal has already been shown in the current session
            // if (!localStorage.getItem('Advisory20241114Shown')) {
            //     $("#overlay, #imageModal").fadeIn();

            //     $(".close").on("click", function() {
            //         $("#overlay, #imageModal").fadeOut();
            //     });

            //     $("#overlay").on("click", function() {
            //         $("#overlay, #imageModal").fadeOut();
            //     });

            //     localStorage.setItem('Advisory20241114Shown', 'true');
            // }
            //   MAINTENANCE MODAL END

            // SECURITY ADVISORY MODAL START
            if (!localStorage.getItem('SecurityAdvisory20260517Shown')) {

                setTimeout(function () {
                    $("#securityOverlay, #securityAdvisoryModal").fadeIn();
                }, 1000);

                $(".security-close").on("click", function () {
                    $("#securityOverlay, #securityAdvisoryModal").fadeOut();
                });

                $("#securityOverlay").on("click", function () {
                    $("#securityOverlay, #securityAdvisoryModal").fadeOut();
                });

                localStorage.setItem('SecurityAdvisory20260517Shown', 'true');
            }
            // SECURITY ADVISORY MODAL END

            if (window.location.hash != null && window.location.hash != '')
                $('body').animate({
                    scrollTop: $(window.location.hash).offset().top
                }, 1500);

            if (localStorage.getItem('ssx_cookies_enabled') === null) {
                $('#cookieConsent').addClass('animate__animated animate__fadeInUp animate__delay-2s active')
            }
            $(".cookie_btn").click(function() {
                localStorage.setItem('ssx_cookies_enabled', 1);
                $('#cookieConsent').removeClass('animate__fadeInUp animate__delay-2s active').addClass(
                    'animate__fadeOutDown')
            });

            var attendeeModal = document.getElementById('attendee_modal')
            attendeeModal.addEventListener('shown.bs.modal', function(event) {
                var container = document.getElementById('78xxj9F2YYW2WeH0uksj5N0hC')
                var iframe = document.createElement('iframe');
                iframe.src =
                    'https://registration.hopin.com/widgets/registration/sustainability-solutions-exchange?widget_id=78xxj9F2YYW2WeH0uksj5N0hC' +
                    window.location.search.replace('?', '&');
                container.appendChild(iframe);
            });

            $('#btnSearch').click(function() {
                var txt = $('#txt_search').val();
                if (txt) {
                    let s = txt.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(
                        /'/g, '&#39;').replace(/"/g, '&#34;');
                    let uri = "/search/" + s;
                    window.location.href = uri;
                }
            });

            $("#txt_search").keypress(function(event) {
                if (event.which == 13) {
                    $('#btnSearch').click();
                    event.preventDefault();
                }
            });
        });
    </script>
</body>

</html>
