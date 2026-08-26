@extends('layouts.website')

@section('content')
    <div class="section form-header">
        <div class="content">
            <div class="header-desc">
                <center>
                    <h1>Digital Exhibition & Conference 2025</h1>
                </center>
                <p>Sustainable Solutions Exchange is a digital trade event. It promotes sustainable products and solutions
                    that drive businesses to transition towards green growth. SSX highlights the latest relevant solutions
                    and technologies, and champions local producers in the food and lifestyle sectors that adhere to
                    sustainable practices. Experience it again by rewatching the sessions available on our online platforms.
                </p>
            </div>
        </div>
    </div>
    <div class="container mt-5 mb-5 w-75">
        <div class="row g-0">
            @foreach ($conferences as $conference)
                <div class="col-12 mt-5">
                    <div class="card mb-4">
                        @if ($loop->iteration === 1)
                            <div class="card-header lightgreen-bg">
                            @elseif ($loop->iteration === 2)
                                <div class="card-header maroon-bg orange">
                                @elseif ($loop->iteration === 3)
                                    <div class="card-header orange-bg maroon">
                                    @else
                                        <div class="card-header lightgreen-bg">
                        @endif
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <div class="text-uppercase text-center">
                                    <h3 class="p-0 m-0">{{ $conference->sub_title }}</h3>
                                    {{ $conference->conference_date->format('j F Y') }}
                                </div>
                            </div>
                            <div class="col-md-8 text-center">
                                <h3 class="mt-3">{{ $conference->title }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <div class="row">
            @foreach ($conference->videos as $video)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <a href="" role="button" data-bs-toggle="modal"
                            data-tagVideo="https://www.youtube.com/embed/{{ $video->video_id }}"
                            data-bs-target="#videoModal"><img
                                src="http://img.youtube.com/vi/{{ $video->video_id }}/hqdefault.jpg" class="card-img-top"
                                alt="..."></a>
                        <div class="card-body card-text">
                            {!! $video->details !!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @endforeach
    </div>
    </div>
    <div class="modal fade" id="videoModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="ratio ratio-16x9">
                        <iframe src="" allow="autoplay;" allowfullscreen></iframe>
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
            $('#nav-articles').addClass('active');
            autoPlayYouTubeModal();
        });
        // Get and autoplay Video from data
        function autoPlayYouTubeModal() {
            var triggerOpen = $("body").find('[data-tagVideo]');
            triggerOpen.click(function() {
                var theModal = $(this).data("bs-target"),
                    videoSRC = $(this).attr("data-tagVideo"),
                    videoSRCauto = videoSRC + "?autoplay=1";
                $(theModal + ' iframe').attr('src', videoSRCauto);
                $(theModal + ' button.btn-close').click(function() {
                    $(theModal + ' iframe').attr('src', videoSRC);
                });
            });
        }
    </script>
@endpush
