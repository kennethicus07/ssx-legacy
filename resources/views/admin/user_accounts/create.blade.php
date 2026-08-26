@extends('layouts.admin')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">User Accounts</h4>
            <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.user-accounts.index') }}">User Accounts</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Add User Account
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <form method="POST" action="{{ route('admin.user-accounts.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <h5 class="card-header">Adding new user account</h5>
                    <div class="card-body">
                        <div class="form-group mt-3">
                            <label class="form-label">Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="" value="{{ old('name') }}" maxlength="100"/>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">E-mail Address *</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="" value="{{ old('email') }}" maxlength="150"/>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Password *</label>
                            <div class="input-group mb-3">
                                <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" aria-label="Password" aria-describedby="password1" maxlength="150"/>
                                <span class="input-group-text" id="password1"><a href="javascript:;" id="toggle_pwd1"><i class="fas fa-eye"></i></a></span>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Confirm Password *</label>
                            <div class="input-group mb-3">
                                <input type="password" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" aria-label="Confirm Password" aria-describedby="password2" maxlength="150"/>
                                <span class="input-group-text" id="password2"><a href="javascript:;" id="toggle_pwd2"><i class="fas fa-eye"></i></a></span>
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <h5 class="card-header">Actions</h5>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="d-grid gap-2 mt-3">
                                <button class="btn btn-success text-white" type="submit">Save</button>
                                <a href="{{ route('admin.user-accounts.index') }}" class="btn btn-secondary" role="button">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('styles')
@endpush
@push('scripts')
<script>    
    $(document).ready(function(){
        $('#nav-user-accounts').addClass('selected');
        $('#subnav-user-accounts').addClass('active');

        $("#toggle_pwd1 i").click(function () {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var type = $(this).hasClass("fa-eye-slash") ? "text" : "password";
            $("#password").attr("type", type);
        });

        $("#toggle_pwd2 i").click(function () {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var type = $(this).hasClass("fa-eye-slash") ? "text" : "password";
            $("#password_confirmation").attr("type", type);
        });
    });
</script>
@endpush