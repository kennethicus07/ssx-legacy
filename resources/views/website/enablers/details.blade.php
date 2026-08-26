@extends('layouts.website')

@section('content')
<div class="section carousel-holder full-vh" id="home-main">
<div id="heroCarousel" class="carousel slide carousel-fade hero-carousel" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            @if ($offer->image_banner)
            <img src="{{ url('storage/articles/banners/'.$offer->image_banner) }}" class="d-block w-100" alt="...">
            @else
            <img src="https://sustainability.ph/assets/images/default-thumb.jpg" class="d-block w-100" alt="...">
            @endif
        </div>
    </div>
</div>

<div class="section excerpt-info">
    <div class="content">
        <p class="date text-uppercase">POSTED {{ \Carbon\Carbon::parse($offer->created_at)->format('M d, Y - h:i A') }}</p>
        <h1>{{ $offer->title }}</h1>
        <!-- <p class="author">AUTHOR NAME HERE</p> -->
        <!-- <p class="excerpt">{{ $offer->sub_title }}</p> -->
    </div>
</div>

<div class="section ssx-info article-holder">
    <div class="content">
        {!! $offer->content !!}
    </div>
</div>

<div class="section ssx-info beige-bg resource-holder">
    <div class="content black">
        <h3>Read more</h3>
        <div class="cards-wrapper four">
            @foreach ($latest_articles as $latest_article)
            <div class="card black">
                <div class="img-wrapper">
                    @if ($latest_article->image_banner)
                    <img src="{{ url('storage/articles/banners/'.$latest_article->image_banner) }}" class="d-block w-100" alt="..."> 
                    @else
                    <img src="https://sustainability.ph/assets/images/default-thumb.jpg" class="card-img-top" alt="...">
                    @endif
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <div class="event-info main" style="margin-top: -80px;">
                            <div class="image">
                                <img src="/storage/export_enablers/logo/{{$latest_article->enabler->co_logo}}" class="border border-3 border-white white-bg">
                            </div>
                        </div>
                    </div>
                    <h5 class="card-title">{{ $latest_article->title }}</h5>
                    <p class="card-text simple-lnk">
                        {{ \Illuminate\Support\Str::limit(strip_tags($latest_article->content), 100) }} 
                        <a href="{{ route('services.export-enablers.programs_offers_details', [$latest_article->id, $latest_article->slug]) }}" class="arrow_btn">Learn More</a>
                    </p>
                    @if (!empty($latest_article->enabler->category_tag))
                    <p class="tags">
                        @foreach ($latest_article->enabler->category_tag as $tag)
                        <span class="badge rounded-pill lightgreen-bg text-white">{{ $tag->sub_category->name }}</span>
                        @endforeach
                    </p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        <p>&nbsp</p>
    </div>
</div>


@endsection

@push('styles')
@endpush
@push('scripts')
<script>
$(document).ready(function() {
    $('#nav-services').addClass('active');
});
</script>
@endpush