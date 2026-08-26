@extends('layouts.supplier')
@section('content')
    <div class="container-fluid">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <supplier-events-list></supplier-events-list>

    </div>
@endsection
