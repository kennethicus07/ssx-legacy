@extends('layouts.website')

@section('content')
@php
$pillars = [
    ['title' => 'THE HABITAT PILLAR', 'subtitle' => 'Resources & Utilities', 'image' => 'https://elements-resized.envatousercontent.com/envato-dam-assets-production/EVA/TRX/f9/c1/f2/33/30/v1_E11/E11NJ7N.jpg?w=1600&cf_fit=scale-down&mark-alpha=18&mark=https%3A%2F%2Felements-assets.envato.com%2Fstatic%2Fwatermark4.png&q=85&format=auto&s=1287a8fd94d5542c6bfb01fd055f73a9d07f97cd33b65620458b8d23e660c337', 'color' => '#E3A72E', 'icon' => 'mdi:solar-power',
        'items' => ['Clean Energy','Water','Waste','Decarbonization','Carbon Capture','Water Recovery','Waste-to-Energy etc.']],
    ['title' => 'THE URBAN PILLAR', 'subtitle' => 'Built Environment', 'image' => 'https://elements-resized.envatousercontent.com/envato-dam-assets-production/EVA/TRX/b9/4a/c3/7c/34/v1_E10/E101FRBV.jpg?w=1600&cf_fit=scale-down&mark-alpha=18&mark=https%3A%2F%2Felements-assets.envato.com%2Fstatic%2Fwatermark4.png&q=85&format=auto&s=29db8bb135d38073159b889eb3748b6aec539dcdcac81c1b142d776f8e80b117', 'color' => '#2A7F8E', 'icon' => 'mdi:city-variant-outline',
        'items' => ['Smart Cities','Green Construction','Sustainable Interiors','Smart Grids','Green Interior Solutions','Sustainable Architecture','Urban Planning etc.']],
    ['title' => 'THE ENGINE PILLAR', 'subtitle' => 'Agri-Food & Bio-Tech', 'image' => 'https://elements-resized.envatousercontent.com/envato-dam-assets-production/EVA/TRX/76/f9/eb/91/06/v1_E11/E117RYY1.jpg?w=1600&cf_fit=scale-down&mark-alpha=18&mark=https%3A%2F%2Felements-assets.envato.com%2Fstatic%2Fwatermark4.png&q=85&format=auto&s=25f73d10af16d463e2b1419863c266143399071d2bef88110baa8a99d75aa70c', 'color' => '#6B8E3D', 'icon' => 'mdi:sprout-outline',
        'items' => ['Agri-Tech','Food Innovation','Manufacturing','Precision Farming','Alternative Proteins','Food R&D','Cold Chain','Sustainable Manufacturing etc.']],
    ['title' => 'THE RECOVERY PILLAR', 'subtitle' => 'Circular Economy and Materials', 'image' => 'https://elements-resized.envatousercontent.com/envato-dam-assets-production/EVA/TRX/6c/f7/fc/0b/c2/v1_E11/E11MP6Y.jpg?w=1600&cf_fit=scale-down&mark-alpha=18&mark=https%3A%2F%2Felements-assets.envato.com%2Fstatic%2Fwatermark4.png&q=85&format=auto&s=9bf516b65eee3fe3272c522ee3184be6b97850da1a68ec61d24956ea70575b4c', 'color' => '#B5652D', 'icon' => 'mdi:recycle-variant',
        'items' => ['Sustainable Packaging','Plastic Alternatives','Lifestyle Design','Biomaterials etc.']],
    ['title' => 'THE STEWARD PILLAR', 'subtitle' => 'Governance, Finance and Policy', 'image' => 'https://elements-resized.envatousercontent.com/envato-dam-assets-production/EVA/TRX/e6/ec/0d/08/fd/v1_E10/E10CG85.jpg?w=1600&cf_fit=scale-down&mark-alpha=18&mark=https%3A%2F%2Felements-assets.envato.com%2Fstatic%2Fwatermark4.png&q=85&format=auto&s=60624bf971d2ce3d5b4132c60af4201513aacb13a0c36e44d11570c8361fa53d', 'color' => '#5C6B5E', 'icon' => 'mdi:bank-outline',
        'items' => ['Green Finance','ESG','Certifiers','Scalable R&D Programs','Academe and Government collaboration etc.']],
];



$stats = [
    ['icon' => 'mdi:storefront-outline', 'color' => '#E3A72E', 'label' => 'Exhibitors', 'y2022' => '165 Exhibitors', 'y2025' => '95 Exhibitors'],
    ['icon' => 'mdi:account-group-outline', 'color' => '#2A7F8E', 'label' => 'Delegates', 'y2022' => '1,204 Delegates', 'y2025' => '129 Delegates'],
    ['icon' => 'mdi:presentation', 'color' => '#6B8E3D', 'label' => 'Thought Leadership', 'y2022' => '15 Plenary/Breakout Sessions', 'y2025' => '12 Plenary/Breakout Sessions'],
    ['icon' => 'mdi:microphone-outline', 'color' => '#B5652D', 'label' => 'Expert Speaker', 'y2022' => '60+ Resource Speakers', 'y2025' => '55 Speakers'],
    ['icon' => 'mdi:handshake-outline', 'color' => '#357937', 'label' => 'Trade Buyers', 'y2022' => '138 Buyers', 'y2025' => '1,111 Buyers'],
    ['icon' => 'mdi:email-multiple-outline', 'color' => '#5C6B5E', 'label' => 'Business Leads', 'y2022' => '1,807 inquiries', 'y2025' => '14,997 inquiries'],
];

$delegateRates = [
    ['type' => 'Early Bird Rate', 'note' => '10% discount until March 31, 2026', 'amount' => '₱ 2,250.00'],
    ['type' => 'Regular Rate', 'note' => 'after March 31, 2026', 'amount' => '₱ 2,500.00'],
    ['type' => 'Walk-in', 'note' => 'event proper', 'amount' => '₱ 2,750.00'],
    ['type' => 'Group', 'note' => '5+1 Free', 'amount' => '₱ 12,500.00'],
    ['type' => 'PWD / SC / Govt / Academe', 'note' => '20% discount', 'amount' => '₱ 2,000.00'],
    ['type' => 'Special Rate for Registered IFEX Exhibitor', 'note' => '30% discount', 'amount' => '₱ 1,750.00'],
];

