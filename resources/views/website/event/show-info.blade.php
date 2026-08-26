@extends('layouts.website')

@section('content')
    <!-- START HERE -->
    <section class="container-fluid parallax">
        <div id="eventCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <!-- Indicators -->
            <div class="carousel-indicators">
                {{-- <button type="button" data-bs-target="#eventCarousel" data-bs-slide-to="0" class="active"></button> --}}
                <button type="button" data-bs-target="#eventCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#eventCarousel" data-bs-slide-to="1"></button>
            </div>

            <!-- Slides -->
            <div class="carousel-inner">

                <!-- Slide 1: Your event section -->
                {{-- <div class="carousel-item active">
                <div class="container-fluid parallax position-relative text-white" style=" background: url('/assets/show-info_2025/banner.png') center center / cover no-repeat;">
                  <div class="overlay position-absolute top-0 start-0 " style="background: rgba(0, 0, 0, 0.5);"></div>
                  <div class="row banner-content position-relative z-2  align-items-center justify-content-center text-center">
                    <div class="col-12 banner-1">
                      <h1>Sustainability Solutions Exchange 2025</h1>
                      <h2><em>Green Innovations: Navigating Sustainability Solutions to Future-Proof the Food Industry</em></h2>
                      <p>May 22-24, 2025</p>
                      <p class="mt-1 mb-3 fs-5">Exhibition: World Trade Center Metro Manila</p>
                      <p class="mb-5 fs-5">Conference: Philippine Trade Training Center</p>
                      <!-- <a href="https://sustainability.ph/conference/registration" target="_blank" class="btn btn-light">REGISTER NOW</a> -->
                    </div>
                  </div>
                </div>
              </div> --}}

                <!-- Slide 2: Just a background image -->
                <div class="carousel-item active">
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
        <div class="row justify-content-center">
            <div class="col-12 col-lg-9 ">
                <h2><em>Where Innovation Meets Sustainability</em></h2>
                <p>
                    The <b>Sustainability Solutions Exchange (SSX)</b> is the latest flagship initiative of the Center for
                    International Trade Expositions and Missions (CITEM) – a platform designed to empower MSMEs on their
                    journey toward a circular economy while reinforcing the Philippines’ commitment to the UN Sustainable
                    Development Goals (SDGs).
                </p>
                <p>
                    SSX serves as a dynamic hub for transformation, bringing together industry pioneers, sustainability
                    advocates, and forward-thinking businesses through key interconnected events:
                    <br><br>
                    A thought-provoking conference on <b>May 22-23, 2025, at the Philippine Trade Training Center, Pasay
                        City</b>, where global experts will share insights on sustainable consumption and production,
                    particularly for the Philippine food industry.
                    <br><br>
                    An immersive exhibition running from <b>May 22-24, 2025, at the Sustainability Hall (Hall D) within IFEX
                        Philippines, World Trade Center Metro Manila</b>. This exhibition will spotlight cutting-edge
                    sustainable solutions and innovations.
                    <br><br>
                    Alongside these, SSX will feature business matching & pitching sessions designed to foster high-impact
                    collaborations, taking place at the <b>World Trade Center Mezzanine, Hidalgo Function Room</b>.
                    <br><br>
                    Together, these components offer an unparalleled experience in sustainability-driven trade and
                    innovation.
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
                <div class="mt-3">
                    <a href="https://sustainability.ph/downloads/2025/SSX-Pitching-Sessions-2025.pdf"
                        class="btn btn-success mx-2" target="_blank">Learn More</a>
                    <!-- <a href="https://forms.office.com/pages/responsepage.aspx?id=-ZsJNoohvkC7xDeyEHvVeVfo5qy2N5NEhDIiBlnZHbRUNkdLRlBXTlJUSzVCRzBRMzVNVDhCVTFORi4u&origin=QRCode&route=shorturl" class="btn  btn-outline-success mx-2" target="_blank">Register Now</a> -->
                </div>
            </div>
            <div class="col-lg-4 d-flex justify-content-center align-items-center flex-column text-center card-3-content">
                <img src="/assets/show-info_2025/card-1.png" class="img-fluid mb-3" alt="">
                <h3>Exhibition</h3>
                <p>Discover groundbreaking sustainable solutions in food production.</p>
            </div>
        </div>
    </section>






    <section class=" shape " style="background-color:#FAFAEA">


        <div class="row headings justify-content-center text-center">
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
                    <p><strong>Financing the Future:</strong> <br> Enabling Businesses to Reach their Sustainability Goals
                    </p>
                    <p><strong>Embracing Transfromative, Climate-Smart Food Systems</strong></p>
                    <p><strong>Fresh Perspectives on Sustainable Packaging</strong></p>
                    <p><strong>Standard Setting:</strong><br> Identifying Social Responsibilities in the Food Industry</p>
                    <p><strong>The Case for a Greener Future</strong></p>
                </div>

                <div class="col-md-5 col-sm-10 card-22">
                    <p class="day">Day 2 (1:00PM - 5:30 PM PST)</p>
                    {{-- <h3>Empowering Conscious Consumers</h3> --}}
                    <h3>CONSUMER TRACK</h3>
                    <p><strong>Mindful Consumption and Sustainable Living:</strong><br> Steps Toward Progressive Foodways
                    </p>
                    <p><strong>Transformative Approaches to Food Waste Management</strong></p>
                    <p><strong>Taking Action:</strong><br> Social Enterprises on Consumer Education and Engagement</p>
                </div>
            </div>
        </div>

        <div class="container my-5">
            <div class="accordion" id="scheduleAccordion">

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingDay1">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseDay1" aria-expanded="true" aria-controls="collapseDay1">
                            <span class="fs-5 text-success m-0">DAY 1 &mdash; May 22, 2025 (Thursday)</span>
                            <h3 class="text-success"><b>FOOD PHILIPPINES JOURNEY TO CIRCULARITY</b></h3>
                        </button>
                    </h2>
                    <div id="collapseDay1" class="accordion-collapse collapse show" aria-labelledby="headingDay1"
                        data-bs-parent="#scheduleAccordion">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table table-hovered text-success table-stackable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Time</th>
                                            <th scope="col">Session Title</th>
                                            <th scope="col">Brief Description</th>
                                            <th scope="col">Speakers</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td data-label="Time">12:00 PM - 1:00 PM</td>
                                            <td colspan="3" data-label="Session">Registration</td>
                                        </tr>
                                        <tr>
                                            <td data-label="Time">1:00 PM - 1:05 PM</td>
                                            <td colspan="3" data-label="Session">Invocation</td>
                                        </tr>
                                        <tr>
                                            <td data-label="Time">1:05 PM - 1:10 PM</td>
                                            <td colspan="3" data-label="Session">Singing of the Philippine National
                                                Anthem</td>
                                        </tr>
                                        <tr>
                                            <td data-label="Time">1:10 PM - 1:15 PM</td>
                                            <td colspan="2" data-label="Session">Acknowledgement of Guests</td>
                                            <td><strong>Host - Mikki Sachiko</strong></td>
                                        </tr>
                                        <tr>
                                            <td data-label="Time">1:15 PM - 1:25 PM</td>
                                            <td data-label="Session Title">Welcome Remarks</td>
                                            <td data-label="Brief Description">
                                                The Executive Director’s message will introduce CITEM, provide an overview
                                                of SSX, and highlight the platform’s significant achievements.
                                            </td>
                                            <td data-label="Speakers">
                                                <b>Romleah Juliet P. Ocampo</b><br>
                                                <small>Executive Director</small><br>
                                                <small><em>Center for International Trade Expositions and Missions
                                                        (CITEM)</em></small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-label="Time">1:30 PM - 1:40 PM</td>
                                            <td data-label="Session Title">Opening Remarks</td>
                                            <td data-label="Brief Description">
                                                The Secretary will underline the DTI’s mandate, sharing ongoing measures to
                                                achieve sustainability in the food trade industry. It will also introduce
                                                the SSX theme and set delegates’ expectations for the two-day program.
                                            </td>
                                            <td data-label="Speakers" rowspan="2"> <b>Maria Cristina A. Roque</b><br>
                                                <small><em>Secretary, Department of Trade and Industry (DTI)</em></small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-label="Time">1:45 PM - 2:00 PM</td>
                                            <td data-label="Session Title">
                                                Keynote Address<br>
                                                <small><em>With Clarity of Purpose: The Philippines' Pursuit of a Greener
                                                        Future</em></small>
                                            </td>
                                            <td data-label="Brief Description">
                                                The keynote speaker will provide an overview of the Philippines’ impact on
                                                the environment, highlighting the role of businesses and consumers in the
                                                transition to circularity. The Secretary will also touch on the commitment
                                                of the Philippine government to promote sustainability and responsible
                                                consumption and production within the food sector.
                                            </td>

                                        </tr>
                                        <tr>
                                            <td data-label="Time">2:05 PM - 2:50 PM</td>
                                            <td data-label="Session Title">
                                                Keynote Message + Panel Discussion<br>
                                                <small><em>Making An Impact: The European Union Partnerships Seeking
                                                        Sustainability</em></small>
                                            </td>
                                            <td data-label="Brief Description">This session will introduce delegates to the
                                                EU-Philippines partnership on the green economy, highlighting collaborative
                                                efforts and joint initiatives that support the country's transition toward
                                                sustainability. It will also announce the launch of the Green Economy
                                                Platform, which will serve as a digital space for knowledge exchange,
                                                stakeholder engagement, and partnership-building.</td>
                                            <td data-label="Speakers">
                                                <strong>Keynote Speaker:</strong><br>Dr. Marco Gemmer<br><small><em>Head of
                                                        Cooperation, European Union in the Philippines</em></small><br>
                                                <strong>Panelists:</strong>
                                                <ul>
                                                    <li>Veera Kaarel<br><small><em>Deputy Head of Mission, Finnish
                                                                Embassy</em></small></li>
                                                    <li>Dr. David Klebs<br><small><em>Economic Counsellor, Embassy of the
                                                                Federal Republic of Germany</em></small></li>
                                                    <li>Dr. Diana Edralin<br><small><em>Vice President, European Chamber of
                                                                Commerce of the Philippines (ECCP)</em></small></li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-label="Time">2:55 PM - 3:10 PM</td>
                                            <td data-label="Session Title">COFFEE BREAK</td>
                                            <td data-label="Brief Description"></td>
                                            <td data-label="Speakers"></td>
                                        </tr>
                                        <tr>
                                            <td data-label="Time">3:15 PM - 4:00 PM</td>
                                            <td data-label="Session Title">
                                                Keynote Presentation<br>
                                                <small><em>Transforming our World: 2030 Agenda for Sustainable
                                                        Development</em></small>
                                            </td>
                                            <td data-label="Brief Description">The presentation will center on the global
                                                community's progress toward the 2030 Sustainable Development Agenda.</td>
                                            <td data-label="Speakers">
                                                <b>Dr. Selva Ramachandran</b><br>
                                                <small>Resident Representative, United Nations Development Programme,
                                                    Philippines (UNDP)</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-label="Time">4:05 PM - 4:50 PM</td>
                                            <td data-label="Session Title">
                                                Panel Session<br>
                                                <small><em>Major Strides: The Philippines' Efforts Toward Food
                                                        Sustainability</em></small>
                                            </td>
                                            <td data-label="Brief Description">The session will center on measures taken to
                                                promote food sustainability in the country in accordance with the Philippine
                                                Development Plan (PDP), Ambisyon Natin 2040, and Sustainable Development
                                                Goal 12 (SDG 12).</td>
                                            <td data-label="Speakers">
                                                <strong>Presenter/Moderator:</strong><br>Marie Maylis
                                                Charlat<br><small><em>Project Leader, Expertise France</em></small><br>
                                                <strong>Panelists:</strong>
                                                <ul>
                                                    <li>Philip Young<br><small><em>Assistant Secretary and Special Assistant
                                                                for Export Development, Department of Agriculture
                                                                (DA)</em></small></li>
                                                    <li>Leah Buendia<br><small><em>Undersecretary for Research and
                                                                Development, Department of Science and Technology
                                                                (DOST)</em></small></li>
                                                    <li>Engr. Esperanza Sajul<br><small><em>OIC AD and Concurrent Chief, EIA
                                                                Division EMB-DENR</em></small></li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-label="Time">4:55 PM - 5:40 PM</td>
                                            <td data-label="Session Title">
                                                Keynote Presentation + Panel Session<br>
                                                <small><em>Attaining a Circular Food Economy: Challenges and
                                                        Opportunities</em></small>
                                            </td>
                                            <td data-label="Brief Description">
                                                What are the challenges and opportunities in seeking a more sustainable food
                                                industry?
                                                <br>
                                                The panel will seek new perspectives into this question, covering critical
                                                areas such as agriculture, food production, nutrition, packaging, and waste
                                                management. Their discussion will also provide insights into policy gaps,
                                                industry innovations, and scalable solutions.
                                            </td>
                                            <td data-label="Speakers">
                                                <strong>Keynote Presenter:</strong><br>Myrtle Faye
                                                Solina<br><small><em>Chief Trade Industry Development Specialist, Food
                                                        Division, Export Marketing Bureau (EMB)</em></small><br>
                                                <strong>Moderator:</strong><br>Elvin Ivan Y. Uy<br><small><em>Executive
                                                        Director, Philippines Business for Social Progress
                                                        (PBSP)</em></small><br>
                                                <strong>Panelists:</strong>
                                                <ul>
                                                    <li>Ace Estrada<br><small><em>Co-Founder, Rural Rising
                                                                Philippines</em></small></li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-label="Time">5:45 PM - 6:00 PM</td>
                                            <td data-label="Session Title">DAY 1 Synthesis - What's next?</td>
                                            <td data-label="Brief Description">The speaker will provide a summary of key
                                                points from Day 1 discussion. It will then set delegates' expectations for
                                                Day 2.</td>
                                            <td data-label="Speakers">
                                                <b>Dr. Juan Alfonso Leonardia</b><br>
                                                <small>Senior Advisor, GEPP SO1 Policy and Alliances</small>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingDay2Future">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseDay2Future" aria-expanded="false"
                            aria-controls="collapseDay2Future">
                            <span class="fs-5 text-success m-0">DAY 2 &mdash; May 23, 2025 (Friday)</span>
                            <h3 class="text-success"><b>FUTURE FOOD SYSTEMS FOR SUSTAINABLE CONSUMPTION AND PRODUCTION</b>
                            </h3>
                        </button>
                    </h2>
                    <div id="collapseDay2Future" class="accordion-collapse collapse" aria-labelledby="headingDay2Future"
                        data-bs-parent="#scheduleAccordion">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table table-hovered text-success table-stackable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Time</th>
                                            <th scope="col">Session Title</th>
                                            <th scope="col">Brief Description</th>
                                            <th scope="col">Speakers</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td data-label="Time">9:00 AM - 9:15 AM</td>
                                            <td data-label="Session Title">Day 1 Recap & Day 2 Overview</td>
                                            <td data-label="Brief Description">The host will deliver a recap of Day 1 and
                                                provide an overview of Day 2 program of activities.</td>
                                            <td data-label="Speakers">
                                                <b>Host - Mikki Sachiko</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-label="Time">9:20 AM - 10:20 AM</td>
                                            <td data-label="Session Title">
                                                Keynote Presentation + Panel Session<br>
                                                <small><em>Roles in Circularity: A Guide for Businesses and
                                                        Consumers</em></small>
                                            </td>
                                            <td data-label="Brief Description">This session will explore the impact of the
                                                Extended Producer Responsibility (EPR) Act on businesses, focusing on
                                                compliance, waste reduction, and circular economy strategies. The discussion
                                                will also cover how EPR reshapes corporate sustainability and promotes
                                                responsible waste management in the food industry.</td>
                                            <td data-label="Speakers">
                                                <strong>Keynote Speaker:</strong><br>Jacqueline
                                                Caancan<br><small><em>Assistant Secretary, Department of Environment and
                                                        Natural Resources</em></small><br>
                                                <strong>Moderator:</strong><br>Ping Manongdo<br><small><em>Head of
                                                        Partnerships, Corporate Decarbonization Exchange
                                                        (CDx)</em></small><br>
                                                <strong>Panelists:</strong>
                                                <ul>
                                                    <li>Jess Reyes<br><small><em>Interim President, Philippine Alliance for
                                                                Recycling and Materials Sustainability (PARMS) and Co-chair
                                                                of the Environmental Committee, Philippine Chamber of
                                                                Commerce and Industry (PCCI)</em></small></li>
                                                    <li>Ted Guayco<br><small><em>Business Development Manager, Plastic
                                                                Bank</em></small></li>
                                                    <li>Mark Jerome Castillo<br><small><em>Sustainability Team Lead and
                                                                Chief Information Officer, Hotel and Restaurant Association
                                                                of the Philippines/ The Bellevue Manila</em></small></li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-label="Time">10:25 AM - 11:25 AM</td>
                                            <td data-label="Session Title">
                                                Sprint Presentations + Panel Session<br>
                                                <small><em>Sustainability as Foundation: Innovative Strategies for Food
                                                        Businesses</em></small>
                                            </td>
                                            <td data-label="Brief Description">The session will highlight global trends on
                                                sustainability, with a focus on identifying strategies for MSME's to adapt
                                                to the changing landscape.</td>
                                            <td data-label="Speakers">
                                                <strong>Moderator: </strong><br>Mikki Sachiko<br>
                                                <strong>Panelists:</strong>
                                                <ul>
                                                    <li>Atty. Rami Amer Hourani<br><small><em>National Project Coordinator,
                                                                Arise Plus Philippines</em></small></li>
                                                    <li>Prof. Ma. Janesa A. Reyes<br><small><em>Director, Bicol University -
                                                                Bicol Regional Food Innovation and Commercialization Center
                                                                (BRFICC)</em></small></li>
                                                    <li>Shoraliah Macalbe<br><small><em>Head of Startup Development, QBO and
                                                                IdeaSpace Innovations</em></small></li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-label="Time">11:30 AM - 1:00 PM</td>
                                            <td colspan="3" data-label="Session">LUNCH BREAK</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingDay2Business">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseDay2Business" aria-expanded="false"
                            aria-controls="collapseDay2Business">
                            <span class="fs-5 text-success m-0">DAY 2 &mdash; May 23, 2025 (Friday)</span>
                            <h3 class="text-success"><b>DAY 2 - BUSINESS TRACK</b></h3>
                        </button>
                    </h2>
                    <div id="collapseDay2Business" class="accordion-collapse collapse"
                        aria-labelledby="headingDay2Business" data-bs-parent="#scheduleAccordion">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table table-hovered text-success table-stackable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Time</th>
                                            <th scope="col">Session Title</th>
                                            <th scope="col">Brief Description</th>
                                            <th scope="col">Speakers</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td data-label="Time">1:00 PM - 1:45 PM</td>
                                            <td data-label="Session Title">
                                                Sprint Presentations + Panel Session<br>
                                                <small><em>Financing the Future: Enabling Businesses to Reach their
                                                        Sustainability Goals</em></small>
                                            </td>
                                            <td data-label="Brief Description">This panel will touch on green financing
                                                opportunities, investment programs, and other pathways leading to a
                                                sustainable food system.</td>
                                            <td data-label="Speakers">
                                                <strong>Presenter/Moderator:</strong><br>Jocelle
                                                Mamaril<br><small><em>Assistant Division Chief, Strategy Management
                                                        Division, Philippine Trade Training Center</em></small><br>
                                                <strong>Panelists:</strong>
                                                <ul>
                                                    <li>Marcel Silvius<br><small><em>Subregional Director Southeast Asia and
                                                                Country Representative, Global Green Growth Institute (GGGI)
                                                                Philippines</em></small></li>
                                                    <li>George Inocencio<br><small><em>Head of Development and Resiliency
                                                                Sector, Development Bank of the Philippines
                                                                (DBP)</em></small></li>
                                                    <li>Aditi Pandit<br><small><em>FIG Upstream and Advisory, International
                                                                Finance Corporation (IFC)</em></small></li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-label="Time">1:50 PM - 2:50 PM</td>
                                            <td data-label="Session Title">
                                                Keynote Presentation + Panel Session<br>
                                                <small><em>Embracing Transformative, Climate-Smart Food Systems</em></small>
                                            </td>
                                            <td data-label="Brief Description">The session will explore the ecological
                                                balance of food focusing on measures to mitigate sourcing risks, green
                                                technologies, and sustainable farming. The session will also explore
                                                practical, cost-effective strategies to enhance efficiency, resilience, and
                                                market competitiveness for a climate-smart food system.</td>
                                            <td data-label="Speakers">
                                                <strong>Keynote Presenter:</strong><br>Pendatun Patarasa,
                                                MPA<br><small><em>Director General, Fisheries Services,
                                                        MAFAR-BARMM</em></small><br>
                                                <strong>Moderator:</strong><br>Dr. Nathaniel C. Bantayan<br><small><em>Vice
                                                        Chancellor for Research and Extension, University of the Philippines
                                                        Los Baños (UPLB)</em></small><br>
                                                <strong>Panelists:</strong>
                                                <ul>
                                                    <li>Carlomagno Aguilar<br><small><em>Chief Farmer and Head Farm
                                                                Consultant, FarmYields Inc</em></small></li>
                                                    <li>Raymund Aaron<br><small><em>Banana Chief, Villa Socorro
                                                                Farm</em></small></li>
                                                    <li>Maria Grazia Presacco<br><small><em>Head of Delegation, Spanish Red
                                                                Cross in the Philippines</em></small></li>
                                                    <li>Margaret Navarro<br><small><em>Country Manager, CODESPA</em></small>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-label="Time">2:50 PM - 3:05 PM</td>
                                            <td colspan="3" data-label="Session">COFFEE BREAK</td>
                                        </tr>
                                        <tr>
                                            <td data-label="Time">3:10 PM - 3:55 PM</td>
                                            <td data-label="Session Title">
                                                Panel Session<br>
                                                <small><em>Fresh Perspectives on Sustainable Packaging</em></small>
                                            </td>
                                            <td data-label="Brief Description">The panel will cover the newest trends and
                                                technological advancements in sustainable packaging solutions. Delegates
                                                will discover eco-friendly alternatives that enhance product value, reduce
                                                waste, and ensure compliance with evolving consumer and regulatory demands.
                                            </td>
                                            <td data-label="Speakers">
                                                <strong>Moderator: </strong><br>Dr. Annabelle V.
                                                Briones<br><small><em>Director, Department of Science and Technology -
                                                        Industrial Technology Development Institute (DOST-ITDI)</em></small>
                                                <strong>Panelists:</strong>
                                                <ul>
                                                    <li>Lucky Lopez<br><small><em>Deputy Executive Director, Design Center
                                                                of the Philippines</em></small></li>
                                                    <li>Nikki Sevilla<br><small><em>Managing Director, AKO Packaging,
                                                                EcoNest Philippines, and PASS Foundation, Inc.</em></small>
                                                    </li>
                                                    <li>John David Pestano<br><small><em>VP for External Affairs, Packaging
                                                                Institute of the Philippines</em></small></li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-label="Time">4:00 PM - 5:00 PM</td>
                                            <td data-label="Session Title">
                                                Sprint Presentations + Panel Session<br>
                                                <small><em>The Case for a Greener Future</em></small>
                                            </td>
                                            <td data-label="Brief Description">The panel will establish the need for
                                                compliance with environmental policies, as well as its connection to greater
                                                market access, higher trust, and long-term success.</td>
                                            <td data-label="Speakers">
                                                <strong>Moderator: </strong><br>Myra Magabilin<br><small><em>Supervising
                                                        Trade Industry Specialist, Department of Trade and Industry - Bureau
                                                        of Philippine Standards</em></small>
                                                <strong>Presenters/Panelists:</strong>
                                                <ul>
                                                    <li>Natasha Erika Jane Siaron<br><small><em>Advocacy Manager for Asia
                                                                and Pacific and PSR Manager for the Philippines, Fairtrade
                                                                NAPP</em></small></li>
                                                    <li>Abdul Rahman T. Linzag<br><small><em>Chairman, IDCP Halal
                                                                Certification Authority</em></small></li>
                                                    <li>Tom van der Muelen<br><small><em>Managing Director, Control Union
                                                                Philippines</em></small></li>
                                                    <li>Mariglo Laririt<br><small><em>Assistant Director, Department of
                                                                Environment and Natural Resources (DENR) - Biodiversity
                                                                Management Bureau (BMB)</em></small></li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-label="Time">5:05 PM - 5:20 PM</td>
                                            <td data-label="Session Title">Business Track Synthesis + Closing Remarks</td>
                                            <td data-label="Brief Description">The speaker will summarize important points
                                                from the Business Track sessions and deliver the day's closing remarks.</td>
                                            <td data-label="Speakers">
                                                Dr. Melodee Marciana E. De Castro<br><small><em>Associate Professor, College
                                                        of Economics and Management, UP Los Baños</em></small>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingDay2Consumer">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseDay2Consumer" aria-expanded="false"
                            aria-controls="collapseDay2Consumer">
                            <span class="fs-5 text-success m-0">DAY 2 &mdash; May 23, 2025 (Friday)</span>
                            <h3 class="text-success"><b>DAY 2 - CONSUMER TRACK</b></h3>
                        </button>
                    </h2>
                    <div id="collapseDay2Consumer" class="accordion-collapse collapse"
                        aria-labelledby="headingDay2Consumer" data-bs-parent="#scheduleAccordion">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table table-hovered text-success table-stackable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Time</th>
                                            <th scope="col">Session Title</th>
                                            <th scope="col">Brief Description</th>
                                            <th scope="col">Speakers</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td data-label="Time">1:00 PM - 2:00 PM</td>
                                            <td data-label="Session Title">
                                                Sprint Presentations + Panel Session<br>
                                                <small><em>Meeting the Standard: Compliance with Environmental Laws and
                                                        Regulations</em></small>
                                            </td>
                                            <td data-label="Brief Description">The session will emphasize the need for
                                                compliance with environmental policies and establish ways consumers can help
                                                push for a more resilient economy. Join community leaders and local
                                                government representatives as they discuss effective measures to achieve
                                                sustainability goals through collaborative community involvement.</td>
                                            <td data-label="Speakers">
                                                <strong>Moderator:</strong><br>Gwyneth Anne Palmes<br><small><em>Climate
                                                        Action Programme Analyst, United Nations Development Programme
                                                        (UNDP)</em></small><br>
                                                <strong>Presenters/Panelists:</strong>
                                                <ul>
                                                    <li>Alfredo Coro II<br><small><em>Municipal Mayor, Municipality of Del
                                                                Carmen, Siargao Islands, Surigao Del Norte</em></small></li>
                                                    <li>Atty. Diego Luis S. Santiago<br><small><em>Assistant City
                                                                Administrator and Officer-In-Charge of the Local Economic
                                                                Development and Investment Office, Pasig City</em></small>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-label="Time">2:05 PM - 2:50 PM</td>
                                            <td data-label="Session Title">
                                                Sprint Presentations + Panel Session<br>
                                                <small><em>Mindful Consumption and Sustainable Living: Steps Toward
                                                        Progressive Foodways</em></small>
                                            </td>
                                            <td data-label="Brief Description">The session will explore trends, challenges,
                                                and opportunities in the push for mindful consumption and sustainable
                                                living, aiming to impart measures to achieve a sustainable future.</td>
                                            <td data-label="Speakers">
                                                <strong>Moderator:</strong><br>Liezl Stuart del Rosario<br><small><em>Team
                                                        Lead for Sustainable Consumption and Production and Policy
                                                        Engagement Lead, WWF-PH</em></small><br>
                                                <strong>Panelists:</strong>
                                                <ul>
                                                    <li>Chef Laurence Castillo<br><small><em>Co-founder, Gulay
                                                                Na</em></small></li>
                                                    <li>Chit Juan<br><small><em>President, Slow Food Manila and Co-Founder,
                                                                ECHOstore</em></small></li>
                                                    <li>Dhanvantari Saulo<br><small><em>Founder and CEO, Cosmic Group
                                                                Philippines</em></small></li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-label="Time">2:50 PM - 3:05 PM</td>
                                            <td colspan="3" data-label="Session">COFFEE BREAK</td>
                                        </tr>
                                        <tr>
                                            <td data-label="Time">3:10 PM - 3:55 PM</td>
                                            <td data-label="Session Title">
                                                Sprint Presentations + Panel Session<br>
                                                <small><em>Transformative Approaches to Food Waste Management</em></small>
                                            </td>
                                            <td data-label="Brief Description">This session will focus on the environmental
                                                impacts of waste, identifying measures to responsibly manage plastic and
                                                food waste in households and communities.</td>
                                            <td data-label="Speakers">
                                                <strong>Presenter/Moderator:</strong><br>Dr. Marlon de Luna
                                                Era<br><small><em>President, Solid Waste Management Association of the
                                                        Philippines (SWAPP)</em></small><br>
                                                <strong>Panelists:</strong>
                                                <ul>
                                                    <li>Peter Damary<br><small><em>Founder, LimaDOL</em></small></li>
                                                    <li>Coleen Awit<br><small><em>Chief Operating Officer, Sagup
                                                                Negros</em></small></li>
                                                    <li>Adrian Bonifacio<br><small><em>Director of Impact and Operations,
                                                                ARK Solves</em></small></li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-label="Time">4:10 PM - 4:55 PM</td>
                                            <td data-label="Session Title">
                                                Sprint Presentations + Panel Session<br>
                                                <small><em>Taking Action: Social Enterprises on Consumer Education and
                                                        Engagement</em></small>
                                            </td>
                                            <td data-label="Brief Description">The session will identify roles of social
                                                enterprises in transforming the food industry. Delegates will learn
                                                practical strategies to engage consumers and encourage them to adopt more
                                                conscientious practices.</td>
                                            <td data-label="Speakers">
                                                <strong>Moderator: </strong><br>Mari De Leon<br>
                                                <strong>Presenters/Panelists:</strong>
                                                <ul>
                                                    <li>Moncini Hinay<br><small><em>Founder, Kids Who Farm</em></small></li>
                                                    <li>Hubert Cortes<br><small><em>Executive Director, Bayan Innovation
                                                                Group</em></small></li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-label="Time">5:00 PM - 5:15 PM</td>
                                            <td data-label="Session Title">Consumer Track Synthesis + Closing Remarks</td>
                                            <td data-label="Brief Description">The speaker will summarize significant
                                                points from the consumer track and deliver the event's closing remarks.</td>
                                            <td data-label="Speakers">
                                                <strong>Host - Mari De Leon</strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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
                            <li>Trade Purchasers/Buyers</li>
                            <li>Policymakers</li>
                            <li>Non-government Organizations</li>
                            <li>Academia</li>
                            <li>Sustainability Advocates</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="row text-center button">
                        <div class="col-12 button d-flex justify-content-center mb-0">
                            <p>Ready to shape a sustainable food future?</p>
                        </div>

                        <div class="col-12 button d-flex justify-content-center">
                            <a href="https://sustainability.ph/conference/registration" class="btn ">REGISTER NOW</a>
                        </div>
                    </div> -->
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

            <div class="col-3 col-sm-12 speaker">
                <span>
                    <img src="/assets/show-info_2025/SSX SPEAKER POSTER_Baleta_NF.png" alt="">
                </span>
            </div>

            <div class="col-3 col-sm-12 speaker">
                <span>
                    <img src="/assets/show-info_2025/DR. MARLON.png" alt="">
                </span>
            </div>

            <div class="col-3 col-sm-12 speaker">
                <span>
                    <img src="/assets/show-info_2025/SSX SPEAKER POSTER_ACE_ESTRADA.png" alt="">
                </span>
            </div>

            <div class="col-3 col-sm-12 speaker">
                <span>
                    <img src="/assets/show-info_2025/SSX SPEAKER POSTER_CARLOMAGNO_AGUILAR.png" alt="">
                </span>
            </div>

            <div class="col-3 col-sm-12 speaker">
                <span>
                    <img src="/assets/show-info_2025/SSX SPEAKER POSTER_CHEF CASTILLO.png" alt="">
                </span>
            </div>

            <div class="col-3 col-sm-12 speaker">
                <span>
                    <img src="/assets/show-info_2025/SSX SPEAKER POSTER_COLEEN_AWIT.png" alt="">
                </span>
            </div>

            <div class="col-3 col-sm-12 speaker">
                <span>
                    <img src="/assets/show-info_2025/SSX SPEAKER POSTER_ELVIN_UY.png" alt="">
                </span>
            </div>

            <div class="col-3 col-sm-12 speaker">
                <span>
                    <img src="/assets/show-info_2025/SSX SPEAKER POSTER_GEORGE_INOCENCIO.png" alt="">
                </span>
            </div>

            <div class="col-3 col-sm-12 speaker">
                <span>
                    <img src="/assets/show-info_2025/SSX SPEAKER POSTER_LEAH_BUENDIA.png" alt="">
                </span>
            </div>

            <div class="col-3 col-sm-12 speaker">
                <span>
                    <img src="/assets/show-info_2025/SSX SPEAKER POSTER_LUIS_SANTIAGO.png" alt="">
                </span>
            </div>

            <div class="col-3 col-sm-12 speaker">
                <span>
                    <img src="/assets/show-info_2025/SSX SPEAKER POSTER_MARIA_PRESSACO.png" alt="">
                </span>
            </div>

            <div class="col-3 col-sm-12 speaker">
                <span>
                    <img src="/assets/show-info_2025/SSX SPEAKER POSTER_MARK_CASTILLO.png" alt="">
                </span>
            </div>

            <div class="col-3 col-sm-12 speaker">
                <span>
                    <img src="/assets/show-info_2025/SSX SPEAKER POSTER_MYRTLE_SOLINA.png" alt="">
                </span>
            </div>

            <div class="col-3 col-sm-12 speaker">
                <span>
                    <img src="/assets/show-info_2025/SSX SPEAKER POSTER_NIKKI_CAAMPUED.png" alt="">
                </span>
            </div>

            <div class="col-3 col-sm-12 speaker">
                <span>
                    <img src="/assets/show-info_2025/SSX SPEAKER POSTER_RAMI_HOURANI.png" alt="">
                </span>
            </div>

            <div class="col-3 col-sm-12 speaker">
                <span>
                    <img src="/assets/show-info_2025/SSX SPEAKER POSTER_RAYMUND_AARON.png" alt="">
                </span>
            </div>

            <div class="col-3 col-sm-12 speaker">
                <span>
                    <img src="/assets/show-info_2025/SSX SPEAKER POSTER_SELVA_RAMACHANDRAN.png" alt="">
                </span>
            </div>

            <div class="col-3 col-sm-12 speaker">
                <span>
                    <img src="/assets/show-info_2025/SSX SPEAKER POSTER_SHORALIAH MACALBE.png" alt="">
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
            {{-- 
            <div class="col-12 text-center mt-5 coming-soon">
                <p><em>Full Speaker Lineup Coming Soon</em></p>
            </div> --}}

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

            <!-- <div class="row">
                            <div class="col-12 button d-flex justify-content-center">

                                <a href="https://sustainability.ph/conference/registration" class="btn ">REGISTER NOW</a>
                            </div>
                        </div> -->
    </section>

    <section class="container py-5 text-success">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6 my-2">
                    <h2>
                        Getting to the SSX Conference: Philippine Trade Training Center
                    </h2>
                    <p>
                        We look forward to welcoming you to the conference segment of the Sustainability Solutions Exchange
                        (SSX) on <b>May 22-23, 2025</b>. All conference sessions will take place at the <b>Philippine Trade
                            Training Center (PTTC)</b> in Pasay City.
                        <br><br>
                        To help you plan your visit, please use the interactive Google Map below.
                    </p>
                    <p>
                        <b>Address:</b>
                        <br>Philippine Trade Training Center (PTTC)
                        <br>PTTC Building, Sen. Gil J. Puyat Ave. cor. Roxas Blvd., Pasay City, 1300
                    </p>
                    <div>

                    </div>
                </div>
                <div class="col-12 col-lg-6 my-2">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3861.8349662850133!2d120.98370172988041!3d14.551428349537677!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c961c25dd769%3A0x9b9b0028d7e90560!2sPhilippine%20Trade%20Training%20Center%20-%20Global%20MSME%20Academy!5e0!3m2!1sen!2sph!4v1747386177984!5m2!1sen!2sph"
                        width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12 col-lg-6 my-2">
                    <h2>
                        Navigating the SSX Hub: Exhibition & Business Matching at World Trade Center Metro Manila
                    </h2>
                    <p>
                        The vibrant Sustainability Solutions Exchange (SSX) Exhibition and the dynamic Business Matching &
                        Pitching Sessions will be hosted at the World Trade Center Metro Manila (WTCMM).
                        <br><br>
                        To help you plan your visit, please use the interactive Google Map below.
                    </p>
                    <p>
                        <b>Address:</b>
                        <br>World Trade Center Metro Manila
                        <br>WTCMM Building, Sen. Gil J. Puyat Ave. cor. Diosdado Macapagal Blvd., Pasay City, 1300, Metro
                        Manila
                    </p>
                </div>
                <div class="col-12 col-lg-6 my-2">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3861.8420776089865!2d120.98463231283407!3d14.551021885870774!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397cbdf7dba6b55%3A0x20a3c896a2fc6c69!2sWorld%20Trade%20Center%20Metro%20Manila!5e0!3m2!1sen!2sph!4v1747386606421!5m2!1sen!2sph"
                        width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
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
        <div class="row ">
            <div class="col-12 headings co-presented-title">
                <span>
                    <h2>SSX CO-PRESENTED BY:</h2>
                </span>
            </div>
        </div>
        <div class="co-presented justify-content-center d-flex flex-column">

            <div class="d-flex flex-row justify-content-center gg-eu-denr">
                <div>
                    <img class="gg-co-funded-by-eu-logo" src="/assets/show-info_2025/gg-co-funded-by-eu-logo.png"
                        alt="">
                </div>
                <div>
                    <img class="denr-logo" src="/assets/show-info_2025/denr-logo.png" alt="">
                </div>
            </div>
            <div>
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
            <div>
                <img class="giz-logo" src="/assets/show-info_2025/giz-logo.png" alt="">
            </div>
            <div>
                <img class="expertise-france-logo" src="/assets/show-info_2025/expertise-france-logo.png" alt="">
            </div>
            {{-- <div >
<img class="gggi-logo" src="/assets/show-info_2025/gggi-logo.png" alt="">
</div> --}}
        </div>
        <div class="justify-content-center mt-4 px-4 program-partners-holder">
            <div class="row ">
                <div class="col-12 headings co-organize-title">
                    <span>
                        <h2>PROGRAM PARTNERS:</h2>
                    </span>
                </div>
            </div>
            <img class="mx-4 mb-3" src="/assets/show-info_2025/da.png" alt="">
            <img class="mx-4 mb-3" src="/assets/show-info_2025/denr-logo.png" alt="">
            <img class="mx-4 mb-3" src="/assets/show-info_2025/dost.png" alt="">
            <img class="mx-4 mb-3" src="/assets/show-info_2025/dti.png" alt="">
            <img class="mx-4 mb-3" src="/assets/show-info_2025/up-cifal.png" alt="">
        </div>
    </section>
    <section class=" text-center partner-section">

        <div class="partners-container justify-content-center d-flex flex-column">

            <div
                class="d-flex flex-column flex-md-column flex-lg-column flex-xl-row justify-content-center align-items-center  align-items-lg-center align-items-xl-start">
                <div class="col-12 col-md-12 col-lg-12 col-xl-4">
                    <h2>TRAINING AND EVENT PARTNER</h2>
                    <div><img class="pttc_logo" src="/assets/show-info_2025/pttc_logo.png" alt=""></div>
                </div>
                <div class="col-12 col-md-12 col-lg-12 col-xl-4">
                    <h2>OFFICIAL MOBILITY PARTNER</h2>
                    <div><img class="fmc_logo" src="/assets/show-info_2025/fmc_logo.png" alt=""></div>
                </div>
                <div class="col-12 col-md-12 col-lg-12 col-xl-4 partner-container">
                    <h2>EVENT PARTNERS</h2>
                    <div class="d-flex flex-column">
                        <div>
                            <img class="m-3" style="height: 90px" src="/assets/show-info_2025/oikos_logo.png"
                                alt="">
                            <img class="m-3" style="height: 90px" src="/assets/show-info_2025/unisol_logo.png"
                                alt="">
                            <img class="m-3" style="height: 150px" src="/assets/show-info_2025/ffcci.png"
                                alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="bss-container">
                <h2>BUSINESS SOLUTIONS SERVICES (BSS) PARTNERS</h2>
                <div
                    class="bss-logos d-flex flex-column flex-md-column flex-lg-column flex-xl-row justify-content-center align-items-center  align-items-lg-center align-items-xl-center gap-5">
                    <div><img class="sunlife_logo" src="/assets/show-info_2025/sun_life_logo.png" alt=""></div>
                    <div><img class="water_ph_logo" src="/assets/show-info_2025/waters_philippines_logo.png"
                            alt=""></div>
                    <div><img class="phl_post_logo" src="/assets/show-info_2025/phl_post_logo.png" alt=""></div>
                    <div><img class="air_speed_logo" src="/assets/show-info_2025/air_speed_logo.png" alt="">
                    </div>
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

        .coming-soon p {

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

        .program-partners-holder img {
            height: 100px
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

        /* Custom CSS for stackable tables on mobile */
        @media (max-width: 767.98px) {
            .table-stackable thead {
                display: none;
                /* Hide table headers on mobile */
            }

            .table-stackable tbody,
            .table-stackable tr,
            .table-stackable td {
                display: block;
                width: 100%;
            }

            .table-stackable tr {
                margin-bottom: 1rem;
                border-bottom: 2px solid #dee2e6;
                /* Add separation between stacked rows */
            }

            .table-stackable td {
                text-align: left;
                /* Align content to the right */
                padding-left: 45%;
                /* Create space for the label */
                position: relative;
                border-bottom: 1px solid #f0f0f0;
                /* Light border for cells */
            }

            .table-stackable td:last-child {
                border-bottom: none;
            }

            .table-stackable td::before {
                content: attr(data-label);
                /* Get content from data-label attribute */
                position: absolute;
                left: 0.5rem;
                /* Adjust as needed */
                width: calc(50% - 1rem);
                /* Adjust as needed */
                padding-right: 0.5rem;
                /* Adjust as needed */
                font-weight: bold;
                text-align: left;
                white-space: nowrap;
            }

            /* Handle colspan for stacked cells */
            .table-stackable td[colspan="3"] {
                text-align: left;
                /* Center or left align full-width cells */
                padding-left: 0.5rem;
            }

            .table-stackable td[colspan="3"]::before {
                display: none;
                /* No label needed for full-width special cells */
            }

            .accordion-body {
                padding: 0.5rem;
                /* Reduce padding on mobile for accordion body */
            }
        }

        /* General styling for accordion headers */
        .accordion-button h3 {
            font-size: 1.25rem;
            /* Adjust h3 size within button */
            margin-bottom: 0;
        }

        .accordion-button .fs-5 {
            font-size: 0.9rem !important;
            /* Adjust date line size */
            display: block;
            width: 100%;
        }

        .accordion-button {
            flex-direction: column;
            align-items: flex-start;
        }

        .accordion-button:not(.collapsed) {
            background-color: #FAFAEA
        }

        .accordion-button,
        .accordion-button:focus {
            border: #367938 2px solid;
            box-shadow: none
        }

        tr>td:first-child {
            min-width: 200px
        }

        tr>td:nth-child(2) {
            font-weight: bold
        }

        .card-outline {
            padding: 0px 35px 35px 35px;
        }

        .card {
            background: #FAFAEA 0% 0% no-repeat padding-box;
            box-shadow: 8px 8px 0px #00000029;
            /* border: 2px solid #367938; */
            border-radius: 40px;
            padding: 25px 50px 50px 50px;
            display: block;
            height: 100% !important;
        }


        .card-2 {
            background: #FAFAEA 0% 0% no-repeat padding-box;
            box-shadow: 8px 8px 0px #00000029;
            /* border: 2px solid #367938; */
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
            /* border: 2px solid #367938; */
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

            .coming-soon p {
                font-size: 16px !important;
                color: #21693c !important;
            }

            .shape {
                padding: 24px 12px !important;
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
                /* font-size: 24px; */
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

            .p-small {
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

        .slide-two {
            background: url('/assets/show-info_2025/mobile_small.png') center center / cover no-repeat;
        }

        .slide-three {
            background: url('/assets/show-info_2025/mobile_small_slide_3.png') center center / cover no-repeat;
        }

        .denr-logo {
            margin-top: 0px;
            height: 50px;
            width: 50px;
        }

        .gg-co-funded-by-eu-logo {
            margin-top: 0px;
            height: 50px;
            width: 280px;
        }

        .bmwk-iki-logo {
            height: 80px;
            width: 330px;
        }

        .co-presented {
            gap: 10px;
            display: flex;
            flex-direction: column;
        }

        .giz-logo {
            height: 50px;
            width: 50px;
        }

        .expertise-france-logo {
            width: 120px;
            height: 40px;
        }

        /* .gggi-logo{
                        height: 50px;
                        width: 130px;
                    } */

        .co-presented-title {
            margin-top: 0px;
        }

        .co-organize-title {
            margin-top: 60px;
        }

        .co-organize {

            gap: 30px;
            display: flex;
            flex-direction: row;
        }

        .co-section {
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
            width: auto !important;

        }

        .speaker img {
            width: 320px;
            /* margin-right: 30px; */
            object-fit: cover;
            border-radius: 10%;

        }

        .carousel-inner {
            padding: 0px !important;
        }

        .gg-eu-denr {
            gap: 20px;
        }

        .day {
            margin-bottom: 0px !important;
        }

        .partner-section .pttc_logo {
            height: 180px;
        }

        .partner-section .fmc_logo {
            width: 220px;
            padding-top: 30px;
        }

        .partner-section .oikos_logo {
            width: 280px;
        }

        .partner-section .unisol_logo {
            width: 285px;
        }

        .partner-section .sunlife_logo {
            width: 285px;

            margin-right: 20px;
        }

        .partner-section .water_ph_logo {
            width: 285px;
            margin-right: 20px;
            margin-left: 20px;
        }

        .partner-section .phl_post_logo {
            height: 75px;
        }

        .partner-section .air_speed_logo {
            height: 130px;
        }



        .partners-container h2 {
            font-size: 26px;
            color: #367938;
            margin-top: 70px;
        }

        .partner-section {
            background-color: #FAFAEA;
            padding-bottom: 70px;
        }

        /* Small devices (landscape phones, 576px and up) */
        @media (min-width: 576px) and (max-width: 767.98px) {

            .parallax {
                height: 700px;
            }

            .slide-two {
                background: url('/assets/show-info_2025/mobile_medium.png') center center / cover no-repeat;
            }

            .slide-three {
                background: url('/assets/show-info_2025/mobile_medium_slide_3.png') center center / cover no-repeat;
            }

            .denr-logo {
                margin-top: 0px;
                height: 80px;
                width: 80px;
            }

            .gg-co-funded-by-eu-logo {
                margin-top: 0px;
                height: 80px;
                width: 400px;
            }

            .bmwk-iki-logo {
                height: 120px;
                width: 470px;
            }

            .co-presented-title {
                margin-top: 0px;
            }

            .co-organize-title {
                margin-top: 70px;
            }

            .giz-logo {
                height: 70px;
                width: 70px;
            }

            .expertise-france-logo {
                width: 180px;
                height: 65px;
            }

            /* .gggi-logo{
                        height: 70px;
                        width: 235px;
                    }  */
            .co-organize {
                gap: 30px;
            }

            .experts {
                padding: 60px 20px;
            }

            .speaker img {
                width: 250px;
            }

            .co-presented {
                gap: 20px;
            }

            .gg-eu-denr {
                gap: 20px;
            }

            .partners-container h2 {
                font-size: 30px;
                color: #367938;
                margin-top: 80px;
            }

            .partner-section .pttc_logo {
                height: 180px;
            }

            .partner-section .fmc_logo {
                width: 220px;
                padding-top: 30px;
            }

            .partner-section .oikos_logo {
                width: 280px;
            }

            .partner-section .unisol_logo {
                width: 285px;
            }

            .partner-section .sunlife_logo {
                width: 285px;
                margin-top: 30px;
                margin-right: 20px;
            }

            .partner-section .water_ph_logo {
                width: 285px;
                margin-right: 20px;
                margin-left: 20px;
            }

            .partner-section .phl_post_logo {
                height: 75px;
            }

            .partner-section .air_speed_logo {
                height: 130px;
            }
        }

        /* Medium devices (tablets, 768px and up) */
        @media (min-width: 768px) and (max-width: 991.98px) {

            .parallax {
                height: 500px;
            }

            .slide-two {
                background: url('/assets/show-info_2025/tablet.png') center center / cover no-repeat;
            }

            .slide-three {
                background: url('/assets/show-info_2025/tablet_slide_3.png') center center / cover no-repeat;
            }

            .co-presented {
                gap: 10px;
            }

            .denr-logo {
                margin-top: 5px;
                height: 80px;
                width: 80px;
            }

            .gg-co-funded-by-eu-logo {
                margin-top: 0px;
                height: 80px;
                width: 420px;
            }

            .bmwk-iki-logo {
                height: 130px;
                width: 530px;
            }

            .co-presented-title {
                margin-top: 0px;
            }

            .co-organize-title {
                margin-top: 70px;
            }

            /* .co-organize{
                        gap: 24px;
                        display: flex;
                        flex-direction: row;
                    } */

            .giz-logo {
                height: 70px;
                width: 70px;
            }

            .expertise-france-logo {
                width: 210px;
                height: 60px;
            }

            /* .gggi-logo{
                        height: 70px;
                        width: 235px;
                    }  */
            .co-organize {
                gap: 30px;
                display: flex;
                flex-direction: row;
            }

            .experts {
                padding: 60px 50px;
            }

            .gg-eu-denr {
                gap: 30px;
            }

            .partners-container h2 {
                font-size: 32px;
                color: #367938;
                margin-top: 80px;

            }

            .partner-section .pttc_logo {
                height: 180px;
            }

            .partner-section .fmc_logo {
                width: 220px;
                padding-top: 30px;
            }

            .partner-section .oikos_logo {
                width: 280px;
            }

            .partner-section .unisol_logo {
                width: 285px;
            }

            .partner-section .sunlife_logo {
                width: 285px;
                margin-top: 30px;
                margin-right: 20px;
            }

            .partner-section .water_ph_logo {
                width: 285px;
                margin-right: 20px;
                margin-left: 20px;
            }

            .partner-section .phl_post_logo {
                height: 75px;
            }

            .partner-section .air_speed_logo {
                height: 130px;
            }
        }

        /* Large devices (desktops, 992px and up) */
        @media (min-width: 992px) and (max-width: 1199.98px) {
            .parallax {
                height: 500px;
            }

            .slide-two {
                background: url('/assets/show-info_2025/large_screen.png') center center / cover no-repeat;
            }

            .slide-three {
                background: url('/assets/show-info_2025/large_screen_slide_3.png') center center / cover no-repeat;
            }


            .co-presented {
                gap: 0px;
            }

            .denr-logo {
                margin-top: 5px;
                height: 100px;
                width: 100px;
            }

            .gg-co-funded-by-eu-logo {
                margin-top: 0px;
                height: 100px;
                width: 500px;
            }

            .bmwk-iki-logo {
                height: 160px;
                width: 660px;
            }

            .co-presented-title {
                margin-top: 0px;
            }

            .co-organize-title {
                margin-top: 70px;
            }

            .giz-logo {
                height: 80px;
                width: 80px;
            }

            .expertise-france-logo {
                width: 240px;
                height: 70px;
            }

            /* .gggi-logo{
                        height: 70px;
                        width: 240px;
                    }  */
            .co-organize {
                gap: 30px;
                display: flex;
                flex-direction: row;
            }

            .experts {

                padding: 60px 20px !important;
            }

            .gg-eu-denr {
                gap: 30px;
            }

            .partner-section .pttc_logo {
                margin-top: 30px;
                height: 200px;
            }

            .partner-section .fmc_logo {
                width: 220px;
                padding-top: 30px;
            }

            .partner-section .unisol_logo {
                width: 300px;
            }

            .partner-section .oikos_logo {
                width: 300px;
            }

            .partner-container>div {
                padding-top: 30px;
                gap: 25px;
            }

            .partner-section .water_ph_logo {
                width: 280px;
                margin-right: 20px;
                margin-left: 20px;
            }

            .partner-section .phl_post_logo {
                height: 95px;
            }

            .partner-section .air_speed_logo {
                height: 150px;
            }

            .partner-section .sunlife_logo {
                margin-top: 30px;
                width: 300px;
                /* margin-right: 20px; */
            }

            .partners-container h2 {
                margin-top: 80px;
                font-size: 40px;
                color: #367938;
            }
        }

        /* Extra large devices (large desktops, 1200px and up) */
        @media (min-width: 1200px) and (max-width: 1399.98px) {
            .parallax {
                height: 500px;
            }

            .slide-two {
                background: url('/assets/show-info_2025/large_screen.png') center center / cover no-repeat;
            }

            .slide-three {
                background: url('/assets/show-info_2025/large_screen_slide_3.png') center center / cover no-repeat;
            }

            .denr-logo {
                margin-top: 35px;
                height: 90px;
                width: 90px;
            }

            .gg-co-funded-by-eu-logo {
                margin-top: 15px;
                height: 100px;
                width: 470px;
            }

            .bmwk-iki-logo {
                /* margin-top: 17px; */
                height: 150px;
                width: 590px;
            }

            .co-presented {
                gap: 0px;
                display: flex;
                flex-direction: row;
            }

            .co-presented-title {
                margin-top: 0px;
            }

            .co-organize-title {
                margin-top: 70px;
            }

            .giz-logo {
                height: 80px;
                width: 80px;
            }

            .expertise-france-logo {
                width: 220px;
                height: 70px;
            }

            /*
                    .gggi-logo{
                        height: 70px;
                        width: 240px;
                    }  */
            .co-organize {
                gap: 30px;
                display: flex;
                flex-direction: row;
            }

            .experts {
                padding: 60px 100px !important;
            }

            .gg-eu-denr {
                gap: 30px;
            }

            .partner-section .pttc_logo {
                margin-top: 30px;
                height: 170px;
            }

            .partner-section .fmc_logo {
                width: 210px;
                padding-top: 30px;
            }

            .partner-section .unisol_logo {
                width: 230px;
            }

            .partner-section .oikos_logo {
                width: 240px;
            }

            .partner-container>div {
                padding-top: 30px;
                gap: 25px;
            }

            .partner-section .water_ph_logo {
                width: 240px;
                margin-right: 20px;
                margin-left: 20px;
            }

            .partner-section .phl_post_logo {
                height: 75px;
                margin-right: 20px;
            }

            .partner-section .air_speed_logo {
                height: 120px;
            }

            .partner-section .sunlife_logo {
                width: 270px;
                margin-right: 20px;
                margin-top: 0px;
            }

            .bss-container {
                margin-top: 70px;
            }

            .partner-section .sunlife_logo {
                width: 270px;
                margin-right: 0px;
                /* margin-right: 20px; */
            }
        }

        /* XXL devices (very large desktops) */
        @media (min-width: 1400px) {
            .parallax {
                height: 700px;
            }

            .slide-two {
                background: url('/assets/show-info_2025/large_screen.png') center center / cover no-repeat;
            }

            .slide-three {
                background: url('/assets/show-info_2025/large_screen_slide_3.png') center center / cover no-repeat;
            }

            .denr-logo {
                margin-top: 15px;
                height: 110px;
                width: 110px;
            }

            .gg-co-funded-by-eu-logo {
                margin-top: 0px;
                height: 120px;
                width: 570px;
            }

            .bmwk-iki-logo {
                /* margin-top: 18px; */
                height: 160px;
                width: 590px;
            }

            .co-presented {
                gap: 24px;
                display: flex;
                flex-direction: row;
            }

            /* .co-presented {
                        gap: 70px;
                    } */

            .giz-logo {
                height: 80px;
                width: 80px;
            }

            .expertise-france-logo {
                width: 240px;
                height: 80px;
            }

            /* .gggi-logo{
                        height: 80px;
                        width: 250px;
                    } */
            .co-presented-title {
                margin-top: 0px;
            }

            .co-organize-title {
                margin-top: 70px;
            }

            .co-organize {
                padding-top: 30px;
                gap: 70px;
                display: flex;
                flex-direction: row;
            }

            .experts {
                padding: 60px 100px !important;
            }

            .gg-eu-denr {
                gap: 45px;
            }

            .partner-section .pttc_logo {
                margin-top: 30px;
                height: 210px;
            }

            .partner-section .fmc_logo {
                width: 270px;
                padding-top: 30px;
            }

            .partner-section .unisol_logo {

                width: 300px;
            }

            .partner-section .oikos_logo {
                width: 300px;
            }

            .partner-container>div {
                padding-top: 30px;
                gap: 25px;
            }

            .partner-section .water_ph_logo {
                width: 300px;
                margin-right: 20px;
                margin-left: 20px;
            }

            .partner-section .phl_post_logo {
                height: 100px;
                margin-right: 40px;
            }

            .partner-section .air_speed_logo {
                height: 150px;
            }

            .partner-section .sunlife_logo {
                width: 320px;
                margin-right: 20px;
            }

            .partners-container h2 {
                font-size: 26px;
                color: #367938;
            }

            .bss-container .bss-logos {
                margin-top: 30px;
            }

            .bss-container {
                margin-top: 50px;
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
