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
                        <li class="breadcrumb-item active" aria-current="page">
                            User Account
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <user-accounts-list></user-accounts-list>
</div>
@endsection

@push('styles')
<link href="/libs/toastr/build/toastr.min.css" rel="stylesheet"/>
@endpush
@push('scripts')
<script src="/libs/toastr/build/toastr.min.js"></script>
@if (session('status'))
	<script>
		toastr.success("{{ session('status') }}", 'Success!');
	</script>
@endif
<script>    
    $(document).ready(function(){
        
    });
</script>
@endpush