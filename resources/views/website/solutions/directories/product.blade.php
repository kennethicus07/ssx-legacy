@extends('layouts.website')

@section('content')
    <div class="section subnav beige-bg nav-holder gradient-top">
        <div class="content">
            <div class="d-flex justify-content-center">
                <h3 class="me-3">Browse Solutions: </h3>
                <div class="mt-2 me-3 lightgreen">
                    <i class="fas fa-book-open align-middle fs-4"></i> <a href="{{ route('solutions.directories.index') }}"
                        class="text-decoration-none">Marketplace</a>
                </div>
                <div class="mt-2 me-3 black">
                    <i class="fas fa-solar-panel align-middle fs-4"></i> <a href="{{ route('solutions.sustainable.index') }}"
                        class="text-decoration-none">Sustainable
                        Solutions</a>
                </div>
                <div class="mt-2 black">
                    <i class="fas fa-lightbulb align-middle fs-4"></i> <a href="{{ route('solutions.intelligence.index') }}"
                        class="text-decoration-none">Solutions Intelligence</a>
                </div>
            </div>
        </div>
    </div>
    <div class="section ssx-info white-bg product-inner">
        <div class="content">
            <div class="flex double">
                <div class="left">
                    <h2>{{ $product->name }}</h2>
                    <p>{{ $product->description }}</p>
                    <!-- <div class="prod_desc_list">
                                    <ul>
                                        <li>
                                            <p>Designed using Ecological Waste Management Principle or</p>
                                        </li>
                                        <li>
                                            <p>Reduce-Reuse-Recycle Philosophy</p>
                                        </li>
                                        <li>
                                            <p>Product can improve or protect the environment Has environmental labeling certification
                                                or environmental group recognition from a reputable accredited body in compliance with
                                                national or international standards
                                                and regulations or based on Life-Cycle Assessment (a key to ecolabel schemes)
                                            </p>
                                        </li>
                                    </ul>
                                </div> -->
                    <h4>Supplier/Exhibitor</h4>
                    <div class="prod_desc_list product-details">
                        <div class="image">
                            <a
                                href="{{ route('solutions.directories.details', [$product->supplier->id, $exhibitor->slug]) }}"><img
                                    src="{{ check_file_exist('exhibitors/logos/', 'logo', $product->supplier->logo) }}"
                                    class="d-block w-100" alt="..."></a>
                        </div>
                        <div class="desc">
                            <h4><a
                                    href="{{ route('solutions.directories.details', [$product->supplier->id, $exhibitor->slug]) }}">{{ $exhibitor->co_name }}</a>
                            </h4>
                            <!-- <p class="tags"><a href="#">Tag 1</a><a href="#">Tag 2</a><a href="#" class="maroon-bg">Tag
                                                2</a></p> -->
                            <p>{{ Str::limit($exhibitor->co_details, 100) }}<a
                                    href="{{ route('solutions.directories.details', [$product->supplier->id, $exhibitor->slug]) }}">Learn
                                    more</a></p>
                        </div>
                    </div>
                    @if (!empty($product->product_certifications))
                        <h4>Certifications</h4>
                        <div class="prod_desc_list product-images">
                            <p>
                                @foreach ($product->product_certifications as $prod_cert)
                                    <img src="{{ check_file_exist('certifications/', 'logo', $prod_cert->certification->logo) }}"
                                        title="{{ $prod_cert->certification->name }}">
                                @endforeach
                            </p>
                        </div>
                        <p class="align-right black"><a href="{{ route('certifications.index') }}" class="arrow_btn">View
                                Glossary of Certifications</a></p>
                    @endif
                    <!-- <h4>Recommended by the following organizations</h4>
                                <div class="prod_desc_list product-images">
                                    <p>
                                        <img src="/assets/images/iec-logo.png">
                                        <img src="/assets/images/Wildlife-Conservation-Society.png">
                                        <img src="/assets/images/iec-logo.png">
                                    </p>
                                </div> -->
                </div>
                <div class="right">
                    <div class="featured">
                        <!-- <div class="image curvy"><img src="/assets/images/product.jpg"></div> -->
                        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                @foreach ($product->product_images as $prod_image)
                                    <button type="button" data-bs-target="#carouselExampleCaptions"
                                        data-bs-slide-to="{{ $loop->index }}" @class(['active' => $loop->iteration === 1])
                                        @if ($loop->iteration === 1) aria-current="true" @endif
                                        aria-label="Slide {{ $loop->iteration }}"></button>
                                @endforeach
                            </div>
                            <div class="carousel-inner">
                                @foreach ($product->product_images as $prod_image)
                                    <div @class([
                                        'carousel-item image curvy',
                                        'active' => $loop->iteration === 1,
                                    ])>
                                        <img src="{{ check_file_exist('exhibitors/products/', 'thumb', $prod_image->image) }}"
                                            alt="...">
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                        @foreach ($product->product_profiles as $tag)
                            <p class="tags m-1 p-0">
                                <a href="#" class="text-uppercase">{{ $tag->sub_category_remarks }}</a>
                            </p>
                        @endforeach
                    </div>
                    <p class="black align-left mt-3"><a href="{{ route('solutions.directories.index') }}"
                            class="arrow_btn">Back to Directory</a></p>
                    <!-- <div class="product-specs">
                                    <div class="spec">
                                        <h5>PRODUCT DIMENSIONS</h5>
                                        <p>5 feet by 3 feet per panel</p>
                                    </div>
                                    <div class="spec">
                                        <h5>PRODUCT WEIGHT</h5>
                                        <p>38 lbs per panel</p>
                                    </div>
                                    <div class="spec">
                                        <h5>CELLS PER PANEL</h5>
                                        <p>60 for Residential, 72 for Commercial</p>
                                    </div>
                                    <div class="spec">
                                        <h5>SYSTEM POWER</h5>
                                        <p>265-300 per panel</p>
                                    </div>
                                    <div class="spec">
                                        <h5>INVERTER</h5>
                                        <p>True Hybrid Inverter</p>
                                    </div>
                                </div> -->
                    <!-- <h4>Similar Products and Solutions</h4>
                                <div class="other-products">
                                    <div class="prod">
                                        <div class="image">
                                            <a href="company.html"><img src="/assets/images/Commit-to-sustainability-reporting.jpg"
                                                    class="d-block w-100" alt="..."></a>
                                        </div>
                                        <div class="desc">
                                            <h6><a href="#">COMPANY SUPPLIER</a></h6>
                                            <h4><a href="#">Name of Product</a></h4>
                                            <p>Short description of company. consetetur sadipscing elitr, sed diam nonumy eirmod tempor
                                                invidunt ut labore et dolore magna aliquyam erat, sed diam… <a href="company.html">Learn
                                                    more</a></p>
                                            <p class="tags"><a href="#">Tag 1</a><a href="#">Tag 2</a></p>
                                        </div>
                                    </div>
                                    <div class="prod">
                                        <div class="image">
                                            <a href="company.html"><img src="/assets/images/Commit-to-sustainability-reporting.jpg"
                                                    class="d-block w-100" alt="..."></a>
                                        </div>
                                        <div class="desc">
                                            <h6><a href="#">COMPANY SUPPLIER</a></h6>
                                            <h4><a href="#">Name of Product</a></h4>
                                            <p>Short description of company. consetetur sadipscing elitr, sed diam nonumy eirmod tempor
                                                invidunt ut labore et dolore magna aliquyam erat, sed diam… <a href="company.html">Learn
                                                    more</a></p>
                                            <p class="tags"><a href="#">Tag 1</a><a href="#">Tag 2</a></p>
                                        </div>
                                    </div>
                                    <div class="prod">
                                        <div class="image">
                                            <a href="company.html"><img src="assets/images/Commit-to-sustainability-reporting.jpg"
                                                    class="d-block w-100" alt="..."></a>
                                        </div>
                                        <div class="desc">
                                            <h6><a href="#">COMPANY SUPPLIER</a></h6>
                                            <h4><a href="#">Name of Product</a></h4>
                                            <p>Short description of company. consetetur sadipscing elitr, sed diam nonumy eirmod tempor
                                                invidunt ut labore et dolore magna aliquyam erat, sed diam… <a href="company.html">Learn
                                                    more</a></p>
                                            <p class="tags"><a href="#">Tag 1</a><a href="#">Tag 2</a></p>
                                        </div>
                                    </div>
                                </div>
                                <p class="black align-left"><a href="#" class="arrow_btn">Back to Directory</a></p> -->
                </div>
            </div>
        </div>
    </div>
    @if (!empty($user->products))
        <div class="section ssx-info">
            <div class="content curvy">
                <center>
                    <h2>More From This Supplier/Exhibitor</h2>
                    <div class="solutions-holder">
                        @foreach ($user->products as $prod)
                            @if ($prod->id != $product->id)
                                <div class="solution product">
                                    <div class="image">
                                        <a
                                            href="{{ route('solutions.directories.product_details', [$exhibitor->slug, $prod->id, $prod->slug]) }}"><img
                                                src="{{ check_file_exist('exhibitors/products/thumbs/', 'thumb', $prod->product_image[0]->image) }}"
                                                class="d-block w-100" alt="..."></a>
                                    </div>
                                    <div class="desc">
                                        <h6><a
                                                href="{{ route('solutions.directories.details', [$user->id, $exhibitor->slug]) }}">{{ $exhibitor->co_name }}</a>
                                        </h6>
                                        <h3><a
                                                href="{{ route('solutions.directories.product_details', [$exhibitor->slug, $prod->id, $prod->slug]) }}">{{ $prod->name }}</a>
                                        </h3>
                                        <p>
                                            {{ Str::limit($prod->description, 60) }} <a
                                                href="{{ route('solutions.directories.product_details', [$exhibitor->slug, $prod->id, $prod->slug]) }}">Learn
                                                more</a>
                                        </p>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </center>
            </div>
        </div>
    @endif
    <div class="popup-container">
        <div class="popup">
            <div class="login-holder">
                <div class="close-btn_holder"><a href="#" class="close_btn">✕</a></div>
                <div class="content">
                    <h1>Log in to your account.</h1>
                    <div class="form-container">
                        <form action="/action_page.php">
                            <div class="form-group">
                                <label for="email">Email address:</label>
                                <input type="email" class="form-control" id="email"
                                    placeholder="email@domain.com">
                            </div>
                            <div class="form-group">
                                <label for="pwd">Password:</label>
                                <input type="password" class="form-control" id="pwd" placeholder="password">
                            </div>
                            <div class="pt-20 push-right link-border">
                                <button type="submit" class="btn black_btn"><strong>SUBMIT</strong></button>
                            </div>
                            <div class="push-right">
                                <a href="#" class="black"><sub><strong>Forgot Password?</strong></sub></a>
                            </div>
                        </form>
                    </div>
                    <h4>Don't have an account?</h4>
                    <div class="flex link-border">
                        <a href="#" class="lightgreen_btn arrow_btn">Register as an Supplier/Exhbitor</a>
                        <a href="#" class="orange_btn arrow_btn">Register as a Purchaser/Buyer</a>
                    </div>
                    <h4>Join the Event!</h4>
                    <div class="flex link-border">
                        <a href="#" class="maroon_btn arrow_btn">Register as an Attendee</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
