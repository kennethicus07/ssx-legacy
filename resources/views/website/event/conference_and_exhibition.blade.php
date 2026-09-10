@extends('layouts.website')

@section('content')
@php
$programs = config('ssx_october_2026.programs');
$eventPartners = config('ssx_october_2026_partners.event_partners');
$sessionPartners = config('ssx_october_2026_partners.session_partners');
$governmentPartners = config('ssx_october_2026_partners.government_partners');
$institutionalPartners = config('ssx_october_2026_partners.institutional_partners');
$officialTrainingEventPartners = config('ssx_october_2026_partners.official_training_and_event_partners');
$officialBusinessLoungePartners = config('ssx_october_2026_partners.official_business_lounge_partners');
$officialTokenPartners = config('ssx_october_2026_partners.official_token_partners');

// All other static content now lives in config/ssx_conference_2026_other_data.php
$otherData = config('ssx_conference_2026_data');

$pillars            = $otherData['pillars'];
$stats              = $otherData['stats'];
$delegateRates      = $otherData['delegateRates'];
$inclusions         = $otherData['inclusions'];
$localBooths        = $otherData['localBooths'];
$intlBooths         = $otherData['intlBooths'];
$benefits           = $otherData['benefits'];
$eligibilityDocs    = $otherData['eligibilityDocs'];
$exhibitionFeatures = $otherData['exhibitionFeatures'];
$partnerTiers       = $otherData['partnerTiers'];
$partnerBenefits    = $otherData['partnerBenefits'];
$shiftCtas          = $otherData['shiftCtas'];
$pitchCriteria      = $otherData['pitchCriteria'];

$btn = "inline-block appearance-none border-0 outline-none bg-forest hover:bg-forestdark text-white font-bold rounded-full px-10 py-3.5 transition-all duration-200 shadow-lg";
$card = "bg-white border-2 border-forest rounded-[24px] shadow-[8px_8px_0_rgba(31,69,34,0.14)]";
$cardcream = "bg-cream border-2 border-forest rounded-[24px] shadow-[8px_8px_0_rgba(31,69,34,0.14)]";

// Running counter used to give every speaker-with-profile a unique modal id.
$speakerModalCounter = 0;

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


    </section>

    <section id="conference" class="bg-cream py-16 md:py-20 px-6 md:px-16">
        <div class="max-w-5xl mx-auto text-center">
            <iconify-icon icon="mdi:presentation" width="64" height="64" class="text-forest"></iconify-icon>
            <h2 class="font-display text-3xl md:text-4xl font-bold text-forestdark mt-3 mb-4">Conference</h2>
            <p class="text-forest mb-8 max-w-2xl mx-auto">A two-day high-energy educational forum providing practical knowledge on net-zero solutions and regional leadership.</p>

            <div class="rounded-[28px] overflow-hidden border-2 border-forest shadow-[8px_8px_0_rgba(31,69,34,0.16)] mb-12">
                <img src="{{ asset('assets/show-info_2026/ssx_2026_conference_img.jpg') }}" alt="SSX Conference plenary session" loading="lazy" class="w-full h-72 md:h-96 object-cover">
            </div>

        <div class="space-y-5 mb-5">

            @foreach($programs as $dayIndex => $day)

                {{-- ONLY THIS IS AN ACCORDION --}}
                <details
                    class="group bg-white border-2 border-forest rounded-[24px] shadow-[8px_8px_0_rgba(31,69,34,0.14)] overflow-hidden"
                >

                    {{-- DAY HEADER --}}
                    <summary class="cursor-pointer list-none px-6 md:px-8 py-6 flex items-center justify-between gap-6 hover:bg-gray-50 transition">

                        <div class="flex items-center gap-5">

                            <div class="text-left">

                                <div class="flex flex-wrap items-center gap-3">

                                    <h3 class="text-2xl md:text-3xl font-extrabold text-forest">
                                        {{ $day['day_label'] }}
                                    </h3>

                                    @if(!empty($day['date']))
                                        <span class="px-3 py-1 mb-2 rounded-full bg-cream text-sm font-semibold text-gray-600">
                                            {{ \Carbon\Carbon::parse($day['date'])->format('F d, Y') }}
                                        </span>
                                    @endif

                                </div>

                                @if(!empty($day['theme']))
                                    <p class="mt-1 text-gray-600">
                                        {{ $day['theme'] }}
                                    </p>
                                @endif

                            </div>

                        </div>

                        <iconify-icon
                            icon="mdi:chevron-down"
                            class="text-3xl text-forest transition-transform group-open:rotate-180"
                        ></iconify-icon>

                    </summary>


                    {{-- =====================================================
                        DAY CONTENT
                    ====================================================== --}}
                    <div class="border-t-2 border-forest/10">


                        {{-- =================================================
                            PLENARY SESSIONS
                        ================================================== --}}
                        @if(!empty($day['sessions']))

                            <div class="p-6 md:p-8 ">

                                <div class="mb-3 text-center" >

                                    <h4 class="text-xl font-extrabold text-forest">
                                        Plenary Sessions
                                    </h4>

                                </div>


                                {{-- TABLE --}}
                          <div class="overflow-x-auto rounded-xl border border-gray-200">
    <table class="w-full min-w-[800px] border-collapse text-sm">

        <thead>
            <tr class="bg-forest text-white">
                <th class="text-left px-4 py-3 w-[130px] font-bold">
                    TIME
                </th>

                  <th class="text-left px-4 py-3 w-[100px] font-bold">
                    DURATION
                </th>

                <th class="text-left px-4 py-3 font-bold">
                    PROGRAM
                </th>


            </tr>
        </thead>

        <tbody>
            @foreach($day['sessions'] as $session)
                <tr class="border-t border-gray-200 hover:bg-cream/50 transition">

                    {{-- TIME --}}
<td class="px-4 py-3 align-top">
    <div class="font-bold text-forest whitespace-nowrap">
        {{ \Carbon\Carbon::parse($session['start_time'])->format('g:i A') }}

        @if(!empty($session['end_time']))
            – {{ \Carbon\Carbon::parse($session['end_time'])->format('g:i A') }}
        @endif
    </div>
