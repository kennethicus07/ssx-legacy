@extends('layouts.website')

@section('content')

    {{-- Hero Section --}}
    <section class="sdg-hero-section d-flex align-items-center text-white">
        <div class="container">
            <div class="row">
                <div class="col-12 d-flex flex-column justify-content-end align-items-end" style="height: 500px;">
                <h1 class="sdg-hero-title">2026 SDG ASIA</h1>
                <p class="sdg-hero-date">2026 August 27-29</p>
                <p class="sdg-hero-venue">TAIPEI WORLD TRADE CENTER, HALL 1 ABCD</p>
            </div>
            </div>
        </div>
    </section>

    {{-- Intro / Source Sustainable Section --}}
    <section class="sdg-intro-section py-5">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-9">
                    <span class="sdg-eyebrow">2026 5TH SDG ASIA</span>
                    <h2 class="sdg-intro-title mt-2">
                        Source sustainable.<br>
                        The Philippines takes the stage at SDG Asia 2026.
                    </h2>
                    <p class="mt-4">
                        As sustainability reshapes how industries source, produce, and grow, the Philippines is
                        keeping pace with responsible practices, circular solutions, and innovations that create
                        value for business and communities.
                    </p>
                    <p class="">
                        Taking these solutions to the regional stage, the Philippines makes its debut at
                        <strong>SDG Asia 2026</strong> with a dedicated pavilion showcasing 12 sustainability-driven
                        enterprises under the Sustainability Solutions Exchange (SSX).
                    </p>
                    <p class="">
                        Witness the Philippine showcase from <strong>August 27–29, 2026</strong> at the Taipei
                        World Trade Center Hall 1, Taipei, Taiwan.
                    </p>

                </div>
            </div>
        </div>
    </section>

    {{-- From the Sidelines Section --}}
    <section class="sdg-sidelines-section py-5">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <h2 class="text-white">From the sidelines to front and center</h2>
                    <p class="text-white mt-3">
                        Last year, the <strong class="text-white">Center for International Trade Expositions and Missions
                        (CITEM)</strong>, the export promotion arm of the Philippine <strong class="text-white">Department of Trade
                        and Industry (DTI)</strong>, participated in SDG Asia through a market-sensing mission to
                        explore Taiwan's sustainability ecosystem, technologies, and emerging opportunities.
                    </p>
                    <p class="text-white">
                        This year, the Philippines moves from <strong class="text-white">market sensing to market presence</strong>.
                        The first Philippine Pavilion brings homegrown enterprises directly into the conversation.
                    </p>
                </div>
                <div class="col-lg-6">
                    <img src="{{ asset('assets/sdg_asia_2026/sidelines-photo.png') }}" alt="SDG Asia Mission"
                        class="img-fluid rounded sdg-sidelines-img">
                </div>
            </div>
        </div>
    </section>

    {{-- Enterprises Section --}}
    <section id="enterprises" class="sdg-enterprises-section py-5">
        <div class="container">
            <h2 class="fw-bold">12 Enterprises, 3 Solution Areas, and One Sustainable Direction</h2>
            <p class="py-3">
                From the farm to the factory and from physical products to digital platforms, Philippine
                enterprises are finding new ways to make sustainability practical.
                Check them out at <strong>Booth 312</strong> in <strong>Hall 1</strong> of the Taipei World Trade
                Center.
            </p>

            {{-- Category 1: Agriculture, Food & Biotechnology --}}
            <div class="sdg-category-card mt-4">
                <div class="sdg-category-header sdg-gradient-1">
                    <span class="text-white">AGRICULTURE, FOOD &amp; BIOTECHNOLOGY</span>
                </div>
                <div class="sdg-category-body">
                    <p class="text-muted">
                        Discover tropical food, natural wellness, and biotechnology solutions built around
                        responsible sourcing and transparency.
                    </p>
                    <div class="row g-4 text-center justify-content-center">
                        <div class="col-6 col-md-4 col-lg-2">
                            <div class="sdg-logo-box">
                                <img src="{{ asset('assets/sdg_asia_2026/butuan-coconut.png') }}"
                                    alt="Butuan Coconut Products, Inc." class="img-fluid">
                            </div>
                            <p class="sdg-logo-caption">Butuan Coconut Products, Inc.</p>
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <div class="sdg-logo-box">
                                <img src="{{ asset('assets/sdg_asia_2026/cecilias-ilocos.png') }}"
                                    alt="Cecilia's Ilocos Delights Food Products" class="img-fluid">
                            </div>
                            <p class="sdg-logo-caption">Cecilia's Ilocos Delights Food Products</p>
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <div class="sdg-logo-box">
                                <img src="{{ asset('assets/sdg_asia_2026/discovery-tea-craft.png') }}"
                                    alt="Discovery Tea Craft, Inc." class="img-fluid">
                            </div>
                            <p class="sdg-logo-caption">Discovery Tea Craft, Inc.</p>
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <div class="sdg-logo-box">
                                <img src="{{ asset('assets/sdg_asia_2026/kkdee-food.png') }}"
                                    alt="Kkdee Food Products Trading" class="img-fluid">
                            </div>
                            <p class="sdg-logo-caption">Kkdee Food Products Trading</p>
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <div class="sdg-logo-box">
                                <img src="{{ asset('assets/sdg_asia_2026/natureearth.png') }}"
                                    alt="Natureearth Corporation" class="img-fluid">
                            </div>
                            <p class="sdg-logo-caption">Natureearth Corporation</p>
                        </div>
                        <div class="col-6 col-md-4 col-lg-2">
                            <div class="sdg-logo-box">
                                <img src="{{ asset('assets/sdg_asia_2026/thega-coconut.png') }}"
                                    alt="Thega Coconut Farm" class="img-fluid">
                            </div>
                            <p class="sdg-logo-caption">Thega Coconut Farm</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Category 2: Circular Lifestyle & Green Manufacturing --}}
            <div class="sdg-category-card mt-4">
                <div class="sdg-category-header sdg-gradient-2">
                    <span class="text-white">CIRCULAR LIFESTYLE &amp; GREEN MANUFACTURING</span>
                </div>
                <div class="sdg-category-body">
                    <p class="text-muted">
                        Explore fashion, lifestyle products, upcycled materials, and manufacturing solutions that
                        turn local resources into lasting value.
                    </p>
                    <div class="row g-4 text-center justify-content-center">
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="sdg-logo-box">
                                <img src="{{ asset('assets/sdg_asia_2026/logos/anmaris-fashion.png') }}"
                                    alt="Anmari's Fashion House" class="img-fluid">
                            </div>
                            <p class="sdg-logo-caption">Anmari's Fashion House</p>
                        </div>
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="sdg-logo-box">
                                <img src="{{ asset('assets/sdg_asia_2026/logos/arya-aramid.png') }}"
                                    alt="Ar-Ya Aramid Inang Handicrafts Trading" class="img-fluid">
                            </div>
                            <p class="sdg-logo-caption">Ar-Ya Aramid Inang Handicrafts Trading</p>
                        </div>
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="sdg-logo-box">
                                <img src="{{ asset('assets/sdg_asia_2026/logos/siklo-enterprises.png') }}"
                                    alt="Siklo Enterprises" class="img-fluid">
                            </div>
                            <p class="sdg-logo-caption">Siklo Enterprises</p>
                        </div>
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="sdg-logo-box">
                                <img src="{{ asset('assets/sdg_asia_2026/logos/three-women-opc.png') }}"
                                    alt="Three Women OPC (The Eco Shift)" class="img-fluid">
                            </div>
                            <p class="sdg-logo-caption">Three Women OPC (The Eco Shift)</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Category 3: Green Technology & Digital Solutions --}}
            <div class="sdg-category-card mt-4">
                <div class="sdg-category-header sdg-gradient-3">
                    <span class="text-white">GREEN TECHNOLOGY &amp; DIGITAL SOLUTIONS</span>
                </div>
                <div class="sdg-category-body">
                    <p class="text-muted">
                        Find technologies and digital solutions that support efficiency, resilience, compliance,
                        and more sustainable operations.
                    </p>
                    <div class="row g-4 text-center justify-content-center">
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="sdg-logo-box">
                                <img src="{{ asset('assets/sdg_asia_2026/logos/demaf.png') }}"
                                    alt="DEMAF 3D Printing & Fabrications" class="img-fluid">
                            </div>
                            <p class="sdg-logo-caption">DEMAF 3D Printing &amp; Fabrications</p>
                        </div>
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="sdg-logo-box">
                                <img src="{{ asset('assets/sdg_asia_2026/logos/taxumo.png') }}"
                                    alt="Taxumo Inc." class="img-fluid">
                            </div>
                            <p class="sdg-logo-caption">Taxumo Inc.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <a href="{{ asset('assets/sdg_asia_2026/SDG_Asia_2026_Lookbook.pdf') }}"
                    download="SDG_Asia_2026_Lookbook.pdf" class="btn sdg-btn-download">
                    Download the Lookbook
                </a>
            </div>
        </div>
    </section>

    {{-- Homegrown Innovation Section --}}
    <section class="sdg-innovation-section py-5">
        <div class="container">
            <div class="row align-items-center g-4">
                 <div class="col-lg-6">
                    <img src="{{ asset('assets/sdg_asia_2026/homegrown-innovation.jpg') }}" alt="SDG Asia Mission"
                        class="img-fluid rounded sdg-sidelines-img">
                </div>
                <div class="col-lg-6">
                    <h2 class="text-white">Homegrown Innovation, Regional Impact</h2>
                    <p class="text-white mt-3">
                        The Philippine Pavilion is presented under <strong>Sustainability Solutions Exchange
                        (SSX)</strong>, CITEM's platform connecting enterprises with sustainable practices,
                        technologies, resources, and new markets.
                    </p>
                    <p class="text-white">
                        At SDG Asia 2026, SSX takes that exchange beyond the Philippines—putting homegrown
                        sustainability solutions in front of an Asia-Pacific audience.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Continue the Exchange Section --}}
    <section class="sdg-continue-section py-5">
        <div class="container">
            <span class="sdg-eyebrow-light">OVERVIEW</span>
            <h2 class="text-white mt-2">Continue the Exchange</h2>
            <p class="text-white mt-3">
                The journey continues in Manila. Join <strong>SSX Exhibition and Conference 2026</strong> on
                <strong>October 15–17</strong> at the Philippine Trade Training Center (PTTC) in Pasay City, where
                businesses, innovators, and sustainability leaders will come together for a larger sustainability
                experience featuring a conference and exhibition, expert sessions, sustainable technologies, and
                the Startup Pitching Competition Finals.
            </p>
            <p class="text-white">
                Discover more Philippine sustainability solutions, stories, and opportunities through
                <strong>Sustainability.ph</strong>, the online community of Sustainability Solutions Exchange.
            </p>
            <a href="https://www.sdgs-asia.com.tw/en/" target="_blank" class="btn sdg-btn-dark mt-3">Explore more</a>
        </div>
    </section>

