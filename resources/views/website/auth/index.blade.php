@extends('layouts.website')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-10">
                <div class="login-holder">
                    <div class="content mt-5 mb-5 registration-form">
                        <h1>Log in to your account.</h1>

                        {{-- Flash Messages --}}
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if (session('info'))
                            <div class="alert alert-info">{{ session('info') }}</div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form action="{{ route('auth.attempt') }}" method="post">
                            @csrf
                            <div class="row mt-4 g-3">
                                <div class="form-label-group">
                                    <label for="email" class="form-label text-uppercase fw-bold">E-mail address:</label>
                                    <input type="email"
                                        class="form-control text-lowercase @error('email') is-invalid @enderror"
                                        id="email" name="email" placeholder="email@domain.com" autofocus>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-label-group">
                                    <label for="pwd" class="form-label text-uppercase fw-bold">Password:</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="pwd" name="password" placeholder="password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="pt-20 push-right link-border">
                                    <button type="submit" class="btn btn-sm black_btn"><strong>SUBMIT</strong></button>
                                </div>
                                <div class="push-right mt-0">
                                    <a href="{{ route('auth.forgot.password') }}" class="black"><sub><strong>Forgot
                                                Password?</strong></sub></a>
                                </div>
                            </div>
                        </form>
                        <h4>Don't have an account?</h4>
                        <div class="flex link-border">
                            <a href="{{ route('registration.supplier') }}" class="lightgreen_btn arrow_btn">Register as a
                                Supplier/Exhibitor</a>
                            <a href="{{ route('registration.buyer') }}" class="orange_btn arrow_btn">Register as a
                                Purchaser/Buyer</a>
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