</td>
 {{-- TYPE --}}
                    <td class="px-4 py-3 align-top">

                        @if(!empty($session['duration']))
                            <div class=" text-gray-500">
                                {{ $session['duration'] }}
                            </div>
                        @endif

                    </td>

                    {{-- PROGRAM --}}
                    <td class="px-4 py-3 align-top text-start">

                        <div class="font-bold text-gray-900">
                            {{ $session['title'] }}
                        </div>

                        @if(!empty($session['description']))
                            <p class="mt-1 text-sm text-gray-600 leading-relaxed">
                                {{ $session['description'] }}
                            </p>
                        @endif

                        @if(!empty($session['speakers']))
                            <div class="mt-2">
                                <span class="text-xs font-bold uppercase tracking-wide text-forest">
                                    Speakers:
                                </span>

                                @foreach($session['speakers'] as $speaker)
                                    @php
                                        $hasProfile = !empty($speaker['status']) && (int) $speaker['status'] === 1;
                                        if ($hasProfile) {
                                            $speakerModalCounter++;
                                            $modalId = 'speaker-modal-' . $speakerModalCounter;
                                        }
                                    @endphp

                                    <div class="text-sm leading-6">

                                        @if($hasProfile)
                                            <span
                                                class="speaker-trigger font-semibold text-gray-900 cursor-pointer underline decoration-dotted decoration-forest/60 underline-offset-2 hover:text-forest transition"
                                                onclick="toggleSpeakerModal('{{ $modalId }}', event)"
                                                role="button"
                                                tabindex="0"
                                                onkeydown="if(event.key==='Enter'){toggleSpeakerModal('{{ $modalId }}', event);}"
                                            >
                                                {{ $speaker['name'] }}
                                            </span>
                                        @else
                                            <span class="font-semibold text-gray-900">
                                                {{ $speaker['name'] }}
                                            </span>
                                        @endif

                                        @if(!empty($speaker['position']))
                                            <span class="text-gray-500">
                                                — {{ $speaker['position'] }}
                                            </span>
                                        @endif

                                        @if(!empty($speaker['organization']))
                                            <span class="text-forest font-medium">
                                                · {{ $speaker['organization'] }}
                                            </span>
                                        @endif

                                        @if($hasProfile)
                                            {{-- SPEAKER PROFILE MODAL --}}
                                            <div id="{{ $modalId }}" class="speaker-modal-overlay hidden" onclick="closeSpeakerModalOnOverlay(event, '{{ $modalId }}')">
                                                <div class="speaker-modal-content" onclick="event.stopPropagation()">

                                                    <button type="button" class="speaker-modal-close" onclick="toggleSpeakerModal('{{ $modalId }}', event)" aria-label="Close">
                                                        <iconify-icon icon="mdi:close" width="22" height="22"></iconify-icon>
                                                    </button>

                                                    @if(!empty($speaker['image']))
                                                        <img src="{{ asset($speaker['image']) }}" alt="{{ $speaker['name'] }}" class="speaker-modal-img">
                                                    @endif

                                                    <h4 class="font-display font-bold text-lg text-forestdark mb-1">
                                                        {{ $speaker['name'] }}
                                                    </h4>

                                                    @if(!empty($speaker['position']))
                                                        <p class="text-sm text-gray-600 mb-0.5">
                                                            {{ $speaker['position'] }}
                                                        </p>
                                                    @endif

                                                    @if(!empty($speaker['organization']))
                                                        <p class="text-sm font-semibold text-forest mb-3">
                                                            {{ $speaker['organization'] }}
                                                        </p>
                                                    @endif

                                                    @if(!empty($speaker['profile']))
                                                        <p class="text-sm text-gray-700 leading-relaxed speaker-modal-bio">
                                                    {!! $speaker['profile'] !!}
                                                        </p>
                                                    @endif

                                                    @if(!empty($speaker['website']))
                                                        <a
                                                            href="{{ $speaker['website'] }}"
                                                            target="_blank"
                                                            rel="noopener noreferrer"
                                                            class="inline-flex items-center gap-2 text-sm font-semibold text-forest hover:underline mt-3"
                                                        >
                                                            Visit Website
                                                            <iconify-icon icon="mdi:open-in-new" class="text-base"></iconify-icon>
                                                        </a>
                                                    @endif

                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if(!empty($session['moderators']))
                            <div class="mt-2">
                                <span class="text-xs font-bold uppercase tracking-wide text-forest">
                                    Moderator:
                                </span>

                                @foreach($session['moderators'] as $moderator)
                                    <div class="text-sm leading-6">
                                        <span class="font-semibold text-gray-900">
                                            {{ $moderator['name'] }}
                                        </span>

                                        @if(!empty($moderator['organization']))
                                            <span class="text-forest font-medium">
                                                · {{ $moderator['organization'] }}
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif

                    </td>

                </tr>
            @endforeach
        </tbody>

    </table>
