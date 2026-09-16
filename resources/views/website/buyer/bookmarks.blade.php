@extends('website.buyer.layouts.app')

@section('title', 'My Bookmarks')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h4 class="mb-0">Saved Bookmarks</h4>
    </div>
    <div class="card-body">
        <p class="text-muted">Quickly access suppliers, products, and sustainable solutions you have bookmarked.</p>
        <div class="alert alert-secondary">
            Your bookmark list is currently empty. Start exploring the 
            <a href="{{ route('solutions.directories.index') }}" class="alert-link">Marketplace</a> to save items.
        </div>
    </div>
</div>
@endsection