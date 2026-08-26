@extends('layouts.website')

@section('content')
<div class="section ssx-info" id="featuredEvent">
    <div class="featured">
        <div class="image"><img src="/assets/images/Featured-event-banner.jpg" alt="..."></div>
    </div>
    <div class="content">
        <div class="double flex flex-center">
            <div class="left black pr-40">
                @if (!empty($event_top1->category_tag))
                <p class="tags">
                    @foreach ($event_top1->category_tag as $tag)
                    <span class="badge rounded-pill lightgreen-bg text-white">{{ $tag->sub_category->name }}</span>
                    @endforeach
                </p>
                @endif
                <h2>{{ $event_top1->title }}</h2>
                <div class="event-link">
                    @if ($event_top1->event_happening == 'global')
                    <div class="global"></div>
                    @else
                    <div class="local"></div>
                    @endif
                    <div class="categ darkgreen">
                        <a href="#" class="text-uppercase">{{ $event_top1->event_type }}</a>
                    </div>
                    <div class="loc">
                        @if ($event_top1->event_type == 'digital')
                        <h3 class="text-uppercase">{{ $event_top1->platform }}</h3>
                        @else
                        <h3 class="text-uppercase">{{ $event_top1->location }}</h3>
                        @endif
                    </div>
                    <div class="date">
                        @if (!empty($event_top1->event_date_2))
                        <h3>{{ $event_top1->event_date_1->format('d') }}-{{ $event_top1->event_date_2->format('d F Y') }}</h3>
                        @else
                        <h3>{{ $event_top1->event_date_1->format('d F Y') }}</h3>
                        @endif
                    </div>
                </div>
                <div class="event-info main">
                    <div class="image">
                        <img src="{{ check_file_exist('events/organizer_logos/', 'logo', $event_top1->organizer_logo) }}" alt="..." class="rounded img-fluid">
                    </div>
                    <div class="desc">Organized By <strong>{{ $event_top1->organizer }}</strong></div>
                </div>
            </div>
            <div class="right">
                {!! $event_top1->description !!}
                <div class="link-border">
                    <a href="{{ $event_top1->event_link }}" target="_blank" class="clear_btn arrow_btn">Learn more</a>
                    <a href="{{ $event_top1->event_link }}" target="_blank" class="lightgreen_btn arrow_btn">Register now</a>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="black">
            <p align="center"><a href="#more" class="scroll_btn arrow_bottom_btn">Scroll to learn more!</a></p>
        </div>
    </div>
</div>
<div class="section beige-bg ssx-info">
    <div class="content" id="more">
        <div class="double flex">
            <div class="left">
                <div class="image">
                    <img src="{{ check_file_exist('events/thumbs/', 'thumb', $event_top2->event_banner) }}" alt="..." class="curvy img-fluid">
                </div>
            </div>
            <div class="right">
                <div class="desc black">
                    @if (!empty($event_top2->category_tag))
                    <p class="tags">
                        @foreach ($event_top2->category_tag as $tag)
                        <span class="badge rounded-pill lightgreen-bg text-white">{{ $tag->sub_category->name }}</span>
                        @endforeach
                    </p>
                    @endif
                    <h2>{{ $event_top2->title }}</h2>
                    <div class="event-link">
                        @if ($event_top2->event_happening == 'global')
                        <div class="global"></div>
                        @else
                        <div class="local"></div>
                        @endif
                        <div class="categ darkgreen">
                            <a href="#" class="text-uppercase">{{ $event_top2->event_type }}</a>
                        </div>
                        <div class="loc">
                            @if ($event_top2->event_type == 'digital')
                            <h3 class="text-uppercase">{{ $event_top2->platform }}</h3>
                            @else
                            <h3 class="text-uppercase">{{ $event_top2->location }}</h3>
                            @endif
                        </div>
                        <div class="date">
                            @if (!empty($event_top2->event_date_2))
                            <h3>{{ $event_top2->event_date_1->format('d') }}-{{ $event_top2->event_date_2->format('d F Y') }}</h3>
                            @else
                            <h3>{{ $event_top2->event_date_1->format('d F Y') }}</h3>
                            @endif
                        </div>
                    </div>
                    <div class="event-info main">
                        <div class="image">
                            <img src="{{ check_file_exist('events/organizer_logos/', 'logo', $event_top2->organizer_logo) }}" alt="..." class="rounded img-fluid">
                        </div>
                        <div class="desc">Organized By <strong>{{ $event_top2->organizer }}</strong></div>
                    </div>
                    {!! $event_top2->description !!}
                    <div class="link-border">
                        <a href="{{ $event_top2->event_link }}" target="_blank" class="clear_btn arrow_btn">Learn more</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 
  <div class="section ssx-info">
    <div class="content">
      <center><h3>Browse all our Featured Partner Events and Activities</h3>      </center>
      <div id="browseAllEvents1" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#browseAllEvents1" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#browseAllEvents1" data-bs-slide-to="1" aria-label="Slide 2"></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="assets/images/Hero-Banner-1.jpg" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
              <h2>Make sustainable choices.</h2>
            </div>
          </div>
          <div class="carousel-item">
            <img src="assets/images/Hero-Banner-2.jpg" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
              <h2>Make sustainable choices.</h2>
            </div>
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div> 
    </div>
  </div> 
