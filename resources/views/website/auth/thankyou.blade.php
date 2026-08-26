@extends('layouts.website')

@section('content')
<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-6">
            <div class="login-holder">
                <div class="content mt-5 mb-5 registration-form">
                    <h1>Create password</h1>
                    <div class="alert alert-success mt-4" role="alert">
                        <h4 class="alert-heading m-0 p-0 mb-2">Thank you!</h4>
                        <p>You can now log in with your new password.</p>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('auth.index') }}" role="button" class="btn btn-sm btn-success"><strong>LOGIN</strong></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
@endpush
@push('scripts')
@endpush