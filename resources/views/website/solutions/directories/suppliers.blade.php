@extends('layouts.website')

@section('content')
<div class="section subnav beige-bg nav-holder gradient-top">
    <div class="content">
        <div class="d-flex justify-content-center">
            <h3 class="me-3">Browse Solutions: </h3>
            <div class="mt-2 me-3 lightgreen">
                <i class="fas fa-book-open align-middle fs-4"></i> <a href="{{ route('solutions.directories.index') }}" class="text-decoration-none">Marketplace</a>
            </div>
            <div class="mt-2 me-3 black">
                <i class="fas fa-solar-panel align-middle fs-4"></i> <a href="{{ route('solutions.sustainable.index') }}" class="text-decoration-none">Sustainable Solutions</a>
            </div>
            <div class="mt-2 black">
                <i class="fas fa-lightbulb align-middle fs-4"></i> <a href="{{ route('solutions.intelligence.index') }}" class="text-decoration-none">Solutions Intelligence</a>
            </div>
        </div>
    </div>
</div>
<solutions-directories-suppliers></solutions-directories-suppliers>
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