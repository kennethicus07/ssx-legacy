@extends('layouts.website')

@push('styles')
    <style>
        .event-component {
            min-height: 0 !important;
        }

        .contact-content {
            min-height: 0 !important;
        }
    </style>
@endpush

@section('content')
    <div class="section carousel-holder full-vh" id="top">
        <div id="heroCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel">
            <div class="carousel-indicators">
                @foreach ($banners as $banner_indicator)
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $loop->index }}"
                        @class(['active' => $loop->iteration === 1]) @if ($loop->iteration === 1) aria-current="true" @endif
                        aria-label="Slide {{ $loop->iteration }}"></button>
                @endforeach
            </div>
            <div class="carousel-inner">
                @foreach ($banners as $banner)
                    <div @class(['carousel-item', 'active' => $loop->iteration === 1])>
                        <a href="{{ $banner->url }}" target="_blank">
                            <img src="{{ check_file_exist('carousel_banners/', 'masthead', $banner->banner) }}"
                                class="d-block w-100" alt="...">
                        </a>
                        @if (!in_array($banner->id, [34, 35]))
                            <div class="carousel-caption">
                                <a href="{{ $banner->url }}" target="_blank" class="text-white text-decoration-none">
                                    <h2>{{ $banner->title }}</h2>
                                </a>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <widgets :id="1"></widgets>
    <div class="section container carousel-holder mb-3 mt-4" id="home-discover-sustainability">
        <div class="content">
            <center>
                <h2>Discover Sustainability</h2>
            </center>
        </div>
    </div>
    <div class="section card-carousel-holder darkgreen-bg" id="articleCarousel">
        <div class="content">
            <h4 class="white">Latest News</h4>
            <div class="row">
                <div id="latest-news" class="col owl-carousel owl-theme">
                    @foreach ($latest_articles as $latest_article)
                        <div class="card h-100">
                            <img data-src="{{ $latest_article['thumb'] }}" class="owl-lazy card-img-top" alt="...">
                            <div class="card-body">
                                <a href="{{ $latest_article['url'] }}" class="lightgreen-link">
                                    <p class="fw-bold lh-base fs-6">{{ $latest_article['title'] }}</p>
                                </a>
                                <p class="card-text">
                                    {{ $latest_article['intro'] }}
                                    <a href="{{ $latest_article['url'] }}" class="lightgreen-link">Read more</a>
                                </p>
                                @if (!empty($latest_article['tags']))
                                    <p class="tags">
                                        @foreach ($latest_article['tags'] as $tag)
                                            <span class="badge rounded-pill lightgreen-bg text-white text-uppercase"
                                                title="{{ $tag->sub_category->name ?? '' }}">
                                                {{ Str::limit($tag->sub_category->name ?? '', 30) }}
                                            </span>
                                        @endforeach
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <p align="right" class="white simple-lnk"><a href="{{ route('news-articles.index') }}" class="arrow_btn">Read
                    all articles</a></p>
        </div>
    </div>
    <widgets :id="2"></widgets>
    {{-- FEATURED EVENT --}}
    {{-- 
@if ($featured_event)    
<div class="section highlight-holder darkgreen-bg ssx-info" id="eventHighlights">
    <div class="full-content">
        <div class="double flex white">
            <div class="left">
                <div class="image">
                    <img class="bright100" src="/assets/images/event-logo-transparent2.png" alt="..." />
                </div>
            </div>
            <div class="right">
                <div class="desc">
                    <h3>{{ $featured_event->title }}</h3>
                    {!! $featured_event->description !!}
                    <div class="event-link">
                        <div class="categ darkgreen text-uppercase">
                            <a href="#">{{ $featured_event->event_type }}</a>
                        </div>
                        <div class="loc">
                            @if ($featured_event->event_type == 'digital')
                            <h3 class="text-uppercase">{{ $featured_event->platform }}</h3>
                            @else
                            <h3 class="text-uppercase">{{ $featured_event->location }}</h3>
                            @endif
                        </div>
                        <div class="date">
                            @if (!empty($featured_event->event_date_2))
                                <h3>{{ $featured_event->event_date_1->format('d') }}-{{ $featured_event->event_date_2->format('d F Y') }}</h3>
                            @else
                                <h3>{{ $featured_event->event_date_1->format('d F Y') }}</h3>
                            @endif
                        </div>
                    </div>
                    <p class="pt-20 simple-lnk"><a href="{{ $featured_event->event_link }}" target="_blank" class="arrow_btn">Learn more</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
--}}
    {{-- <widgets :id="4"></widgets> --}}
    <div class="container-fluid section event-summary" id="The4Es">
        <div class="content">
            <h2>What to expect in our Sustainability Solutions Exchange</h2>
        </div>
    </div>
    <div class="container-fluid section event-component beige-bg" id="Explore">
        <div class="content">
            <h2 class="lightgreen">Explore</h2>
            <h3>Exhibition</h3>
            <div class="double flex">
                <widgets :id="5"></widgets>
                <div class="right pl-40">
                    <p><strong>Enter Our Zones</strong></p>
                    <div class="link-border">
                        <a href="{{ route('solutions.sustainable.index') }}" class="clear_btn arrow_btn">Food Solutions</a>
                        <a href="{{ route('solutions.sustainable.index') }}" class="clear_btn arrow_btn">Sustainable
                            Solutions</a>
                        {{-- <a class="lightgreen_btn arrow_btn" href="{{ env('SUPPLIER_REG_LINK') }}" target="_blank">Register as a Supplier</a>
                    <a class="orange_btn arrow_btn" href="{{ env('PURCHASER_REG_LINK') }}" target="_blank">Register as a Purchaser</a>  --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Event: Educate --}}
    {{--
@if ($educate_event)
<div class="container-fluid section event-component" id="Educate">
    <div class="content">
        <div class="double flex">
            <div class="left featured">
                <div class="image"><img src="/assets/images/educate.jpg" alt=""></div>
            </div>
            <div class="right">
                <div class="desc event-desc darkgreen">
                    <widgets :id="38"></widgets>
                    <h4>{{ $educate_event->title }}</h4>
                    <div class="event-link">
                        <div class="categ">
                            <p><a href="#">{{ $educate_event->event_type }}</a></p>
                        </div>
                        <div class="loc">
                            @if ($educate_event->event_type == 'digital')
                            <p>{{ $educate_event->platform }}</p>
                            @else
                            <p>{{ $educate_event->location }}</p>
                            @endif
                        </div>
                        <div class="date">
                            @if (!empty($educate_event->event_date_2))
                            <p>
                                {{ $educate_event->event_date_1->format('d') }}-{{ $educate_event->event_date_2->format('d F Y') }}
                            </p>
                            @else
                            <p>{{ $educate_event->event_date_1->format('d F Y') }}</p>
                            @endif
                        </div>
                    </div>
                    {!! $educate_event->description !!}
                  
                </div>
            </div>
        </div>
    </div>
</div>
@endif
--}}
    <div class="container-fluid section event-component beige-bg" id="Enable">
        <div class="content">
            <div class="double flex-rev">
                <div class="left featured">
                    <div class="image"><img src="/assets/images/enable.jpg" alt=""></div>
                    {{-- <div class="link-border">
                    <x-registerbuttons />
                </div> --}}
                </div>
                <div class="right">
                    <widgets :id="7"></widgets>
                </div>
            </div>
        </div>
    </div>

    {{-- Networking --}}
    {{--
@if ($latest_events)
<div class="container-fluid section event-carousel-holder" id="Elevate">
    <div class="content">
        <center>
            <widgets :id="8"></widgets>
            <div class="link-border flex no-resize">
                <a href="{{ route('events-activities.index') }}" class="arrow_btn clear_btn maroon">View all events</a>
                <a href="#" class="arrow_btn clear_btn maroon">Check out partners</a>
            </div>
        </center>
        <div class="row mt-3">
            <div id="eventSlider" class="col owl-carousel owl-theme event-carousel">
                @foreach ($latest_events as $event)
                <div class="card h-100 maroon-bg item">
                    <img data-src="{{ $event['thumb'] }}" class="owl-lazy card-img-top" alt="...">
                    <div class="card-body">
                        <a href="{{ $event['url'] }}" target="_blank" class="lightgreen-link2">
                            <p class="fw-bold lh-base fs-6">{{ $event['title'] }}</p>
                        </a>
                        <p class="loc"><i class="fas fa-map-marker-alt"></i> {{ $event['type'] }}</p>
                        <div class="d-flex align-items-center mt-2">
                            <div class="event-org-logo flex-shrink-0">
                                <img src="{{ $event['organizer_logo'] }}" alt="...">
                            </div>
                            <div class="flex-grow-1 ms-2 white fs-12">
                                Organized By<br/><strong>{{ $event['organizer_name'] }}</strong>
                            </div>
                        </div>
                        @if (!empty($event['tags']))
                        <p class="tags mt-3">
                            @foreach ($event['tags'] as $tag)
                            <span class="badge rounded-pill lightgreen-bg text-white text-uppercase">{{ $tag->sub_category->name }}</span>
                            @endforeach
                        </p>
                        @endif
                        <a href="{{ $event['url'] }}" class="card-link text-white fs-12 fw-bold" target="_blank">Register here <i class="fas fa-angle-right fs-5 align-middle"></i></a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <p align="center" class="maroon"><a href="{{ route('events-activities.index') }}">View all events, activities, webinars, and more...</a></p>
    </div>
</div>
@endif
--}}
    <widgets :id="41"></widgets>
    <div class="container-fluid section event-component">
        <div class="content">
            <div class="double flex-rev">
                <div class="left featured">
                    <div class="image"><img src="/assets/images/start-your-journey.jpg" alt="..."></div>
                </div>
                <div class="right">
                    <div class="desc">
                        <widgets :id="10"></widgets>
                        <!-- <div class="link-border">
                                    <x-registerbuttons />
                                    <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#attendee_modal" class="maroon_btn arrow_btn">Register as an Attendee</a>
                                </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-contactus title="Get in touch with us." subtitle="Sustainability values partnerships."
        details="SSX is also a hub for business, partnerships, and networking. Help us empower our stakeholders by becoming a sustainability partner or enabler." />
@endsection
@push('styles')
    <link rel="stylesheet" href="/libs/owlcarousel/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/libs/owlcarousel/css/owl.theme.default.min.css">
@endpush
@push('scripts')
    <script src="/libs/owlcarousel/js/owl.carousel.min.js"></script>
    <script src="{{ mix('js/website/home.js') }}"></script>
@endpush