</div>

                            </div>

                        @endif



                        {{-- =================================================
                            BREAKOUT
                        ================================================== --}}
                        @if(!empty($day['breakout']))

                            <div class="px-6 md:px-8 pb-8">

                                {{-- BREAKOUT HEADER --}}
                                <div class="mb-3 pt-2 text-center">

                                    <h4 class="text-xl font-extrabold text-forest">
                                        {{ $day['breakout']['title'] }}
                                    </h4>

                                    @if(!empty($day['breakout']['subtitle']))

                                        <p class="text-sm text-gray-500 mt-1">
                                            {{ $day['breakout']['subtitle'] }}
                                        </p>

                                    @endif

                                </div>

                             {{-- TRACK TABLE --}}
                        <div class="overflow-x-auto rounded-xl border border-gray-200">

                            <table class="w-full min-w-[900px] border-collapse text-sm">

                                <thead>
                                    <tr class="bg-forest text-white">

                                        <th class="text-left px-4 py-3 w-[235px] font-bold">
                                            TRACK
                                        </th>

                                        <th class="text-left px-4 py-3 w-[130px] font-bold">
                                            TIME
                                        </th>

                                        <th class="text-left px-4 py-3 font-bold">
                                            SESSION
                                        </th>

                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($day['breakout']['tracks'] as $track)

                                        @foreach($track['sessions'] as $sessionIndex => $session)

                                            <tr class="border-t border-gray-200 hover:bg-cream/50 transition">

                                                {{-- TRACK --}}
                                                @if($sessionIndex === 0)
                                                    <td
                                                        class="px-4 py-3 align-top"
                                                        rowspan="{{ count($track['sessions']) }}"
                                                    >
                                                        <div class="flex items-start gap-2.5">

                                                            {{-- Track Details --}}
                                                            <div>
                                                                <div class="font-bold text-forest leading-tight">
                                                                    {{ $track['track_name'] }}
                                                                </div>

                                                                @if(!empty($track['track_category']))
                                                                    <div class="text-xs text-gray-500 mt-0.5 leading-relaxed">
                                                                        {{ $track['track_category'] }}
                                                                    </div>
                                                                @endif
                                                            </div>

                                                        </div>
                                                    </td>
                                                @endif


                                                {{-- TIME --}}
                                                <td class="px-4 py-3 align-top">
                                                    <div class="font-bold text-forest whitespace-nowrap">
                                                        {{ \Carbon\Carbon::parse($session['start_time'])->format('g:i A') }}

                                                        @if(!empty($session['end_time']))
                                                            – {{ \Carbon\Carbon::parse($session['end_time'])->format('g:i A') }}
                                                        @endif
                                                    </div>
                                                </td>


                                                {{-- SESSION --}}
                                                <td class="px-4 py-3 align-top text-start">

                                                    {{-- Session Title --}}
                                                    <div class="font-bold text-gray-900 leading-snug">
                                                        {{ $session['title'] }}
                                                    </div>

                                                    {{-- Description --}}
                                                    @if(!empty($session['description']))
                                                        <p class="mt-1 text-sm text-gray-600 leading-relaxed">
                                                            {{ $session['description'] }}
                                                        </p>
                                                    @endif


                                                    {{-- SPEAKERS --}}
                                                    @if(!empty($session['speakers']))
                                                        <div class="mt-2">

                                                            <div class="text-xs font-bold uppercase tracking-wide text-forest mb-1">
                                                                Speakers
                                                            </div>

                                                            <div class="space-y-0.5">
                                                                @foreach($session['speakers'] as $speaker)
                                                                    @php
                                                                        $hasProfile = !empty($speaker['status']) && (int) $speaker['status'] === 1;
                                                                        if ($hasProfile) {
                                                                            $speakerModalCounter++;
                                                                            $modalId = 'speaker-modal-' . $speakerModalCounter;
                                                                        }
                                                                    @endphp

                                                                    <div class="text-sm leading-6">

                                                                        @if($hasProfile)
                                                                            <span
                                                                                class="speaker-trigger font-semibold text-gray-900 cursor-pointer underline decoration-dotted decoration-forest/60 underline-offset-2 hover:text-forest transition"
                                                                                onclick="toggleSpeakerModal('{{ $modalId }}', event)"
                                                                                role="button"
                                                                                tabindex="0"
                                                                                onkeydown="if(event.key==='Enter'){toggleSpeakerModal('{{ $modalId }}', event);}"
                                                                            >
                                                                                {{ $speaker['name'] }}
                                                                            </span>
                                                                        @else
                                                                            <span class="font-semibold text-gray-900">
                                                                                {{ $speaker['name'] }}
                                                                            </span>
                                                                        @endif

                                                                        @if(!empty($speaker['position']))
                                                                            <span class="text-gray-500">
                                                                                — {{ $speaker['position'] }}
                                                                            </span>
                                                                        @endif

                                                                        @if(!empty($speaker['organization']))
                                                                            <span class="text-forest font-medium">
                                                                                · {{ $speaker['organization'] }}
                                                                            </span>
                                                                        @endif

                                                                        @if($hasProfile)
                                                                            {{-- SPEAKER PROFILE MODAL --}}
                                                                            <div id="{{ $modalId }}" class="speaker-modal-overlay hidden" onclick="closeSpeakerModalOnOverlay(event, '{{ $modalId }}')">
                                                                                <div class="speaker-modal-content" onclick="event.stopPropagation()">

                                                                                    <button type="button" class="speaker-modal-close" onclick="toggleSpeakerModal('{{ $modalId }}', event)" aria-label="Close">
                                                                                        <iconify-icon icon="mdi:close" width="22" height="22"></iconify-icon>
                                                                                    </button>

                                                                                    @if(!empty($speaker['image']))
                                                                                        <img src="{{ asset($speaker['image']) }}" alt="{{ $speaker['name'] }}" class="speaker-modal-img">
                                                                                    @endif

                                                                                    <h4 class="font-display font-bold text-lg text-forestdark mb-1">
                                                                                        {{ $speaker['name'] }}
                                                                                    </h4>

                                                                                    @if(!empty($speaker['position']))
                                                                                        <p class="text-sm text-gray-600 mb-0.5">
                                                                                            {{ $speaker['position'] }}
                                                                                        </p>
                                                                                    @endif

                                                                                    @if(!empty($speaker['organization']))
                                                                                        <p class="text-sm font-semibold text-forest mb-3">
                                                                                            {{ $speaker['organization'] }}
                                                                                        </p>
                                                                                    @endif

                                                                                    @if(!empty($speaker['profile']))
                                                                                        <p class="text-sm text-gray-700 leading-relaxed speaker-modal-bio">
                                                                                       {!! $speaker['profile'] !!}
                                                                                        </p>
                                                                                    @endif

                                                                                    @if(!empty($speaker['website']))
                                                                                        <a
                                                                                            href="{{ $speaker['website'] }}"
                                                                                            target="_blank"
                                                                                            rel="noopener noreferrer"
                                                                                            class="inline-flex items-center gap-2 text-sm font-semibold text-forest hover:underline mt-3"
                                                                                        >
                                                                                            Visit Website
                                                                                            <iconify-icon icon="mdi:open-in-new" class="text-base"></iconify-icon>
                                                                                        </a>
                                                                                    @endif

                                                                                </div>
                                                                            </div>
                                                                        @endif

                                                                    </div>

                                                                @endforeach
                                                            </div>

                                                        </div>
                                                    @endif


                                                    {{-- MODERATORS --}}
                                                    @if(!empty($session['moderators']))
                                                        <div class="mt-2">

                                                            <div class="text-xs font-bold uppercase tracking-wide text-forest mb-1">
                                                                Moderator
                                                            </div>

                                                            <div class="space-y-0.5">
                                                                @foreach($session['moderators'] as $moderator)

                                                                    <div class="text-sm leading-6">

                                                                        <span class="font-semibold text-gray-900">
                                                                            {{ $moderator['name'] }}
                                                                        </span>

                                                                        @if(!empty($moderator['position']))
                                                                            <span class="text-gray-500">
                                                                                — {{ $moderator['position'] }}
                                                                            </span>
                                                                        @endif

                                                                        @if(!empty($moderator['organization']))
                                                                            <span class="text-forest font-medium">
                                                                                · {{ $moderator['organization'] }}
                                                                            </span>
                                                                        @endif

                                                                    </div>

                                                                @endforeach
                                                            </div>

                                                        </div>
                                                    @endif


                                                    {{-- FACILITATORS --}}
                                                    @if(!empty($session['facilitators']))
                                                        <div class="mt-2">

                                                            <div class="text-xs font-bold uppercase tracking-wide text-forest mb-1">
                                                                Facilitator
                                                            </div>

                                                            <div class="space-y-0.5">
                                                                @foreach($session['facilitators'] as $facilitator)

                                                                    <div class="text-sm leading-6">

                                                                        <span class="font-semibold text-gray-900">
                                                                            {{ $facilitator['name'] }}
                                                                        </span>

                                                                        @if(!empty($facilitator['position']))
                                                                            <span class="text-gray-500">
                                                                                — {{ $facilitator['position'] }}
                                                                            </span>
                                                                        @endif

                                                                        @if(!empty($facilitator['organization']))
                                                                            <span class="text-forest font-medium">
                                                                                · {{ $facilitator['organization'] }}
                                                                            </span>
                                                                        @endif

                                                                    </div>

                                                                @endforeach
                                                            </div>

                                                        </div>
                                                    @endif

                                                </td>

                                            </tr>

                                        @endforeach

                                    @endforeach
                                </tbody>

                            </table>

                        </div>

                            </div>

                        @endif

                    </div>

                </details>

            @endforeach

           

        </div>

            <h3 class="font-display text-2xl font-bold text-forestdark mb-6">Delegate Registration</h3>
            <p>*Free registration subject to qualification, evaluation, and approval of CITEM</p>
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
               <button type="button" class="mt-5 {{ $btn }}" onclick="window.open('{{ route('conference.registration') }}','_blank')">Reserve a seat</button>
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
                <div class="grid md:grid-cols-4 gap-6 text-left">
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