-->
<widgets :id="11"></widgets>
<div class="section event-carousel-holder">
    <div class="content">
        <div class="row pt-3">
            <div id="eventSlider" class="col owl-carousel owl-theme event-carousel">
                @foreach ($latest_events as $event)
                <div class="card h-100 maroon-bg item">
                    <img data-src="{{ check_file_exist('events/thumbs/', 'thumb', $event->event_banner) }}" class="owl-lazy card-img-top" alt="...">
                    <div class="card-body">
                        <a href="{{ $event->event_link }}" target="_blank" class="lightgreen-link2">
                            <p class="fw-bold lh-base fs-6">{{ $event->title }}</p>
                        </a>
                        @if ($event->event_type == 'digital')
                        <p class="loc"><i class="fas fa-map-marker-alt"></i> {{ $event->platform }}</p>
                        @else
                        <p class="loc"><i class="fas fa-map-marker-alt"></i> {{ $event->location }}</p>
                        @endif
                        <div class="d-flex align-items-center mt-2">
                            <div class="event-org-logo flex-shrink-0">
                                <img src="{{ check_file_exist('events/organizer_logos/', 'logo', $event->organizer_logo) }}" alt="...">
                            </div>
                            <div class="flex-grow-1 ms-2 white fs-12">
                                Organized By<br/><strong>{{ $event->organizer }}</strong>
                            </div>
                        </div>
                        @if (!empty($event->category_tag))
                        <p class="tags mt-3">
                            @foreach ($event->category_tag as $tag)
                            <span class="badge rounded-pill lightgreen-bg text-white text-uppercase" title="{{ $tag->sub_category->name }}">{{ Str::limit($tag->sub_category->name, 30) }}</span>
                            @endforeach
                        </p>
                        @endif
                        <a href="{{ $event->event_link }}" class="card-link text-white fs-12 fw-bold" target="_blank">Register here <i class="fas fa-angle-right fs-5 align-middle"></i></a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="section container carousel-holder" id="home-discover-sustainability">
    <div class="content">
        <center>
            <h2>Dive deep into sustainability.</h2>
        </center>
    </div>