$inclusions = ['Delegate Pass','3-day IFEX Philippines x SSX exhibits access','2-day SSX Conference access','Conference kit (bag, booklet, pen)','Conference meals','Conference materials','Certificate of attendance'];

$localBooths = [
    ['type' => 'Corner Raw Space', 'size' => '4 sqm', 'discount' => '₱3,553.00', 'full' => '₱3,740.00', 'base' => '₱14,960.00'],
    ['type' => 'Inner Raw Space', 'size' => '4 sqm', 'discount' => '₱3,230.00', 'full' => '₱3,400.00', 'base' => '₱13,600.00'],
    ['type' => 'Corner Booth System', 'size' => '4 sqm', 'discount' => '₱4,389.00', 'full' => '₱4,620.00', 'base' => '₱18,480.00'],
    ['type' => 'Inner Booth System', 'size' => '4 sqm', 'discount' => '₱3,990.00', 'full' => '₱4,200.00', 'base' => '₱16,800.00'],
];

$intlBooths = [
    ['type' => 'Corner Raw Space', 'size' => '4 sqm', 'discount' => 'USD 219.45', 'full' => 'USD 231', 'base' => 'USD 924'],
    ['type' => 'Inner Raw Space', 'size' => '4 sqm', 'discount' => 'USD 199.50', 'full' => 'USD 210', 'base' => 'USD 840'],
    ['type' => 'Corner Booth System', 'size' => '4 sqm', 'discount' => 'USD 261.25', 'full' => 'USD 275', 'base' => 'USD 1100'],
    ['type' => 'Inner Booth System', 'size' => '4 sqm', 'discount' => 'USD 237.50', 'full' => 'USD 250', 'base' => 'USD 1000'],
];

$benefits = [
    ['icon' => 'mdi:earth', 'color' => '#E3A72E', 'title' => 'Market Access', 'text' => 'Connect with local and international buyers, food manufacturers, policymakers, and industry leaders actively seeking sustainable solutions.'],
    ['icon' => 'mdi:eye-outline', 'color' => '#2A7F8E', 'title' => 'Visibility & Branding', 'text' => 'Showcase your innovations and advocacy to a broad cross-section of industries and communities committed to environmental and social sustainability.'],
    ['icon' => 'mdi:account-network-outline', 'color' => '#6B8E3D', 'title' => 'Networking & Partnerships', 'text' => 'Meet potential partners, clients, and collaborators from both government and private sectors.'],
    ['icon' => 'mdi:lightbulb-on-outline', 'color' => '#B5652D', 'title' => 'Thought Leadership', 'text' => 'Position your organization as an advocate and changemaker in advancing sustainability in the Philippines and across Asia.'],
    ['icon' => 'mdi:recycle-variant', 'color' => '#5C6B5E', 'title' => 'Impact & Advocacy', 'text' => 'Shape the future of circular economies and responsible consumption by bridging the gap between traditional industry and modern urban living.'],
];

$eligibilityDocs = [
    ['icon' => 'mdi:file-certificate-outline', 'color' => '#E3A72E', 'text' => 'Copy of business registration from the Department of Trade and Industry (DTI) or Securities and Exchange Commission (SEC), including complete Articles of Incorporation'],
    ['icon' => 'mdi:receipt-text-outline', 'color' => '#2A7F8E', 'text' => 'Copy of Bureau of Internal Revenue (BIR) Certificate of Registration (Form 2303) and/or Certificate of VAT-Exempt'],
    ['icon' => 'mdi:license', 'color' => '#6B8E3D', 'text' => 'Copy of valid License to Operate (LTO)'],
    ['icon' => 'mdi:file-document-check-outline', 'color' => '#B5652D', 'text' => 'Copy of valid Certificate of Product Registration (CPR) for food and/or pharmaceutical products'],
    ['icon' => 'mdi:leaf-circle-outline', 'color' => '#5C6B5E', 'text' => 'Copies of relevant and valid food or environmental certifications, if available (e.g., Fairtrade, FSC, Green Choice, HACCP, Halal, ISO, etc.)'],
];

$exhibitionFeatures = [
    ['icon' => 'mdi:sofa-outline', 'color' => '#E3A72E', 'title' => 'Business Meeting Lounge', 'text' => 'A dedicated, professional hub for pre-arranged consultations designed to facilitate high-level collaboration, supply chain adaptation, and strategic financing between sustainable suppliers and global purchasers.'],
    ['icon' => 'mdi:account-tie-outline', 'color' => '#2A7F8E', 'title' => 'Consultancy Clinics', 'text' => 'One-on-one sessions with "enablers," including government agencies, certifiers, and green financing institutions, to navigate regulatory requirements.'],
    ['icon' => 'mdi:image-frame', 'color' => '#6B8E3D', 'title' => 'The Green Gallery', 'text' => 'A visual gallery highlighting the Philippines\' progress in circularity and award-winning sustainable innovations.'],
];

$partnerTiers = [
    ['name' => 'Gold Partner', 'price' => '₱500,000.00', 'desc' => 'Maximum visibility and prime booth placement.', 'accent' => '#E3A72E', 'text' => '#B5850F'],
    ['name' => 'Silver Partner', 'price' => '₱300,000.00', 'desc' => 'Strong brand presence and strategic exposure.', 'accent' => '#9AA79E', 'text' => '#6B7A70'],
    ['name' => 'Bronze Partner', 'price' => '₱100,000.00', 'desc' => 'Strategic entry-level visibility in the green ecosystem.', 'accent' => '#B5652D', 'text' => '#B5652D'],
];

$partnerBenefits = [
    ['icon' => 'mdi:bullhorn-outline', 'color' => '#E3A72E', 'title' => 'Media Mileages', 'text' => 'Social media spotlight posts, logo inclusion on partnership e-cards, and live onsite acknowledgments.'],
    ['icon' => 'mdi:storefront-outline', 'color' => '#2A7F8E', 'title' => 'Onsite Presence', 'text' => 'Premium booth systems (up to 8sqm), brand placement in show guides and sponsor loops, and promotional video slots.'],
    ['icon' => 'mdi:key-star', 'color' => '#6B8E3D', 'title' => 'Exclusive Access', 'text' => 'VIP Lounge passes, exhibitor badges for IFEX and Manila FAME, and complimentary seats at the SSX Conference.'],
];

