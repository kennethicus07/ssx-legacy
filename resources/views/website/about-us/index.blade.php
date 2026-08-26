@extends('layouts.website')

@section('content')
<div class="section carousel-holder full-vh" id="home-main">
    <widgets :id="28"></widgets>
    <widgets :id="29"></widgets>
    <div class="section ssx-info" id="weAre">
        <widgets :id="30"></widgets>
    </div>
    <div class="container-fluid section event-summary" id="">
        <widgets :id="31"></widgets>
    </div>
    @if($featured_event)
    <div class="section highlights darkgreen-bg" id="eventHighlights">
        <div class="full-content">
            <div class="double flex">
                <div class="left logo-outline">
                    <div class="desc white" style="float: right;">
                        <div class="image">
                            <img src="/assets/images/ssx-full-logo-white.png" alt="..." />
                        </div>
                        {!! $featured_event->description !!}
                        <div class="event-link">
                            <div class="categ white text-uppercase">
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
                        <div class="highlight-links">
                            <div class="link-border">
                                <a href="/storage/SSX_BROCHURE_2022.pdf" target="_blank" class="clearwhite_btn arrow_btn">Download Event Brochure</a>
                                <a href="https://sustainability.ph/resources-news/digital-exhibition-conference-2022" target="_blank" class="clearwhite_btn arrow_btn">Watch the 2022 Digital Conference Here</a>
                              <!--   <a href="https://hopin.com/events/sustainability-solutions-exchange/registration?utm_source=SSX_Website&utm_medium=referral&utm_campaign=SSX%202022" target="_blank" class="clearwhite_btn arrow_btn">See List of Speakers</a> -->
                                <!-- <x-registerbuttons /> -->
                                <!-- <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#attendee_modal" class="maroon_btn arrow_btn">Register as an Attendee</a> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="right laptop-holder2">
                    <div class="featured-w-bg image featured-laptop">
                        <div class="bg">
                            <img src="/assets/images/laptop-bg.png" alt="...">
                        </div>
                        <div class="fg">
                            <img src="/assets/images/SSX2.gif" alt="...">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="section ssx-info darkgreen-bg" id="event-component">
        <div class="content white pt-5">
            <div class="desc">
                <widgets :id="33"></widgets>
            </div>
        </div>
        <div class="content white">
            <div class="desc">
                <widgets :id="34"></widgets>
            </div>
        </div>
        <div class="content white">
            <div class="desc">
                <widgets :id="35"></widgets>
            </div>
        </div>
        <div class="content white">
            <div class="desc">
                <center>
                    <h3>Join us at the Sustainable Solutions Exchange</h3>
                </center>
                <!-- <div class="flex link-border">
                    <x-registerbuttons />
                    <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#attendee_modal" class="maroon_btn arrow_btn">Register as an Attendee</a>
                </div> -->
            </div>
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
                        <a href="/solutions/marketplace/suppliers" class="clear_btn arrow_btn">Marketplace</a>
                        <a href="/solutions/sustainable" class="clear_btn arrow_btn">Sustainable Solutions</a>
                        <x-registerbuttons />
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($educate_event)
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
                        <div class="link-border">
                            <!-- <a class="black_btn arrow_btn" href="https://sustainability.ph/resources-news/digital-exhibition-conference-2022" target="blank">Watch the 2022 Digital Conference Here</a> -->
                            <!-- <a class="black_btn arrow_btn" href="https://hopin.com/events/sustainability-solutions-exchange/registration?utm_source=SSX_Website&utm_medium=referral&utm_campaign=SSX%202022" target="blank">Check out speakers</a> -->
                           <!--  <a class="black_btn arrow_btn" href="javascript:;" data-bs-toggle="modal" data-bs-target="#attendee_modal">Register as an attendee</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="container-fluid section event-component beige-bg" id="Enable">
        <div class="content">
            <div class="double flex-rev">
                <div class="left featured">
                    <div class="image"><img src="/assets/images/enable.jpg" alt=""></div>
                    <div class="link-border">
                        <x-registerbuttons />
                    </div>
                </div>
                <div class="right">
                    <widgets :id="7"></widgets>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid section event-component" id="Elevate">
        <div class="content">
            <widgets :id="36"></widgets>
        </div>
    </div>

    <div class="section ssx-info contact beige-bg">
        <div class="content">
            <widgets :id="37"></widgets>
        </div>
        <div class="content">
            <div class="double flex-rev">
                <div class="left">
                    <div class="desc black">
                        <h3>LEARN MORE ON</h3>
                        <h1><a href="{{ env('CITEM_WEBSITE') }}" class="arrow_btn" target="_blank">citem.gov.ph</a></h1>
                    </div>
                </div>
                <div class="right">
                    <div class="desc black">
                        <h3>FOLLOW US ON OUR SOCIAL MEDIA!</h3>
                        <h3 class="ico-holder reverse-black">
                            <a href="{{ env('APP_SOCIAL_FACEBOOK') }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            <a href="{{ env('APP_SOCIAL_TWITTER') }}" target="_blank"><i class="fab fa-twitter"></i></a>
                            <a href="{{ env('APP_SOCIAL_INSTAGRAM') }}" target="_blank"><i class="fab fa-instagram"></i></a>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-contactus title="Get in touch with us." subtitle="Sustainability values partnerships." details="SSX is also a hub for business, partnerships, and networking. Help us empower our stakeholders by becoming a sustainability partner or enabler." />
@endsection

@push('styles')
@endpush
@push('scripts')
<script>
$(document).ready(function() {
    $('#nav-about').addClass('active');
});
</script>
@endpush