{{-- EVENT PARTNERS CAROUSEL --}}
<div class="mb-16">

    <h3 class="text-3xl md:text-4xl font-bold text-forest mt-2 mb-8">
        Event Partners
    </h3>

    <div class="relative max-w-6xl mx-auto">

        {{-- LEFT BUTTON --}}
        <button
            type="button"
            onclick="scrollEventPartners(-1)"
            class="ssx-partner-arrow ssx-partner-arrow-left"
            aria-label="Previous partner"
        >
            <iconify-icon
                icon="mdi:chevron-left"
                class="text-2xl text-forest">
            </iconify-icon>
        </button>


        {{-- CAROUSEL TRACK --}}
        <div
            id="eventPartnersCarousel"
            class="ssx-partners-track"
        >

            @foreach($eventPartners as $partner)

                <div class="event-partner-card">

                    <div
                        class="h-full bg-white
                               border-2 border-forest/10
                               rounded-2xl overflow-hidden
                               shadow-sm hover:shadow-lg
                               transition
                               flex flex-col"
                    >

                        {{-- IMAGE --}}
                        <div
                            class="h-40 bg-white
                                   flex items-center justify-center
                                   p-6"
                        >
                            <img
                                src="{{ asset($partner['image']) }}"
                                alt="{{ $partner['name'] }}"
                                loading="lazy"
                                class="max-h-full max-w-full object-contain"
                                style="
                                    width: {{ $partner['image_width'] ?? 'auto' }};
                                "
                            >
                        </div>


                        {{-- CONTENT --}}
                        <div
                            class="p-6 flex flex-col flex-1 text-left"
                        >

                            <h4
                                class="text-lg font-bold text-forest mb-3"
                            >
                                {{ $partner['name'] }}
                            </h4>


                            @if(!empty($partner['description']))

                                <p
                                    class="text-sm text-gray-600
                                           leading-relaxed line-clamp-5"
                                >
                                    {{ $partner['description'] }}
                                </p>

                            @endif


                            @if(!empty($partner['website']))

                                <div class="mt-auto pt-5">

                                    <a
                                        href="{{ $partner['website'] }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center
                                               gap-2 text-sm
                                               font-semibold text-forest
                                               hover:underline"
                                    >
                                        Visit Website

                                        <iconify-icon
                                            icon="mdi:open-in-new"
                                            class="text-base">
                                        </iconify-icon>

                                    </a>

                                </div>

                            @endif

                        </div>

                    </div>

                </div>

            @endforeach

        </div>


        {{-- RIGHT BUTTON --}}
        <button
            type="button"
            onclick="scrollEventPartners(1)"
            class="ssx-partner-arrow ssx-partner-arrow-right"
            aria-label="Next partner"
        >
            <iconify-icon
                icon="mdi:chevron-right"
                class="text-2xl text-forest">
            </iconify-icon>
        </button>

    </div>

</div>
{{-- SESSION PARTNERS CAROUSEL --}}