$shiftCtas = [

    [
        'icon' => 'mdi:email-fast-outline',
        'color' => '#E3A72E',
        'title' => 'Inquire for Sponsorship',
        'text' => 'Access our 2026 Sponsorship Prospectus and discover how your brand can lead the transition.',
        'url' => 'https://sustainability.ph/login',
    ],

    [
        'icon' => 'mdi:cart-outline',
        'color' => '#2A7F8E',
        'title' => 'Register as a Trade Purchaser',
        'text' => 'Join a network of trade purchasers and "conscientious buyers" looking to adopt eco-certified products and green production technologies.',
        'url' => 'https://sustainability.ph/registration/purchaser/email-validation',
    ],

    [
        'icon' => 'mdi:account-check-outline',
        'color' => '#6B8E3D',
        'title' => 'Register as a Delegate',
        'text' => 'Join over 300 decision-makers for the 2-day SSX Conference to gain practical "how-to" knowledge on navigating the EPR Act and global green regulations.',
        'url' => 'https://sustainability.ph/conference/registration',
    ],

    [
        'icon' => 'mdi:storefront-plus-outline',
        'color' => '#B5652D',
        'title' => 'Apply to Exhibit',
        'text' => 'Feature your sustainable solutions in our showcase, reaching a diverse audience across lifestyle, home, fashion, and smart city sectors.',
        'url' => 'https://sustainability.ph/registration/supplier/email-validation',
    ],

];

$pitchCriteria = [
    ['title' => 'Age of the Business', 'items' => ['Less than 5 years old.', 'Still in the early or growing stages of development and market establishment.']],
    ['title' => 'Funding Readiness', 'items' => ['May be self-funded, grant-awardee, or in early stages of investor engagement.']],
    ['title' => 'Team Capacity & Commitment', 'items' => ['Should have a dedicated founding or management team with the skills, knowledge, and commitment to drive both the business and sustainability goals.']],
    ['title' => 'Innovation & Impact', 'items' => ['Offers a novel product, service, or business model that directly addresses environmental and/or social challenges.']],
];

$btn = "inline-block appearance-none border-0 outline-none bg-forest hover:bg-forestdark text-white font-bold rounded-full px-10 py-3.5 transition-all duration-200 shadow-lg";
$card = "bg-white border-2 border-forest rounded-[24px] shadow-[8px_8px_0_rgba(31,69,34,0.14)]";
$cardcream = "bg-cream border-2 border-forest rounded-[24px] shadow-[8px_8px_0_rgba(31,69,34,0.14)]";
@endphp

<main id="ssxApp">
    
    <section class="relative min-h-[620px] flex items-center justify-center overflow-hidden">
        <div class="relative z-10 text-center text-white max-w-3xl px-6 py-16">
            <span class="inline-block text-xs font-bold tracking-widest uppercase bg-white/10 border border-white/40 rounded-full px-5 py-2 mb-6">October 15&ndash;17, 2026 <br> PTTC, Pasay City</span>
            <h1 class="font-display font-extrabold text-4xl md:text-6xl leading-tight tracking-tight mb-5">
                Sustainability Solutions<br>Exchange <span class="text-cream underline decoration-cream/40 underline-offset-8">2026</span>
            </h1>
            <p class="italic text-lg md:text-xl text-cream mb-9">&ldquo;Green&#8209;Ready: Scaling the Shift for Impact and Growth&rdquo;</p>
            <div class="flex flex-wrap gap-4 justify-center">
                <button type="button" class="{{ $btn }}" onclick="window.open('{{ route('registration.supplier') }}','_blank')">
                    Exhibit at SSX
                </button>
        <button
    type="button"
    class="text-forestdark hover:bg-white hover:text-forest font-bold rounded-full px-10 py-3.5 transition-all duration-200 border-0"
    onclick="window.open('{{ asset('assets/show-info_2026/SSX_2026_Participation_Brochure_Campaign_Deck.pdf') }}', '_blank')">
    Download Event Brochure
</button>
            </div>
        </div>
       
    </section>

    <section class="relative h-10 overflow-hidden ">
    <svg class="absolute left-0 right-0 -bottom-px w-full h-10 z-10" viewBox="0 0 1440 80" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,40 C240,90 480,0 720,30 C960,60 1200,10 1440,40 L1440,80 L0,80 Z" fill="#FAFAEA"></path>
        </svg>
</section>

    {{-- SIGNATURE: the five pillars, one spectrum --}}
    {{-- <div class="flex w-full h-2.5">
        @foreach($pillars as $pillar)
            <div class="flex-1 hover:flex-[1.6] transition-all duration-300" style="background:{{ $pillar['color'] }};" title="{{ $pillar['subtitle'] }}"></div>
        @endforeach
    </div> --}}
    {{-- <section class=" bg-cream border-y border-forest/10 overflow-hidden py-2">
    <div class="ssx-marquee">
        
        <div class="ssx-marquee-track">

            <img
                src="{{ asset('assets/show-info_2026/marquee-ssx-space.png') }}"
                alt="SSX Categories"
                class="ssx-marquee-img pr-12"
                onclick="window.location='#exhibition'"
            >

            <!-- Duplicate for seamless looping -->
            <img
                src="{{ asset('assets/show-info_2026/marquee-ssx-space.png') }}"
                alt=""
                aria-hidden="true"
                class="ps-2 ssx-marquee-img "
            >

        </div>
    </div>
    
    
</section> --}}

<section class="relative h-10 overflow-hidden bg-white">
    <svg
        class="absolute left-0 right-0 bottom-0 w-full h-10 -scale-y-100"
        viewBox="0 0 1440 80"
        preserveAspectRatio="none"
        xmlns="http://www.w3.org/2000/svg"
    >
        <path
            d="M0,40 C240,90 480,0 720,30 C960,60 1200,10 1440,40 L1440,80 L0,80 Z"
            fill="#FAFAEA">
        </path>
    </svg>
