@extends('layouts.website')

@section('content')
    <div class="section ssx-info" id="featuredEvent">
        <div class="featured">
            <div id="resourceCarousel" class="carousel slide carousel-fade resource-carousel" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    @foreach ($articles_carousel as $banner_indicator)
                        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $loop->index }}"
                            @class(['active' => $loop->iteration === 1]) @if ($loop->iteration === 1) aria-current="true" @endif
                            aria-label="Slide {{ $loop->iteration }}"></button>
                    @endforeach
                </div>
                <div class="carousel-inner">
                    @foreach ($articles_carousel as $article_carousel)
                        <div @class(['carousel-item', 'active' => $loop->iteration === 1])>
                            <img src="{{ url('storage/articles/banners/' . $article_carousel->image_banner) }}"
                                class="d-block w-100" alt="...">
                            <div class="carousel-caption white">
                                @if (!empty($article_carousel->category_tag))
                                    <p class="tags mb-1">
                                        @foreach ($article_carousel->category_tag as $tag)
                                            <span
                                                class="badge rounded-pill lightgreen-bg">{{ $tag->sub_category->name }}</span>
                                        @endforeach
                                    </p>
                                @endif
                                <h2 class="lh-sm">{{ $article_carousel->title }}</h2>
                                <p>{{ $article_carousel->sub_title }}</p>
                                <p class="simple-lnk"><a
                                        href="{{ route('news-articles.details', [$article_carousel->slug]) }}"
                                        class="arrow_btn">Read more</a></p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#resourceCarousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#resourceCarousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
    <div class="section ssx-info resource-holder">
        <div class="content">
            <h2>Read about the latest in sustainability</h2>
            <div class="row row-cols-1 row-cols-md-3 g-4 mt-3">
                @foreach ($latest_articles as $latest_article)
                    <div class="col">
                        <div class="card h-100">
                            <img src="{{ url('storage/articles/thumbs/' . $latest_article->image_thumb) }}"
                                class="card-img-top" alt="...">
                            <div class="card-body">
                                <a href="{{ route('news-articles.details', [$latest_article->slug]) }}"
                                    class="lightgreen-link">
                                    <p class="fw-bold lh-base fs-6">{{ $latest_article->title }}</p>
                                </a>
                                <p class="card-text">
                                    {{ \Illuminate\Support\Str::limit($latest_article->sub_title, 100) }}
                                    <a href="{{ route('news-articles.details', [$latest_article->slug]) }}"
                                        class="lightgreen-link">Learn more</a>
                                </p>
                                @if (!empty($latest_article->category_tag))
                                    <p class="tags">
                                        @foreach ($latest_article->category_tag as $tag)
                                            <span
                                                class="badge rounded-pill lightgreen-bg text-white ms-1">{{ $tag->sub_category->name ?? '' }}</span>
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
    @if (!empty($featured_article))
        <div class="section ssx-info">
            <div class="content">
                <div class="featured-resource">
                    <div class="image">
                        <img src="{{ url('storage/articles/banners/' . $featured_article->image_banner) }}"
                            class="d-block w-100" alt="...">
                    </div>
                    <div class="desc darkgreen-bg white">
                        <div class="double flex flex-center">
                            <div class="left">
                                @if (!empty($featured_article->category_tag))
                                    <p class="tags">
                                        @foreach ($featured_article->category_tag as $tag)
                                            <span
                                                class="badge rounded-pill lightgreen-bg p-2 text-white ms-1">{{ $tag->sub_category->name }}</span>
                                        @endforeach
                                    </p>
                                @endif
                                <h2>{{ $featured_article->title }}</h2>
                            </div>
                            <div class="right">
                                <p>{{ \Illuminate\Support\Str::limit($featured_article->sub_title, 200) }}</p>
                                <p class="simple-lnk"><a
                                        href="{{ route('news-articles.details', [$featured_article->slug]) }}"
                                        class="arrow_btn">Read More</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <articles></articles>
    <div class="section ssx-info">
        <div class="content">
            <div class="image curvy"><img src="/assets/images/Ambisyon-Natin-banner.jpg" alt="..."></div>
        </div>
        <div class="content">
            <div class="double flex flex-center">
                <div class="left">
                    <div class="desc">
                        <h2>Ambisyon Natin 2040</h2>
                        <h3>represents the collective long-term vision and aspirations of the Filipino people…</h3>
                    </div>
                </div>
                <div class="right">
                    <div class="desc">
                        <p class="fs-6 lh-base">…for themselves and for the country in the next 25 years. It describes the
                            kind of life that
                            people want to live, and how the country will be by 2040. As such, it is an anchor for
                            development planning across at least four administrations.</p>
                        <p class="fs-6 lh-base">AmBisyon Natin 2040 is a picture of the future, a set of life goals and
                            goals for the country. It
                            is different from a plan, which defines the strategies to achieve the goals. It is like a
                            destination that answers the question “Where do we want to be?”. A plan describes the way to get
                            to the destination; AmBisyon Natin 2040 is the vision that guides the future and is the anchor
                            of the country’s plans.</p>
                        <p class="fs-6 lh-base">AmBisyon Natin 2040 is the result of a long-term visioning process that
                            began in 2015. More than
                            300 citizens participated in focus group discussions and close to 10,000 answered the national
                            survey. Technical studies were prepared to identify strategic options for realizing the vision
                            articulated by citizens. The exercise benefitted from the guidance of an Advisory Committee
                            composed of government, private sector, academe, and civil society.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">
            <center>
                <h3 class="pb-20">2040 Quality of Living</h3>
            </center>
            <div class="resource-desc">
                <div class="ico-desc">
                    <div class="flex-row">
                        <div class="image"><img src="/assets/images/Matatag-icon.png" alt="..."></div>
                        <div class="desc">
                            <p class="fs-6 lh-base">
                                Family is together Time with friends Work-life balance Volunteering
                            </p>
                        </div>
                    </div>
                    <div class="flex-column more-details">
                        <h3>Matatag</h3>
                        <p><span class="lightgreen">Strongly rooted</span></p>
                    </div>
                </div>
                <div class="ico-desc">
                    <div class="flex-row">
                        <div class="image"><img src="/assets/images/Maginhawa-icon.png" alt="..."></div>
                        <div class="desc">
                            <p class="fs-6 lh-base">
                                Free from hunger and poverty Secure home ownership Good transport facilities Travel and
                                vacation
                            </p>
                        </div>
                    </div>
                    <div class="flex-column more-details">
                        <h3>Maginhawa</h3>
                        <p><span class="lightgreen">Comfortable</span></p>
                    </div>
                </div>
                <div class="ico-desc">
                    <div class="flex-row">
                        <div class="image"><img src="/assets/images/Panatag-icon.png" alt="..."></div>
                        <div class="desc">
                            <p class="fs-6 lh-base">
                                Enough resources for day-to-day needs, unexpected expenses and savings Peace and security
                                Long and healthy life Comfortable retirement
                            </p>
                        </div>
                    </div>
                    <div class="flex-column more-details">
                        <h3>Panatag</h3>
                        <p><span class="lightgreen">Secure</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section ssx-info">
        <div class="content">
            <div class="double flex flex-rev flex-center">
                <div class="left">
                    <div class="image curvy"><img src="/assets/images/Ambisyon-Natin-photo.jpg" alt="..."></div>
                </div>
                <div class="right">
                    <div class="desc">
                        <h2>Make this AmBisyon<br /> <span class="lightgreen">a reality.</span></h2>
                        <p class="fs-6 lh-base">All sectors of society, whether public or private, should direct their
                            efforts towards creating
                            opportunities for Filipinos to enjoy a matatag, maginhawa at panatag na buhay. Government, in
                            particular, must use its tools of fiscal, monetary and regulatory policies to steer the
                            development path towards enabling Filipinos to attain their AmBisyon. This pertains to all
                            dimensions of development: economic, human and physical capital, institutional, social and
                            cultural.</p>
                        <div class="link-border">
                            <a href="http://web.csc.gov.ph/phocadownload/userupload/csi/hrs_ppt/2019HRSPPT/Public%20Service%20Values%20on%20Patriotism%20Towards%20Public%20Service%20Excellence_Atty%20Alexander%20L%20Lacson.pdf"
                                target="_blank" class="lightgreen_btn arrow_btn">Download A Long-Term Vision of the
                                Philippines</a>
                        </div>
                        <p class="simple-lnk black"><a href="https://2040.depdev.gov.ph/about-ambisyon-natin-2040/" target="_blank"
                                class="arrow_btn">Learn more at neda.gov.ph</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section beige-bg ssx-info">
        <div class="content">
            <div class="double flex flex-center">
                <div class="left">
                    <div class="image curvy"><img src="/assets/images/Commit-to-sustainability-reporting.jpg"
                            alt="...">
                    </div>
                </div>
                <div class="right">
                    <div class="desc">
                        <h2>Commit to <br /><span class="lightgreen">sustainability reporting.</span></h2>
                        <!-- <p class="fs-6 lh-base">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy
                            eirmod tempor invidunt
                            ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo
                            dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est.</p> -->
                        <div class="link-border">
                            <a href="https://www.sec.gov.ph/wp-content/uploads/2019/10/2019MCNo04.pdf" target="_blank"
                                class="lightgreen_btn arrow_btn">Download Sustainability Reporting Guidelines</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="/libs/owlcarousel/css/owl.carousel.min.css" rel="stylesheet">
    <link href="/libs/owlcarousel/css/owl.theme.default.min.css" rel="stylesheet">
@endpush
@push('scripts')
    <script src="/libs/owlcarousel/js/owl.carousel.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#nav-articles').addClass('active');
        });
    </script>
@endpush
