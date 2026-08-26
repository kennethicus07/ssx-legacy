@extends('layouts.website')

@section('content')
<div class="mt-3">&nbsp;</div>
<div class="container-fluid lightgreen-bg p-5 registration-header">
    <div class="row">
        <div class="col-12 text-center">
            <h1 class="text-white">404</h1>
        </div>
    </div>
</div>
<div class="section mt-5 mb-5">
    <div class="container text-center">
        <h2>Sorry! Page Not Found.</h2>
        <p class="mt-4">The page you are looking for was moved, removed, renamed or might never have existed.</p>
        <p class="mb-4"><a href="{{ route('home') }}" class="btn btn-sm btn-outline-success">Back to home</a></p>
        <p>Need Assistance? <a href="{{ route('home') }}" class="link-success">Contact Us</a></p>
    </div>
</div>
@endsection

@push('styles')
@endpush
@push('scripts')
@endpush