@endsection

@push('styles')
    <style>
        :root {
            --sdg-teal: #3fb6ab;
            --sdg-teal-dark: #2f8f8a;
            --sdg-green: #367938;
            --sdg-olive: #7c8a2e;
            --sdg-navy: #1c2b36;
        }

        h1, h2, h3, h4, h5, h6 {
            color: var(--sdg-teal-dark);
        }

        /* Hero */
        .sdg-hero-section {
            background: radial-gradient(circle at 30% 30%, #2aa7d6 0%, #eeab2a 55%, #eeab2a 100%);
            min-height: 720px;
            position: relative;
        }

        .sdg-hero-title {
            color: #fff;
            font-weight: 700;
            font-size: 3rem;
        }

        .sdg-hero-date {
            color: #fff;
            font-size: 1.5rem;
            margin-bottom: 0.25rem;
        }

        .sdg-hero-venue {
            color: #fff;
            letter-spacing: 1px;
            font-size: 0.9rem;
        }

        @media (max-width: 700px) {
            .sdg-hero-section {
                min-height: 320px;
            }

            .sdg-hero-title {
                font-size: 2rem;
            }
        }

        /* Intro */
        .sdg-eyebrow {
            color: var(--sdg-teal);
            font-weight: 700;
            font-size: 0.8rem;
            letter-spacing: 1px;
        }

        .sdg-intro-title {
            color: #5FC0C6;
            font-weight: 700;
        }

        .sdg-btn-outline {
            background-color: transparent;
            border: 2px solid var(--sdg-teal-dark);
            color: var(--sdg-teal-dark);
            border-radius: 30px;
            padding: 0.5rem 1.75rem;
        }

        .sdg-btn-outline:hover {
            background-color: var(--sdg-teal-dark);
            color: #fff;
        }

        /* Sidelines */
        .sdg-sidelines-section {
            background-color: var(--sdg-teal);
        }

        .sdg-sidelines-img {
            width: 100%;
            object-fit: cover;
        }

        .sdg-btn-light {
            background-color: #fff;
            border: 2px solid #fff;
            color: var(--sdg-teal-dark);
            border-radius: 30px;
            padding: 0.5rem 1.75rem;
        }

        .sdg-btn-light:hover {
            background-color: transparent;
            color: #fff;
        }

        /* Enterprises / Categories */
        .sdg-category-card {
            border: 1px solid #e5e5e5;
            border-radius: 6px;
            overflow: hidden;
        }

        .sdg-category-header {
            padding: 0.9rem 1.5rem;
            color: #fff;
            font-weight: 700;
            letter-spacing: 0.5px;
            font-size: 0.95rem;
        }

        .sdg-gradient-1 {
            background: linear-gradient(90deg, #00AB7D 64%, #E579A0 100%);
        }

        .sdg-gradient-2 {
            background: linear-gradient(90deg, #E9B749 76%, #0098D0 100%);
        }

        .sdg-gradient-3 {
            background: linear-gradient(90deg, #E5798A 91%, #0098D0 100%);
        }

        .sdg-category-body {
            padding: 1.5rem;
        }

        .sdg-logo-box {
            border: 1px solid #eee;
            border-radius: 6px;
            padding: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 110px;
            background-color: #fff;
        }

        .sdg-logo-box img {
            max-height: 80px;
            max-width: 100%;
        }

        .sdg-logo-caption {
            font-size: 0.8rem;
            color: #555;
            margin-top: 0.5rem;
            margin-bottom: 0;
        }

        .sdg-btn-download {
            background-color: #2aa7d6;
            border: 2px solid #2aa7d6;
            color: #fff;
            border-radius: 30px;
            padding: 0.6rem 2rem;
            font-weight: 600;
        }

        .sdg-btn-download:hover {
            background-color: #fff;
            color: #2aa7d6;
        }

        /* Homegrown Innovation */
        .sdg-innovation-section {
            background-color: var(--sdg-teal);
        }

        .sdg-collage-img {
            width: 100%;
            aspect-ratio: 1 / 1;
            object-fit: cover;
        }

        /* Continue the Exchange */
        .sdg-continue-section {
            background-color: var(--sdg-olive);
        }

        .sdg-eyebrow-light {
            color: #fff;
            opacity: 0.8;
            font-weight: 700;
            font-size: 0.8rem;
            letter-spacing: 1px;
        }

        .sdg-btn-dark {
            background-color: var(--sdg-navy);
            border: 2px solid var(--sdg-navy);
            color: #fff;
            border-radius: 4px;
            padding: 0.6rem 1.75rem;
            font-weight: 600;
        }

        .sdg-btn-dark:hover {
            background-color: transparent;
            border: 2px solid #fff;
            color: #fff;
        }
    </style>
@endpush
