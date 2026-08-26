@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row g-5 justify-content-center">
        <div class="col-12">
            <p class="text-danger text-center fs-1 fw-bold mt-5">403</p>
            <p class="text-danger text-center fs-1 fw-bold">Forbidden</p>
            <p class="text-muted text-center">USER DOES NOT HAVE THE RIGHT PERMISSIONS.</p>
            <p class="text-center mt-4"><a href="{{ route('admin.dashboard') }}" class="btn btn-danger btn-rounded waves-effect waves-light mb-5 text-white">Back to home</a></p>
        </div>
    </div>
</div>
@endsection

@push('styles')
@endpush
@push('scripts')
@endpush