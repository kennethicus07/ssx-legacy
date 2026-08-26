<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ env('APP_URL') }}</loc>
        <lastmod>{{ $time_now }}</lastmod>
        <priority>0.6</priority>
    </url>
    <url>
        <loc>{{ env('APP_URL') }}/events</loc>
        <lastmod>{{ $time_now }}</lastmod>
        <priority>0.6</priority>
    </url>
    <url>
        <loc>{{ env('APP_URL') }}/events#global-initiatives</loc>
        <lastmod>{{ $time_now }}</lastmod>
        <priority>0.6</priority>
    </url>
    <url>
        <loc>{{ env('APP_URL') }}/events#webinars</loc>
        <lastmod>{{ $time_now }}</lastmod>
        <priority>0.6</priority>
    </url>
    <url>
        <loc>{{ env('APP_URL') }}/events#local-highlights</loc>
        <lastmod>{{ $time_now }}</lastmod>
        <priority>0.6</priority>
    </url>
    <url>
        <loc>{{ env('APP_URL') }}/events#on-demand-resources</loc>
        <lastmod>{{ $time_now }}</lastmod>
        <priority>0.6</priority>
    </url>
    <url>
        <loc>{{ env('APP_URL') }}/about-us</loc>
        <lastmod>{{ $time_now }}</lastmod>
        <priority>0.6</priority>
    </url>
    <url>
        <loc>{{ env('APP_URL') }}/about-us#contactUs</loc>
        <lastmod>{{ $time_now }}</lastmod>
        <priority>0.6</priority>
    </url>
    <url>
        <loc>{{ env('APP_URL') }}/solutions/marketplace</loc>
        <lastmod>{{ $time_now }}</lastmod>
        <priority>0.6</priority>
    </url>
    <url>
        <loc>{{ env('APP_URL') }}/solutions/marketplace/suppliers</loc>
        <lastmod>{{ $time_now }}</lastmod>
        <priority>0.6</priority>
    </url>
    <url>
        <loc>{{ env('APP_URL') }}/solutions/sustainable</loc>
        <lastmod>{{ $time_now }}</lastmod>
        <priority>0.6</priority>
    </url>
    <url>
        <loc>{{ env('APP_URL') }}/solutions/intelligence</loc>
        <lastmod>{{ $time_now }}</lastmod>
        <priority>0.6</priority>
    </url>
    <url>
        <loc>{{ env('APP_URL') }}/solutions/sustainable/suppliers</loc>
        <lastmod>{{ $time_now }}</lastmod>
        <priority>0.6</priority>
    </url>
    <url>
        <loc>{{ env('APP_URL') }}/solutions/sustainable/intelligence</loc>
        <lastmod>{{ $time_now }}</lastmod>
        <priority>0.6</priority>
    </url>
    @foreach ($suppliers as $supplier)
        <url>
            <loc>{{ env('APP_URL').'/solutions/marketplace/'.$supplier->id.'/'.$supplier->exhibitor->slug }}</loc>
            <lastmod>{{ Carbon\Carbon::parse($supplier->updated_at)->toIso8601String() }}</lastmod>
            <priority>0.6</priority>
        </url>
        @if (!empty($supplier->products)) 
            @foreach ($supplier->products as $product)
            <url>
                <loc>{{ env('APP_URL').'/solutions/marketplace/product/'.$supplier->exhibitor->slug.'/'.$product->id.'/'.$product->slug }}</loc>
                <lastmod>{{ Carbon\Carbon::parse($supplier->updated_at)->toIso8601String() }}</lastmod>
                <priority>0.6</priority>
            </url>
            @endforeach
        @endif
    @endforeach
    @foreach ($sustainables as $sustainable)
        <url>
            <loc>{{ env('APP_URL').'/solutions/sustainable/'.$sustainable->id.'/'.$sustainable->exhibitor->slug }}</loc>
            <lastmod>{{ Carbon\Carbon::parse($sustainable->updated_at)->toIso8601String() }}</lastmod>
            <priority>0.6</priority>
        </url>
    @endforeach
    @foreach ($intelligences as $intelligence)
        <url>
            <loc>{{ env('APP_URL').'/solutions/intelligence/'.$intelligence->slug }}</loc>
            <lastmod>{{ Carbon\Carbon::parse($intelligence->updated_at)->toIso8601String() }}</lastmod>
            <priority>0.6</priority>
        </url>
    @endforeach
    <url>
        <loc>{{ env('APP_URL') }}/services/export-enablers</loc>
        <lastmod>{{ $time_now }}</lastmod>
        <priority>0.6</priority>
    </url>
    <url>
        <loc>{{ env('APP_URL') }}/services/export-enablers/about</loc>
        <lastmod>{{ $time_now }}</lastmod>
        <priority>0.6</priority>
    </url>
    @foreach ($offers as $offer)
        <url>
            <loc>{{ env('APP_URL').'/services/export-enablers/programs-offers/'.$offer->id.'/'.$offer->slug }}</loc>
            <lastmod>{{ Carbon\Carbon::parse($offer->updated_at)->toIso8601String() }}</lastmod>
            <priority>0.6</priority>
        </url>
    @endforeach
    <url>
        <loc>{{ env('APP_URL') }}/news-articles</loc>
        <lastmod>{{ $time_now }}</lastmod>
        <priority>0.6</priority>
    </url>
    @foreach ($articles as $article)
        <url>
            <loc>{{ env('APP_URL').'/news-articles/'.$article->slug }}</loc>
            <lastmod>{{ Carbon\Carbon::parse($article->updated_at)->toIso8601String() }}</lastmod>
            <priority>0.6</priority>
        </url>
    @endforeach
    <url>
        <loc>{{ env('APP_URL') }}/resources-news/digital-exhibition-conference-2022</loc>
        <lastmod>{{ $time_now }}</lastmod>
        <priority>0.6</priority>
    </url>
    <url>
        <loc>{{ env('APP_URL') }}/certifications</loc>
        <lastmod>{{ $time_now }}</lastmod>
        <priority>0.6</priority>
    </url>
    <url>
        <loc>{{ env('APP_URL') }}/login</loc>
        <lastmod>{{ $time_now }}</lastmod>
        <priority>0.6</priority>
    </url>
    <url>
        <loc>{{ env('APP_URL') }}/registration/supplier</loc>
        <lastmod>{{ $time_now }}</lastmod>
        <priority>0.6</priority>
    </url>
    <url>
        <loc>{{ env('APP_URL') }}/registration/supplier/email-validation</loc>
        <lastmod>{{ $time_now }}</lastmod>
        <priority>0.6</priority>
    </url>
    <url>
        <loc>{{ env('APP_URL') }}/registration/purchaser</loc>
        <lastmod>{{ $time_now }}</lastmod>
        <priority>0.6</priority>
    </url>
    <url>
        <loc>{{ env('APP_URL') }}/registration/purchaser/email-validation</loc>
        <lastmod>{{ $time_now }}</lastmod>
        <priority>0.6</priority>
    </url>
</urlset>