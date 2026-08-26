@extends('layouts.admin')

@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Retail Sales</h4>
                <div class="ms-auto text-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Retail Sales
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <supplier-retail-sales-view></supplier-retail-sales-view>
    </div>
@endsection

@push('styles')
    <link href="/libs/toastr/build/toastr.min.css" rel="stylesheet" />
    <style>
.table-slider {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.table-slider table {
    min-width: 1200px;
}

/* Optional scrollbar styling */
.table-slider::-webkit-scrollbar {
    height: 8px;
}

.table-slider::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 10px;
}

.table-slider::-webkit-scrollbar-track {
    background: #f5f5f5;
}

.subcat-dropdown {
    z-index: 9999;
}

.table-slider,
.table-responsive {
    overflow: visible;
}

/* prevent overflow text in trigger */
.form-control span {
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}

/* mobile safety */
@media (max-width: 576px) {
    .subcat-dropdown {
        position: fixed !important;
        left: 10px;
        right: 10px;
        width: auto !important;
    }
}
</style>
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

        });
    </script>
@endpush