</div>
<div class="section beige-bg ssx-info">
    <div class="content">
        <div class="double flex">
            <div class="left">
                <div class="image">
                    <img src="{{ check_file_exist('events/banners/', 'thumb', $event_top3->event_banner) }}" alt="..." class="curvy img-fluid">
                </div>
            </div>
            <div class="right">
                <div class="desc black">
                    @if (!empty($event_top3->category_tag))
                    <p class="tags lightgreen">
                        @foreach ($event_top3->category_tag as $tag)
                        <span class="badge rounded-pill lightgreen-bg text-white" title="{{ $tag->sub_category->name }}">{{ Str::limit($tag->sub_category->name, 30) }}</span>
                        @endforeach
                    </p>
                    @endif
                    <h2>{{ $event_top3->title }}</h2>
                    <div class="event-link">
                        @if ($event_top3->event_happening == 'global')
                        <div class="global"></div>
                        @else
                        <div class="local"></div>
                        @endif
                        <div class="categ darkgreen">
                            <a href="#" class="text-uppercase">{{ $event_top3->event_type }}</a>
                        </div>
                        <div class="loc">
                            @if ($event_top3->event_type == 'digital')
                            <h3 class="text-uppercase">{{ $event_top3->platform }}</h3>
                            @else
                            <h3 class="text-uppercase">{{ $event_top3->location }}</h3>
                            @endif
                        </div>
                        <div class="date">
                            @if (!empty($event_top3->event_date_2))
                            <h3>{{ $event_top3->event_date_1->format('d') }}-{{ $event_top3->event_date_2->format('d F Y') }}</h3>
                            @else
                            <h3>{{ $event_top3->event_date_1->format('d F Y') }}</h3>
                            @endif
                        </div>
                    </div>
                    <div class="event-info main">
                        <div class="image">
                            <img src="{{ check_file_exist('events/organizer_logos/', 'logo', $event_top3->organizer_logo) }}" alt="..." class="rounded img-fluid">
                        </div>
                        <div class="desc">Organized By <strong>{{ $event_top3->organizer }}</strong></div>
                    </div>
                    {!! $event_top3->description !!}
                    <div class="link-border">
                        <a href="{{ $event_top3->event_link }}" target="_blank" class="clear_btn arrow_btn">Learn more</a>
                        <a href="{{ $event_top3->event_link }}" target="_blank" class="lightgreen_btn arrow_btn">Register Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="section event-carousel-holder" id="webinars">
    <div class="content">
        <div class="double flex black">
            <div class="left">
                <div class="desc">
                    <h2>Upcoming Webinars</h2>
                </div>
            </div>
            <div class="right">
                <div class="desc align-right">
                    <h3>ORGANIZED BY <img src="/assets/images/dti-citem-logo-black.png" alt="" style="display: inline-block; max-width: 240px;"></h3>
                </div>
            </div>
        </div>
        <div class="row pt-3">
            <div id="eventSlider2" class="col owl-carousel owl-theme event-carousel">
                @foreach ($upcoming_events as $event)
                <div class="card h-100 maroon-bg item">
                    <img data-src="{{ check_file_exist('events/thumbs/', 'thumb', $event->event_banner) }}" class="owl-lazy card-img-top" alt="...">
                    <div class="card-body">
                        <a href="{{ $event->event_link }}" target="_blank" class="lightgreen-link2">
                            <p class="fw-bold lh-base fs-6">{{ $event->title }}</p>
                        </a>
                        @if ($event->event_type == 'digital')
                        <p class="loc"><i class="fas fa-map-marker-alt"></i> {{ $event->platform }}</p>
                        @else
                        <p class="loc"><i class="fas fa-map-marker-alt"></i> {{ $event->location }}</p>
                        @endif
                        <div class="d-flex align-items-center mt-2">
                            <div class="event-org-logo flex-shrink-0">
                                <img src="{{ check_file_exist('events/organizer_logos/', 'logo', $event->organizer_logo) }}" alt="...">
                            </div>
                            <div class="flex-grow-1 ms-2 white fs-12">
                                Organized By<br/><strong>{{ $event->organizer }}</strong>
                            </div>
                        </div>
                        @if (!empty($event->category_tag))
                        <p class="tags mt-3">
                            @foreach ($event->category_tag as $tag)
                            <span class="badge rounded-pill lightgreen-bg text-white text-uppercase" title="{{ $tag->sub_category->name }}">{{ Str::limit($tag->sub_category->name, 30) }}</span>
                            @endforeach
                        </p>
                        @endif
                        <a href="{{ $event->event_link }}" class="card-link text-white fs-12 fw-bold" target="_blank">Register here <i class="fas fa-angle-right fs-5 align-middle"></i></a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="content">
        <h2 class="event-title local">Browse Local Webinars</h2>
        <div class="row pt-3">
            <div id="eventSlider3" class="col owl-carousel owl-theme event-carousel">
                @foreach ($local_events as $event)
                <div class="card h-100 maroon-bg item">
                    <img data-src="{{ check_file_exist('events/thumbs/', 'thumb', $event->event_banner) }}" class="owl-lazy card-img-top" alt="...">
                    <div class="card-body">
                        <a href="{{ $event->event_link }}" target="_blank" class="lightgreen-link2">
                            <p class="fw-bold lh-base fs-6">{{ $event->title }}</p>
                        </a>
                        @if ($event->event_type == 'digital')
                        <p class="loc"><i class="fas fa-map-marker-alt"></i> {{ $event->platform }}</p>
                        @else
                        <p class="loc"><i class="fas fa-map-marker-alt"></i> {{ $event->location }}</p>
                        @endif
                        <div class="d-flex align-items-center mt-2">
                            <div class="event-org-logo flex-shrink-0">
                                <img src="{{ check_file_exist('events/organizer_logos/', 'logo', $event->organizer_logo) }}" alt="...">
                            </div>
                            <div class="flex-grow-1 ms-2 white fs-12">
                                Organized By<br/><strong>{{ $event->organizer }}</strong>
                            </div>
                        </div>
                        @if (!empty($event->category_tag))
                        <p class="tags mt-3">
                            @foreach ($event->category_tag as $tag)
                            <span class="badge rounded-pill lightgreen-bg text-white text-uppercase" title="{{ $tag->sub_category->name }}">{{ Str::limit($tag->sub_category->name, 30) }}</span>
                            @endforeach
                        </p>
                        @endif
                        <a href="{{ $event->event_link }}" class="card-link text-white fs-12 fw-bold" target="_blank">Register here <i class="fas fa-angle-right fs-5 align-middle"></i></a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="content">
        <h2 class="event-title global">Browse Global Webinars</h2>
        <div class="row pt-3">
            <div id="eventSlider4" class="col owl-carousel owl-theme event-carousel">
                @foreach ($global_events as $event)
                <div class="card h-100 maroon-bg item">
                    <img data-src="{{ check_file_exist('events/thumbs/', 'thumb', $event->event_banner) }}" class="owl-lazy card-img-top" alt="...">
                    <div class="card-body">
                        <a href="{{ $event->event_link }}" target="_blank" class="lightgreen-link2">
                            <p class="fw-bold lh-base fs-6">{{ $event->title }}</p>
                        </a>
                        @if ($event->event_type == 'digital')
                        <p class="loc"><i class="fas fa-map-marker-alt"></i> {{ $event->platform }}</p>
                        @else
                        <p class="loc"><i class="fas fa-map-marker-alt"></i> {{ $event->location }}</p>
                        @endif
                        <div class="d-flex align-items-center mt-2">
                            <div class="event-org-logo flex-shrink-0">
                                <img src="{{ check_file_exist('events/organizer_logos/', 'logo', $event->organizer_logo) }}" alt="...">
                            </div>
                            <div class="flex-grow-1 ms-2 white fs-12">
                                Organized By<br/><strong>{{ $event->organizer }}</strong>
                            </div>
                        </div>
                        @if (!empty($event->category_tag))
                        <p class="tags mt-3">
                            @foreach ($event->category_tag as $tag)
                            <span class="badge rounded-pill lightgreen-bg text-white text-uppercase" title="{{ $tag->sub_category->name }}" >{{ Str::limit($tag->sub_category->name, 30) }}</span>
                            @endforeach
                        </p>
                        @endif
                        <a href="{{ $event->event_link }}" class="card-link text-white fs-12 fw-bold" target="_blank">Register here <i class="fas fa-angle-right fs-5 align-middle"></i></a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="container-fluid section beige-bg ssx-info event-carousel-holder" id="on-demand-resources">
    <div class="content">
        <div class="double flex flex-rev flex-center">
            <div class="left">
                <div class="image">
                    <img src="/assets/images/philippine-map.png" class="ph-map" alt="...">
                </div>
            </div>
            <div class="right">
                <widgets id="40"></widgets>
                <!-- Event List -->
                <div class="row pt-3">
                    <div id="eventSlider5" class="col owl-carousel owl-theme event-carousel">
                        @foreach ($local_events as $event)
                        <div class="card h-100 maroon-bg item">
                            <img data-src="{{ check_file_exist('events/thumbs/', 'thumb', $event->event_banner) }}" class="owl-lazy card-img-top" alt="...">
                            <div class="card-body">
                                <a href="{{ $event->event_link }}" target="_blank" class="lightgreen-link2">
                                    <p class="fw-bold lh-base fs-6">{{ $event->title }}</p>
                                </a>
                                @if ($event->event_type == 'digital')
                                <p class="loc"><i class="fas fa-map-marker-alt"></i> {{ $event->platform }}</p>
                                @else
                                <p class="loc"><i class="fas fa-map-marker-alt"></i> {{ $event->location }}</p>
                                @endif
                                <div class="d-flex align-items-center mt-2">
                                    <div class="event-org-logo flex-shrink-0">
                                        <img src="{{ check_file_exist('events/organizer_logos/', 'logo', $event->organizer_logo) }}" alt="...">
                                    </div>
                                    <div class="flex-grow-1 ms-2 white fs-12">
                                        Organized By<br/><strong>{{ $event->organizer }}</strong>
                                    </div>
                                </div>
                                @if (!empty($event->category_tag))
                                <p class="tags mt-3">
                                    @foreach ($event->category_tag as $tag)
                                    <span class="badge rounded-pill lightgreen-bg text-white text-uppercase" title="{{ $tag->sub_category->name }}">{{ Str::limit($tag->sub_category->name, 30) }}</span>
                                    @endforeach
                                </p>
                                @endif
                                <a href="{{ $event->event_link }}" class="card-link text-white fs-12 fw-bold" target="_blank">Register here <i class="fas fa-angle-right fs-5 align-middle"></i></a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<on-demand-resources></on-demand-resources>
<x-contactus title="Do you have an event that you want us to feature?" subtitle="Let SSX help you reach a wider audience and get your message out there!" details="Just let us know the details of your event and send it to us. Someone from our team will reach out to you to verify the information and get you on track to be featured on our channels."/>
@endsection

@push('styles')
<link rel="stylesheet" href="/libs/owlcarousel/css/owl.carousel.min.css">
<link rel="stylesheet" href="/libs/owlcarousel/css/owl.theme.default.min.css">
@endpush
@push('scripts')
<script src="/libs/owlcarousel/js/owl.carousel.min.js"></script>
<script src="{{ mix('js/website/events.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#nav-events').addClass('active');
    });
</script>
@endpush