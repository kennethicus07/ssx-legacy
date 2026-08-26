@extends('layouts.website')

@section('content')
    <div class="section form-header">
        <div class="content">
            <div class="header-desc">
                <center>
                    <h1>Conference Registration</h1>
                </center>
            </div>
        </div>
    </div>
    <registration-conference-registration :params="{{ json_encode(['id' => $id]) }}"></registration-conference-registration>
@endsection

@push('styles')
@endpush
@push('scripts')
@endpush