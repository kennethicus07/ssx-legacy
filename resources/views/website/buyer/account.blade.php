@extends('website.buyer.layouts.app')

@section('title', 'Account Management')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h4 class="mb-0">My Account Management</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('buyer.account.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" value="{{ $user->email }}" disabled>
                <small class="text-muted">Email cannot be changed directly. Contact support if needed.</small>
            </div>

            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
</div>
@endsection