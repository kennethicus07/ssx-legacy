@extends('layouts.supplier')

@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Export Sales</h4>
                <div class="ms-auto text-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('supplier.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Export Sales
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
       <supplier-daily-sales-report-export-sales-edit :params='@json(["supplier_id" => $supplier_id->id, "sale_id" => $sale->id])'></supplier-daily-sales-report-export-sales-edit>
    </div>
@endsection

@push('styles')
    <link href="/libs/toastr/build/toastr.min.css" rel="stylesheet" />
        <style>
.step-circle-export {
    width: 23px;
    height: 23px;
    font-size: 12px;
    font-weight: 600;
    border-radius: 50%;
    background: #2255a4 !important;
    color: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.hr-custom {
    border: none;
    border-top: 1px solid #f1f1f1;
    opacity: 1;
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
