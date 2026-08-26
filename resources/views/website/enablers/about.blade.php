@extends('layouts.website')

@section('content')
<div class="section subnav beige-bg nav-holder gradient-top">
    <div class="content">
        <div class="d-flex justify-content-center">
            <h3 class="me-3">Browse Services: </h3>
            <div class="mt-2 me-3 lightgreen">
                <i class="fas fa-globe align-middle fs-4"></i> <a href="{{ route('services.export-enablers.index') }}" class="text-decoration-none">Export Enablers</a>
            </div>
            <!-- <div class="mt-2 black">
                <i class="fas fa-handshake align-middle fs-4"></i> <a href="{{ route('services.export-enablers.index') }}" class="text-decoration-none">Partnership Opportunities</a>
            </div> -->
        </div>
    </div>
</div>
<div class="section form-header certification-header intelligence">
    <div class="content">
        <div class="header-desc">
            <center>
                <h1>Business Solutions Services</h1>
            </center>
            <p>Business Solutions Services is a program featuring private companies, government institutions, organizations, and individuals that offer services, solutions or products that help exporters meet their goals in all aspects of the business, from inception to operations.</p>
        </div>
    </div>
</div>
<div class="section black mt-5 mb-5">
    <div class="content">
        <h3 class="pb-3">Frequently Ask Questions</h3>
        <h4>1. Is signing up as a Business Solutions Partner FREE?</h4>
        <p>Yes, signing up as a Business Solutions Partner is FREE subject to screening. Our Basic package is inclusive of company name, company description, logo, contact information, featured services and a dedicated inquiry form.</p>
        <h4>2. Who can be part of the Business Solutions Services Program?</h4>
        <p>Private companies, government entities, professionals such as creative and technical consultants and certifying bodies from both local and overseas.</p>
        <h4>3. What services do I need to be a Business Solutions Partner?</h4>
        <p>Your solutions should be geared towards exporters and aspiring exporters. This can be related to trainings, logistics, export marketing, design, product development or other relevant services. Note that companies will be screened prior to acceptance as an Business Solutions Partner.</p>
    </div>
</div>
<div class="container mb-5">
    <div class="row justify-content-md-center">
        <div class="col text-center">
            <a href="{{ route('services.export-enablers.index') }}"><button type="button" class="submit_btn mb-4">View Directory</button></a>
        </div>
    </div>
</div>
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