<div class="mb-16">

    <h3 class="text-3xl md:text-4xl font-bold text-forest mt-2 mb-8">
        Session Partners
    </h3>

    <div class="relative max-w-6xl mx-auto">

        {{-- LEFT BUTTON --}}
        <button
            type="button"
            onclick="scrollSessionPartners(-1)"
            class="ssx-partner-arrow ssx-partner-arrow-left"
            aria-label="Previous session partner"
        >
            <iconify-icon
                icon="mdi:chevron-left"
                class="text-2xl text-forest">
            </iconify-icon>
        </button>


        {{-- CAROUSEL TRACK --}}
        <div
            id="sessionPartnersCarousel"
            class="ssx-partners-track"
        >

            @foreach($sessionPartners as $partner)

                <div class="event-partner-card">

                    <div
                        class="h-full bg-white
                               border-2 border-forest/10
                               rounded-2xl overflow-hidden
                               shadow-sm hover:shadow-lg
                               transition
                               flex flex-col"
                    >

                        {{-- IMAGE --}}
                        <div
                            class="h-40 bg-white
                                   flex items-center justify-center
                                   p-6"
                        >

                            <img
                                src="{{ asset($partner['img']) }}"
                                alt="{{ $partner['company_name'] }}"
                                loading="lazy"
                                class="max-h-full max-w-full object-contain"
                                  style="
                                    width: {{ $partner['image_width'] ?? 'auto' }};
                                "
                            >

                        </div>


                        {{-- CONTENT --}}
                        <div
                            class="p-6 flex flex-col flex-1 text-left"
                        >

                            <h4
                                class="text-lg font-bold text-forest mb-3"
                            >
                                {{ $partner['company_name'] }}
                            </h4>


                            @if(!empty($partner['description']))

                                <p
                                    class="text-sm text-gray-600
                                           leading-relaxed line-clamp-5"
                                >
                                    {{ $partner['description'] }}
                                </p>

                            @endif


                            @if(!empty($partner['website']))

                                <div class="mt-auto pt-5">

                                    <a
                                        href="{{ $partner['website'] }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center
                                               gap-2 text-sm
                                               font-semibold text-forest
                                               hover:underline"
                                    >

                                        Visit Website

                                        <iconify-icon
                                            icon="mdi:open-in-new"
                                            class="text-base">
                                        </iconify-icon>

                                    </a>

                                </div>

                            @endif

                        </div>

                    </div>

                </div>

            @endforeach

        </div>


        {{-- RIGHT BUTTON --}}
        <button
            type="button"
            onclick="scrollSessionPartners(1)"
            class="ssx-partner-arrow ssx-partner-arrow-right"
            aria-label="Next partner"
        >

            <iconify-icon
                icon="mdi:chevron-right"
                class="text-2xl text-forest">
            </iconify-icon>

        </button>

    </div>

</div>

{{-- GOVERNMENT PARTNERS --}}
<div class="mb-16">
    <h3 class="text-3xl md:text-4xl font-bold text-forest mt-2 mb-8">
        Government Partners
    </h3>

    <div class="relative max-w-6xl mx-auto">

        {{-- LEFT BUTTON --}}
        <button type="button"
                onclick="scrollGovernmentPartners(-1)"
                class="ssx-partner-arrow ssx-partner-arrow-left"
                aria-label="Previous government partner">
            <iconify-icon
                icon="mdi:chevron-left"
                class="text-2xl text-forest">
            </iconify-icon>
        </button>

        {{-- CAROUSEL --}}
        <div id="governmentPartnersCarousel"
             class="ssx-partners-track">

            @foreach($governmentPartners as $partner)

                <div class="event-partner-card">

                    <div class="h-full bg-white border-2 border-forest/10 rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition flex flex-col">

                        {{-- LOGO --}}
                        <div class="h-40 bg-white flex items-center justify-center p-6">
                            <img
                                src="{{ asset($partner['img']) }}"
                                alt="{{ $partner['company_name'] }}"
                                loading="lazy"
                                class="max-h-full max-w-full object-contain"
                                  style="
                                    width: {{ $partner['image_width'] ?? 'auto' }};
                                "
                                >
                                
                        </div>

                        {{-- CONTENT --}}
                        <div class="p-6 flex flex-col flex-1 text-left">

                            <h4 class="text-lg font-bold text-forest mb-3">
                                {{ $partner['company_name'] }}
                            </h4>

                            @if(!empty($partner['description']))
                                <p class="text-sm text-gray-600 leading-relaxed line-clamp-5">
                                    {{ $partner['description'] }}
                                </p>
                            @endif

                            {{-- WEBSITE --}}
                            @if(!empty($partner['website']))
                                <div class="mt-auto pt-5">

                                    <a
                                        href="{{ $partner['website'] }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center gap-2 text-sm font-semibold text-forest hover:underline">

                                        Visit Website

                                        <iconify-icon
                                            icon="mdi:open-in-new"
                                            class="text-base">
                                        </iconify-icon>

                                    </a>

                                </div>
                            @endif

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

        {{-- RIGHT BUTTON --}}
        <button type="button"
                onclick="scrollGovernmentPartners(1)"
                class="ssx-partner-arrow ssx-partner-arrow-right"
                aria-label="Next government partner">

            <iconify-icon
                icon="mdi:chevron-right"
                class="text-2xl text-forest">
            </iconify-icon>

        </button>

    </div>
</div>

{{-- INSTITUTIONAL PARTNERS --}}
<div class="mb-16">
    <h3 class="text-3xl md:text-4xl font-bold text-forest mt-2 mb-8">
        Institutional Partners
    </h3>

    <div class="relative max-w-6xl mx-auto">

        {{-- LEFT BUTTON --}}
        <button type="button"
                onclick="scrollInstitutionalPartners(-1)"
                class="ssx-partner-arrow ssx-partner-arrow-left"
                aria-label="Previous institutional partner">

            <iconify-icon
                icon="mdi:chevron-left"
                class="text-2xl text-forest">
            </iconify-icon>

        </button>

        {{-- CAROUSEL --}}
        <div id="institutionalPartnersCarousel"
             class="ssx-partners-track">

            @foreach($institutionalPartners as $partner)

                <div class="event-partner-card">

                    <div class="h-full bg-white border-2 border-forest/10 rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition flex flex-col">

                        {{-- LOGO --}}
                        <div class="h-40 bg-white flex items-center justify-center p-6">

                            <img
                                src="{{ asset($partner['img']) }}"
                                alt="{{ $partner['company_name'] }}"
                                loading="lazy"
                                class="max-h-full max-w-full object-contain"
                                 style="
                                    width: {{ $partner['image_width'] ?? 'auto' }};
                                "
                                >

                        </div>

                        {{-- CONTENT --}}
                        <div class="p-6 flex flex-col flex-1 text-left">

                            <h4 class="text-lg font-bold text-forest mb-3">
                                {{ $partner['company_name'] }}
                            </h4>

                            @if(!empty($partner['description']))
                                <p class="text-sm text-gray-600 leading-relaxed line-clamp-5">
                                    {{ $partner['description'] }}
                                </p>
                            @endif

                            {{-- WEBSITE --}}
                            @if(!empty($partner['website']))
                                <div class="mt-auto pt-5">

                                    <a
                                        href="{{ $partner['website'] }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center gap-2 text-sm font-semibold text-forest hover:underline">

                                        Visit Website

                                        <iconify-icon
                                            icon="mdi:open-in-new"
                                            class="text-base">
                                        </iconify-icon>

                                    </a>

                                </div>
                            @endif

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

        {{-- RIGHT BUTTON --}}
        <button type="button"
                onclick="scrollInstitutionalPartners(1)"
                class="ssx-partner-arrow ssx-partner-arrow-right"
                aria-label="Next institutional partner">

            <iconify-icon
                icon="mdi:chevron-right"
                class="text-2xl text-forest">
            </iconify-icon>

        </button>

    </div>
