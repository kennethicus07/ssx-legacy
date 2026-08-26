@extends('layouts.admin')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">User Account Change Password</h4>
            <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            User Account Change Password
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <form method="POST" action="{{ route('admin.my.accounts.change_password.update') }}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <h5 class="card-header">Updating user account password</h5>
                    <div class="card-body">
                        <div class="form-group mt-3">
                            <label class="form-label">Current Password *</label>
                            <div class="input-group mb-3">
                                <input type="password" id="current_password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" maxlength="150"/>
                                <span class="input-group-text"><a href="javascript:;" id="toggle_curr_pwd"><i class="fas fa-eye"></i></a></span>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">New Password *</label>
                            <div class="input-group mb-3">
                                <input type="password" id="new_password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" maxlength="150"/>
                                <span class="input-group-text"><a href="javascript:;" id="toggle_new_pwd"><i class="fas fa-eye"></i></a></span>
                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Confirm Password *</label>
                            <div class="input-group mb-3">
                                <input type="password" id="new_password_confirmation" class="form-control @error('new_password_confirmation') is-invalid @enderror" name="new_password_confirmation" maxlength="150"/>
                                <span class="input-group-text"><a href="javascript:;" id="toggle_con_pwd"><i class="fas fa-eye"></i></a></span>
                                @error('new_password_confirmation')
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
                            <div class="form-group">
                                <label class="form-label">Date Created</label>
                                <input type="text" class="form-control form-control-sm" value="{{ auth()->user()->created_at->format('F j, Y, g:i A') }}" readonly/>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Date Updated</label>
                                <input type="text" class="form-control form-control-sm" value="{{ auth()->user()->updated_at->format('F j, Y, g:i A') }}" readonly/>
                            </div>
                            <hr class="w-100 mt-2">
                            <div class="d-grid gap-2 mt-3">
                                <button class="btn btn-success text-white" type="submit">Update Password</button>
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
<link href="/libs/dropify/css/dropify.min.css" rel="stylesheet">
<link href="/libs/select2/dist/css/select2.min.css" rel="stylesheet">
@endpush
@push('scripts')
<script src="/libs/dropify/js/dropify.min.js"></script>   
<script src="/libs/select2/dist/js/select2.full.min.js"></script>  
<script src="/libs/maxlength/maxlength.js"></script>  
<script>    
    $(document).ready(function(){
        $("#toggle_curr_pwd i").click(function () {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var type = $(this).hasClass("fa-eye-slash") ? "text" : "password";
            $("#current_password").attr("type", type);
        });

        $("#toggle_new_pwd i").click(function () {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var type = $(this).hasClass("fa-eye-slash") ? "text" : "password";
            $("#new_password").attr("type", type);
        });

        $("#toggle_con_pwd i").click(function () {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var type = $(this).hasClass("fa-eye-slash") ? "text" : "password";
            $("#new_password_confirmation").attr("type", type);
        });
    });
</script>
@endpush