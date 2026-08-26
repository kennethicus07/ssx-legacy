@extends('layouts.supplier')

@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Sales Inquiry</h4>

                <div class="ms-auto text-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('supplier.dashboard') }}">
                                    Home
                                </a>
                            </li>

                            <li class="breadcrumb-item">
                                <a href="{{ route('supplier.daily-sales-report.inquiries.index') }}">
                                    Inquiries
                                </a>
                            </li>

                            <li class="breadcrumb-item active" aria-current="page">
                                Edit Inquiry
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <supplier-daily-sales-report-inquiry-sales-edit
            :params='@json([
                "supplier_id" => $supplier_id->id,
                "inquiry_id" => $inquiry->id
            ])'
        >
        </supplier-daily-sales-report-inquiry-sales-edit>
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
@endpush