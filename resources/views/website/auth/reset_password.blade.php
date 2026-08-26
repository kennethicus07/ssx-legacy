@extends('layouts.website')

@section('content')
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-12 col-md-7">
                <div class="login-holder">
                    <div class="content mt-5 mb-5 registration-form">
                        <h1>Reset password</h1>
                        @if (session('status_success'))
                            <div class="alert alert-success mt-4" role="alert">
                                <h4 class="alert-heading m-0 p-0 mb-2">Thank you!</h4>
                                <p>Your password has been successfully reset. You can now log in with your new password.</p>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{ route('auth.index') }}" role="button"
                                        class="btn btn-sm btn-success"><strong>LOGIN</strong></a>
                                </div>
                            </div>
                        @else
                            <form action="{{ route('auth.reset.password.attempt') }}" method="post">
                                @csrf
                                <input type="hidden" name="reset_token" value="{{ $user->reset_password_token }}">
                                <div class="row mt-4 g-3">
                                    <div class="form-label-group">
                                        <label for="password" class="form-label text-uppercase fw-bold">New Password</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            id="password" name="password">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-label-group">
                                        <label for="confirm_password" class="form-label text-uppercase fw-bold">Confirm
                                            Password</label>
                                        <input type="password"
                                            class="form-control @error('confirm_password') is-invalid @enderror"
                                            id="confirm_password" name="confirm_password">
                                        @error('confirm_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="pt-20 push-right link-border">
                                        <button type="submit" class="btn btn-sm black_btn"><strong>SUBMIT</strong></button>
                                    </div>
                                </div>
                            </form>
                        @endif
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