</div>

{{-- OFFICIAL PARTNERS --}}
<div class="mb-16">

    <h3 class="text-3xl md:text-4xl font-bold text-forest mt-2 mb-8">
        Official Partners
    </h3>

    <div class="grid md:grid-cols-2 gap-6 text-left">

        {{-- OFFICIAL TRAINING & EVENT PARTNER --}}
        @foreach($officialTrainingEventPartners as $partner)

            <div class="bg-white border-2 border-forest/10 rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition flex flex-col">

                {{-- LOGO --}}
                <div class="h-40 bg-white flex items-center justify-center p-6">

                    <img
                        src="{{ asset($partner['img']) }}"
                        alt="{{ $partner['company_name'] }}"
                        loading="lazy"
                        class="max-h-full max-w-full object-contain"
                        style="width: {{ $partner['image_width'] ?? 'auto' }};"
                    >

                </div>

                {{-- CONTENT --}}
                <div class="p-6 flex flex-col flex-1 text-left">

                    <span class="text-xs font-bold uppercase tracking-widest text-stone mb-2">
                        Official Training & Event Partner
                    </span>

                    <h4 class="text-lg font-bold text-forest mb-3">
                        {{ $partner['company_name'] }}
                    </h4>

                    @if(!empty($partner['description']))
                        <p class="text-sm text-gray-600 leading-relaxed line-clamp-6">
                            {{ $partner['description'] }}
                        </p>
                    @endif

                    @if(!empty($partner['website']))
                        <div class="mt-auto pt-5">

                            <a
                                href="{{ $partner['website'] }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 text-sm font-semibold text-forest hover:underline"
                            >
                                Visit Website

                                <iconify-icon
                                    icon="mdi:open-in-new"
                                    class="text-base">
                                </iconify-icon>

                            </a>

                        </div>
                    @endif

                </div>

            </div>

        @endforeach


        {{-- OFFICIAL BUSINESS LOUNGE PARTNER --}}
        @foreach($officialBusinessLoungePartners as $partner)

            <div class="bg-white border-2 border-forest/10 rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition flex flex-col">

                {{-- LOGO --}}
                <div class="h-40 bg-white flex items-center justify-center p-6">

                    <img
                        src="{{ asset($partner['img']) }}"
                        alt="{{ $partner['company_name'] }}"
                        loading="lazy"
                        class="max-h-full max-w-full object-contain"
                        style="width: {{ $partner['image_width'] ?? 'auto' }};"
                    >

                </div>

                {{-- CONTENT --}}
                <div class="p-6 flex flex-col flex-1 text-left">

                    <span class="text-xs font-bold uppercase tracking-widest text-stone mb-2">
                        Official Business Lounge Partner
                    </span>

                    <h4 class="text-lg font-bold text-forest mb-3">
                        {{ $partner['company_name'] }}
                    </h4>

                    @if(!empty($partner['description']))
                        <p class="text-sm text-gray-600 leading-relaxed line-clamp-6">
                            {{ $partner['description'] }}
                        </p>
                    @endif

                    @if(!empty($partner['website']))
                        <div class="mt-auto pt-5">

                            <a
                                href="{{ $partner['website'] }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 text-sm font-semibold text-forest hover:underline"
                            >
                                Visit Website

                                <iconify-icon
                                    icon="mdi:open-in-new"
                                    class="text-base">
                                </iconify-icon>

                            </a>

                        </div>
                    @endif

                </div>

            </div>

        @endforeach


        {{-- OFFICIAL TOKEN PARTNER --}}
        {{-- @foreach($officialTokenPartners as $partner)

            <div class="bg-white border-2 border-forest/10 rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition flex flex-col">

               
                <div class="h-40 bg-white flex items-center justify-center p-6">

                    <img
                        src="{{ asset($partner['img']) }}"
                        alt="{{ $partner['company_name'] }}"
                        loading="lazy"
                        class="max-h-full max-w-full object-contain"
                        style="width: {{ $partner['image_width'] ?? 'auto' }};"
                    >

                </div>

                <div class="p-6 flex flex-col flex-1 text-left">

                    <span class="text-xs font-bold uppercase tracking-widest text-stone mb-2">
                        Official Token Partner
                    </span>

                    <h4 class="text-lg font-bold text-forest mb-3">
                        {{ $partner['company_name'] }}
                    </h4>

                    @if(!empty($partner['description']))
                        <p class="text-sm text-gray-600 leading-relaxed line-clamp-6">
                            {{ $partner['description'] }}
                        </p>
                    @endif

                    @if(!empty($partner['website']))
                        <div class="mt-auto pt-5">

                            <a
                                href="{{ $partner['website'] }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center gap-2 text-sm font-semibold text-forest hover:underline"
                            >
                                Visit Website

                                <iconify-icon
                                    icon="mdi:open-in-new"
                                    class="text-base">
                                </iconify-icon>

                            </a>

                        </div>
                    @endif

                </div>

            </div>

        @endforeach --}}

    </div>

</div>
          

        </div>

    </section>
        <section id="partnership" class="bg-white">


        <div class="max-w-5xl mx-auto text-center px-6 py-16 md:py-20">
          






            <h3 class="font-display text-2xl font-bold text-forestdark mb-2">Be Part of the Green Shift.</h3>
            <p class="text-forest max-w-2xl mx-auto mb-10">Whether you are a solution provider looking to showcase innovation or a corporate leader ready to champion sustainability, now is the time to secure your place.</p>
