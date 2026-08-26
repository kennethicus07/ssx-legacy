@extends('layouts.website')

@section('content')
<div class="section subnav beige-bg nav-holder gradient-top">
    <div class="content">
        <div class="d-flex justify-content-center">
            <h3 class="me-3">Browse Services: </h3>
            <div class="mt-2 me-3 lightgreen">
                <i class="fas fa-globe align-middle fs-4"></i> <a href="{{ route('services.export-enablers.index') }}" class="text-decoration-none">Business Solutions Services</a>
            </div>
            <!-- <div class="mt-2 black">
                <i class="fas fa-handshake align-middle fs-4"></i> <a href="{{ route('services.export-enablers.index') }}" class="text-decoration-none">Partnership Opportunities</a>
            </div> -->
        </div>
    </div>
</div>
<export-enablers></export-enablers>
<x-contactus title="Get in touch with us." subtitle="Sustainability values partnerships."
    details="SSX is also a hub for business, partnerships, and networking. Help us empower our stakeholders by becoming a sustainability partner or enabler." />
@endsection

@push('styles')
@endpush
@push('scripts')
<script>
$(document).ready(function() {
    $('#nav-services').addClass('active');
});
</script>
@endpush