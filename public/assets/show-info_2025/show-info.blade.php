@extends('layouts.website')

@section('content')
    <!-- START HERE -->
    <section class="container-fluid parallax">
        <div id="eventCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <!-- Indicators -->
            <div class="carousel-indicators">
              <button type="button" data-bs-target="#eventCarousel" data-bs-slide-to="0" class="active"></button>
              <button type="button" data-bs-target="#eventCarousel" data-bs-slide-to="1"></button>
              <button type="button" data-bs-target="#eventCarousel" data-bs-slide-to="2"></button>
            </div>
          
            <!-- Slides -->
            <div class="carousel-inner">
          
              <!-- Slide 1: Your event section --> 
              <div class="carousel-item active">
                <div class="container-fluid parallax position-relative text-white" style=" background: url('/assets/show-info_2025/banner.png') center center / cover no-repeat;">
                  <div class="overlay position-absolute top-0 start-0 " style="background: rgba(0, 0, 0, 0.5);"></div>
                  <div class="row banner-content position-relative z-2  align-items-center justify-content-center text-center">
                    <div class="col-12 banner-1">
                      <h1>Sustainability Solutions Exchange 2025</h1>
                      <h2><em>Pioneering Circularity in the Food Industry</em></h2>
                      <p>May 22-24, 2025</p>
                      <p class="mb-5">World Trade Center Metro Manila</p>
                      <a href="https://sustainability.ph/conference/registration" target="_blank" class="btn btn-light">REGISTER NOW</a>
                    </div>
                  </div>
                </div>
              </div>
          
              <!-- Slide 2: Just a background image -->
              <div class="carousel-item ">
                <div class="parallax slide-two"></div>
              </div>

               <!-- Slide 3: Just a background image -->
              <div class="carousel-item ">
                <div class="parallax slide-three"></div>
              </div>
          
            </div>
          
            <!-- Controls -->
            <button class="carousel-control-prev  ms-3" type="button" data-bs-target="#eventCarousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next  me-3" type="button" data-bs-target="#eventCarousel" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </div>
    </section>


    <section class="container-fluid my-100 intro">
        <div class="row d-flex align-items-center">
            <div class="col-12 ">
                <h2><em>Where Innovation Meets Sustainability</em></h2>
                <p>The <strong> Sustainability Solutions Exchange (SSX)</strong> is the latest flagship initiative of the
                    Center
                    for International
                    Trade Expositions and Missions (CITEM)—a platform designed to empower MSMEs on their journey toward a
                    circular
                    economy while reinforcing the Philippines' commitment to the UN Sustainable Development Goals (SDGs).
                </p>
                <p>SSX serves as a dynamic hub for transformation, bringing together industry pioneers, sustainability
                    advocates, and forward-thinking businesses through: An immersive exhibition spotlighting cutting-edge
                    sustainable solutions and innovations. Business matching & pitching sessions that foster high-impact
                    collaborations. A thought-provoking conference where global experts share insights on sustainable
                    consumption
                    and production for the Philippine food industry.
                </p>
                <p>For the first time ever, SSX will take center stage as a physical event on <strong>May 22-24,
                        2025</strong>,
                    at the
                    <strong>Sustainability Hall (Hall D) within IFEX Philippines, World Trade Center Metro
                        Manila</strong>—offering an unparalleled
                    experience in sustainability-driven trade and innovation.
                </p>
                <p><strong>Be part of the movement. Shape the future of sustainability.</strong></p>
            </div>
        </div>
    </section>

    <section class="card-3">

        <div class="row g-4 d-flex justify-content-center">
            <div
                class="col-lg-4 col-sm-12 d-flex justify-content-center align-items-center flex-column text-center card-3-content">
                <img src="/assets/show-info_2025/card-3.png" class="img-fluid mb-3" alt="">
                <h3>Conference</h3>
                <p>Gain insights from global and local sustainability experts.</p>
            </div>
            <div
                class="col-lg-4 col-sm-12 d-flex justify-content-center align-items-center flex-column text-center card-3-content">
                <img src="/assets/show-info_2025/card-2.png" class="img-fluid mb-3" alt="">
                <h3>Matching & Pitching</h3>
                <p>Connect with key decision-makers in the industry.</p>
            </div>
            <div class="col-lg-4 d-flex justify-content-center align-items-center flex-column text-center card-3-content">
                <img src="/assets/show-info_2025/card-1.png" class="img-fluid mb-3" alt="">
                <h3>Exhibition</h3>
                <p>Discover groundbreaking sustainable solutions in food production.</p>
            </div>
        </div>
    </section>




<section class=" text-center co-section">
    <div class="row ">
        <div class="col-12 headings co-presented-title">
            <span>
                <h2>SSX CO-PRESENTED BY:</h2>
            </span>
        </div>
    </div>
<div class="co-presented justify-content-center d-flex flex-column">

    <div class="d-flex flex-row justify-content-center gg-eu-denr">
<div >
    <img class="gg-co-funded-by-eu-logo" src="/assets/show-info_2025/gg-co-funded-by-eu-logo.png" alt="">
</div>
<div >
    <img class="denr-logo" src="/assets/show-info_2025/denr-logo.png" alt="">
</div>
</div>
<div >
    <img class="bmwk-iki-logo" src="/assets/show-info_2025/bmwk-iki-logo.png" alt="">
</div>
</div>


<div class="row ">
    <div class="col-12 headings co-organize-title">
        <span>
            <h2>SSX CO-ORGANIZED BY:</h2>
        </span>
    </div>
</div>
<div class="co-organize justify-content-center">
<div >
<img class="giz-logo" src="/assets/show-info_2025/giz-logo.png" alt="">
</div>
<div >
<img class="expertise-france-logo" src="/assets/show-info_2025/expertise-france-logo.png" alt="">
</div>
{{-- <div >
<img class="gggi-logo" src="/assets/show-info_2025/gggi-logo.png" alt="">
</div> --}}
</div>
</section>

    <section class=" shape text-center">


        <div class="row headings justify-content-center">
            <div class="col-12 col-md-10">
                <h2>Shape the Future of Food</h2>
                <h3>Join the Philippine Journey to Circularity & Sustainability!</h3>
                <p>
                    The Philippine food industry is at a pivotal moment. Join us on May 22nd (Thursday) and May 23rd
                    (Friday) for a crucial two-day conference dedicated to navigating the path towards a sustainable and
                    circular food economy. Whether you’re a business leader, an innovator, a concerned consumer, or a
                    policymaker, this event offers vital insights, actionable strategies, and unparalleled networking
                    opportunities to shape a resilient and responsible food future for the Philippines.
                </p>
                {{-- <a href="#">See full schedule here.</a> --}}
            </div>
        </div>