<div class="flex flex-wrap justify-center gap-5 text-left">
   @foreach($shiftCtas as $cta)

    <div
        class="w-full md:w-[calc(100%-10px)] flex items-center gap-4 bg-white border border-forest/20 rounded-2xl p-6 border-l-4 cursor-pointer hover:translate-x-1 hover:shadow-[0_12px_24px_rgba(31,69,34,0.12)] transition-all duration-200"
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
        href="mailto:mlquimson.citem@gmail.com?subject=SSX%202026%20Partnership%20Inquiry"
        class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-forest text-white font-semibold rounded-lg hover:bg-forestdark transition-colors no-underline hover:no-underline">
        <iconify-icon
            icon="solar:handshake-outline"
            width="20"
            height="20">
        </iconify-icon>
        Partner with Us
    </a>
</div>
        </div>

    </section>
 {{-- <section id="pitching" class="bg-forestdark py-16 md:py-20 px-6 md:px-16">
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
    </section> --}}
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
                        display: ['DIN-Bold,Open Sans,Helvetica,sans-serif'],
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

/* ==========================================================
   EVENT PARTNERS CAROUSEL
   Hard-coded CSS (not relying on Tailwind CDN JIT for
   bracket-notation classes) so this always renders as a true
   horizontal, one-card-at-a-time carousel on every screen size.
   ========================================================== */

.ssx-partners-track {
    display: flex !important;
    flex-wrap: nowrap !important;
    overflow-x: auto !important;
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
    gap: 24px;
    padding: 8px 8px 16px;
    scrollbar-width: none;
    -ms-overflow-style: none;
}

.ssx-partners-track::-webkit-scrollbar {
    display: none;
}

.ssx-partners-track .event-partner-card {
    flex: 0 0 auto !important;
    width: 85vw;
    scroll-snap-align: start;
}

@media (min-width: 640px) {
    .ssx-partners-track .event-partner-card { width: 80vw; }
}

@media (min-width: 768px) {
    .ssx-partners-track .event-partner-card { width: calc((100% - 24px) / 2); }
}

@media (min-width: 1024px) {
    .ssx-partners-track .event-partner-card { width: calc((100% - 48px) / 3); }
}

.ssx-partner-arrow {
    position: absolute !important;
    top: 50% !important;
    transform: translateY(-50%) !important;
    z-index: 20 !important;
    width: 40px;
    height: 40px;
    border-radius: 9999px;
    background: #fff !important;
    box-shadow: 0 4px 14px rgba(0,0,0,0.15) !important;
    border: 1px solid rgba(31,69,34,0.1);
    display: flex !important;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    padding: 0;
}

.ssx-partner-arrow:hover {
    transform: translateY(-50%) scale(1.08) !important;
}

.ssx-partner-arrow-left { left: 4px !important; }
.ssx-partner-arrow-right { right: 4px !important; }

@media (min-width: 768px) {
    .ssx-partner-arrow-left { left: -20px !important; }
    .ssx-partner-arrow-right { right: -20px !important; }
    .ssx-partner-arrow { width: 48px; height: 48px; }
}

/* ==========================================================
   SPEAKER PROFILE MODAL (status = 1 speakers)
   ========================================================== */

.speaker-modal-overlay {
    position: fixed !important;
    inset: 0 !important;
    background: rgba(15, 30, 15, 0.6) !important;
    z-index: 9999 !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    padding: 20px !important;
}

.speaker-modal-overlay.hidden {
    display: none !important;
}

.speaker-modal-content {
    background: #fff;
    border-radius: 20px;
    max-width: 480px;
    width: 100%;
    max-height: 85vh;
    overflow-y: auto;
    padding: 28px;
    position: relative;
    box-shadow: 0 20px 50px rgba(0,0,0,0.35);
    border: 2px solid #357937;
    text-align: left;
}

.speaker-modal-close {
    position: absolute;
    top: 14px;
    right: 14px;
    width: 34px;
    height: 34px;
    border-radius: 9999px;
    background: #FAFAEA;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: #1F4522;
}

.speaker-modal-close:hover {
    background: #357937;
    color: #fff;
}

.speaker-modal-img {
    width: 96px;
    height: 96px;
    border-radius: 9999px;
    object-fit: cover;
    margin-bottom: 14px;
    border: 3px solid #357937;
}

.speaker-modal-bio {
    max-height: 260px;
    overflow-y: auto;
}

.speaker-trigger:focus-visible {
    outline: 2px solid #357937;
    outline-offset: 2px;
    border-radius: 3px;
}
    </style>
@endpush

@push('scripts')
<script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>

<script>
/* ==========================================================
   SPEAKER PROFILE MODAL
   - Click a speaker name (status = 1) to open their profile.
   - Clicking a different speaker closes the current one and
     opens the new one.
   - Clicking the dark overlay, the close (X) button, or
     pressing Escape closes the open modal.
   ========================================================== */

window.toggleSpeakerModal = function (id, event) {
    if (event) {
        event.stopPropagation();
    }

    // Close every other open modal first.
    document.querySelectorAll('.speaker-modal-overlay').forEach(function (modal) {
        if (modal.id !== id) {
            modal.classList.add('hidden');
        }
    });

    var target = document.getElementById(id);
    if (!target) return;

    // Toggle the requested modal.
    target.classList.toggle('hidden');
};

window.closeSpeakerModalOnOverlay = function (event, id) {
    var target = document.getElementById(id);
    if (target) {
        target.classList.add('hidden');
    }
};

