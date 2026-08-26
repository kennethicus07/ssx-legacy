@extends('layouts.website')

@section('content')
<div class="section form-header">
    <div class="content">
        <div class="header-desc">
            <center>
                <h1>Supplier/Exhibitor Registration</h1>
            </center>
        </div>
    </div>
</div>
<registration-exhibitor-registration params="{{ json_decode($id)}}"></registration-exhibitor-registration>
@endsection

@push('styles')
@endpush
@push('scripts')
@endpush