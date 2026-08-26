@extends('layouts.website')

@section('content')
    <!-- <widgets :id="21"></widgets> -->
    <div class="section form-header">
        <div class="content">
            <div class="header-desc">
                <center>
                    <h1>Be a Purchaser/Buyer</h1>
                </center>
            </div>
        </div>
    </div>
    <!-- <widgets :id="22"></widgets> -->
    <div class="section ssx-info registration-intro">
        <div class="content">
            <div class="flex double flex-center">
                <div class="left">
                    <div class="featured">
                        <div class="image curvy"><img src="/assets/images/Intro-photo-Exhibitor.jpg" alt="..." /></div>
                    </div>
                </div>
                <div class="right">
                    <div class="desc text-center">
                        <h3>Make your business grow green.</h3>
                        <!-- <p class="fs-6 lh-base">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy
                                eirmod tempor invidunt
                                ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo
                                dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor
                                sit amet. Lorem ipsum dolor sit amet.</p> -->
                        <div class="black pt-40">
                            <p align="black">
                                <a class="scroll_btn arrow_bottom_btn fs-13" href="#learn-more">Scroll to learn more!</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <widgets :id="23"></widgets> -->
    <div class="section ssx-info darkgreen-bg" id="learn-more">
        <div class="full-content">
            <div class="double flex">
                <div class="left">
                    <div class="image"><img src="/assets/images/ssx-event-logo.jpg" alt="..." /></div>
                </div>
                <div class="right">
                    <div class="desc white">
                        <div class="ico-holder">
                            <div class="meet">
                                <h4>Meet Suppliers/Exhibitors through our Pre-Arranged Online Business Matching.</h4>
                            </div>
                        </div>
                        <!-- <p class="fs-6 lh-base">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.
                                Consetetur sadipscing elitr.</p> -->
                        <div class="ico-holder">
                            <div class="future">
                                <h4>Purchaser/Buyer perks during online event.</h4>
                            </div>
                        </div>
                        <!-- <p class="fs-6 lh-base">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt.
                                Consetetur sadipscing elitr.</p> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section ssx-info registration">
        <div class="content">
            <widgets :id="24"></widgets>
        </div>
    </div>
    <div class="section ssx-info beige-bg">
        <div class="content">
            <!-- <widgets :id="25"></widgets> -->
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 mb-4">
                        <div class="desc text-center">
                            <h3>LOCAL / FOREIGN</h3>
                        </div>
                    </div>
                    <div class="col-md-4 offset-md-2">
                        <div class="desc">
                            <p class="fs-6">&bull; Philippine Manufactures and Exporters from Food and Home Sectors</p>
                            <p class="fs-6">&bull; Wholesalers, Distributors and Retailers</p>
                            <p class="fs-6">&bull; International NGOs</p>
                        </div>
                    </div>
                    <div class="col-md-5 offset-md-1">
                        <div class="desc">
                            <p class="fs-6">&bull; Hotel, Restaurant, and Catering Services</p>
                            <p class="fs-6">&bull; Policymakers and Regulators</p>
                            <p class="fs-6">&bull; Reseachers and Academe</p>
                            <p class="fs-6">&bull; Green Purchasing Networks</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <widgets :id="26"></widgets> -->
        <div class="content">
            <h4 align="center">For any questions or concerns, please contact</h4>
            <div class="flex double justify-center">
                <div class="contact-info-curve">
                    <div class="type">
                        <h3>Purchasers/Buyers</h3>
                    </div>
                    <div class="det">
                        <p><strong>Ms. Katrina C. Pineda</strong></p>
                        <p><a href="mailto:kcpineda@citem.com.ph" target="_blank" rel="noopener">kcpineda@citem.com.ph</a>
                        </p>
                        <p class="mt-2"><strong>Leilani J. Santiago</strong></p>
                        <p><a href="mailto:lsantiago@citem.com.ph" target="_blank" rel="noopener">lsantiago@citem.com.ph</a>
                        </p>
                    </div>
                </div>
            </div>
            <center>
                <p class="black simple-lnk talign-center"><a class="black arrow_btn" href="mailto:{{ env('SSX_EMAIL') }}"
                        target="_blank" rel="noopener">Or email us at
                        {{ env('SSX_EMAIL') }}</a></p>
            </center>
        </div>
    </div>
    <div class="section ssx-info">
        <div class="content">
            <!-- <widgets :id="27"></widgets> -->
            <div class="flex double flex-rev flex-center">
                <div class="left">
                    <div class="featured">
                        <div class="image curvy"><img src="/assets/images/Closing-photo-Exhibitor.jpg" alt="..." />
                        </div>
                    </div>
                </div>
                <div class="right">
                    <div class="desc">
                        <h2>Start your journey to growing green.</h2>
                        <!-- <p class="fs-6 lh-base">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt
                                ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo
                                dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor
                                sit amet.</p> -->
                        <div class="link-border"><a class="lightgreen_btn arrow_btn"
                                href="/registration/purchaser/email-validation">Register as a Purchaser/Buyer</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
@endpush
@push('scripts')
@endpush
