@extends('website.buyer.layouts.app')

@section('title', 'Events Management')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h4 class="mb-0">Events Management</h4>
    </div>
    <div class="card-body">
        <p class="text-muted">Manage the events and conferences you are registered for.</p>
        <div class="alert alert-info">
            You are not currently registered for any upcoming events. 
            <a href="{{ route('events-activities.index') }}" class="alert-link">Browse available events here</a>.
        </div>
    </div>
</div>
@endsection