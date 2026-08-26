@extends('layouts.website')

@section('content')
<div class="section subnav beige-bg nav-holder gradient-top">
    <div class="content">
        <div class="d-flex justify-content-center">
            <h3 class="me-3">Browse Solutions: </h3>
            <div class="mt-2 me-3 black">
                <i class="fas fa-book-open align-middle fs-4"></i> <a href="{{ route('solutions.directories.index') }}" class="text-decoration-none">Marketplace</a>
            </div>
            <div class="mt-2 me-3 black">
                <i class="fas fa-solar-panel align-middle fs-4"></i> <a href="{{ route('solutions.sustainable.index') }}" class="text-decoration-none">Sustainable Solutions</a>
            </div>
            <div class="mt-2 lightgreen">
                <i class="fas fa-lightbulb align-middle fs-4"></i> Solutions Intelligence
            </div>
        </div>
    </div>
    <solutions-intelligence></solutions-intelligence>
    @if (!empty($featured_article))
    <div class="section white-bg ssx-info resource-holder">
        <div class="content">
            <div class="featured-resource">
                <div class="image">
                    <img src="{{ url('storage/articles/banners/'.$featured_article->image_banner) }}" class="d-block w-100" alt="...">
                </div>
            <div class="desc darkgreen-bg white">
                <div class="double flex flex-center">
                    <div class="left">
                        @if (!empty($featured_article->category_tag))
                        <p class="tags">
                            @foreach ($featured_article->category_tag as $tag)
                            <span class="badge rounded-pill lightgreen-bg p-2 text-white ms-1 mt-1">{{ $tag->sub_category->name }}</span>
                            @endforeach
                        </p>
                        @endif
                        <h2>{{ $featured_article->title }}</h2>
                    </div>
                    <div class="right">
                        <p>{{ \Illuminate\Support\Str::limit($featured_article->sub_title, 200) }}</p>
                        <p class="simple-lnk"><a href="{{ route('solutions.intelligence.details', [$featured_article->slug]) }}" class="arrow_btn">Read More</a></p>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    @endif
    <div class="section white-bg ssx-info resource-holder">
        <div class="content">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach ($latest_articles as $latest_article)
                <div class="col">
                    <div class="card h-100">
                        <img src="{{ url('storage/articles/thumbs/'.$latest_article->image_thumb) }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <a href="{{ route('solutions.intelligence.details', [$latest_article->slug]) }}" class="lightgreen-link">
                                <p class="fw-bold lh-base fs-6">{{ $latest_article->title }}</p>
                            </a>
                            <p class="card-text">
                                {{ \Illuminate\Support\Str::limit($latest_article->sub_title, 100) }}
                                <a href="{{ route('solutions.intelligence.details', [$latest_article->slug]) }}" class="lightgreen-link">Learn more</a>
                            </p>
                            @if (!empty($latest_article->category_tag))
                            <p class="tags">
                                @foreach ($latest_article->category_tag as $tag)
                                <span class="badge rounded-pill lightgreen-bg text-white ms-1">{{ $tag->sub_category->name }}</span>
                                @endforeach
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<x-contactus title="Get in touch with us." subtitle="Sustainability values partnerships."
    details="SSX is also a hub for business, partnerships, and networking. Help us empower our stakeholders by becoming a sustainability partner or enabler." />
@endsection

@push('styles')
@endpush
@push('scripts')
<script>
$(document).ready(function() {
    $('#nav-solutions').addClass('active');
});
</script>
@endpush