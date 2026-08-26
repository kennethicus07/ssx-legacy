@extends('layouts.website')

@push('styles')
    <style>
    #accordionFaq .btn {
        text-decoration: none;
        font-family: DIN-Bold,Open Sans,Helvetica,sans-serif;
        color: #303030;
        font-size: 20px;
    }
    #accordionFaq p {
        font-family: Brown,Helvetica,Arial,sans-serif;
        color: #606060;
        font-size: 16px;
    }
    #accordionFaq p ul li {
        font-family: Brown,Helvetica,Arial,sans-serif;
        color: #505050;
        font-size: 16px;
    }
    
    #accordionFaq .FaqLink {
        text-decoration: none underline;
        font-weight: bold;
        font-family: Brown,Helvetica,Arial,sans-serif;
        color: #303030;
        font-size: 17px;
    }
    #accordionFaq h3 {
        font-family: Brown,Helvetica,Arial,sans-serif;
        font-weight: bold;
        color: #505050;
        font-size: 16px;
    }
    #accordionFaq .emphasize {
        font-family: Brown,Helvetica,Arial,sans-serif;
        font-weight: bold;
        color: #303030;
        font-size: 16px;
    }
    </style>
@endpush

@section('content')

<div class="section">

    <div class="container pt-20">
        <div class="col-12" style="padding: 20px 0;">
                <h2>About SSX Philippines</h2>
        </div>

        <div class="accordion" id="accordionFaq">
            <div class="card">
                <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    What is Sustainability Solutions Exchange (SSX)?
                    </button>
                </h5>
                </div>

                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionFaq">
                <div class="card-body">
                    <p>
                    Sustainability Solutions Exchange (SSX) is the country’s first sourcing program promoting sustainable goods, practices, resources, and technology. SSX serves MSMEs across various export sectors that seek to start or continue their journey to a circular economy in support of the United Nations’ Sustainable Development Goals (SDGs).
                    </p>
                    <p>
                    Sustainability Solutions Exchange (SSX) will focus in promoting solutions, service and an exchange of ideas on sustainable consumption and production for Philippine food and lifestyle companies. The event will consist of various digital components such as the Exhibition, Conference, Business Matching, and other special activities.
                    </p>
                    <p><a class="FaqLink" href=" {{ route('about-us') }} ">About Us</a></p>
                </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingTwo">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    What is Sustainability.ph?
                    </button>
                </h5>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionFaq">
                <div class="card-body">
                    <p>
                    Sustainability.ph is the online community platform for Sustainability Solutions Exchange (SSX). It bridges purchasers/buyers and suppliers/exhibitors in search of products, services and ideas on sustainable consumption and production. The website aggregates a diverse range of stories about sustainable technologies, interventions and practices that seek to engage businesses and consumers to start or continue their journey towards sustainability.
                    </p>
                    <p>
                    Sustainability.ph is published by the Center for International Trade Expositions & Missions (CITEM).
                    </p>
                </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingThree">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Who are qualified to enlist in the SSX directory? What are the criteria and/or requirements?
                    </button>
                </h5>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionFaq">
                <div class="card-body">
                    <p>
                    Local and international Suppliers/Exhibitors and Purchasers/Buyers are eligible to enlist in the SSX Directory.
                    </p>
                    <p>
                    <span class="emphasize">Supplier/Exhibitor</span> - company in the food and/or lifestyle sector offering sustainability solutions either products or services that will contribute to the circular economy.
                    </p>
                    <p>
                    <span class="emphasize">Purchaser/Buyer</span> - individual or company that is looking for a supplier/exhibitor that will help transition to more sustainable business and adds value to products and/or services.
                    </p>
                    <p>&nbsp;</p>
                    <p><a class="FaqLink" href=" {{ route('registration.supplier.intro') }} ">Supplier/Exhibitor Registration</a></p>

                    </p><a class="FaqLink" href=" {{ route('registration.buyer.intro') }} ">Purchaser/Buyer Registration</a></p>
                </div>
                </div>
            </div>

            <div class="card">
            <div class="card-header" id="headingFour">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                What are the benefits of enlisting in the SSX directory?
                </button>
            </h5>
            </div>
            <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionFaq">
            <div class="card-body">
                    <p>
                        Enlisting in the SSX Directory entitles the members to:
                        <ul>
                            <li>Customize their page</li>
                            <li>Showcase their product and/or services</li>
                        </ul>
                    </p>
                    <p>
                        <span class="emphasize">For suppliers/exhibitors</span>
                        <ul>
                            <li>Send direct message and request proposal/ quotation</li>
                        </ul>
                    </p>
                    <p>
                        <span class="emphasize">For purchasers/buyers</span>
                        <ul>
                            <li>Opportunity to join networking events and access on-demand resources</li>
                            <li>Review page performance and access data analytics</li>
                        </ul>
                    </p>
                    <p>&nbsp;</p>
                    <p><a class="FaqLink" href=" {{ route('registration.supplier.intro') }} ">Supplier/Exhibitor Registration</a></p>

                    </p><a class="FaqLink" href=" {{ route('registration.buyer.intro') }} ">Purchaser/Buyer Registration</a></p>
            </div>
            </div>
            </div>


            <div class="card">
            <div class="card-header" id="headingFive">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                Where can I see the list of suppliers/exhibitors?
                </button>
            </h5>
            </div>
            <div id="collapseFive" class="collapse" aria-labelledby="headingFive" data-parent="#accordionFaq">
            <div class="card-body">
                <p>
                SSX Directory is accessible by the public. You may access the list of suppliers/exhibitors and/or solution providers here:
                <br><a class="FaqLink" href="{{ route('solutions.directories.suppliers') }}">https://sustainability.ph/solutions/marketplace/suppliers</a>
                </p>
                <p>&nbsp;</p>
                    <p><a class="FaqLink" href=" {{ route('solutions.directories.suppliers') }} ">Marketplace</a></p>

                    </p><a class="FaqLink" href=" {{ route('solutions.sustainable.index') }} ">Sustainable Solutions</a></p>
            </div>
            </div>
            </div>


            <div class="card">
            <div class="card-header" id="headingSix">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                Who are the organizers of SSX?
                </button>
            </h5>
            </div>
            <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionFaq">
            <div class="card-body">
                <p>
                Sustainability Solutions Exchange (SSX) is organized by the Center for International Trade Expositions and Missions (CITEM).
                </p>
                <p>&nbsp;</p>
                    <p><a class="FaqLink" href="{{ route('about-us') }}#contactUs">Contact Us</a></p>

                    </p><a class="FaqLink" href="https://citem.gov.ph/">citem.gov.ph</a></p>
            
            </div>
            </div>
            </div>


            <div class="card">
            <div class="card-header" id="headingSeven">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                What events do you hold/participate for the year?
                </button>
            </h5>
            </div>
            <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordionFaq">
            <div class="card-body">
            Local and international events hosted by CITEM and other sustainability driven organizations may be accessed here:
            <br><a class="FaqLink" href="{{ route('events-activities.index') }}">https://sustainability.ph/events</a>
            <p>&nbsp;</p>
                    <p><a class="FaqLink" href=" {{ route('resources-news.digital-exhibition-conference-2022.index') }}">Digital Exhibition & Conference</a></p>
            </div>
            </div>
            </div>


            <div class="card">
            <div class="card-header" id="headingEight">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                Do you have free seminars and/or resources I can access?
                </button>
            </h5>
            </div>
            <div id="collapseEight" class="collapse" aria-labelledby="headingEight" data-parent="#accordionFaq">
            <div class="card-body">
                <p>
                    Yes, you may access latest free resources here:
                    <br><a class="FaqLink" href="{{ route('news-articles.index') }}">https://sustainability.ph/news-articles</a>
                </p>
                <p>
                    You may also get updates by following our social media handles:
                    <br><a class="FaqLink" href="https://www.facebook.com/SustainabilitySolutionsExchange.ph">https://www.facebook.com/SustainabilitySolutionsExchange.ph</a>
                    <br><a class="FaqLink" href="https://twitter.com/SSXPhilippines">https://twitter.com/SSXPhilippines</a>
                    <br><a class="FaqLink" href="https://www.instagram.com/ssx.philippines">https://www.instagram.com/ssx.philippines</a>
                </p>
                <p>&nbsp;</p>
                    <p><a class="FaqLink" href=" {{ route('events-activities.index') }}#webinars">Webinars</a></p>
                    <p><a class="FaqLink" href=" {{ route('events-activities.index') }}#on-demand-resources">On-Demand Resources</a></p>
                    <p><a class="FaqLink" href=" {{ route('resources-news.digital-exhibition-conference-2022.index') }}">Digital Exhibition & Conference</a></p>
            </div>
            </div>
            </div>


            <div class="card">
            <div class="card-header" id="headingNine">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                I am interested to get updates about SSX and other sustainability-related promotions. How do I subscribe?
                </button>
            </h5>
            </div>
            <div id="collapseNine" class="collapse" aria-labelledby="headingNine" data-parent="#accordionFaq">
            <div class="card-body">
            You may subscribe on our mailing list by filling out the form in 
            <br><a class="FaqLink" href="{{ route('about-us') }}#contactUs">https://sustainability.ph/about-us#contactUs</a>
            </div>
            </div>
            </div>



            <div class="card">
            <div class="card-header" id="headingTen">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                I am interested to contribute resources to the website. How do I send materials?
                </button>
            </h5>
            </div>
            <div id="collapseTen" class="collapse" aria-labelledby="headingTen" data-parent="#accordionFaq">
            <div class="card-body">
                <p>
                You may send your proposal, articles and/or other resources to <a class="FaqLink" href="mailto:sustainabilityph@citem.com.ph">sustainabilityph@citem.com.ph</a>. Subject for review and approval. Proper credits shall be given to website contributor.
                </p>
                <p>&nbsp;</p>
                    <p><a class="FaqLink" href=" {{ route('news-articles.index') }}">News & Articles</a></p>
                    <p><a class="FaqLink" href=" {{ route('solutions.intelligence.index') }}">Solutions Intelligence</a></p>
            </div>
            </div>
            </div>


            <div class="card">
            <div class="card-header" id="headingEleven">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseEleven" aria-expanded="false" aria-controls="collapseEleven">
                I am interested to collaborate for future SSX events/ programs. How do I connect?
                </button>
            </h5>
            </div>
            <div id="collapseEleven" class="collapse" aria-labelledby="headingEleven" data-parent="#accordionFaq">
            <div class="card-body">
                <p>
                You may send your proposal or get in touch with Business Development Unit - <a class="FaqLink" href="mailto:busdev@citem.com.ph">busdev@citem.com.ph</a>.
                </p>
                <p>&nbsp;</p>
                    <p><a class="FaqLink" href=" {{ route('services.export-enablers.index') }}">Export Enablers</a></p>
                
            </div>
            </div>
            </div>

            <div class="card">
            <div class="card-header" id="headingTwelve">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwelve" aria-expanded="false" aria-controls="collapseTwelve">
                What other programs and services do you offer to MSMEs?
                </button>
            </h5>
            </div>
            <div id="collapseTwelve" class="collapse" aria-labelledby="headingTwelve" data-parent="#accordionFaq">
            <div class="card-body">
            <p><a class="FaqLink" href=" {{ route('services.export-enablers.index') }}">Export Enablers</a></p>
            <p><a class="FaqLink" href=" {{ route('resources-news.digital-exhibition-conference-2022.index') }}">Digital Exhibition & Conference</a></p>
            </div>
            </div>
            </div>

        </div>

    </div>

</div>
<div>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
</div>

@endsection


@push('scripts')
<script>
$(document).ready(function() {
    $('#nav-about').addClass('active');
});
</script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
@endpush