<div class="container">
        <div class="row cards-22">
            <div class="col-md-5 col-sm-10 card-22">
                <p class="day">Day 1 (22 MAY, 12:00PM - 6:00PM PST)</p>
                <h3>FOOD PHILIPPINES JOURNEY TO CIRCULARITY</h3>
                <p><strong>Transforming our World:</strong> <br> 2030 Agenda for Sustainable Development
                </p>
                <p><strong>Major Strides:</strong><br> The Philippines’ Efforts Toward Food Sustainability
                </p>
                <p><strong>Attaining a Circular Food Economy:</strong><br> Challenges and Opportunities
                </p>
            </div>

            <div class="col-md-5 col-sm-10 card-22">
                <p class="day">Day 2 (23 MAY, 09:00AM - 12:00 NN PST)</p>
                <h3>FUTURE FOOD SYSTEMS FOR SUSTAINABLE CONSUMPTION AND PRODUCTION</h3>
                <p><strong>Roles in Circularity:</strong><br> A Guide for Business and Consumers</p>
                <p><strong>Sustainability as Foundation:</strong><br> Innovative Strategies for Food Businesses
                </p>
                {{-- <p> Learn about innovative strategies for SMEs, including green technologies, efficient sourcing, and
                    enhancing competitiveness.
                </p>
                <p>
                    Explore fresh perspectives on sustainable packaging that reduce waste, enhance product value, and meet
                    consumer demands.
                </p>
                <p>Discover green financing initiatives and investment programs to fund your sustainability goals.</p> --}}
            </div>

            <div class="col-md-5 col-sm-10 card-22">
                <p class="day">Day 2 (1:00PM - 6:00 PM PST)</p>
                {{-- <h3>Navigating Policy & Compliance</h3> --}}
                <h3>BUSINESS TRACK</h3>
                {{-- <p>Understand the Philippines’ commitment to the 2030 Agenda for Sustainable Development (SDGs), the
                    Philippine Development Plan (PDP), and Ambisyon Natin 2040.
                </p>
                <p>Learn about compliance with environmental laws and regulations and how businesses and communities can
                    effectively meet sustainability goals.
                </p>
                <p>
                    Hear about the EU-Philippines Green Economy Partnership and the launch of the Green Economy Program in
                    the Philippines (GEPP) platform.
                </p> --}}
                <p><strong>Financing the Future:</strong> <br> Enabling Businesses to Reach their Sustainability Goals</p>
                <p><strong>Embracing Transfromative, Climate-Smart Food Systems</strong></p>
                <p><strong>Fresh Perspectives on Sustainable Packaging</strong></p>
                <p><strong>Standard Setting:</strong><br> Identifying Social Responsibilities in the Food Industry</p>
                <p><strong>The Case for a Greener Future</strong></p>
            </div>

            <div class="col-md-5 col-sm-10 card-22">
                <p class="day">Day 2 (1:00PM - 5:30 PM PST)</p>
                {{-- <h3>Empowering Conscious Consumers</h3> --}}
                <h3>CONSUMER TRACK</h3>
                <p><strong>Mindful Consumption and Sustainable Living:</strong><br> Steps Toward Progressive Foodways</p>
                <p><strong>Transformative Approaches to Food Waste Management</strong></p>
                <p><strong>Taking Action:</strong><br> Social Enterprises on Consumer Education and Engagement</p>
            </div>
        </div>
    </div>
    </section>


    <section class="container-fluid">
        <div class="row mb-4">
            <div class="col-lg-6 col-sm-12 benefits">
                <div class="row gx-0">
                    <div class="col-12 text-center">
                        <img src="/assets/show-info_2025/benefits.png" alt="">
                        <h3>Why Attend?</h3>

                    </div>
                </div>

                <div class="row gx-0">
                    <div class="col-12">
                        <ul>
                            <li>
                                <h5><i class="bi bi-check-circle-fill"></i>Expert Insights</h5>
                                <p>Hear from government leaders, EU representatives, industry pioneers, community leaders,
                                    and financial experts.</p>
                            </li>
                            <li>
                                <h5><i class="bi bi-check-circle-fill"></i>Actionable Strategies</h5>
                                <p>Gain practical knowledge on EPR compliance, green financing, sustainable packaging, waste
                                    reduction, and climate-smart agriculture.</p>
                            </li>
                            <li>
                                <h5><i class="bi bi-check-circle-fill"></i>Dedicated Tracks </h5>
                                <p>Choose between focused Business and Consumer tracks on Day 2 (PM) tailored to specific
                                    interests.</p>
                            </li>
                            <li>
                                <h5><i class="bi bi-check-circle-fill"></i>Networking</h5>
                                <p>Connect with peers, potential partners, and key stakeholders across the food ecosystem.
                                </p>
                            </li>
                            <li>
                                <h5><i class="bi bi-check-circle-fill"></i>Be Part of the Solution </h5>
                                <p>Contribute to the national dialogue on food sustainability and circularity.</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12 attend">
                <div class="row gx-0">
                    <div class="col-12 text-center">
                        <img src="/assets/show-info_2025/attend.png" alt="">
                        <h3>Who Should Attend?</h3>
                        <ul class="d-flex justify-content-center">
                            <li>Sustainability Innovators</li>
                            <li>Solutions Providers</li>
                            <li>Importers</li>
                            <li>Trade Buyers</li>
                            <li>Policymakers</li>
                            <li>Non-government Organizations</li>
                            <li>Academia</li>
                            <li>Sustainability Advocates</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row text-center button">
            <div class="col-12 button d-flex justify-content-center mb-0">
                <p>Ready to shape a sustainable food future?</p>
            </div>

            <div class="col-12 button d-flex justify-content-center">
                <a href="https://sustainability.ph/conference/registration" class="btn ">REGISTER NOW</a>
            </div>
        </div>
    </section>

    <section class=" experts">
        <div class="row ">
            <div class="col-12 headings">
                <span>
                    <img src="/assets/show-info_2025/experts.png" class="small-icon" alt="">
                </span>
                <span>
                    <h2>Meet the Experts Shaping the Future</h2>
                </span>
            </div>
        </div>

        <div class="row experts-1  justify-content-center align-items-center">

            <div class="col-3 col-sm-12 speaker">
                <span>
                    <img src="/assets/show-info_2025/SSX SPEAKER POSTER_Gemmer_NF.png" alt="">
                </span>
            </div>

            {{-- <div class="col-3 col-sm-12 speaker">
                <span>
                    <img src="/assets/show-info_2025/SSX SPEAKER POSTER_Baleta_NF.png" alt="">
                </span>
               
            </div> --}}

            <div class="col-3 col-sm-12 speaker">
                <span>
                    <img src="/assets/show-info_2025/SSX SPEAKER POSTER_Charlat_NF.png" alt="">
                </span>
               
            </div>

            <div class="col-3 col-sm-12 speaker">
                <span>
                    <img src="/assets/show-info_2025/SSX SPEAKER POSTER_Leonardia_NF.png" alt="">
                </span>
               
            </div>

            <div class="col-3 col-sm-12 speaker">
                <span>
                    <img src="/assets/show-info_2025/SSX SPEAKER POSTER_Manongdo_NF.png" alt="">
                </span>
               
            </div>

            <div class="col-3 col-sm-12 speaker">
                <span>
                    <img src="/assets/show-info_2025/SSX SPEAKER POSTER_Reyes_NF.png" alt="">
                </span>
               
            </div>

             <div class="col-3 col-sm-12 speaker">
                <span>
                    <img src="/assets/show-info_2025/SSX SPEAKER POSTER_Silvius_NF.png" alt="">
                </span>
               
            </div>

            <div class="col-3 col-sm-12 speaker">
                <span>
                    <img src="/assets/show-info_2025/SSX SPEAKER POSTER_LUCKY LOPEZ.png" alt="">
                </span>
               
            </div>
 
            <div class="col-3 col-sm-12 speaker">
                <span>
                    <img src="/assets/show-info_2025/SSX SPEAKER POSTER_PACITA.png" alt="">
                </span>
               
            </div>

            <div class="col-3 col-sm-12 speaker">
                <span>
                    <img src="/assets/show-info_2025/SSX SPEAKER POSTER_PHILIP YOUNG.png" alt="">
                </span>
               
            </div>

            <div class="col-3 col-sm-12 speaker">
                <span>
                    <img src="/assets/show-info_2025/SSX SPEAKER POSTER_TOM MUELEN.png" alt="">
                </span>
               
            </div>

            {{-- <div class="col-md-6 col-sm-12 speaker">
                <span>
                    <img src="/assets/show-info_2025/ed-leah.jpg" alt="">
                </span>
                <span>
                    <h3>Romleah Pulido-Ocampo</h3>
                    <p>Executive Director</p>
                    <p class="p-small">Center for International Trade Expositions and Missions</p>
                </span>
            </div> --}}

            {{-- <div class="col-md-6 col-sm-12 speaker">
                <span>
                    <img src="/assets/show-info_2025/marco.png" alt="">
                </span>
                <span>
                    <h3>Marco Gemmer</h3>
                    <p>Head of Cooperation</p>
                    <p class="p-small">EU Delegation</p>
                </span>
            </div> --}}

            {{-- <div class="col-md-6 col-sm-12 speaker">
                <span>
                    <img src="/assets/show-info_2025/marcel.jpg" alt="">
                </span>
                <span>
                    <h3>Marcel Silvius</h3>
                    <p>Country Representative of Philippines and Deputy Regional Director Asia</p>
                    <p class="p-small">Global Green Growth Institute (GGGI)</p>
                </span>
            </div>

            <div class="col-md-6 col-sm-12 speaker">
                <span>
                    <img src="/assets/show-info_2025/carlomagno.jpeg" alt="">
                </span>
                <span>
                    <h3>Carlomagno Aguilar</h3>
                    <p>Chief Farmer and Head Farm Consultant</p>
                    <p class="p-small">FarmYields Inc.</p>
                </span>
            </div>
            
            <div class="col-md-6 col-sm-12 speaker">
                <span>
                    <img src="/assets/show-info_2025/maylis-charlat.png" alt="">
                </span>
                <span>
                    <h3>Maylis Charlat</h3>
                    <p>Project Leader</p>
                    <p class="p-small">Expertise France- Philippines</p>
                </span>
            </div>

            <div class="col-md-6 col-sm-12 speaker">
                <span>
                    <img src="/assets/show-info_2025/juan-alfonso.jfif" alt="">
                </span>
                <span>
                    <h3>Dr. Juan Alfonso Leonardia</h3>
                    <p>Senior Advisor </p>
                    <p class="p-small">EU-GEPP, GIZ</p>
                </span>
            </div>

            <div class="col-md-6 col-sm-12 speaker">
                <span>
                    <img src="/assets/show-info_2025/abdul-rahman.jpg" alt="">
                </span>
                <span>
                    <h3>Abdul Rahman Linzag</h3>
                    <p>Chairman </p>
                    <p class="p-small">IDCP Halal Certification Authority</p>
                </span>
            </div>

            <div class="col-md-6 col-sm-12 speaker">
                <span>
                    <img src="/assets/show-info_2025/pacita.jpg" alt="">
                </span>
                <span>
                    <h3>Pacita "Chit" Juan</h3>
                    <p>President and Co-Founder </p>
                    <p class="p-small">Slow Food Manila / ECHOStore Sustainable Lifestyle
                    </p>
                </span>
            </div>

            <div class="col-md-6 col-sm-12 speaker">
                <span>
                    <img src="/assets/show-info_2025/peter-damary.jfif" alt="">
                </span>
                <span>
                    <h3>Peter Damary</h3>
                    <p>Founder </p>
                    <p class="p-small">LimaDOL
                    </p>
                </span>
            </div> --}}

            <div class="col-12 text-center mt-5 coming-soon">
                <p><em>Full Speaker Lineup Coming Soon</em></p>
            </div>

        </div>

    </section>



    <section class="my-100 ">

        <div class="row ">
            <div class="col-12 headings">
                <span>
                    <img src="/assets/show-info_2025/delegate.png" alt="">
                </span>
                <span>
                    <h2>Delegate Passes Available Now!</h2>
                </span>
            </div>
        </div>

        <div class="row d-flex justify-content-center">

            <div class="col-lg-6 col-sm-12 gx-0 card-outline">
                <div class="row card-2">
                    <div class="col-12 text-center ">
                        <h3>IFEX Philippines Exhibitors</h3>
                        <div class="row d-flex align-items-center sched">
                            <div class="col-5 text-start">
                                <h5>Local</h5>
                            </div>
                            <div class="col-7 text-start price">
                                <h5>₱3,500.00</h5>
                            </div>
                        </div>
                        <div class="row d-flex align-items-center sched">
                            <div class="col-5 text-start">
                                <h5>Foreign</h5>
                            </div>
                            <div class="col-7 text-start price">
                                <h5>$84.00</h5>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-6 col-sm-12 gx-0 card-outline">

                <div class="row gx-0 card-2 extended">
                    <div class="row gx-0 text-center">
                        <div class="col-12 headings small">
                            {{-- <span> 
                                <img src="/assets/show-info_2025/delegate.png" alt="">
                            </span> --}}
                            <span>
                                <h2>GROUP DISCOUNT</h2>
                                <p><em>Register 5, get 1 free!</em></p>
                            </span>
                        </div>
                    </div>
                    <div class="col-12 text-center ">
                        <div class="row gx-0 d-flex align-items-center sched">
                            <div class="col-5 text-start">
                                <h5>Local</h5>
                            </div>
                            <div class="col-7 text-start price">
                                <h5>₱25,000.00</h5>
                            </div>
                        </div>
                        <div class="row d-flex align-items-center sched">
                            <div class="col-5 text-start">
                                <h5>Foreign</h5>
                            </div>
                            <div class="col-7 text-start price">
                                <h5>$600.00</h5> 
                            </div> 
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-sm-12 gx-0 card-outline">
                <div class="row card-2">
                    <div class="col-12 text-center ">
                        <h3>Walk-in Delegates (Local)</h3>
                        <div class="row d-flex align-items-center sched">
                            <div class="col-5 text-start">
                                <h5>Regular </h5>
                            </div>
                            <div class="col-7 text-start price">
                                <h5>₱6,000.00</h5>
                            </div>
                        </div>
                
                        <div class="row d-flex align-items-center sched">
                            <div class="col-5 text-start">
                                <h5>Government, Academe, Student, Senior Citizan, PWD </h5>
                            </div>
                            <div class="col-7 text-start price">
                                <h5>₱4,000.00</h5>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-6 col-sm-12 gx-0 card-outline">
                <div class="row card-2">
                    <div class="col-12 text-center ">
                        <h3>Walk-in Delegates (Foreign)</h3>
      
                        <div class="row d-flex align-items-center sched">
                            <div class="col-5 text-start">
                                <h5>Regular </h5>
                            </div>
                            <div class="col-7 text-start price">
                                <h5>$150.00</h5>
                            </div>
                        </div>
            
                        <div class="row d-flex align-items-center sched">
                            <div class="col-5 text-start">
                                <h5>Government, Academe, Student, Senior Citizan, PWD </h5>
                            </div>
                            <div class="col-7 text-start price">
                                <h5>$96.00</h5>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-12 button d-flex justify-content-center">

                    <a href="https://sustainability.ph/conference/registration" class="btn ">REGISTER NOW</a>
                </div>
            </div>
    </section>


    {{-- <section class=" experts end-footer">
        <div class="row ">
            <div class="col-12 headings med">
                <span>
                    <h2>Partners & Sponsorship Opportunities</h2>
                    <p class="text-center mt-2"><em>Join Leading Organizations in Driving Sustainability!</em></p>
                </span>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <p>Become a partner at SSX 2025 and showcase your commitment to a greener future.</p>
            </div>

        </div>
        <div class="row">
            <div class="col-12 button d-flex justify-content-center">
                <a href="https://sustainability.ph/events/sponsor" class="btn m-0 mb-3">VIEW Sponsorship Packages</a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <p><strong>For inquiries, contact:</strong> <br> mvalle@citem.com.ph | +63 2 8821 2201 loc 263</p>
            </div>

        </div>
    </section> --}}
    <section class=" text-center co-section">
   
