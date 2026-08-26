@extends('layouts.website')

@section('content')
<div class="section carousel-holder full-vh" id="home-main">
    <div id="heroCarousel" class="carousel slide carousel-fade hero-carousel" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ url('storage/articles/banners/'.$article->image_banner) }}" class="d-block w-100" alt="...">
            </div>
        </div>
    </div>

    <div class="section excerpt-info">
        <div class="content">
            <p class="date text-uppercase">POSTED {{ \Carbon\Carbon::parse($article->created_at)->format('M d, Y - h:i A') }}</p>
            <h1>{{ $article->title }}</h1>
            <!-- <p class="author">AUTHOR NAME HERE</p> -->
            <p class="excerpt">{{ $article->sub_title }}</p>
        </div>
    </div>

    <div class="section ssx-info article-holder">
        <div class="content">
            {!! $article->content !!}
        </div>
    </div>

    <div class="section ssx-info beige-bg resource-holder">
        <div class="content black">
            <h3>Read more</h3>
            <div class="cards-wrapper four">
                @foreach ($latest_articles as $latest_article)
                <div class="card black">
                    <div class="img-wrapper">
                        <img src="{{ url('storage/articles/thumbs/'.$latest_article->image_thumb) }}" class="d-block w-100" alt="..."> 
                    </div>
                    <div class="card-body">
                        <a href="{{ route('on-demand-resources.details', [$latest_article->slug]) }}" class="lightgreen-link">
                            <p class="fw-bold lh-base fs-6">{{ $latest_article->title }}</p>
                        </a>
                        <p class="card-text">
                            {{ \Illuminate\Support\Str::limit($latest_article->sub_title, 100) }} 
                            <a href="{{ route('on-demand-resources.details', [$latest_article->slug]) }}" class="lightgreen-link">Learn more</a>
                        </p>
                        @if (!empty($latest_article->category_tag))
                        <p class="tags">
                            @foreach ($latest_article->category_tag as $tag)
                            <span class="badge rounded-pill lightgreen-bg text-white text-uppercase ms-1">{{ $tag->sub_category->name }}</span>
                            @endforeach
                        </p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            <p>&nbsp</p>
            <p class="align-right simple-lnk">
                <a href="/events#on-demand-resources" class="arrow_btn">Read All Articles</a>
            </p>
        </div>
    </div>
    
    
    @endsection

    @push('styles')
    @endpush
    @push('scripts')
    @endpush