</section>



    {{-- <p class="text-center text-xs font-semibold text-stone bg-cream py-2">Five pillars, five colors &mdash; the map you'll see used throughout SSX 2026</p> --}}

    {{-- ===========================================
         INTRO + PERFORMANCE STATS
    =========================================== --}}
    
    <section id="ssxIntro" class=" bg-white pt-5 pb-16 md:py-20 px-6 md:px-16">
        <div class="max-w-4xl mx-auto text-center space-y-5">
            <p class="text-forest font-medium leading-relaxed">
                The <b>Sustainability Solutions Exchange (SSX)</b> is the Philippines' premier sourcing platform for sustainable solutions, designed to create a high-value, sustainability-driven export model. As a strategic trade platform, it bridges conscientious purchaser to visionary suppliers, facilitating the transition of Philippine enterprises toward a circular economy.
            </p>
            <p class="text-forest font-medium leading-relaxed">
                As the country transitions from traditional manufacturing, SSX aligns local industries with a modernized roadmap&mdash;moving regenerative practices from a niche elective to the universal baseline for all Philippine products. Building on the success of its inaugural physical edition, SSX 2026 expands its scope beyond the food industry to include the lifestyle, home, fashion, and smart cities sectors, ensuring the Philippines remains competitive and resilient in a decarbonizing global economy.
            </p>
            <p class="text-forest font-bold leading-relaxed">
                The full-scale SSX Exhibition and Conference will run from October 15&ndash;17, 2026 &middot; Philippine Trade Training Center (PTTC), Pasay City
            </p>
            <p class="font-display font-bold text-xl text-forestdark">&ldquo;Green-Ready: Scaling the Shift for Impact and Growth&rdquo;</p>
            <p class="text-forest font-medium leading-relaxed">
                This year's theme positions SSX 2026 as the primary engine for the Philippines' transition to a circular economy. By focusing on Innovation, Enterprise, and Ecosystems, the event serves as a strategic roadmap for MSMEs to turn global environmental pressures, such as the EPR Act and EUDR, into competitive advantages. It addresses the "push-pull" dynamic of rising costs and stringent regulations by unlocking the massive potential of green financing and circularity.
            </p>
        </div>

        <div class="max-w-6xl mx-auto mt-16 {{ $cardcream }} p-6 md:p-10 ">
            <div class="text-center mb-8">
                <h3 class="font-display text-2xl md:text-3xl font-bold text-forestdark mb-2">Performance in Numbers</h3>
                <p class="text-forest">SSX continues to build a track record of connecting conscientious purchasers with visionary suppliers to reshape the future of business.</p>
            </div>
<div class="overflow-x-auto ssx-drag-scroll cursor-grab">
    <div class="min-w-[1000px]">
        <!-- Header -->
        <div class="grid grid-cols-[280px_1fr_1fr] gap-6 font-bold text-forestdark border-b-2 border-forest pb-3 mb-2">
            <div>Metric</div>

            <div>
                2022 Maiden Edition
                <span class="block text-xs font-normal italic">
                    (Digital)
                </span>
            </div>

            <div>
                2025 Edition
                <span class="block text-xs font-normal italic">
                    (IFEX Feature)
                </span>
            </div>
        </div>

        @foreach($stats as $stat)
            <div
                class="grid grid-cols-[280px_1fr_1fr] gap-6 items-center border-l-4 py-4 rounded-r-lg hover:bg-forest/5 transition"
                style="border-color:{{ $stat['color'] }};">

                <!-- Metric -->
               <div class="inline-flex items-center gap-3 whitespace-nowrap">
    <span
        class="w-10 h-10 rounded-full flex items-center justify-center bg-black/5 shrink-0"
        style="color:{{ $stat['color'] }};">
        <iconify-icon
            icon="{{ $stat['icon'] }}"
            width="22"
            height="22">
        </iconify-icon>
    </span>

    <span class="font-semibold text-forestdark whitespace-nowrap">
        {{ $stat['label'] }}
    </span>
</div>

                <!-- 2022 -->
                <div class="text-forest whitespace-nowrap">
                    {{ $stat['y2022'] }}
                </div>

                <!-- 2025 -->
                <div class="text-forest whitespace-nowrap">
                    {{ $stat['y2025'] }}
                </div>

            </div>
            <hr class="border-1 border-forestdark p-0 m-0">
        @endforeach
    </div>
</div>
        </div>

<div class="flex flex-col sm:flex-row items-center justify-center gap-4 mt-10">
 <a
    href="{{ asset('assets/show-info_2026/SSX_Partnership_Catalogue.pdf') }}"
    download
    class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-forest text-white font-semibold rounded-lg hover:bg-forestdark transition-colors no-underline hover:no-underline">
    <iconify-icon
        icon="solar:download-outline"
        width="20"
        height="20">
    </iconify-icon>
    Download Partnership Catalog
</a>

    <a
        href="mailto:sustainabilityph@citem.com.ph?subject=SSX%202026%20Partnership%20Inquiry"
        class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-forest text-white font-semibold rounded-lg hover:bg-forestdark transition-colors no-underline hover:no-underline">
        <iconify-icon
            icon="solar:handshake-outline"
            width="20"
            height="20">
        </iconify-icon>
        Partner with Us
    </a>
</div>
    </section>

    {{-- <section class="relative bg-white h-10 overflow-hidden ">
    <svg class="absolute left-0 right-0 -bottom-px w-full h-10 z-10" viewBox="0 0 1440 80" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,40 C240,90 480,0 720,30 C960,60 1200,10 1440,40 L1440,80 L0,80 Z" fill="#FAFAEA"></path>
        </svg>
</section> --}}
    {{-- ===========================================
         CONFERENCE
    =========================================== --}}
    <section id="conference" class="bg-cream py-16 md:py-20 px-6 md:px-16">
        <div class="max-w-5xl mx-auto text-center">
            <iconify-icon icon="mdi:presentation" width="64" height="64" class="text-forest"></iconify-icon>
            <h2 class="font-display text-3xl md:text-4xl font-bold text-forestdark mt-3 mb-4">Conference</h2>
            <p class="text-forest mb-8 max-w-2xl mx-auto">A two-day high-energy educational forum providing practical knowledge on net-zero solutions and regional leadership.</p>

            <div class="rounded-[28px] overflow-hidden border-2 border-forest shadow-[8px_8px_0_rgba(31,69,34,0.16)] mb-12">
                <img src="{{ asset('assets/show-info_2026/ssx_2026_conference_img.jpg') }}" alt="SSX Conference plenary session" loading="lazy" class="w-full h-72 md:h-96 object-cover">
            </div>

            <div class="grid md:grid-cols-2 gap-8 text-left {{ $card }} p-8 md:p-10 mb-12">
                <div>
                    <h3 class="font-display text-xl font-bold text-forestdark mb-4">Plenary</h3>
                    <ul class="list-disc list-inside space-y-2 text-forest">
                        <li>The Philippines in the Global Green Economy</li>
                        <li>Scaling the Green Shift: What's Bankable and Buildable?</li>
                        <li>Philippine Sustainability Outlook</li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-display text-xl font-bold text-forestdark mb-4">Streams / Breakout Sessions</h3>
                    <ul class="list-disc list-inside space-y-2 text-forest">
                        <li>Resources & Utilities</li>
                        <li>Build Environment</li>
                        <li>Agri-food & Bio-tech</li>
                        <li>Circular Economy and Materials</li>
                        <li>Governance & Finance</li>
                    </ul>
                </div>
            </div>

            <h3 class="font-display text-2xl font-bold text-forestdark mb-6">Delegate Registration</h3>
            <div class="grid lg:grid-cols-[1.4fr_1fr] gap-6 text-left">
                <div class="{{ $card }} p-6 md:p-8 overflow-x-auto ssx-drag-scroll cursor-grab">
                    <div class="min-w-[480px]">
                        <div class="grid grid-cols-[1.6fr_1fr] gap-2 font-bold text-forestdark border-b-2 border-forest pb-2 mb-1">
                            <div>Delegate Type</div><div>Amount</div>
                        </div>
                        @foreach($delegateRates as $rate)
                            <div class="grid grid-cols-[1.6fr_1fr] gap-2 items-center py-4 border-t border-forest/15">
                                <div class="text-forest">{{ $rate['type'] }} <span class="block text-xs italic">({{ $rate['note'] }})</span></div>
                                <div class="font-semibold text-forestdark">{{ $rate['amount'] }}</div>
                            </div>
                               <hr class="border-1 border-forestdark p-0 m-0">
                        @endforeach
                    </div>
                </div>
                <div class="{{ $card }} p-6 md:p-8">
                    <h3 class="font-display text-xl font-bold text-forestdark mb-4">Inclusions</h3>
                   <ul class="space-y-2.5 text-forest">
    @foreach($inclusions as $item)
        <li class="flex items-start gap-2">
            <iconify-icon
                icon="mdi:check-circle"
                width="18"
                height="18"
                class="text-forest mt-0.5 flex-shrink-0">
            </iconify-icon>

            <span class="flex-1 text-left">
                {{ $item }}
            </span>
        </li>
    @endforeach
</ul>
                </div>
            </div>
        </div>
    </section>

    {{-- ===========================================
         EXHIBITION
    =========================================== --}}
    <section id="exhibition" class="bg-white py-16 md:py-20 px-6 md:px-16">
        <div class="max-w-6xl mx-auto text-center">
            <iconify-icon icon="mdi:storefront-outline" width="64" height="64" class="text-forest"></iconify-icon>
            <h2 class="font-display text-3xl md:text-4xl font-bold text-forestdark mt-3 mb-4">Exhibition</h2>
            <p class="text-forest mb-10 max-w-2xl mx-auto">A specialized showcase of resource utilities, the built environment, agri-food biotech, and circular economy solutions.</p>

            <h3 class="font-display text-2xl font-bold text-forestdark mb-6 text-left md:text-center">Categories</h3>
<div class="flex flex-wrap justify-center gap-6 mb-16">

    @foreach($pillars as $pillar)
        <div class="w-full md:w-[calc(50%-12px)] xl:w-[calc(33.333%-16px)] max-w-md">

            <div
                class="rounded-[20px] overflow-hidden border-t-[6px] bg-white shadow-[6px_6px_0_rgba(31,69,34,0.12)] hover:shadow-[6px_6px_0_rgba(31,69,34,0.22)] transition-shadow flex flex-col text-left"
                style="border-top-color:{{ $pillar['color'] }};">

                <!-- IMAGE -->
                <div class="relative h-44 overflow-hidden">
                    <img
                        src="{{ $pillar['image'] }}"
                        alt="{{ $pillar['title'] }}"
                        loading="lazy"
                        class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">

                    <span
                        class="absolute left-3 bottom-3 text-white text-xs font-bold px-3 py-1 rounded-full"
                        style="background:{{ $pillar['color'] }};">
                        {{ $pillar['subtitle'] }}
                    </span>
                </div>

                <!-- ACCORDION -->
                <details class="group">

                    <summary class="cursor-pointer list-none p-4 flex items-center gap-3 select-none">

                        <span
                            class="w-12 h-12 rounded-xl bg-black/5 flex items-center justify-center flex-shrink-0"
                            style="color:{{ $pillar['color'] }};">
                            <iconify-icon icon="{{ $pillar['icon'] }}" width="28" height="28"></iconify-icon>
                        </span>

                        <span class="flex-1">
                            <span class="block font-display font-bold text-sm text-forestdark leading-snug">
                                {{ $pillar['title'] }}
                            </span>
                            <span class="block text-xs text-forest">
                                {{ $pillar['subtitle'] }}
                            </span>
                        </span>

                        <iconify-icon
                            icon="mdi:chevron-down"
                            width="24"
                            height="24"
                            class="text-forest transition-transform duration-300 group-open:rotate-180">
                        </iconify-icon>

                    </summary>

                    <ul class="px-5 pb-5 space-y-2 text-sm text-forest list-disc list-inside">
                        @foreach($pillar['items'] as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>

                </details>

            </div>

        </div>
    @endforeach

</div>

            <h3 class="font-display text-2xl font-bold text-forestdark mb-6">Supplier Registration</h3>
            <div class="space-y-8 mb-16 text-left">
                <div class="{{ $cardcream }} p-6 md:p-8">
                    <h4 class="font-display text-lg font-bold text-forestdark mb-4 text-center">Local Supplier</h4>
                    <div class="overflow-x-auto ssx-drag-scroll cursor-grab">
                        <div class="min-w-[820px]">
                            <div class="grid grid-cols-5 gap-3 font-bold text-forestdark border-b-2 border-forest pb-2 mb-1 text-sm">
                                <div>Space / Booth Type</div><div>Booth Size</div>
                                <div>Price / sqm <span class="block text-xs font-normal italic">(Early bird -5%)</span></div>
                                <div>Price per sqm</div>
                                <div>Base Price <span class="block text-xs font-normal italic">(Per booth)</span></div>
                            </div>
                            @foreach($localBooths as $b)
                                <div class="grid grid-cols-5 gap-3 items-center py-3 border-t border-forest/15 text-forest">
                                    <div>{{ $b['type'] }}</div><div>{{ $b['size'] }}</div><div>{{ $b['discount'] }}</div><div>{{ $b['full'] }}</div>
                                    <div class="font-semibold text-forestdark">{{ $b['base'] }}</div>
                                </div>
                                   <hr class="border-1 border-forestdark p-0 m-0">
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="{{ $cardcream }} p-6 md:p-8">
                    <h4 class="font-display text-lg font-bold text-forestdark mb-4 text-center">International Supplier</h4>
                    <div class="overflow-x-auto ssx-drag-scroll cursor-grab">
                        <div class="min-w-[820px]">
                            <div class="grid grid-cols-5 gap-3 font-bold text-forestdark border-b-2 border-forest pb-2 mb-1 text-sm">
                                <div>Space / Booth Type</div><div>Booth Size</div>
                                <div>Price / sqm <span class="block text-xs font-normal italic">(Early bird -5%)</span></div>
                                <div>Price per sqm</div>
                                <div>Base Price <span class="block text-xs font-normal italic">(Per booth)</span></div>
                            </div>
                            @foreach($intlBooths as $b)
                                <div class="grid grid-cols-5 gap-3 items-center py-3 border-t border-forest/15 text-forest">
                                    <div>{{ $b['type'] }}</div><div>{{ $b['size'] }}</div><div>{{ $b['discount'] }}</div><div>{{ $b['full'] }}</div>
                                    <div class="font-semibold text-forestdark">{{ $b['base'] }}</div>
                                </div>
                                   <hr class="border-1 border-forestdark p-0 m-0">
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- PARTICIPATION BENEFITS --}}
            <div class="mb-16">
                <span class="block text-xs font-bold tracking-widest uppercase text-stone mb-1">Why Join</span>
                <h3 class="font-display text-2xl font-bold text-forestdark mb-8">Participation Benefits & Inclusions</h3>
<div class="flex flex-wrap justify-center gap-6 mb-6">
    @foreach($benefits as $b)
        <div
            class="w-full md:w-[calc(50%-12px)] xl:w-[calc(33.333%-16px)] max-w-md bg-white border border-forest/20 rounded-2xl p-6 border-t-4 hover:-translate-y-1.5 hover:shadow-[0_16px_28px_rgba(31,69,34,0.12)] transition-all duration-200 text-left"
            style="border-top-color:{{ $b['color'] }};">

            <div
                class="w-12 h-12 rounded-xl flex items-center justify-center mb-4"
                style="background:{{ $b['color'] }}22; color:{{ $b['color'] }};">
                <iconify-icon
                    icon="{{ $b['icon'] }}"
                    width="26"
                    height="26">
                </iconify-icon>
            </div>

            <h5 class="font-display font-bold text-forestdark mb-2">
                {{ $b['title'] }}
            </h5>

            <p class="text-sm text-forest">
                {{ $b['text'] }}
            </p>
        </div>
    @endforeach
</div>
      <div class="flex items-center gap-4 bg-forestdark text-white rounded-2xl p-6 md:p-7 text-left max-w-4xl mx-auto">
                    
                    <iconify-icon icon="mdi:badge-account-horizontal-outline" width="28" height="28" class="text-solar flex-shrink-0 mt-0.5"></iconify-icon>
                    <p class="text-sm text-white/90 m-0">While the physical set-up varies depending on your chosen size and booth type, every exhibitor is provided with a professional foundation for success such as access via official badges, digital reach thru a featured listing in the SSX Website E-Directory, and integrated promotion in print, social media, and web marketing.</p>
                </div>
            </div>

            {{-- ELIGIBILITY --}}
            <div class="mb-16 ">
                <span class="block text-xs font-bold tracking-widest uppercase text-stone mb-1">Getting Started</span>
                <h3 class="font-display text-2xl font-bold text-forestdark mb-8">Eligibility & Requirements</h3>
                <div class="flex flex-wrap justify-center gap-4">
    @foreach($eligibilityDocs as $req)
        <div class="w-full md:w-[calc(48%-8px)] max-w-xl bg-white border border-forest/20 rounded-2xl p-4">
            <div class="flex items-center gap-3.5">
                <span
                    class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0"
                    style="background:{{ $req['color'] }}22; color:{{ $req['color'] }};">
                    <iconify-icon
                        icon="{{ $req['icon'] }}"
                        width="20"
                        height="20">
                    </iconify-icon>
                </span>

                <span class="flex-1 text-start text-forest text-sm leading-relaxed">
                    {{ $req['text'] }}
                </span>
            </div>
        </div>
    @endforeach
</div>
            </div>

            {{-- FEATURES --}}
            <div class="mb-16">
                <span class="block text-xs font-bold tracking-widest uppercase text-stone mb-1">On-Site</span>
                <h3 class="font-display text-2xl font-bold text-forestdark mb-8">Exhibition Features</h3>
                <div class="grid md:grid-cols-3 gap-6 text-left">
                    @foreach($exhibitionFeatures as $f)
                        <div class="bg-white border-2 rounded-2xl p-7 hover:-translate-y-1.5 transition-transform duration-200" style="border-color:{{ $f['color'] }};">
                            <div class="w-14 h-14 rounded-full flex items-center justify-center text-white mb-2" style="background:{{ $f['color'] }};">
                                <iconify-icon icon="{{ $f['icon'] }}" width="28" height="28"></iconify-icon>
                            </div>
                            <h5 class="font-display font-bold text-forestdark mb-2">{{ $f['title'] }}</h5>
                            <p class="text-sm text-forest">{{ $f['text'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <h3 class="font-display text-2xl font-bold text-forestdark mb-6">Reserve Exhibit Space Now!</h3>
            <button type="button" class="{{ $btn }}" onclick="window.open('{{ route('registration.supplier') }}','_blank')">Register Now</button>
        </div>
    </section>

    {{-- ===========================================
         PARTNERSHIP & SPONSORSHIP
    =========================================== --}}
    <section>
             <div class="relative h-64 md:h-72 overflow-hidden">
            {{-- <img src="https://picsum.photos/seed/ssx-partnership/1920/500" alt="SSX partners and sponsors collaborating" loading="lazy" class="absolute inset-0 w-full h-full object-cover"> --}}
            {{-- <div class="absolute inset-0 bg-gradient-to-r from-forestdark/90 to-forest/70"></div> --}}
            <div class="relative z-10 h-full flex flex-col items-center justify-center gap-2 text-white">
                <iconify-icon icon="mdi:handshake" width="60" height="60"></iconify-icon>
                <h2 class="font-display text-3xl md:text-4xl font-bold">Partnership & Sponsorship</h2>
            </div>
        </div>
    </section>
    <section id="partnership" class="bg-cream">
   

        <div class="max-w-5xl mx-auto text-center px-6 py-16 md:py-20">
            <h4 class="font-display text-xl font-bold text-forestdark mb-6">Collaborate for a Circular Future</h4>
            <p class="text-forest mb-14 max-w-3xl mx-auto">The Sustainability Solutions Exchange (SSX) 2026 employs a "Whole-of-Nation" strategy, transitioning into a collaborative mission involving government leaders, international grant partners, and corporate pioneers. By joining as a partner, your brand becomes a central part of the country's first platform promoting sustainable practices to the world's essential industries.</p>

            <h3 class="font-display text-2xl font-bold text-forestdark mb-8">Major Partnership Packages</h3>
            <div class="grid md:grid-cols-3 gap-6 mb-16 text-center">
                @foreach($partnerTiers as $tier)
                    <div class="bg-white rounded-2xl p-8 border-2 hover:-translate-y-1.5 transition-transform duration-200" style="border-color:{{ $tier['accent'] }};">
                        <iconify-icon icon="mdi:medal-outline" width="34" height="34" style="color:{{ $tier['text'] }};"></iconify-icon>
                        <h5 class="font-display font-bold text-forestdark mt-2 mb-2">{{ $tier['name'] }}</h5>
                        <p class="font-display text-2xl font-bold mb-3" style="color:{{ $tier['text'] }};">{{ $tier['price'] }}</p>
                        <p class="text-sm text-forest">{{ $tier['desc'] }}</p>
                    </div>
                @endforeach
            </div>

            <h3 class="font-display text-2xl font-bold text-forestdark mb-8">Benefits and Inclusions</h3>
            <div class="grid md:grid-cols-3 gap-6 mb-16 text-left">
                @foreach($partnerBenefits as $pb)
                    <div class="bg-white border border-forest/20 rounded-2xl p-6">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4" style="background:{{ $pb['color'] }}22; color:{{ $pb['color'] }};">
                            <iconify-icon icon="{{ $pb['icon'] }}" width="24" height="24"></iconify-icon>
                        </div>
                        <h5 class="font-display font-bold text-forestdark mb-2">{{ $pb['title'] }}</h5>
                        <p class="text-sm text-forest">{{ $pb['text'] }}</p>
                    </div>
                @endforeach
            </div>

            <h3 class="font-display text-2xl font-bold text-forestdark mb-2">Be Part of the Green Shift.</h3>
            <p class="text-forest max-w-2xl mx-auto mb-10">Whether you are a solution provider looking to showcase innovation or a corporate leader ready to champion sustainability, now is the time to secure your place.</p>
<div class="flex flex-wrap justify-center gap-5 text-left">
   @foreach($shiftCtas as $cta)

    <div
        class="w-full md:w-[calc(48%-10px)] flex items-center gap-4 bg-white border border-forest/20 rounded-2xl p-6 border-l-4 cursor-pointer hover:translate-x-1 hover:shadow-[0_12px_24px_rgba(31,69,34,0.12)] transition-all duration-200"
        style="border-left-color:{{ $cta['color'] }};"
        onclick="window.open('{{ $cta['url'] }}','_blank')">

        <!-- Icon -->
        <div
            class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0"
            style="background:{{ $cta['color'] }}22; color:{{ $cta['color'] }};">

            <iconify-icon
                icon="{{ $cta['icon'] }}"
                width="24"
                height="24">
            </iconify-icon>

        </div>

        <!-- Content -->
        <div class="flex-1">

            <h5 class="font-display font-bold text-forestdark text-sm leading-tight whitespace-nowrap">
                {{ $cta['title'] }}
            </h5>

            <p class="text-xs text-forest leading-relaxed">
                {{ $cta['text'] }}
            </p>

        </div>

        <!-- Arrow -->
        <iconify-icon
            icon="mdi:arrow-top-right"
            width="20"
            height="20"
            class="shrink-0"
            style="color:{{ $cta['color'] }};">
        </iconify-icon>

    </div>

@endforeach
</div>
        </div>
    </section>

    {{-- ===========================================
         PITCHING COMPETITION
    =========================================== --}}
    <section id="pitching" class="bg-forestdark py-16 md:py-20 px-6 md:px-16">
        <div class="max-w-4xl mx-auto text-center text-white">
            <iconify-icon icon="mdi:presentation-play" width="60" height="60"></iconify-icon>
            <h2 class="font-display text-3xl md:text-4xl font-bold mt-3 mb-4">Pitching Competition</h2>
            <p class="text-white/85 mb-10">Future Proof: The Green Innovation Pitch &mdash; a flagship event where sustainability startups present innovations to venture capitalists and industry experts.</p>

            <div class="border-2 border-white/70 rounded-[24px] p-8 md:p-10 text-left">
                <h3 class="font-display text-xl font-bold mb-3">Eligibility</h3>
                <p class="mb-6"><strong>Participants must be an approved SSX exhibitor and meet the criteria below.</strong></p>

                <div class="grid md:grid-cols-2 gap-6 mb-8">
                    @foreach($pitchCriteria as $criterion)
                        <div>
                            <h5 class="font-bold mb-2">{{ $criterion['title'] }}</h5>
                            <ul class="list-disc list-inside space-y-1 text-white/85 text-sm">
                                @foreach($criterion['items'] as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>

                <hr class="border-white/40 mb-6">

                <h3 class="font-display text-xl font-bold mb-4">Pitching Competition Guidelines</h3>
                <ol class="list-decimal list-inside space-y-3 mb-6">
                    <li>Register as an exhibitor via Sustainability.ph and select the <strong>"Pitching Competition"</strong> option (limit of one entry per category).</li>
                    <li>
                        Submit a concise paper covering:
                        <ul class="list-disc list-inside ml-5 mt-2 space-y-1 text-white/85 text-sm">
                            <li>Introduction & Problem Statement</li>
                            <li>Proposed Solution & Sustainability Impact</li>
                            <li>Scalability & Future Plans</li>
                            <li>Conclusion / Call to Action</li>
                        </ul>
                    </li>
                    <li>Submit a pitch video (maximum 3 minutes) highlighting your key innovations.</li>
                </ol>

                <div class="bg-white/95 text-forestdark rounded-xl p-4 mb-6 text-sm">
                    <strong>Note:</strong> Overtime submissions will incur score deductions.
                </div>

                <h5 class="font-bold mb-2">Submission Format</h5>
                <ul class="text-sm text-white/85 space-y-1">
                    <li><strong>Paper:</strong> Pitching Paper_Company Name</li>
                    <li><strong>Video:</strong> Video Presentation_Company Name</li>
                </ul>
            </div>

            <button type="button" class="bg-white hover:bg-cream text-forestdark font-bold rounded-full px-10 py-3.5 mt-8 transition-all duration-200 hover:-translate-y-0.5"
                onclick="window.open('{{ route('registration.supplier') }}','_blank')">
                Register Now
            </button>
        </div>
    </section>

</main>

@endsection

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,500;9..144,600;9..144,700;9..144,800&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            important: '#ssxApp',
            corePlugins: {
                preflight: false,
            },
            theme: {
                extend: {
                    colors: {
                        forest: '#357937',
                        forestdark: '#1F4522',
                        cream: '#FAFAEA',
                        solar: '#E3A72E',
                        water: '#2A7F8E',
                        olive: '#6B8E3D',
                        soil: '#B5652D',
                        stone: '#5C6B5E',
                    },
                    fontFamily: {
                        display: ['Harabara', 'serif'],
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <style>
   #ssxApp{
    position:relative;
    overflow:hidden;
}

#ssxApp::before{
    content:"";
    position:fixed;
    inset:0;
    z-index:-1;

    background:
        linear-gradient(rgba(20,40,20,.55),rgba(20,40,20,.7)),
        url("{{ asset('assets/show-info_2026/ssx_2026_banner.png') }}");

    background-size:cover;
    background-position:center;

    animation:ssxFloat 7s ease-in-out infinite alternate;
}

@keyframes ssxFloat{
    from{
        transform:scale(1.03) translateY(0);
    }

    to{
        transform:scale(1.08) translateY(-20px);
    }
}

        .ssx-marquee {
    overflow: hidden;
    width: 100%;
}

.ssx-marquee-track {
    display: flex;
    width: max-content;
    animation: ssxMarquee 40s linear infinite;
}

.ssx-marquee:hover .ssx-marquee-track {
    animation-play-state: paused;
}

.ssx-marquee-img {
    height: 16px;
    width: auto;
    flex-shrink: 0;
    object-fit: contain;
    cursor: pointer;
    user-select: none;
}

@media (min-width:768px){
    .ssx-marquee-img{
        height:2ch0px;
    }
}

@media (min-width:1024px){
    .ssx-marquee-img{
        height:16px;
    }
}

@keyframes ssxMarquee {
    from {
        transform: translateX(0);
    }
    to {
        transform: translateX(-50%);
    }
}
    </style>
@endpush

@push('scripts')
<script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
<script> 

function ssxToggle(id) {
    const currentPanel = document.getElementById(id);
    const currentChevron = document.getElementById(id + '-chevron');

    if (!currentPanel) return;

    // Check if the clicked panel is currently closed
    const shouldOpen = currentPanel.classList.contains('hidden');

    // Close all panels
    document.querySelectorAll('ul[id^="pillar-"]').forEach(panel => {
        panel.classList.add('hidden');
    });

    // Reset all chevrons
    document.querySelectorAll('iconify-icon[id$="-chevron"]').forEach(icon => {
        icon.classList.remove('rotate-180');
    });

    // Open only the clicked panel (if it was previously closed)
    if (shouldOpen) {
        currentPanel.classList.remove('hidden');
        currentChevron.classList.add('rotate-180');
    }
}

document.addEventListener('DOMContentLoaded', function () { document.querySelectorAll('.ssx-drag-scroll').forEach((slider) => { let isDown = false, startX, scrollLeft; slider.addEventListener('mousedown', (e) => { isDown = true; slider.classList.add('dragging'); startX = e.pageX - slider.offsetLeft; scrollLeft = slider.scrollLeft; }); slider.addEventListener('mouseleave', () => { isDown = false; slider.classList.remove('dragging'); }); slider.addEventListener('mouseup', () => { isDown = false; slider.classList.remove('dragging'); }); slider.addEventListener('mousemove', (e) => { if (!isDown) return; e.preventDefault(); const x = e.pageX - slider.offsetLeft; const walk = (x - startX) * 1.5; slider.scrollLeft = scrollLeft - walk; }); }); if (window.jQuery) { $('#nav-events').addClass('active'); } }); </script>
@endpush