<div class="co-presented justify-content-center d-flex flex-column">

<div class="row justify-content-center">
<div class="col-4"><h3>TRAINING AND EVENT PARTNER</h3>
<div><img class="pttc_logo" src="/assets/show-info_2025/pttc_logo.png" alt=""></div></div>
<div class="col-4"><h3>OFFICIAL MOBILITY PARTNER</h3>
<div><img class="fmc_logo" src="/assets/show-info_2025/fmc_logo.png" alt=""></div>
</div>
<div class="col-4 partner-container"><h3>EVENT PARTNER</h3>
<div class="d-flex flex-column">
<div><img class="oikos_logo" src="/assets/show-info_2025/oikos_logo.png" alt=""></div>
<div><img class="unisol_logo" src="/assets/show-info_2025/unisol_logo.png" alt=""></div>
</div>
</div>
</div>
<div class="bss-container"><h3>BUSINESS SOLUTIONS SERVICES (BSS) PARTNERS</h3>
<div class="d-flex flex-row">
<div><img class="sunlife_jpg" src="/assets/show-info_2025/sun_life_logo.png" alt=""></div>
<div><img class="water_ph_logo" src="/assets/show-info_2025/waters_philippines_logo.png" alt=""></div>
<div><img class="phl_post_logo" src="/assets/show-info_2025/phl_post_logo.jpg" alt=""></div>
<div><img class="air_speed_logo" src="/assets/show-info_2025/air_speed_logo.jpg" alt=""></div>
</div>
</div>
</div>
</section>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;700&display=swap');

        body {
            max-width: 1920px;
            width: 100%;
            /* Allows it to shrink on smaller screens */
            font-family: 'Inter', sans-serif;
            margin: 0 auto !important;
            /* Centers it */
            overflow-x: hidden;
            /* Prevents horizontal scroll */
        }


        @import url('https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css');


        @font-face {
            font-family: "Harabara";
            /* Give your font a name */
            src: url("fonts/webfonts/Harabara.ttf") format("truetype");
            font-weight: 500;
        }

        * {
            font-family: 'Inter', sans-serif;
        }


        .my-100 {
            /* padding: 0px 160px;
            margin: 120px 0px !important; */
            padding: 0px 90px;
            margin: 70px 0px !important;
        }

        .my-300 {
            padding: 0px 120px;

        }

        .my-200 {
            padding: 0px 120px;
            margin: 60px 0px !important;
        }


     


        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;

            /* background: rgba(52,121,56, 0.2); */
            /* Semi-transparent black */
            z-index: 1;
            /* Keep this below the content */
        }

        .coming-soon p{

            font-size: 16px !important;
            font-weight: 400 !important;
            color: #21693c !important;
        }

        .btn {
            margin: 0px !important;
        }

        .banner-content {
            position: absolute;
            /* Change to absolute */
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            /* Center it */
            text-align: center;
            color: #ffffff;
            z-index: 2;
            width: 100%;
            /* Higher than overlay */
        }

        .banner-content h1 {
            font-size: 50px;
            font-weight: 600;
            color: #fffdf5;
            margin-bottom: 24px;
            letter-spacing: 0.5px;
        }

        .banner-content h2 {
            font-size: 40px;
            line-height: 30px;
            font-weight: 500;
            margin-bottom: 60px;
            letter-spacing: -1px;

            color: #fffdf5;
        }

        .banner-content p {
            font-size: 30px;
            font-weight: 600;
            color: #fffdf5;
            margin-bottom: 12px;
        }

        .banner-content a {
            font-size: 25px;
            font-weight: 600;
            color: #fffdf5;
            margin-top: 30px;
            padding: 5px 48px;
            border: 4px solid #fffdf5;
            border-radius: 10px;
            background-color: #3d580b;
            margin-bottom: 24px;
        }

        .banner-content a:hover {
            background-color: #fffdf5;
            color: #3d580b;
            border: 4px solid #3d580b;

        }

        .intro {
            text-align: center;
        }

        .intro h2 {
            font-size: 45px;
            font-weight: 600;
            color: #367938;
            margin-bottom: 24px;
            letter-spacing: 0.5px;
        }

        .intro p {
            font-size: 16px;
            line-height: 24px;
            font-weight: 500;
            color: #367938;
            margin-bottom: 24px;
            letter-spacing: -.5px;
        }

        .card-outline {
            padding: 0px 35px 35px 35px;
        }

        .card {
            background: #FAFAEA 0% 0% no-repeat padding-box;
            box-shadow: 8px 8px 0px #00000029;
            border: 2px solid #367938;
            border-radius: 40px;
            padding: 25px 50px 50px 50px;
            display: block;
            height: 100% !important;
        }


        .card-2 {
            background: #FAFAEA 0% 0% no-repeat padding-box;
            box-shadow: 8px 8px 0px #00000029;
            border: 2px solid #367938;
            border-radius: 40px;
            padding: 3vw;
            align-items: center;
            display: block;
            height: 100% !important;
        }

        .extended {
            padding: 70px 50px 50px 50px !important;
        }

        .card-3 {
            /* margin-bottom: 120px !important; */
            margin-bottom: 50px !important;
            /* Offsets the padding */
        }

        .card-3-content {
            background: #FAFAEA 0% 0% no-repeat padding-box;
            box-shadow: 8px 8px 0px #00000029;
            border: 2px solid #367938;
            border-radius: 40px;
            padding: 60px 40px;
            margin: 10px;
            width: 25% !important;
            /* Adds space between items */
            /* Adjust as needed */
        }


        .card-3-content img {
            width: 30%;
        }

        .card-3-content {
            text-align: center !important;
        }

        .card img {
            width: 50%;
            margin-bottom: 10px;
        }


        .card-3-content h3 {
            font-size: 36px !important;
            line-height: 40px;
            font-weight: 600;
            color: #367938 !important;
            margin-bottom: 30px;
            letter-spacing: 0.5px;

        }

        .card-3-content p {
            font-size: 16px;
            line-break: 34px;
            font-weight: 500;
            color: #367938;
            letter-spacing: -1px;
            margin-bottom: 0px !important;
        }

        .card h3,
        .card-2 h3 {
            font-size: 38px;
            line-height: 40px;
            font-weight: 600;
            color: #367938;
            margin-bottom: 30px;
            letter-spacing: 0.5px;

        }

        .card p {
            font-size: 16px;
            font-weight: 500;
            color: #367938;
            letter-spacing: -1px;
            margin-bottom: 0px !important;
        }

        .card-2 h5 {
            font-size: 26px;
            font-weight: 600;
            color: #367938;
            letter-spacing: -1px;
        }

        .card-2 p {
            font-size: 16px;
            font-weight: 300;
            color: #367938;
            letter-spacing: -1px;
            margin-bottom: 0px !important;
        }

        .sched {
            border-top: 3px solid #367938;
            padding-top: 20px;
            padding-bottom: 20px;
        }

        /* .price h5 {
            font-size: 50px !important;
            line-height: 50px !important;
            font-weight: 600;
            color: #367938;
            letter-spacing: -1px;
            margin-bottom: 0px;
        } */

        .price h5 {
  font-size: 40px !important;
  line-height: 40px !important;
  font-weight: 600;
  color: #367938;
  letter-spacing: -1px;
  margin-bottom: 0px;
}

        .accrdn {
            background-color: #fafaea;
            padding-top: 60px;
            padding-bottom: 115px !important;
        }




        .headings {
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            margin-bottom: 40px;
            /* margin-bottom: 66px; */
        }

        .small {
            margin-bottom: 20px !important;
        }


        .headings img {

            width: 100px;
            margin-right: 20px;
        }

        .headings h2 {
            font-size: 40px;
            font-weight: 600;
            color: #367938;
            line-height: 40px;
            margin: 0px !important;
            text-align: center;
        }


        .headings h3 {
            font-size: 30px;
            font-weight: 600;
            color: #367938;
            line-height: 30px;
            margin: 0px !important;
            text-align: center;
        }


        .headings p {
            font-size: 16px;
            font-weight: 500;
            color: #367938;
            margin-bottom: 0px;
            text-align: center;
        }

        .headings a {
            font-size: 20px;
            font-weight: 500;
            color: #367938;
            margin-bottom: 0px;
            text-align: center;
        }

        .accordion-item {
            border: none !important;
            padding: 0 !important;
            margin: 0 !important;
            background-color: transparent !important;
            margin-bottom: 24px !important;
        }

        .row.accordion-button {
            margin: 0 !important;
            padding: 0 !important;
            background-color: #347c3c !important;
            /* your green header */
            border-radius: 20px !important;
        }

        .row.accordion-button::after {
            display: none !important;
        }

        .accordion-ssx {
            width: 100%;
            display: flex !important;
            justify-content: space-between;
            align-items: center;
            padding: 16px 20px !important;
            gap: 20px;
            background-color: transparent !important;
            margin: 0 !important;
        }

        .accr-title {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }




        .date {
            background-color: #b7cb59;
            padding: 10px 15px;
            border-radius: 20px;
            color: #fff;
        }

        .date-month {
            margin: 0;
            font-size: 14px;
            color: #21693c;
            font-weight: bold;
        }

        .date-day {
            font-size: 28px;
            font-weight: bold;
            color: #21693c;
            margin: 0;
        }


        .toggle-icon-2 {
            font-size: 40px !important;
            font-weight: 800;
            color: white;
        }

        .date {
            padding: 16px 30px;
            background-color: #ACC351;
            border-radius: 20px;
            margin-right: 0px;
            /* Removed margin, using flex gap instead */
            text-align: center;
        }

        .date-month {
            font-size: 29px;
            line-height: 29px;
            margin: 0px;
            font-weight: 500;
            color: #367938;
            letter-spacing: -1px;
        }

        .date-day {
            font-size: 50px;
            line-height: 59px;
            margin: 0px;
            letter-spacing: -3px;
            font-weight: 600;
            color: #367938;
        }


        .accr-title {
            background-color: #367938;
            height: 120px;
            padding: 0px 24px;
            border-radius: 20px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .accr-title h3 {
            font-size: 35px;
            line-height: 35px;
            font-weight: 600;
            color: #ffffff;
            margin: 0px;
        }


        .accordion-content {
            border-top: solid 3px #367938;
            /* border-bottom: solid 3px #367938; */
            padding: 24px 12px;

        }

        .accordion-content h5 {
            font-size: 30px !important;
            line-height: 35px;
            color: #367938;
            font-weight: 600;
            letter-spacing: -1px;
            margin-bottom: 12px;
            text-transform: uppercase
        }

        .track {
            background-color: #21693c;
            color: #ffffff !important;
            padding: 12px !important;
            border-radius: 12px !important;
            margin-bottom: 24px;
            font-size: 20px !important;
            font-weight: 600
        }

        .track-sub {
            background-color: none !important;
            color: #707070 !important;
            padding: 0px !important;
            border-radius: 0px !important;
            margin-bottom: 0px;
            font-size: 18px !important;
            font-weight: 600;
        }

        .track-content h5 {
            font-size: 24px !important;
            font-weight: 600 !important;
        }

        .accordion-content p,
        .accordion-content ul,
        .accordion-content li {
            font-size: 18px !important;
            line-height: 24px !important;
            color: #367938 !important;
            font-weight: 500;
            letter-spacing: -1px;
            text-align: justify !important;
        }


        .padding_left {
            padding-left: 50px;
        }

        .accordion-button {
            margin-bottom: 24px;
        }

        .shape {
            color: #367938 !important;
            padding: 60px 120px 120px 60px;
        }

        .shape h2 {
            font-size: 40px;
            line-height: 55px;
            margin-bottom: 24px !important;
            font-weight: 700;
        }

        .shape h3 {
            font-size: 30px;
            line-height: 35px;
            margin-bottom: 24px !important;
            font-weight: 500;
        }

        .shape p {
            margin-bottom: 24px;
            font-size: 16px;
            font-weight: 400 !important;
        }

        .shape a {
            text-align: center;
        }

        .cards-22 {
            display: flex;
            justify-content: center;
            gap: 38px;
            /* Add this line to create space between cards */
        }

        .card-22 {
            width: 45% !important;
            background: var(--unnamed-color-fafaea) 0% 0% no-repeat padding-box;
            border: 2px solid var(--unnamed-color-367938);
            background: #FAFAEA 0% 0% no-repeat padding-box;
            box-shadow: 8px 8px 0px #00000029;
            border: 2px solid #367938;
            border-radius: 40px;
            opacity: 1;
            text-align: left !important;
            padding: 40px !important;
        }

        .attend {
            background-color: #ACC351;
            padding: 4vw;
            /* padding: 77px 72px; */
        }

        .attend img,
        .benefits img {
            width: 100px;
            margin-bottom: 10px;
        }

        .attend ul,
        .attend li {
            display: flex !important;
            flex-wrap: wrap !important;
            ;
            font-size: 30px !important;
            line-height: 37px !important;
            color: #ffffff !important;
            font-weight: 600 !important;
            list-style-type: none !important;
            letter-spacing: -1px !important;
        }

        .attend h3,
        .benefits h3 {
            font-size: 40px;
            line-height: 55px;
            color: #ffffff;
            font-weight: 600;
            letter-spacing: -1px;
            margin-bottom: 40px;
        }

        .attend li {
            margin-right: 70px !important;
            margin-bottom: 35px !important;
        }

        .benefits {
            background-color: #367938;
            padding: 4vw;
            /* padding: 77px 120px; */
        }

        .bi {
            font-size: 30px;
            color: #ffffff;
            margin-right: 20px;
        }

        .benefits p {
            font-size: 16px !important;
            line-height: 22px;
            color: #ffffff;
            font-weight: 300 !important;
            margin-left: 48px;
            text-align: left;

        }

        .benefits h5 {
            font-family: "Inter", sans-serif !important;
            font-weight: 600 !important;
            text-align: left !important;
            color: #ffffff !important;
            font-size: 30px !important;
            margin-bottom: 4px !important;
        }

        .benefits li,
        .benefits ul {
            list-style-type: none !important;
        }

        .benefits a {
            font-size: 25px;
            font-weight: 600;
            color: #fffdf5;
            margin-top: 30px;
            padding: 10px 48px;
            border: 4px solid #fffdf5;
            border-radius: 10px;
            background-color: #3d580b;
            margin-bottom: 24px;
        }

        .benefits a:hover {
            background-color: #fffdf5;
            color: #3d580b;
            border: 4px solid #3d580b;
        }



        .small-icon {
            width: 56px !important;
        }


/*
        .speaker h3 {
            font-size: 35px;
            line-height: 35px;
            color: #3d580b;
            font-weight: 600;
            letter-spacing: -1px;
            margin-bottom: 0px !important;
            text-transform: uppercase;
        }

        .speaker p {
            font-size: 24px;
            line-height: 28px;
            color: #3d580b;
            font-weight: 500;
            letter-spacing: -1px;
            margin-bottom: 0px !important;

        } */

        .p-small {
            font-size: 16px !important;
            line-height: 22px;
        }

        .med {
            margin-bottom: 32px;
        }


        .button {
            margin-bottom: 20px;
        }

        .button a {
            font-size: 16px;
            font-weight: 600;
            color: #fffdf5;
            margin-top: 30px;
            padding: 5px 80px;
            border-radius: 10px;
            border: 3px solid #3d580b;
            background-color: #3d580b !important;
            margin-bottom: 24px;
            width: auto;

        }

        .button p {
            font-size: 16px !important;
            line-height: 35px !important;
            color: #367938 !important;
            font-weight: 500 !important;
            letter-spacing: -1px !important;
            text-align: center !important;
            padding: 0px !important;
        }

        .button a:hover {
            border: 3px solid #3d580b;
            background-color: #ffffff !important;
            color: #3d580b;
        }

        .end-footer p {
            font-size: 16px;
            line-height: 35px;
            color: #367938;
            font-weight: 500;
            letter-spacing: -1px;
            text-align: center;
        }

        @media (min-width: 991px) and (max-width: 1200px) {

            .my-100 {
                margin: 60px 0px;
                padding: 60px;
            }

            .card-2 {
                background: #FAFAEA 0% 0% no-repeat padding-box;
                box-shadow: 8px 8px 0px #00000029;
                border: 2px solid #367938;
                border-radius: 40px;
                padding: 3vw !important;
                align-items: center;
                display: block;
                height: 100% !important;
            }

            .card-3 {
                padding: 24px;
            }


            .card-3-content h3 {
                font-size: 30px !important;
                line-height: 40px;

            }

            .card-3-content p {
                font-size: 20px;
                line-height: 30px;
            }

            .card-3-content img {
                width: 30%;
            }

            .card-3-content {
                padding: 20px;
                margin: 10px;
                width: 30% !important;
                /* Adds space between items */
                /* Adjust as needed */
            }

            .shape {
                padding: 60px 24px;
            }
        }

        @media (min-width: 576px) and (max-width: 990px) {

            .shape {
                padding: 60px 0px !important;
            }

            .cards-22 {
                gap: 24px;
                /* Add this ne to create space between cards */
            }

            .my-100 {
                padding: 60px !important;
            }

            .card-2 {
                background: #FAFAEA 0% 0% no-repeat padding-box;
                box-shadow: 8px 8px 0px #00000029;
                border: 2px solid #367938;
                border-radius: 40px;
                padding: 60px !important;
                display: block;
                height: 100% !important;
            }

            .card-3 {
                padding: 24px;
            }

            .card-3-content {
                padding: 40px 20px;
                margin: 10px;
                width: 30% !important;
                /* Adds space between items */
                /* Adjust as needed */
            }

            .card-3-content img {
                width: 50%;
            }

            .card-3-content h3 {
                font-size: 30px !important;
                line-height: 40px;

            }

            .card-3-content p {
                font-size: 20px;
                line-height: 30px;
            }

            .toggle-icon {
                font-size: 32px !important;
                font-weight: 800;
            }

            .my-100 {
                padding: 0px 64px;
                margin: 60px 0px !important;
            }

            .my-300 {
                padding: 60px 64px;

            }

            .my-200 {
                padding: 0px 64px;
                margin: 60px 0px !important;
            }

            /* .parallax {
                height: 80vw !important;
                background-size: cover;
            } */


            .banner-content h1 {
                font-size: 42px;
            }

            .banner-content h2 {
                font-size: 30px;
            }

            .banner-content p {
                font-size: 16px;
                font-weight: 600;
                color: #fffdf5;
                margin-bottom: 6px;
            }

            .banner-content a {
                font-size: 20px;
                margin-top: 15px;
                padding: 5px 36px;
            }



            .intro h2 {
                font-size: 36px;
            }

            .intro p {
                font-size: 18px;
            }

            .card-outline {
                padding: 12px 0px !important;
            }

            .card img {
                width: 75px;
                margin-bottom: 10px;
            }

            .card-2 {
                background: #FAFAEA 0% 0% no-repeat padding-box;
                box-shadow: 8px 8px 0px #00000029;
                border: 2px solid #367938;
                border-radius: 40px;
                padding: 70px 123px 50px 123px;
                display: block;
                height: 100% !important;
            }


            .card h3,
            .card-2 h3 {
                font-size: 32px;
                line-height: 40px;
                font-weight: 600;
                color: #367938;
                margin-bottom: 30px;
                letter-spacing: 0.5px;

            }

            .card p {
                font-size: 16px;
                font-weight: 500;
                color: #367938;
                letter-spacing: -1px;
                margin-bottom: 0px !important;
            }

            .card-2 h5 {
                font-size: 24px;
                font-weight: 600;
                color: #367938;
                letter-spacing: -1px;
            }

            .card-2 p {
                font-size: 16px;
                font-weight: 300;
                color: #367938;
                letter-spacing: -1px;
                margin-bottom: 0px !important;
            }

            .sched {
                border-top: 3px solid #367938;
                padding-top: 20px;
                padding-bottom: 20px;
            }

            .price h5 {
                font-size: 32px !important;
                line-height: 50px !important;
                font-weight: 600;
                color: #367938;
                letter-spacing: -1px;
                margin-bottom: 0px;
            }

            .small {
                margin-bottom: 24px !important;
            }

            .small img {
                width: 75px;
            }

            .small h2 {
                font-size: 32px !important;
                margin-bo
            }

            .extended {
                padding: 70px 24px 50px 24px !important;
            }

            .headings img {
                width: 75px;
                margin-right: 20px;
            }

            .headings h2 {
                font-size: 32px;

                margin-bottom: 0px;
            }

            .headings p {
                font-size: 18px;
                margin-top: 0px;
            }

            .accr-title {
                background-color: #367938;
                height: 120px;
                padding: 0px 50px;
                border-radius: 20px;
                width: 100%;
                display: flex;
                align-items: center !important;
            }

            .accr-title h3 {
                font-size: 24px;
                line-height: 35px;
                font-weight: 600;
                color: #ffffff;
                margin: 0px !important;

            }
/* 
            .experts {
                background-color: #FAFAEA;
                padding: 60px 64px;
            } */

            /* .speaker img {
                width: 120px;
                margin-right: 30px;
            } */

            .speaker h3 {
                font-size: 20px;
                line-height: 35px;
                color: #3d580b;
                font-weight: 600;
                letter-spacing: -1px;
                margin-bottom: 0px !important;
            }

            .speaker p {
                font-size: 16px;
                line-height: 20px;
                color: #3d580b;
                font-weight: 500;
                letter-spacing: -1px;

            }

            .button a {
                font-size: 20px;
                margin-top: 12px;

            }



            .end-footer p {
                font-size: 16px;
                line-height: 35px;
                color: #367938;
                font-weight: 500;
                letter-spacing: -1px;
                text-align: center;
            }

            .med {
                margin-bottom: 32px;
            }


        }

        @media (max-width: 576px) {

            .coming-soon p{
            font-size: 16px !important;
            color: #21693c !important;
        }
            .shape {
                padding:24px 12px !important;
            }

            .shape h2 {
                font-size: 28px;
                line-height: 35px;
                text-align: center;
            }

            .shape h3 {
                font-size: 24px;
            }

            .cards-22 {
                gap: 24px;
                /* Add this ne to create space between cards */
            }

            .card-22 {
                width: 90% !important;
                text-align: center;
            }

            .card-22 h3 {
                font-size: 28px !important;
                text-align: center;
            }

            .card-22 p {
                font-size: 16px !important;
                text-align: center;
            }

            .my-100 {
                padding: 0px 24px;
                margin: 32px 0px !important;
            }

            .my-300 {
                padding: 60px 24px;

            }

            .my-200 {
                padding: 0px 24px;
                margin: 32px 0px !important;
            }

            /* .parallax {
                height: 80vh !important;
                background-size: cover;
            } */


            .banner-content h1 {
                font-size: 36px;
            }

            .banner-content h2 {
                font-size: 30px;
            }

            .banner-content p {
                font-size: 16px;
                font-weight: 600;
                color: #fffdf5;
                margin-bottom: 6px;
            }

            .banner-content a {
                font-size: 18px;
                margin-top: 15px;
                padding: 5px 36px;
            }



            .intro h2 {
                font-size: 28px;
            }

            .intro p {
                font-size: 16px;
            }

            .card-outline {
                padding: 0px 12px 35px 12px;
            }

            .card img {
                width: 75px;
                margin-bottom: 10px;
            }

            .accr-title {
                background-color: #367938;
                height: 100px;
                padding: 0px 12px;
            }

            .accr-title h3 {
                font-size: 18px;
                line-height: 20px;

            }

            .accordion-content {
                border-top: solid 3px #367938;
                /* border-bottom: solid 3px #367938; */
                padding: 20px 12px;
                margin: 0px 12px 0px 12px;
            }

            .accordion-content h5 {
                font-size: 30px !important;
                line-height: 35px !important;
                color: #367938;
                font-weight: 600;
                letter-spacing: -1px;
                margin-bottom: 20px;
            }

            .accordion-content p {
                font-size: 16px;
                line-height: 22px;
                color: #367938;
                font-weight: 500;
                letter-spacing: -1px;
                text-align: justify !important;
            }

            .headings {
                padding: 0px 32px;
            }

            .headings img {
                width: 75px;
                margin-right: 20px;
            }

            .headings h2 {
                font-size: 30px;
                line-height: 32px;
                margin-bottom: 0px;
            }

            .headings p {
                font-size: 16px;
                line-height: 18px;
                margin-top: 0px;
            }

            .date {
                padding: 28px 15px;
                margin-right: 12px;
                height: 100px;
                width: 100px;
            }

            .date-month {
                font-size: 14px;
                line-height: 14px;
                margin: 0px !important;
                padding: 0px !important;
                font-weight: 500;
                color: #367938;
                letter-spacing: -1px;
            }

            .date-day {
                font-size: 30px;
                line-height: 30px;
                margin: 0px !important;
                letter-spacing: -3px;
                font-weight: 600;
                color: #367938;
            }

            .attend {
                background-color: #ACC351;
                /* padding: 64px 12px; */
                padding: 4vw;
            }

            .attend img,
            .benefits img {
                width: 100px;
                margin-bottom: 10px;
            }

            .attend ul,
            li {
                display: flex;
                flex-wrap: wrap;
                ;
                font-size: 24px;
                line-height: 24px;
                padding: 0px;
            }

            .attend h3,
            .benefits h3 {
                font-size: 32px;
                line-height: 55px;
                color: #ffffff;
                font-weight: 600;
                letter-spacing: -1px;
                margin-bottom: 20px;
            }



            .attend li {
                margin-right: 0px;
                margin-bottom: 0px;
                padding: 16px;
                text-align: center;
            }

            .benefits {
                background-color: #367938;
                /* padding: 64px 24px 64px 12px; */
                padding: 4vw;
            }

            .bi {
                font-size: 20px;
                color: #ffffff;
                margin-right: 15px;
            }

        

            .benefits a {
                font-size: 20px;
                padding: 5px 32px;
                border: 2px solid #fffdf5;
                border-radius: 10px;
            }

            .benefits a:hover {
                border: 2px solid #3d580b;
            }

            
        .benefits p {
            font-size: 16px !important;
            line-height: 22px;
            color: #ffffff;
            font-weight: 300 !important;
            margin-left: 32px;
            text-align: left;

        }

        .benefits h5 {
            font-family: "Inter", sans-serif !important;
            font-weight: 600 !important;
            text-align: left !important;
            color: #ffffff !important;
            font-size: 24px !important;
            margin-bottom: 4px !important;
        }

        .benefits li,
        .benefits ul {
          
            list-style-type: none !important;
        }

            /* .experts {
                background-color: #FAFAEA;
                padding: 60px 24px;
            }

            .speaker{
                width: 100% !important;
            } */

            /* .speaker img {
                width: 100px;
                margin-right: 30px;
            } */

            .speaker h3 {
                font-size: 24px;
                line-height: 26px;
            }

            .speaker p {
                font-size: 16px;
                line-height: 20px;
            }

            .p-small{
                font-size: 16px !important;
                line-height: 20px;
            }

            .card img {
                width: 75px;
                margin-bottom: 10px;
            }

            .card-2 {
                background: #FAFAEA 0% 0% no-repeat padding-box;
                box-shadow: 8px 8px 0px #00000029;
                border: 2px solid #367938;
                padding: 16px;
            }


            .card h3,
            .card-2 h3 {
                font-size: 30px;
                line-height: 40px;

            }

            .card p {
                font-size: 16px;
                font-weight: 500;
                color: #367938;
                letter-spacing: -1px;
                margin-bottom: 0px !important;
            }

            .card-2 h5 {
                font-size: 24px;
                font-weight: 600;
                line-height: 24px;
                margin-bottom: 0px;
            }

            .card-2 p {
                font-size: 16px;
            }

            .card-outline {
                padding: 0px 24px 35px 24px;
            }

            .price h5 {
                font-size: 32px !important;
                line-height: 50px !important;
                font-weight: 600;
                color: #367938;
                letter-spacing: -1px;
                margin-bottom: 0px;
            }

            .extended {
                padding: 30px !important;
                margin: 0px;
            }

            .button a {
                font-size: 18px;
                margin-top: 12px;
                padding: 5px 32px;

            }

            .end-footer {
                text-align: center;
            }

            .end-footer p {
                font-size: 18px;
                line-height: 20px;
            }

            .toggle-icon-2 {
                font-size: 24px !important;
                font-weight: 800;
                color: white;
            }

            .banner-1 {
                margin-left: 12px;
            }

            .accordion-body {
                padding: 0px !important;
            }

            .card-3 {
                padding: 12px !important;
                margin-bottom: 12px !important;
            }

            .card-3-content {
                padding: 24px;
                margin: 10px;
                width: 80% !important;
                /* Adds space between items */
                /* Adjust as needed */
            }

            .card-3-content img {
                width: 40%;
            }

            .card-3-content h3 {
                font-size: 24px !important;
                line-height: 30px;

            }

            .card-3-content p {
                font-size: 18px;
                line-height: 24px;
            }

            .attend ul,
            .attend li {
                font-size: 20px !important;
                line-height: 30px !important;
                margin: 24px !important;
            }

            .attend li {
                margin: 0px !important;
            }
        }

        .parallax {
            position: relative;
            /* Add this */
            height: 700px;
            background-color: #fafaea;
            /* background-image: url("/assets/show-info_2025/banner.png"); */
            background-attachment: fixed;
            background-position: top;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .slide-two{
            background: url('/assets/show-info_2025/mobile_small.png') center center / cover no-repeat;
        }

.slide-three{
    background:url('/assets/show-info_2025/mobile_small_slide_3.png') center center / cover no-repeat;
}
        .denr-logo{
            margin-top: 0px;
            height:50px;
            width: 50px;
        }

        .gg-co-funded-by-eu-logo{
            margin-top: 0px;
            height: 50px;
            width: 280px;
        }

        .bmwk-iki-logo{
            height:80px;
            width: 330px;
        }
        
        .co-presented{
            gap: 10px;
            display: flex;
            flex-direction: column;
        }

        .giz-logo{
            height: 50px;
            width: 50px;
        }

        .expertise-france-logo{
            width: 120px;
            height: 40px;
        }

        /* .gggi-logo{
            height: 50px;
            width: 130px;
        } */
        
        .co-presented-title{
            margin-top: 0px;
        }

        .co-organize-title{
            margin-top:60px;
        }

        .co-organize{
            
            gap: 30px;
            display: flex;
            flex-direction: row;
        }
        .co-section{
            background-color: #FAFAEA;
            padding: 70px 0px;
        }

        .experts {
            background-color: #FAFAEA;
            padding: 60px 0px;
        }

        .speaker {
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            height: 100% !important;
            margin-bottom: 40px !important;
            width:  auto !important;
          
        }

         .speaker img {
            width: 320px;
            /* margin-right: 30px; */
            object-fit: cover;
            border-radius: 10%;

        }

        .carousel-inner{
            padding: 0px !important;
        }

        .gg-eu-denr{
            gap: 20px;
        }

        .day{
            margin-bottom: 0px !important;
        }
        .pttc_logo{ 
            height: 250px;
        }

        .fmc_logo{
            width: 270px;
            padding-top: 30px;
        }
        .unisol_logo{

            width: 300px;
        }

        .oikos_logo{
            width: 300px;
        }
        .partner-container > div{
            padding-top: 30px;     
            gap: 25px;      
        }
/* Small devices (landscape phones, 576px and up) */
@media (min-width: 576px) and (max-width: 767.98px) { 
    
    .parallax{
    height: 700px;
    }

    .slide-two{
            background: url('/assets/show-info_2025/mobile_medium.png') center center / cover no-repeat;
        }

    .slide-three{
    background:url('/assets/show-info_2025/mobile_medium_slide_3.png') center center / cover no-repeat;
}
 
        .denr-logo{
            margin-top: 0px;
            height: 80px;
            width: 80px;
        }

        .gg-co-funded-by-eu-logo{
            margin-top: 0px;
            height: 80px;
            width: 400px;
        }

        .bmwk-iki-logo{
            height:120px;
            width: 470px;
        }
        .co-presented-title{
            margin-top: 0px;
        }
        .co-organize-title{
            margin-top:70px;
        }
        .giz-logo{
            height: 70px;
            width: 70px;
        }

        .expertise-france-logo{
            width: 180px;
            height: 65px;
        }

        /* .gggi-logo{
            height: 70px;
            width: 235px;
        }  */
        .co-organize{
            gap:30px;
        }
        .experts{
            padding: 60px 20px;
        }
        
        .speaker img {
            width: 250px;
        }

        .co-presented{
    gap: 20px;
  }

  .gg-eu-denr{
    gap:20px;
  }
}

/* Medium devices (tablets, 768px and up) */
@media (min-width: 768px) and (max-width: 991.98px) {
   
    .parallax{
    height: 500px;
    }
   
    .slide-two{
            background: url('/assets/show-info_2025/tablet.png') center center / cover no-repeat;
        }

            .slide-three{
    background:url('/assets/show-info_2025/tablet_slide_3.png') center center / cover no-repeat;
}

  .co-presented{
    gap: 10px;
  }

        .denr-logo{
            margin-top: 5px;
            height: 80px;
            width: 80px;
        }

        .gg-co-funded-by-eu-logo{
            margin-top: 0px;
            height: 80px;
            width: 420px;
        }

        .bmwk-iki-logo{
            height:130px;
            width: 530px;
        }
 
        .co-presented-title{
            margin-top: 0px;
        }

        .co-organize-title{
            margin-top:70px;
        }
        /* .co-organize{
            gap: 24px;
            display: flex;
            flex-direction: row;
        } */

        .giz-logo{
            height: 70px;
            width: 70px;
        }

        .expertise-france-logo{
            width: 210px;
            height: 60px;
        }

        /* .gggi-logo{
            height: 70px;
            width: 235px;
        }  */
        .co-organize{
            gap: 30px;
            display: flex;
            flex-direction: row;
        }
        
        .experts{
            padding: 60px 50px;
        }
        .gg-eu-denr{
            gap: 30px;
        }
 }

/* Large devices (desktops, 992px and up) */
@media (min-width: 992px) and (max-width: 1199.98px) { 
    .parallax{
    height: 500px;
    }
    .slide-two{
            background: url('/assets/show-info_2025/large_screen.png') center center / cover no-repeat;
        }

                    .slide-three{
    background:url('/assets/show-info_2025/large_screen_slide_3.png') center center / cover no-repeat;
}


    .co-presented{
        gap: 0px;
    }

        .denr-logo{
            margin-top: 5px;
            height: 100px;
            width: 100px;
        }

        .gg-co-funded-by-eu-logo{
            margin-top: 0px;
            height: 100px;
            width: 500px;
        }

        .bmwk-iki-logo{
            height:160px;
            width: 660px;
        }
 
        .co-presented-title{
            margin-top: 0px;
        }

        .co-organize-title{
            margin-top:70px;
        }

        .giz-logo{
            height: 80px;
            width: 80px;
        }

        .expertise-france-logo{
            width: 240px;
            height: 70px;
        }

        /* .gggi-logo{
            height: 70px;
            width: 240px;
        }  */
        .co-organize{
            gap: 30px;
            display: flex;
            flex-direction: row;
        }

        .experts {
     
            padding: 60px 20px !important;
        }
        .gg-eu-denr{
            gap: 30px;
        }
 }

/* Extra large devices (large desktops, 1200px and up) */
@media (min-width: 1200px) and (max-width: 1399.98px) { 
    .parallax{
    height: 500px;
    }
    .slide-two{
            background: url('/assets/show-info_2025/large_screen.png') center center / cover no-repeat;
        }

         .slide-three{
    background:url('/assets/show-info_2025/large_screen_slide_3.png') center center / cover no-repeat;
}

        .denr-logo{
            margin-top: 35px;
            height: 90px;
            width: 90px;
        }

        .gg-co-funded-by-eu-logo{
            margin-top: 15px;
            height: 100px;
            width: 470px;
        }

        .bmwk-iki-logo{
            /* margin-top: 17px; */
            height:150px;
            width: 590px;
        }
        .co-presented{
            gap: 0px;
            display: flex;
            flex-direction: row;
        }
        .co-presented-title{
            margin-top: 0px;
        }

        .co-organize-title{
            margin-top:70px;
        }
        .giz-logo{
            height: 80px;
            width: 80px;
        }

        .expertise-france-logo{
            width: 220px;
            height: 70px;
        }
/* 
        .gggi-logo{
            height: 70px;
            width: 240px;
        }  */
        .co-organize{
            gap: 30px;
            display: flex;
            flex-direction: row;
        }

        .experts {
            padding: 60px 100px !important;
        }

        .gg-eu-denr{
            gap: 30px;
        }
    }

/* XXL devices (very large desktops) */
@media (min-width: 1400px) {
    .parallax{
    height: 700px;
    } 
    .slide-two{
            background: url('/assets/show-info_2025/large_screen.png') center center / cover no-repeat;
        }
                 .slide-three{
    background:url('/assets/show-info_2025/large_screen_slide_3.png') center center / cover no-repeat;
}
        .denr-logo{
            margin-top: 15px;
            height: 110px;
            width: 110px;
        }

        .gg-co-funded-by-eu-logo{
            margin-top: 0px;
            height: 120px;
            width: 570px;
        }

        .bmwk-iki-logo{
            /* margin-top: 18px; */
            height:160px;
            width: 590px;
        }
        .co-presented{
            gap: 24px;
            display: flex;
            flex-direction: row;
        }
        /* .co-presented {
            gap: 70px;
        } */
   
        .giz-logo{
            height: 80px;
            width: 80px;
        }

        .expertise-france-logo{
            width: 240px;
            height: 80px;
        }

        /* .gggi-logo{
            height: 80px;
            width: 250px;
        } */
        .co-presented-title{
            margin-top: 0px;
        }

        .co-organize-title{
            margin-top:70px;
        }

        .co-organize{
            padding-top: 30px;
            gap: 70px;
            display: flex;
            flex-direction: row;
        }

        .experts {
            padding: 60px 100px !important;
        }
        
        .gg-eu-denr{
            gap: 45px;
        }
    }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".accordion-button").forEach(function(btn) {
                btn.addEventListener("click", function() {
                    let icon = this.querySelector(".toggle-icon-1");
                    if (icon) {
                        icon.classList.toggle("bi-chevron-down");
                        icon.classList.toggle("bi-chevron-up");
                    }
                });
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".accordion-button").forEach(function(btn) {
                btn.addEventListener("click", function() {
                    let icon = this.querySelector(".toggle-icon-2");
                    if (icon) {
                        icon.classList.toggle("bi-chevron-up");
                        icon.classList.toggle("bi-chevron-down");
                    }
                });
            });
        });

        $(document).ready(function() {
            $('#nav-events').addClass('active');
        });
    </script>
@endpush
