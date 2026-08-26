@extends('layouts.website')

@section('content')
<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-6">
            <div class="login-holder">
                <div class="content mt-5 mb-5 registration-form">
                    <h1>Create password</h1>
                    <form action="{{ route('registration.authentication.create', [$group, $user->reg_token]) }}" method="post">
                        @csrf
                        <input type="hidden" name="reset_token" value="{{ $user->reset_password_token }}">
                        <div class="row mt-4 g-3">
                            <div class="form-label-group">
                                <label for="password" class="form-label text-uppercase fw-bold">New Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-label-group">
                                <label for="confirm_password" class="form-label text-uppercase fw-bold">Confirm Password</label>
                                <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" id="confirm_password" name="confirm_password">
                                @error('confirm_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="pt-20 push-right link-border">
                                <button type="submit" class="btn btn-sm black_btn"><strong>SUBMIT</strong></button>
                            </div>          
                        </div>
                    </form>
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