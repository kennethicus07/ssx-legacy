@extends('layouts.admin')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Suppliers Registration</h4>
            <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.suppliers.registration') }}">Suppliers</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Adding New Supplier
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <registration-suppliers-add></registration-suppliers-add>
</div>
@endsection

@push('styles')
<link href="/libs/toastr/build/toastr.min.css" rel="stylesheet" />
@endpush
@push('scripts')
<script src="/libs/toastr/build/toastr.min.js"></script>
@if (session('status'))
<script>
toastr.success("{{ session('status') }}", 'Success!');
</script>
@endif
<script>
    $(document).ready(function() {
        $('#nav-registration').addClass('selected');
        $('#nav-registration-a').addClass('active');
        $('#nav-registration-ul').addClass('in');
        $('#subnav-registration-suppliers-li').addClass('active')
        $('#subnav-registration-suppliers-a').addClass('active')
    });
</script>
@endpush