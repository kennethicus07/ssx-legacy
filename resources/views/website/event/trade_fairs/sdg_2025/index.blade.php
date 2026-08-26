@extends('layouts.website')

@section('content')
    <section class="event-hero-section d-flex align-items-center text-white">
        <div class="container event-hero-content my-4 px-5">
            <div class="row">
                <!-- First Image -->
                <div class="col-12 px-5 mb-3 text-center">
                    <img src="{{ asset('assets/sgd_taipei_2025/SSX_SDG ASIA.png') }}" alt="Image 1" class="img-fluid">
                </div>

                <!-- Paragraph -->
                <div class="col-12 mb-3 text-center">
                    <p style="color: #eeab2a;  ">
                        Market sensing for a more inclusive <br> and resilient future.

                    </p>
                </div>

                <!-- Second Image -->
                <div style="padding: 0px 70px 0px 70px;" class="col-12 mb-3 text-center">
                    <img src="{{ asset('assets/sgd_taipei_2025/SDG ASIA 2.png') }}" alt="Image 2" class="img-fluid">
                </div>

                <!-- Third Image -->
                <div class="col-12 px-5 text-center">
                    <img src="{{ asset('assets/sgd_taipei_2025/date_SDG ASIA.png') }}" alt="Image 3" class="img-fluid">
                </div>
            </div>
        </div>

    </section>
    {{-- Mission Section --}}
    <section class="mission-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4">
                    <img class="img-fluid custom-img" src="{{ asset('assets/sgd_taipei_2025/sdgasia.png') }}"
                        alt="">
                </div>
                <div class="col-lg-8">
                    <h2 class="mb-4">Strategic Market Sensing Mission to Taiwan</h2>
                    <p>
                        The Department of Trade and Industry’s (DTI) Center for International Trade Expositions and Missions
                        (CITEM) is leading a strategic market sensing mission to Taiwan to learn about today’s global
                        benchmarks
                        in future-proofing industries, including at <strong>SDG Asia 2025</strong> happening on
                        <strong>September 11-13, 2025</strong> at the Taipei World Trade Center.
                    </p>
                    <p>
                        This mission aims to gather crucial insights on the latest business models, innovations, and
                        technologies
                        in key sectors, such as food systems, smart cities, and the circular economy.
                    </p>

                    <h3 class="mt-4">Mission Objectives</h3>
                    <ul class="lh-sm">
                        <li>
                            <p class="mb-1 lh-sm">
                                Position Filipino enterprises as key players in the global sustainability landscape. </p>
                        </li>
                        <li>
                            <p class="mb-1 lh-sm"> Foster new partnerships and identify export growth opportunities.</p>
                        </li>
                        <li>
                            <p class="mb-1 lh-sm">
                                Promote Philippine products and services in sustainable and innovative sectors.</p>
                        </li>
                        <li>
                            <p>Reinforce the Philippines' commitment to achieving the UN Sustainable Development Goals
                                (SDGs).</p>
                        </li>
                    </ul>

                    <p>
                        This year’s engagement serves as a platform to promote next year’s
                        <strong>Sustainability Solutions Exchange (SSX) Conference and Exhibition</strong> to be held at the
                        Philippine Trade Training Center, Pasay City, Philippines, simultaneous with the 19th edition of
                        IFEX Philippines 2026 on <strong>May 21-23, 2026</strong> at the World Trade Center Metro Manila.
                    </p>

                    <p>
                        Taiwan is a leading proponent of sustainability, with demonstrated expertise in renewable energy,
                        energy-efficient buildings, and waste management. The country is also actively working towards a
                        net-zero emissions target by 2050 and shares its knowledge in disaster preparedness and climate
                        adaptation, making it an ideal partner for this mission.
                    </p>

                    <p>
                        CITEM, as the export promotion arm of the Philippine Department of Trade and Industry (DTI),
                        plays a crucial role in advancing the nation's sustainability agenda. CITEM's mandate to promote
                        Philippine products and services in the global market includes a special focus on sustainable and
                        innovative sectors, reflecting the country's broader commitment to the UN Sustainable Development
                        Goals (SDGs).
                    </p>

                    <p>
                        This is reinforced by the national government's efforts, which are guided by the
                        <strong>UN Sustainable Development Cooperation Framework (CF) 2024-2028</strong>. Through this
                        strategic
                        alignment with national and international frameworks, CITEM actively supports and nurtures micro,
                        small, and medium enterprises (MSMEs) in developing globally competitive, sustainable solutions and
                        products.
                    </p>

                    <p>
                        In fact, the SSX is one of CITEM’s signature programs that is the country’s first platform promoting
                        sustainable practices, resources, and technology to the world’s essential industries. SSX creates
                        avenues
                        for Philippine MSMEs and other businesses to continue or transition toward a circular economy.
                    </p>

                    <p>
                        The CITEM-led delegation is composed of 11 representatives from various sectors, including local
                        governments, industry associations, sustainability advocates, and green technology companies. Get to
                        know them here: <br><br> <a
                            href="{{ asset('assets/sgd_taipei_2025/DelegateDirectory_ SSX-SDG ASIA 2025.pdf') }}"
                            download="Lookbook_SSX-SDG_Asia_2025.pdf" class="btn ">
                            Download Lookbook
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </section>
    {{-- Delegate Directory --}}
    <section class="container ">
        <div class="">
            <h2 class="mb-4 fw-bold">Delegate Directory</h2>
            <div class="row g-4 d-flex justify-content-center">

                <!-- Card 1-->
                <div class="col-xl-6 col-md-6 col-12">
                    <div class="card  h-100 p-3">
                        <div class="row g-0 align-items-start">

                            <!-- Left Logo/Image -->
                            {{-- <div class="col-3 text-center ps-3 pt-3">
                                <!-- Logo / Image -->
                                <img src="https://picsum.photos/200/200" alt="DTI Caraga"
                                    class="img-fluid rounded-circle  w-100 h-100  mb-3">

                                <!-- Website Button -->
                                <a href="https://www.dti.gov.ph/dti-regions/dti-caraga" target="_blank"
                                    class="btn btn-warning btn-sm w-100">
                                    Read More
                                </a>
                            </div> --}}

                            <!-- Right Info -->
                            <div class="col-12">
                                <div class="card-body">
                                    <h4 class="card-title fw-bold">DTI Caraga Region<br>
                                        <small class="text-muted">DTI Surigao del Norte Provincial Office</small>
                                    </h4>
                                    <p class="card-text">
                                        Trabaho, Negosyo, Kabuhayan (Work, Business, and Livelihood)<br>
                                        Serving one of the five provinces of Caraga, DTI Surigao del Norte plays a critical
                                        role in providing strategic development support and sustainability efforts to over
                                        20,000 MSMEs in the region.
                                    </p>
                                    <p class="card-text">
                                        Through the Shared Service Facilities (SSF) program, MSMEs now have access to modern
                                        equipment and technology to enhance their growth potential. In 2024, 13 new SSF
                                        projects worth P169.47 million were approved.
                                    </p>

                                    <h6 class="fw-bold mt-3 mb-2 ">
                                        <i class="bi bi-person-lines-fill me-1"></i> Contacts
                                    </h6>
                                    <ul class="list-unstyled lh-sm">
                                        <li class="mb-2">
                                            <p class="mb-1 lh-sm">
                                                <span class="fw-bold">Gay A. Tidalgo</span> <br> Regional Director,
                                                DTI-Caraga
                                                <span class=" text-muted d-block">
                                                    <i class="bi bi-envelope-fill"></i><a
                                                        href="mailto:gaytidalgo@dti.gov.ph"
                                                        class="text-decoration-none text-muted">
                                                        gaytidalgo@dti.gov.ph
                                                    </a> <br>
                                                    <i class="bi bi-telephone-fill"></i>
                                                    <a href="tel:+639173049729" class="text-decoration-none text-muted">
                                                        +63 917 304 9729
                                                    </a>

                                                </span>
                                            </p>
                                        </li>

                                        <li class="mb-2">
                                            <p class="mb-1 lh-sm">
                                                <span class="fw-bold">Arnold D. Faelnar</span> <br> Provincial Director
                                                <span class=" text-muted d-block">
                                                    <i class="bi bi-envelope-fill"></i>
                                                    <a href="mailto:arnoldfaelnar@dti.gov.ph"
                                                        class="text-decoration-none text-muted">
                                                        arnoldfaelnar@dti.gov.ph
                                                    </a>
                                                    <br>
                                                    <i class="bi bi-telephone-fill"></i>
                                                    <a href="tel:+639177757070" class="text-decoration-none text-muted">
                                                        +63 917 775 7070
                                                    </a>

                                                </span>
                                            </p>
                                        </li>

                                        <li class="mb-2">
                                            <p class="mb-1 lh-sm">
                                                <span class="fw-bold">Gemma L. Clarin</span> <br> Acting Chief, Industry
                                                Development Division, DTI-Caraga
                                                <span class="text-muted d-block">
                                                    <i class="bi bi-envelope-fill"></i>
                                                    <a href="mailto:gemmaclarin@dti.gov.ph"
                                                        class="text-decoration-none text-muted">
                                                        gemmaclarin@dti.gov.ph
                                                    </a>
                                                    <br>
                                                    <i class="bi bi-telephone-fill"></i>
                                                    <a href="tel:+639989872791" class="text-decoration-none text-muted">
                                                        +63 998 987 2791
                                                    </a>
                                                </span>

                                            </p>
                                        </li>

                                        <li class="mb-0">
                                            <p class="mb-0 lh-sm">
                                                <span class="fw-bold">Elmer M. Natad</span> <br> Provincial Director,
                                                Dinagat
                                                Islands
                                                <span class="text-muted d-block">
                                                    <i class="bi bi-envelope-fill"></i>
                                                    <a href="mailto:elmernatad@dti.gov.ph"
                                                        class="text-decoration-none text-muted">
                                                        elmernatad@dti.gov.ph
                                                    </a>
                                                    <br>
                                                    <i class="bi bi-telephone-fill"></i>
                                                    <a href="tel:+639190943860" class="text-decoration-none text-muted">
                                                        +63 919 094 3860
                                                    </a>
                                                </span>

                                            </p>
                                        </li> <!-- Links -->
                                        <li class="mt-4">
                                            <h5 class="mb-0 lh-sm small text-muted fw-bold">
                                                <i class="bi bi-link-45deg "></i>
                                                <a href="https://www.dti.gov.ph/dti-regions/dti-caraga"
                                                    target="_blank">Learn More</a>
                                            </h5>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Card 1 -->

                <!-- Card 2-->
                <!-- Card: DTI Region 1 -->
                <div class="col-xl-6 col-md-6 col-12">
                    <div class="card h-100 p-3">
                        <div class="row g-0 align-items-start">

                            <!-- Right Info -->
                            <div class="col-12">
                                <div class="card-body">
                                    <h4 class="card-title fw-bold">DTI Region 1<br>
                                        <small class="text-muted">Trade Green, Trade Smart</small>
                                    </h4>
                                    <p class="card-text">
                                        The Department of Trade and Industry (DTI) Region 1 serves the provinces of Ilocos
                                        Norte, Ilocos Sur,
                                        La Union, and Pangasinan, and is an instrumental driver of inclusive growth and
                                        competitiveness in the region.
                                    </p>
                                    <p class="card-text">
                                        DTI Region 1 provides various key programs to enable communities to participate in
                                        an economy that is both
                                        profitable and sustainable. These include promotion of direct farm-to-market
                                        linkages to minimize carbon
                                        footprint in logistics and allow more inclusive growth for local farmers;
                                        strengthening of global
                                        competitiveness of local enterprises through high-quality, ethical, sustainable
                                        production processes and
                                        consumption while highlighting traditional crafts and cultural heritage; and skills
                                        and capacity-building
                                        initiatives that include trainings and mentorship programs for green design and
                                        entrepreneurship.
                                    </p>

                                    <h6 class="fw-bold mt-3 mb-2">
                                        <i class="bi bi-person-lines-fill me-1"></i> Contacts
                                    </h6>
                                    <ul class="list-unstyled lh-sm">
                                        <li class="mb-2">
                                            <p class="mb-1 lh-sm">
                                                <span class="fw-bold">Natalia B. Dalaten</span> <br> Acting Assistant
                                                Regional
                                                Director
                                            </p>
                                        </li>

                                        <li class="mb-2">
                                            <p class="mb-1 lh-sm">
                                                <span class="fw-bold">Amelia E. Galvez</span> <br> Provincial Director
                                            </p>
                                        </li>

                                        <li class="mb-2">
                                            <p class="mb-1 lh-sm  text-muted">
                                                <i class="bi bi-envelope-fill"></i>
                                                <a href="mailto:r01.pangasinan.dti.gov.ph"
                                                    class="text-decoration-none text-muted">
                                                    r01.pangasinan.dti.gov.ph
                                                </a> |
                                                <a href="mailto:r01.ilocosnorte@dti.gov.ph"
                                                    class="text-decoration-none text-muted">
                                                    r01.ilocosnorte@dti.gov.ph
                                                </a>
                                            </p>
                                        </li>

                                        <li class="mb-2">
                                            <p class="mb-1 lh-sm  text-muted">
                                                <i class="bi bi-telephone-fill"></i> <a href="tel:+639175111662"
                                                    class="text-decoration-none text-muted">
                                                    +63 917 511 1662
                                                </a> |
                                                <a href="tel:+639171683165" class="text-decoration-none text-muted">
                                                    +63 917 168 3165
                                                </a>
                                            </p>
                                        </li>


                                        <!-- Links -->
                                        <li class="mt-4">
                                            <h5 class="mb-0 lh-sm small text-muted fw-bold">
                                                <i class="bi bi-link-45deg "></i>
                                                <a href="https://www.facebook.com/DTI.Region1" target="_blank">Learn
                                                    More</a>
                                            </h5>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- /Card: DTI Region 1 -->

                <!-- /Card 2 -->

                <!-- Card 3 -->
                <!-- Municipality of Buguey, Cagayan -->
                <div class="col-xl-6 col-md-6 col-12 mb-4">
                    <div class="card h-100 p-3">
                        <div class="card-body">
                            <!-- Title & Subtitle -->
                            <h4 class="card-title fw-bold mb-1">
                                Municipality of Buguey, Cagayan
                            </h4>
                            <h6 class="text-muted mb-3">Resilient &amp; Food-Secure Buguey</h6>

                            <!-- Description -->
                            <p class="card-text">
                                The Municipality of Buguey, a coastal town in the province of Cagayan in Cagayan Valley,
                                is an agri-fishery and food-farm tourism hub in Northern Luzon, Philippines. It is committed
                                to sustainable rural development amidst constant ecological challenges through consistent
                                and proactive leadership, strong infrastructure, and managed ecosystems.
                            </p>

                            <p class="card-text">
                                Enhancing its reputation as the crab capital of North Luzon—a title formally declared in
                                2024
                                with a production of 45.78 metric tons of mud crab in 2023—the LGU also spearheaded
                                proposals
                                for an agri-processing center and fish post-harvest facilities to promote sustainable
                                agri-fishery product development and improve Buguey’s overall global competitiveness.
                            </p>

                            <p class="card-text">
                                With climate-resilient, eco-friendly practices that protect its rich marine and agricultural
                                resources, the LGU of Buguey is able to maintain economic strength and prosperity for its
                                people.
                            </p>

                            <!-- Contacts -->
                            <h6 class="fw-bold mt-3 mb-2">
                                <i class="bi bi-person-lines-fill me-1"></i> Contacts
                            </h6>
                            {{-- <ul class="list-unstyled">
                                <li class="mb-2">
                                    <span class="fw-bold">May Jocelyn Joan T. Lee, EnP</span><br>
                                    Municipal Planning and Development Coordinator<br>
                                    <small class="text-muted">
                                        <i class="bi bi-envelope-fill"></i> mpdcbuguey@gmail.com |
                                        <i class="bi bi-telephone-fill"></i> +63 915 618 1550
                                    </small>
                                </li>
                                <li>
                                    <span class="fw-bold">Sheryl Ann Alonzo, LPT</span><br>
                                    Agricultural Technologist<br>
                                    <small class="text-muted">
                                        <i class="bi bi-envelope-fill"></i> Sherish082@gmail.com | lgubuguey@ymail.com |
                                        <i class="bi bi-telephone-fill"></i> +63 938 763 0689
                                    </small>
                                </li>
                            </ul> --}}
                            <ul class="list-unstyled lh-sm">
                                <li class="mb-2">
                                    <p class="mb-1 lh-sm">
                                        <span class="fw-bold">May Jocelyn Joan T. Lee, EnP</span> <br> Municipal Planning
                                        and
                                        Development Coordinator
                                        <span class="text-muted d-block">
                                            <i class="bi bi-envelope-fill"></i>
                                            <a href="mailto:mpdcbuguey@gmail.com" class="text-decoration-none text-muted">
                                                mpdcbuguey@gmail.com
                                            </a>
                                            <br>
                                            <i class="bi bi-telephone-fill"></i>
                                            <a href="tel:+639156181550" class="text-decoration-none text-muted">
                                                +63 915 618 1550
                                            </a>
                                        </span>

                                    </p>
                                </li>

                                <li class="mb-2">
                                    <p class="mb-1 lh-sm">
                                        <span class="fw-bold">Sheryl Ann Alonzo, LPT</span> <br> Agricultural Technologist

                                        <span class="text-muted d-block">
                                            <i class="bi bi-envelope-fill"></i>
                                            <a href="mailto:sherish082@gmail.com" class="text-decoration-none text-muted">
                                                sherish082@gmail.com
                                            </a> |
                                            <a href="mailto:lgubuguey@ymail.com" class="text-decoration-none text-muted">
                                                lgubuguey@ymail.com
                                            </a>
                                            <br>
                                            <i class="bi bi-telephone-fill"></i>
                                            <a href="tel:+639387630689" class="text-decoration-none text-muted">
                                                +63 938 763 0689
                                            </a>
                                        </span>

                                    </p>
                                </li>



                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Card 3 -->

                <!-- Card 4 -->
                <div class="col-xl-6 col-md-6 col-12 mb-4">
                    <div class="card h-100 p-3">
                        <div class="card-body">
                            <!-- Title & Subtitle -->
                            <h4 class="card-title fw-bold mb-1">
                                Nutridense Food Manufacturing Corporation
                            </h4>
                            <h6 class="text-muted mb-3">More than food, it’s nutrition.</h6>

                            <!-- Description -->
                            <p class="card-text">
                                Nutridense Food Manufacturing Corporation is a producer of technology-based nutrition
                                products,
                                providing ready-to-eat (RTE) food essential for feeding programs and emergencies. The
                                company also
                                manufactures functional food ideal for diet-conscious and active individuals.
                            </p>

                            <p class="card-text">
                                A certified <strong>cGMP, HACCP, HALAL</strong> company, Nutridense continues to champion
                                innovation
                                in food technology. CEO Racky Doctor, with his strong leadership toward enterprise growth,
                                sustainability, and commitment to food security, has steered the company into excellence,
                                receiving the top accolade in the Medium Enterprise Category of the
                                <strong>2025 Presidential Awards for Outstanding MSMEs</strong>.
                            </p>

                            <p class="card-text">
                                Helping fight malnutrition and promote healthy living, Nutridense manufactures <strong>RIMO
                                    for kids</strong>,
                                a complementary line of food products made from rice and mongo (mung beans).
                            </p>

                            <!-- Contacts -->
                            <h6 class="fw-bold mt-3 mb-2">
                                <i class="bi bi-person-lines-fill me-1"></i> Contacts
                            </h6>
                            <ul class="list-unstyled lh-sm">
                                <li class="mb-2">
                                    <p class="mb-1 lh-sm">
                                        <span class="fw-bold">Racky D. Doctor</span> <br> CEO
                                        <span class="text-muted d-block">
                                            <i class="bi bi-envelope-fill"></i>
                                            <a href="mailto:racky_ddoctor@yahoo.com"
                                                class="text-decoration-none text-muted">
                                                racky_ddoctor@yahoo.com
                                            </a>
                                            <br>
                                            <i class="bi bi-telephone-fill"></i>
                                            <a href="tel:+63756008251" class="text-decoration-none text-muted">
                                                +63 75 600 8251
                                            </a> /
                                            <a href="tel:+639176878611" class="text-decoration-none text-muted">
                                                +63 917 687 8611
                                            </a>
                                        </span>

                                    </p>
                                </li>
                                <li>
                                    <p class="mb-1 lh-sm">
                                        <span class="fw-bold">Karl Victor C. Doctor</span> <br> Marketing Manager
                                        <span class="text-muted d-block">
                                            <i class="bi bi-envelope-fill"></i>
                                            <a href="mailto:nutridensefmc@yahoo.com.ph"
                                                class="text-decoration-none text-muted">
                                                nutridensefmc@yahoo.com.ph
                                            </a>
                                            <br>
                                            <i class="bi bi-telephone-fill"></i>
                                            <a href="tel:+639171060687" class="text-decoration-none text-muted">
                                                +63 917 106 0687
                                            </a>
                                        </span>

                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /Card 4-->

                <!--Card 5-->
                <div class="col-xl-6 col-md-6 col-12 mb-4">
                    <div class="card h-100 p-3">
                        <div class="card-body">
                            <!-- Title & Subtitle -->
                            <h4 class="card-title fw-bold mb-1">
                                Quezon City Small Business and Cooperatives Development and Promotions Office (QC-SBCDPO)
                            </h4>
                            <h6 class="text-muted mb-3">MSECs for inclusive growth</h6>

                            <!-- Description -->
                            <p class="card-text">
                                The Quezon City Small Business and Cooperatives Development and Promotions Office
                                (QC-SBCDPO) is mandated
                                to develop and promote micro, small enterprises and cooperatives (MSECs) in Quezon City by
                                initiating
                                and implementing programs, projects, and other support mechanisms in financing, marketing,
                                and training.
                            </p>

                            <p class="card-text">
                                QC-SBCDPO is committed to advancing sustainability by empowering MSECs through market and
                                mentorship initiatives,
                                and by fostering strong collaborations among the private sector and development
                                organizations.
                            </p>

                            <p class="card-text">
                                This commitment aligns with the Sustainable Development Goals (SDGs) of the United Nations
                                (UN),
                                particularly in promoting inclusive economic growth and sustainable development.
                            </p>

                            <!-- Contacts -->
                            <h6 class="fw-bold mt-3 mb-2">
                                <i class="bi bi-person-lines-fill me-1"></i> Contacts
                            </h6>
                            <ul class="list-unstyled lh-sm">
                                <li class="mb-2">
                                    <p class="mb-1 lh-sm">
                                        <span class="fw-bold">Paulo P. Borres</span> <br> Acting Division Chief | Market
                                        Specialist III
                                        <span class="text-muted d-block">
                                            <i class="bi bi-envelope-fill"></i>
                                            <a href="mailto:paulo.borres@quezoncity.gov.ph"
                                                class="text-decoration-none text-muted">
                                                paulo.borres@quezoncity.gov.ph
                                            </a>
                                            <br>
                                            <i class="bi bi-telephone-fill"></i>
                                            <a href="tel:+63289884242" class="text-decoration-none text-muted">
                                                +632 8988 4242
                                            </a> locals 8731, 8734, 8736 |
                                            <a href="tel:+639989609017" class="text-decoration-none text-muted">
                                                +63 998 960 9017
                                            </a>
                                        </span>

                                    </p>
                                </li>
                                <!-- Links -->
                                <li class="mt-4">
                                    <h5 class="mb-0 lh-sm small text-muted fw-bold">
                                        <i class="bi bi-link-45deg "></i>
                                        <a href="https://quezoncity.gov.ph/departments/small-business-and-cooperatives-devt-and-promotions-office/"
                                            target="_blank">Learn More</a>
                                    </h5>
                                </li>
                            </ul>



                        </div>
                    </div>
                </div>

                <!--/Card 5-->

            </div>
        </div>
    </section>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        .event-hero-section {
            background: url('{{ asset('assets/sgd_taipei_2025/1920x700_SDG ASIA BANNER.jpg') }}') no-repeat center center;
            background-size: cover;
            height: auto;
            /* let it be responsive */
            aspect-ratio: 1920 / 700;
            /* keeps proportion */
            position: relative;
        }

        .event-hero-content {
            display: none;
        }

        .custom-img {
            width: 100%;
            /* take full column width */
            aspect-ratio: 400 / 845;
            /* enforce 1:2 ratio */
            object-fit: cover;
            /* keeps image from stretching */

        }

        @media (max-width: 700px) {
            .event-hero-section {
                background: url('{{ asset('assets/sgd_taipei_2025/700x700_SDG ASIA BANNER.jpg') }}') no-repeat center center;
                background-size: cover;
                aspect-ratio: 700 / 700;
                height: auto;
                position: relative;
            }
        }

        @media (max-width: 991px) {
            .custom-img {
                display: none;
            }
        }

        @media(max-width: 500px) {
            .event-hero-content {
                display: block;
            }

            .event-hero-section {
                background: url('{{ asset('assets/sgd_taipei_2025/700x700_SDG ASIA 2.jpg') }}') no-repeat center center;
                background-size: cover;
                aspect-ratio: 700 / 700;
                height: auto;
                position: relative;
            }
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            color: #367938;
        }

        .btn {
            background-color: #367938;
            border: 3px solid #367938;
            color: #fff;
        }

        .btn:hover {
            background-color: white;
            border: 3px solid #367938;
            color: #367938;
        }
    </style>
@endpush
