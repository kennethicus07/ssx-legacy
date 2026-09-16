@extends('website.buyer.layouts.app')

@section('title', 'Buyer Dashboard')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h4 class="mb-0">Welcome Back, {{ Auth::user()->name ?? 'Buyer' }}!</h4>
    </div>
    <div class="card-body">
        <p class="text-muted">Here is a quick overview of your sourcing and portal activity.</p>
        <div class="row text-center">
            <div class="col-md-4 mb-3">
                <div class="p-3 border rounded bg-white shadow-sm">
                    <h5>Bookmarked Items</h5>
                    <h3 class="text-primary">0</h3>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="p-3 border rounded bg-white shadow-sm">
                    <h5>Registered Events</h5>
                    <h3 class="text-success">0</h3>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="p-3 border rounded bg-white shadow-sm">
                    <h5>Inquiries Sent</h5>
                    <h3 class="text-info">0</h3>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection