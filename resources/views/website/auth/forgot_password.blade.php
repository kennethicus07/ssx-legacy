@extends('layouts.website')

@section('content')
<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-12 col-md-7">
            <div class="login-holder">
                <div class="content mt-5 mb-5 registration-form">
                    <h1>Forgot password</h1>
                    @if (session('status'))
                    <div class="alert alert-success mt-4" role="alert">
                        <h4 class="alert-heading m-0 p-0 mb-2">Thank you!</h4>
                        <p>If the e-mail you have entered exists in our system, we will sent a link to reset your password in a few seconds.</p>
                        <p>If you do not receive the email, Please check your spam folder.</p>
                    </div>
                    @else
                    <p class="mt-4">Please enter your registered email address to request a password reset.</p>
                    <form action="{{ route('auth.forgot.password.request') }}" method="post">
                        @csrf
                        <div class="row g-3">
                            <div class="form-label-group">
                                <label for="email" class="form-label text-uppercase fw-bold">Email address:</label>
                                <input type="email" class="form-control text-lowercase @error('email') is-invalid @enderror" id="email" name="email" placeholder="email@domain.com" autofocus>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="push-right link-border">
                                <button type="submit" class="btn btn-sm black_btn"><strong>SUBMIT</strong></button>
                            </div>          
                        </div>
                    </form>
                    @endif
                    <h4>Don't have an account?</h4>
                    <div class="flex link-border">
                        <a href="{{ route('registration.supplier') }}" class="lightgreen_btn arrow_btn">Register as a Supplier/Exhibitor</a>
                        <a href="{{ route('registration.buyer') }}" class="orange_btn arrow_btn">Register as a Purchaser/Buyer</a>
                    </div>
                    <h4>Join the Event!</h4>
                    <div class="flex link-border">
                        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#attendee_modal" class="maroon_btn arrow_btn">Register as an Attendee</a>
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