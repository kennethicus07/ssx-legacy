@extends('layouts.website')

@section('content')
<div class="section subnav beige-bg nav-holder gradient-top">
    <div class="content">
        <div class="flex ico-holder">
            <h3>Browse Solutions: </h3>
            <!-- <a href="#" class="directory">Directory Sustainable </a> -->
            <a href="#" class="solutions active">Sustainable Solutions </a>
            <a href="#" class="intelligence">Solutions Intelligence</a>
        </div>
    </div>
    <div class="section form-header solution-header">
        <div class="content">
            <div class="header-desc">
                <center>
                    <h1>Sustainable Solutions</h1>
                </center>
                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut
                    labore et dolore magna aliquyam erat, sed diam voluptua.</p>
                <div class="searchbox">
                    <div class="text"><input type="text" placeholder="Search"></div>
                    <div class="button"><button class="Search">SEARCH</button></div>
                </div>
            </div>
        </div>
    </div>

    <div class="section white-bg ssx-info solution-listing">
        <div class="content">
            <div class="flex">
                <div class="flex1">
                    <div class="list-header">
                        <h4 class="ico-holder filter">Filter</h4>
                    </div>
                    <div class="select-holder">
                        <div class="select-options">
                            <h4>ZONE</h4>
                            <h5><a href="#">Food Solutions</a></h5>
                            <ul class="sub-options">
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="option1">
                                        <label class="form-check-label" for="option1">
                                            Natural, Herbal and Organic Food Products
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="option2">
                                        <label class="form-check-label" for="option2">
                                            Healthy Food and Food Supplements
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="option3">
                                        <label class="form-check-label" for="option3">
                                            Organic Farms/Parks
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="option4">
                                        <label class="form-check-label" for="option4">
                                            Certifying Bodies
                                        </label>
                                    </div>
                                </li>
                            </ul>
                            <h5><a href="#">Food Solutions</a></h5>
                            <ul class="sub-options">
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="option5">
                                        <label class="form-check-label" for="option5">
                                            Natural, Herbal and Organic Food Products
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="option6">
                                        <label class="form-check-label" for="option6">
                                            Healthy Food and Food Supplements
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="option7">
                                        <label class="form-check-label" for="option7">
                                            Organic Farms/Parks
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="option8">
                                        <label class="form-check-label" for="option8">
                                            Certifying Bodies
                                        </label>
                                    </div>
                                </li>
                            </ul>


                            <h4>TYPE</h4>
                            <ul class="type-options">
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="option9">
                                        <label class="form-check-label" for="option9">
                                            Efficiency Practices & Solutions
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="option10">
                                        <label class="form-check-label" for="option10">
                                            Carbon Sequestration, Reducing Sources, Shift Production
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="option11">
                                        <label class="form-check-label" for="option11">
                                            Society, Culture & Community, Accountability, Supporting Causes
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="option12">
                                        <label class="form-check-label" for="option12">
                                            Logistics, Packaging Waste Management
                                        </label>
                                    </div>
                                </li>
                            </ul>

                            <div class="btn-holder link-border flex">
                                <button class="btn black_btn">APPLY</button>
                                <button class="btn clear_btn">RESET</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex4">
                    <div class="list-header">
                        <p class="align-right">Sort by <select>
                                <option>A-Z</option>
                            </select></p>
                    </div>
                    <div class="solutions-holder">
                        <div class="solution product">
                            <div class="image"><a href="product.html"><img src="assets/images/elevate_article01.jpg"
                                        class="d-block w-100" alt="..."></a></div>
                            <div class="desc">
                                <h6><a href="company.html">COMPANY SUPPLIER/EXHIBITOR</a></h6>
                                <h3><a href="product.html">Name of Product</a></h3>
                                <p>Short description of company. consetetur sadipscing elitr, sed diam nonumy eirmod
                                    tempor invidunt ut labore et dolore magna aliquyam erat, sed diam… <a href="#">Learn
                                        more</a></p>
                                <p class="tags"><a href="#">Tag 1</a><a href="#">Tag 2</a></p>
                            </div>
                        </div>
                        <div class="solution product">
                            <div class="image"><a href="product.html"><img src="assets/images/elevate_article01.jpg"
                                        class="d-block w-100" alt="..."></a></div>
                            <div class="desc">
                                <h6><a href="company.html">COMPANY SUPPLIER/EXHIBITOR</a></h6>
                                <h3><a href="product.html">Name of Product</a></h3>
                                <p>Short description of company. consetetur sadipscing elitr, sed diam nonumy eirmod
                                    tempor invidunt ut labore et dolore magna aliquyam erat, sed diam… <a href="#">Learn
                                        more</a></p>
                                <p class="tags"><a href="#">Tag 1</a><a href="#">Tag 2</a></p>
                            </div>
                        </div>
                        <div class="solution product">
                            <div class="image"><a href="product.html"><img src="assets/images/elevate_article01.jpg"
                                        class="d-block w-100" alt="..."></a></div>
                            <div class="desc">
                                <h6><a href="company.html">COMPANY SUPPLIER/EXHIBITOR</a></h6>
                                <h3><a href="product.html">Name of Product</a></h3>
                                <p>Short description of company. consetetur sadipscing elitr, sed diam nonumy eirmod
                                    tempor invidunt ut labore et dolore magna aliquyam erat, sed diam… <a href="#">Learn
                                        more</a></p>
                                <p class="tags"><a href="#">Tag 1</a><a href="#">Tag 2</a></p>
                            </div>
                        </div>
                        <div class="solution product">
                            <div class="image"><a href="product.html"><img src="assets/images/elevate_article01.jpg"
                                        class="d-block w-100" alt="..."></a></div>
                            <div class="desc">
                                <h6><a href="company.html">COMPANY SUPPLIER/EXHIBITOR</a></h6>
                                <h3><a href="product.html">Name of Product</a></h3>
                                <p>Short description of company. consetetur sadipscing elitr, sed diam nonumy eirmod
                                    tempor invidunt ut labore et dolore magna aliquyam erat, sed diam… <a href="#">Learn
                                        more</a></p>
                                <p class="tags"><a href="#">Tag 1</a><a href="#">Tag 2</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section white-bg ssx-info resource-holder">
        <div class="content">
            <h3>Read about the latest in sustainability</h3>
            <div class="featured-resource">
                <div class="image">
                    <img src="assets/images/article-sample2.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="desc darkgreen-bg white">
                    <div class="double flex flex-center">
                        <div class="left">
                            <p class="tags lightgreen"><a href="#">ARTICLE CATEGORY TAG</a></p>
                            <h2>Article Title Vesbulum</h2>
                        </div>
                        <div class="right">
                            <p>Neque Pellentesque Excerpt here. Luis pretium, lectus eu condimentum accumsan, leo leo
                                maximus diam, eget ullamcorper diam leo sit amet ante. Lorem ipsum dolor sit amet.</p>
                            <p class="simple-lnk"><a href="#" class="arrow_btn">Read More</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="cards-wrapper three">
                <div class="card black">
                    <div class="img-wrapper"><img src="assets/images/explore-thumbnail.png" class="d-block w-100"
                            alt="..."> </div>
                    <div class="card-body">
                        <h5 class="card-title">Media Title Here Lorem Ipsum</h5>
                        <p class="card-text simple-lnk">Discover eco-friendly products and services through our
                            directory. <a href="#" class="arrow_btn">Learn More</a></p>
                        <p class="tags"><a href="#">TAG 1</a><a href="#">TAG 2</a></p>
                    </div>
                </div>
                <div class="card black">
                    <div class="img-wrapper"><img src="assets/images/explore-thumbnail.png" class="d-block w-100"
                            alt="..."> </div>
                    <div class="card-body">
                        <h5 class="card-title">Media Title Here Lorem Ipsum</h5>
                        <p class="card-text simple-lnk">Discover eco-friendly products and services through our
                            directory. <a href="#" class="arrow_btn">Learn More</a></p>
                        <p class="tags"><a href="#">TAG 1</a><a href="#">TAG 2</a></p>
                    </div>
                </div>
                <div class="card black">
                    <div class="img-wrapper"><img src="assets/images/explore-thumbnail.png" class="d-block w-100"
                            alt="..."> </div>
                    <div class="card-body">
                        <h5 class="card-title">Media Title Here Lorem Ipsum</h5>
                        <p class="card-text simple-lnk">Discover eco-friendly products and services through our
                            directory. <a href="#" class="arrow_btn">Learn More</a></p>
                        <p class="tags"><a href="#">TAG 1</a><a href="#">TAG 2</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<x-contactus title="Get in touch with us." subtitle="Sustainability values partnerships."
    details="SSX is also a hub for business, partnerships, and networking. Help us empower our stakeholders by becoming a sustainability partner or enabler." />
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