@extends('layouts.supplier')

@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Inquiries</h4>
                <div class="ms-auto text-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('supplier.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Inquiries
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
       <supplier-daily-sales-report-inquiry-sales-index :params='@json([
            'supplier_id' => $supplier_id->id,
        ])'></supplier-daily-sales-report-inquiry-sales-index>
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

        });
    </script>
@endpush
