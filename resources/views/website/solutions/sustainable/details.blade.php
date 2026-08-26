@extends('layouts.website')

@section('content')
    <div class="section subnav beige-bg nav-holder gradient-top">
        <div class="content">
            <div class="d-flex justify-content-center">
                <h3 class="me-3">Browse Solutions: </h3>
                <div class="mt-2 me-3 black">
                    <i class="fas fa-book-open align-middle fs-4"></i> <a href="{{ route('solutions.directories.index') }}"
                        class="text-decoration-none">Marketplace</a>
                </div>
                <div class="mt-2 me-3 lightgreen">
                    <i class="fas fa-solar-panel align-middle fs-4"></i> <a href="{{ route('solutions.sustainable.index') }}"
                        class="text-decoration-none">Sustainable Solutions</a>
                </div>
                <div class="mt-2 black">
                    <i class="fas fa-lightbulb align-middle fs-4"></i> <a href="{{ route('solutions.intelligence.index') }}"
                        class="text-decoration-none">Solutions Intelligence</a>
                </div>
            </div>
        </div>
    </div>
    <div class="section ssx-info company-info" id="featuredEvent">
        <div class="featured">
            <div class="image">
                @if ($user->data_from == 'api')
                    <img src="{{ check_file_exist('exhibitors/mastheads/', 'thumb', $user->masthead) }}" class="img-fluid"
                        alt="...">
                @else
                    <img src="{{ check_file_exist('exhibitors/thumbs/', 'thumb', $user->masthead) }}" class="img-fluid"
                        alt="...">
                @endif
            </div>
            <div class="company-ico">
                <img src="{{ check_file_exist('exhibitors/logos/', 'logo', $user->logo) }}" class="img-fluid"
                    alt="...">
            </div>
        </div>
        <div class="content">
            <div class="tags mb-3">
                @foreach ($user->category_subcategory as $tag)
                    <span
                        class="badge rounded-pill lightgreen-bg text-white text-uppercase ms-1 mt-1">{{ $tag->sub_category_remarks }}</span>
                @endforeach
            </div>
            <h1>{{ $exhibitor->co_name }}</h1>
            <p>{{ $exhibitor->co_details }}</p>

            <ul class="nav nav-pills nav-fill">
                <!-- <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="products-tab" data-bs-toggle="tab" data-bs-target="#products"
                            type="button" role="tab" aria-controls="products" aria-selected="true">Products and Services</a>
                    </li> -->
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="about-tab" data-bs-toggle="tab" data-bs-target="#about" type="button"
                        role="tab" aria-controls="about" aria-selected="true">About the Company</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="practices-tab" data-bs-toggle="tab" data-bs-target="#practices" type="button"
                        role="tab" aria-controls="practices" aria-selected="false">Practices and Certifications</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button"
                        role="tab" aria-controls="contact" aria-selected="false">Contact Us</a>
                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <!-- <div class="tab-pane fade show active" id="products" role="tabpanel" aria-labelledby="products-tab">
                        <div class="content">
                            <div class="double-div-container">
                                <div>
                                    <h4>Lifestyle Solutions</h4>
                                    <div class="beige-bg product-box">
                                        <h5>Energy Efficient Lighting Fixtures</h5>
                                        <p>Description of product or service. Lorem ipsum dolor sit amet, consetetur sadipscing
                                            elitr, sed diam nonumy eirmod.</p>
                                        <h5>Automatic and Efficient Machines</h5>
                                        <p>Description of product or service. Lorem ipsum dolor sit amet, consetetur sadipscing
                                            elitr, sed diam nonumy eirmod.</p>
                                    </div>
                                </div>
                                <div>
                                    <h4>Advanced Solutions</h4>
                                    <div class="beige-bg product-box">
                                        <h5>Renewable Energy</h5>
                                        <p>Description of product or service. Lorem ipsum dolor sit amet, consetetur sadipscing
                                            elitr, sed diam nonumy eirmod.</p>
                                        <h5>Solar Hot Water</h5>
                                        <p>Description of product or service. Lorem ipsum dolor sit amet, consetetur sadipscing
                                            elitr, sed diam nonumy eirmod.</p>
                                        <h5>Energy Saving</h5>
                                        <p>Description of product or service. Lorem ipsum dolor sit amet, consetetur sadipscing
                                            elitr, sed diam nonumy eirmod.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="content">
                            <h4>Browse Our Products</h4>
                            <div class="solutions-holder">
                                <div class="solution product">
                                    <div class="image"><a href="product.html"><img src="assets/images/elevate_article01.jpg"
                                                class="d-block w-100" alt="..."></a></div>
                                    <div class="desc">
                                        <h6><a href="company.html">COMPANY SUPPLIER</a></h6>
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
                                        <h6><a href="company.html">COMPANY SUPPLIER</a></h6>
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
                                        <h6><a href="company.html">COMPANY SUPPLIER</a></h6>
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
                                        <h6><a href="company.html">COMPANY SUPPLIER</a></h6>
                                        <h3><a href="product.html">Name of Product</a></h3>
                                        <p>Short description of company. consetetur sadipscing elitr, sed diam nonumy eirmod
                                            tempor invidunt ut labore et dolore magna aliquyam erat, sed diam… <a href="#">Learn
                                                more</a></p>
                                        <p class="tags"><a href="#">Tag 1</a><a href="#">Tag 2</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="about-tab">
                    <div class="content">
                        <div class="flex">
                            <div class="flex1">
                                @if (!empty($exhibitor->organization_type))
                                    <h4>Type of Organization</h4>
                                    <p>{{ $exhibitor->organization_type->name }}</p>
                                @endif
                                @if (!empty($exhibitor->year_established))
                                    <h4>Year Established</h4>
                                    <p>{{ $exhibitor->year_established }}</p>
                                @endif
                                <!-- @if (!empty($imp_nature_business))
    <h4>Nature of Business</h4>
                                    <p>{{ $imp_nature_business }}</p>
    @endif -->
                                @if (!empty($imp_location))
                                    <h4>Location</h4>
                                    <p>{{ $imp_location }}</p>
                                @endif
                                <!-- <h4>With Export Experience?</h4>
                                    <p>{{ $exhibitor->industry_rep === 1 ? 'Yes' : 'No' }}</p> -->
                                @if (!empty($exhibitor->business_registration_type))
                                    <h4>Business Registration</h4>
                                    <p>{{ $exhibitor->business_registration_type->name }}</p>
                                @endif
                                @if (!empty($exhibitor->directory_name))
                                    <h4>Brand Name</h4>
                                    <p>{{ $exhibitor->directory_name }}</p>
                                @endif
                            </div>
                            <div class="flex4">
                                @if (!empty($exhibitor->mission_statement))
                                    <h3>Our Mission and Vision</h3>
                                    <p>{{ $exhibitor->mission_statement }}</p>
                                @endif
                                @if (!empty($exhibitor->website))
                                    <h4>Check us out on: <a href="{{ check_scheme_url($exhibitor->website) }}"
                                            target="_blank">{{ $exhibitor->website }}</a></h4>
                                @endif
                                <p>
                                    @if (!empty($exhibitor->facebook))
                                        <a href="https://www.facebook.com/{{ $exhibitor->facebook }}" target="_blank"><i
                                                class="fab fa-facebook-square fs-1 black me-2"></i></a>
                                    @endif
                                    @if (!empty($exhibitor->twitter))
                                        <a href="https://www.twitter.com/{{ $exhibitor->twitter }}" target="_blank"><i
                                                class="fab fa-twitter-square fs-1 black me-2"></i></a>
                                    @endif
                                    @if (!empty($exhibitor->instagram))
                                        <a href="https://www.instagram.com/{{ $exhibitor->instagram }}"
                                            target="_blank"><i class="fab fa-instagram-square fs-1 black me-2"></i></a>
                                    @endif
                                    @if (!empty($exhibitor->linkedin))
                                        <a href="https://www.instagram.com/{{ $exhibitor->instagram }}"
                                            target="_blank"><i class="fab fa-linkedin fs-1 black me-2"></i></a>
                                    @endif
                                    @if (!empty($exhibitor->other_social))
                                        <a href="{{ check_scheme_url($exhibitor->other_social) }}"
                                            target="_blank">{{ $exhibitor->other_social }}</a>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="practices" role="tabpanel" aria-labelledby="practices-tab">
                    <div class="content">
                        <div class="double-div-container">
                            @if (!empty($user->on_input_output))
                                <div>
                                    <h4>Input/Output Practices</h4>
                                    <ul>
                                        @foreach ($user->on_input_output as $inout)
                                            <li>
                                                <p>{{ $inout->product_char_inputoutput->name }}</p>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (!empty($user->certification))
                                <div>
                                    <h4>Certifications</h4>
                                    <div class="certification-logo">
                                        @foreach ($user->certification as $cert)
                                            <img src="/storage/certifications/{{ $cert->food_cert->logo }}"
                                                class="img-thumbnail" title="{{ $cert->food_cert->name }}"
                                                alt="{{ $cert->food_cert->name }}">
                                        @endforeach
                                    </div>
                                    <a href="{{ route('certifications.index') }}" class="fs-12 text-black mt-3">View
                                        Glossary of Certifications</a>
                                </div>
                            @endif
                            @if (!empty($user->on_production_process))
                                <div>
                                    <h4>Production Processes</h4>
                                    <ul>
                                        @foreach ($user->on_production_process as $process)
                                            <li>
                                                <p>{{ $process->product_char_prod_process->name }}</p>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (!empty($exhibitor->website))
                                <div>
                                    <h4>Reports and Policies</h4>
                                    <div class="link-border black">
                                        <a href="{{ check_scheme_url($exhibitor->website) }}" target="_blank"
                                            class="clear_btn arrow_btn">More information on our website</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="content">
                        <div class="double-div-container">
                            <div>
                                <h4>Company Representative(s)</h4>
                                @if (!empty($user->business_contact_person))
                                    <div class="beige-bg product-box">
                                        <h5>{{ $user->business_contact_person->fname }}
                                            {{ $user->business_contact_person->mi }}
                                            {{ $user->business_contact_person->lname }}</h5>
                                        <p>{{ $user->business_contact_person->designation }}</p>
                                        <p><a href="mailto:{{ $user->business_contact_person->email }}"
                                                target="_blank">{{ $user->business_contact_person->email }}</a></p>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h4>Company Contact Information</h4>
                                <!-- @if (!empty($imp_location))
    <h5>Office Address</h5>
                                    <p>{{ $imp_location }}</p>
    @endif     -->
                                @if (!empty($exhibitor->website))
                                    <h4>Check us out on: <a href="{{ check_scheme_url($exhibitor->website) }}"
                                            target="_blank">{{ $exhibitor->website }}</a></h4>
                                @endif
                                <p>
                                    @if (!empty($exhibitor->facebook))
                                        <a href="https://www.facebook.com/{{ $exhibitor->facebook }}" target="_blank"><i
                                                class="fab fa-facebook-square fs-1 black me-2"></i></a>
                                    @endif
                                    @if (!empty($exhibitor->twitter))
                                        <a href="https://www.twitter.com/{{ $exhibitor->twitter }}" target="_blank"><i
                                                class="fab fa-twitter-square fs-1 black me-2"></i></a>
                                    @endif
                                    @if (!empty($exhibitor->instagram))
                                        <a href="https://www.instagram.com/{{ $exhibitor->instagram }}"
                                            target="_blank"><i class="fab fa-instagram-square fs-1 black me-2"></i></a>
                                    @endif
                                    @if (!empty($exhibitor->linkedin))
                                        <a href="https://www.instagram.com/{{ $exhibitor->instagram }}"
                                            target="_blank"><i class="fab fa-linkedin fs-1 black me-2"></i></a>
                                    @endif
                                    @if (!empty($exhibitor->other_social))
                                        <a href="{{ check_scheme_url($exhibitor->other_social) }}"
                                            target="_blank">{{ $exhibitor->other_social }}</a>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="section ssx-info">
            <div class="content">
                <h3>We are featured in:</h3>
                <div class="cards-wrapper three">
                    <div class="card black">
                        <div class="img-wrapper"><img src="assets/images/explore-thumbnail.png" class="d-block w-100" alt="...">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Media Title Here Lorem Ipsum</h5>
                            <p class="card-text simple-lnk">Discover eco-friendly products and services through our directory.
                                <a href="#" class="arrow_btn">Learn More</a></p>
                            <p class="tags"><a href="#">TAG 1</a><a href="#">TAG 2</a></p>
                        </div>
                    </div>
                    <div class="card black">
                        <div class="img-wrapper"><img src="assets/images/explore-thumbnail.png" class="d-block w-100" alt="...">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Media Title Here Lorem Ipsum</h5>
                            <p class="card-text simple-lnk">Discover eco-friendly products and services through our directory.
                                <a href="#" class="arrow_btn">Learn More</a></p>
                            <p class="tags"><a href="#">TAG 1</a><a href="#">TAG 2</a></p>
                        </div>
                    </div>
                    <div class="card black">
                        <div class="img-wrapper"><img src="assets/images/explore-thumbnail.png" class="d-block w-100" alt="...">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Media Title Here Lorem Ipsum</h5>
                            <p class="card-text simple-lnk">Discover eco-friendly products and services through our directory.
                                <a href="#" class="arrow_btn">Learn More</a></p>
                            <p class="tags"><a href="#">TAG 1</a><a href="#">TAG 2</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
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
