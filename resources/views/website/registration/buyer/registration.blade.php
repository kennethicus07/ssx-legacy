@extends('layouts.website')

@section('content')
<div class="section form-header">
    <div class="content">
        <div class="header-desc">
            <center>
                <h1>Purchaser/Buyer Registration</h1>
            </center>
        </div>
    </div>
</div>
<registration-buyer-registration params="{{ json_decode($id)}}"></registration-buyer-registration>
@endsection

@push('styles')
@endpush
@push('scripts')
@endpush