document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.speaker-modal-overlay').forEach(function (modal) {
            modal.classList.add('hidden');
        });
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | REUSABLE PARTNER CAROUSEL
    |--------------------------------------------------------------------------
    */

    function initPartnerCarousel(carouselId, scrollFunctionName) {

        const carousel = document.getElementById(carouselId);

        if (!carousel) return;

        const originalCards = Array.from(
            carousel.querySelectorAll('.event-partner-card')
        );

        if (originalCards.length === 0) return;


        /*
        |--------------------------------------------------------------------------
        | CREATE CLONES
        |--------------------------------------------------------------------------
        */

        const clonesBefore = originalCards.map(card =>
            card.cloneNode(true)
        );

        const clonesAfter = originalCards.map(card =>
            card.cloneNode(true)
        );


        // Add clones BEFORE originals
        clonesBefore.reverse().forEach(card => {
            carousel.insertBefore(
                card,
                carousel.firstChild
            );
        });


        // Add clones AFTER originals
        clonesAfter.forEach(card => {
            carousel.appendChild(card);
        });


        /*
        |--------------------------------------------------------------------------
        | CALCULATE ORIGINAL SET WIDTH
        |--------------------------------------------------------------------------
        */

        function getOriginalSetWidth() {

            const cards = Array.from(
                carousel.querySelectorAll('.event-partner-card')
            );

            const firstSet = cards.slice(
                originalCards.length,
                originalCards.length * 2
            );

            if (firstSet.length === 0) return 0;

            const gap = 24;

            const cardWidth = firstSet.reduce(
                (total, card) => {
                    return total + card.offsetWidth;
                },
                0
            );

            return cardWidth +
                ((firstSet.length - 1) * gap);
        }


        /*
        |--------------------------------------------------------------------------
        | MOVE TO ORIGINAL SET
        |--------------------------------------------------------------------------
        */

        function moveToOriginalSet() {

            const cards = Array.from(
                carousel.querySelectorAll('.event-partner-card')
            );

            const firstOriginalCard =
                cards[originalCards.length];

            if (!firstOriginalCard) return;

            carousel.scrollLeft =
                firstOriginalCard.offsetLeft -
                carousel.offsetLeft;
        }


        /*
        |--------------------------------------------------------------------------
        | INITIAL POSITION
        |--------------------------------------------------------------------------
        */

        setTimeout(function () {
            moveToOriginalSet();
        }, 100);


        /*
        |--------------------------------------------------------------------------
        | NEXT / PREVIOUS BUTTON
        |--------------------------------------------------------------------------
        */

        window[scrollFunctionName] = function (direction) {

            const card =
                carousel.querySelector('.event-partner-card');

            if (!card) return;

            const gap = 24;

            const cardWidth =
                card.offsetWidth;

            carousel.scrollBy({
                left:
                    direction * (cardWidth + gap),
                behavior: 'smooth'
            });
        };


        /*
        |--------------------------------------------------------------------------
        | INFINITE CAROUSEL
        |--------------------------------------------------------------------------
        */

        let isResetting = false;

        carousel.addEventListener('scroll', function () {

            if (isResetting) return;

            const totalOriginalWidth =
                getOriginalSetWidth();

            if (!totalOriginalWidth) return;


            /*
            |--------------------------------------------------------------------------
            | LEFT
            |--------------------------------------------------------------------------
            */

            if (
                carousel.scrollLeft <=
                totalOriginalWidth * 0.1
            ) {

                isResetting = true;

                carousel.scrollLeft +=
                    totalOriginalWidth;

                requestAnimationFrame(function () {
                    isResetting = false;
                });
            }


            /*
            |--------------------------------------------------------------------------
            | RIGHT
            |--------------------------------------------------------------------------
            */

            else if (
                carousel.scrollLeft >=
                totalOriginalWidth * 1.9
            ) {

                isResetting = true;

                carousel.scrollLeft -=
                    totalOriginalWidth;

                requestAnimationFrame(function () {
                    isResetting = false;
                });
            }
        });


        /*
        |--------------------------------------------------------------------------
        | AUTO MOVE
        |--------------------------------------------------------------------------
        */

        let autoScrollTimer;

        function startAutoScroll() {

            clearInterval(autoScrollTimer);

            autoScrollTimer = setInterval(function () {

                const card =
                    carousel.querySelector('.event-partner-card');

                if (!card) return;

                const gap = 24;

                const cardWidth =
                    card.offsetWidth;

                carousel.scrollBy({
                    left: cardWidth + gap,
                    behavior: 'smooth'
                });

            }, 2500);
        }


        /*
        |--------------------------------------------------------------------------
        | PAUSE WHEN MOUSE IS OVER CAROUSEL
        |--------------------------------------------------------------------------
        */

        carousel.addEventListener('mouseenter', function () {
            clearInterval(autoScrollTimer);
        });

        carousel.addEventListener('mouseleave', function () {
            startAutoScroll();
        });


        /*
        |--------------------------------------------------------------------------
        | START AUTO SCROLL
        |--------------------------------------------------------------------------
        */

        setTimeout(function () {
            startAutoScroll();
        }, 1000);


        /*
        |--------------------------------------------------------------------------
        | HANDLE RESIZE
        |--------------------------------------------------------------------------
        */

        let resizeTimer;

        window.addEventListener('resize', function () {

            clearTimeout(resizeTimer);

            resizeTimer = setTimeout(function () {
                moveToOriginalSet();
            }, 150);

        });

    }


    /*
    |--------------------------------------------------------------------------
    | INITIALIZE ALL PARTNER CAROUSELS
    |--------------------------------------------------------------------------
    */

    initPartnerCarousel(
        'eventPartnersCarousel',
        'scrollEventPartners'
    );

    initPartnerCarousel(
        'sessionPartnersCarousel',
        'scrollSessionPartners'
    );

    initPartnerCarousel(
        'governmentPartnersCarousel',
        'scrollGovernmentPartners'
    );

    initPartnerCarousel(
        'institutionalPartnersCarousel',
        'scrollInstitutionalPartners'
    );

});
</script>
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

document.addEventListener('DOMContentLoaded', function () { document.querySelectorAll('.ssx-drag-scroll').forEach((slider) => { let isDown = false, startX, scrollLeft; slider.addEventListener('mousedown', (e) => { isDown = true; slider.classList.add('dragging'); startX = e.pageX - slider.offsetLeft; scrollLeft = slider.scrollLeft; }); slider.addEventListener('mouseleave', () => { isDown = false; slider.classList.remove('dragging'); }); slider.addEventListener('mouseup', () => { isDown = false; slider.classList.remove('dragging'); }); slider.addEventListener('mousemove', (e) => { if (!isDown) return; e.preventDefault(); const x = e.pageX - slider.offsetLeft; const walk = (x - startX) * 1.5; slider.scrollLeft = scrollLeft - walk; }); }); if (window.jQuery) { $('#nav-events').addClass('active'); } });



</script>
@endpush