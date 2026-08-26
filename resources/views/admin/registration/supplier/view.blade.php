@extends('layouts.admin')

@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">Suppliers/Exhibitors Registration</h4>
                <div class="ms-auto text-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('admin.suppliers.registration') }}">Suppliers/Exhibitors</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Supplier/Exhibitor Details
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <registration-suppliers-view id="{{ $id }}"
            event_fair_code="{{ $fair_code }}"></registration-suppliers-view>
    </div>
@endsection


@push('styles')
    <link href="/libs/toastr/build/toastr.min.css" rel="stylesheet" />
    <style>
        .accordion-button {
            border: 1px solid #9daa39;
            color: #212529;
            border-radius: 5px;
        }

        .accordion-button.collapsed {
            border-bottom-width: 1px;
        }

        .accordion-collapse {
            border: solid #9daa39;
            border-width: 0px 1px 1px 1px;
            border-radius: 0px 0px 5px 5px;
        }

        .accordion-button:focus {
            border-color: #9daa39;
        }

        /* Make table act like a slider */
        .table-slider {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            /* smooth scroll on iOS */
            scrollbar-width: thin;
            /* Firefox slim scrollbar */
        }

        /* Optional: make scrollbar subtle */
        .table-slider::-webkit-scrollbar {
            height: 6px;
        }

        .table-slider::-webkit-scrollbar-track {
            background: #f8f9fa;
        }

        .table-slider::-webkit-scrollbar-thumb {
            background: #adb5bd;
            border-radius: 3px;
        }

        /* Remove Bootstrap default arrow */
        .add-on-accordion .accordion-button::after {
            display: none !important;
        }

        .add-on-container>p {
            color: #2a3418;
            margin-bottom: 0px;
            margin-top: 0px;
        }

        /* Header */
        .add-on-accordion .accordion-button {
            justify-content: flex-start;
            text-align: left;
            background-color: #f8f9fa;
            color: #212529;
            border: none;
        }

        .add-on-accordion .accordion-button:not(.collapsed) {
            background-color: #198754;
            /* green header when open */
            color: #fff;
            box-shadow: none;
        }

        .add-on-accordion .accordion-item {
            border: 1px solid #198754;
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .add-on-container {
            border: 1px solid #9daa39;
            /* border-radius: 0.5rem; */
        }

        /* Green body */
        .add-on-accordion .accordion-body {
            background-color: #198754;
            color: #fff;
            padding: 1rem;
            border-top: none;
            /* remove the "overlap" border */
        }

        /* Input group styling inside green */
        .add-on-accordion .input-group .form-control {
            border-right: 0;
        }

        .add-on-accordion .input-group-text {
            background-color: #e9ecef;
            border-left: 0;
        }

        /* Optional: make placeholder text visible on green bg */
        .add-on-accordion .form-control::placeholder {
            color: #6c757d;
        }

        /* Packages-specific styling: only target the packages accordion (id=accordionPackages) */
        #accordionPackages .accordion-button:not(.collapsed) {
            border-radius: 5px 5px 0 0 !important;
        }

        ;

        #accordionPackages .accordion-button {
            color: #2a3418;
            /* preserve default unless hovered/active */
            border-radius: 5px;
        }

        #accordionPackages .accordion-button:not(.collapsed) {
            border-radius: 5px 5px 0 0 !important;
        }

        #accordionPackages .accordion-button:hover,
        #accordionPackages .accordion-button:not(.collapsed) {
            color: white !important;
            background-color: #9daa39 !important;
        }

        #accordionPackages .accordion-button::after {
            filter: brightness(0) saturate(100%) invert(0%) !important;
            /* Default: black icon */
        }

        #accordionPackages .accordion-button:hover::after,
        #accordionPackages .accordion-button:not(.collapsed)::after {
            filter: brightness(0) saturate(100%) invert(100%) !important;
            /* White on hover/active */
        }


        /* Style the Select button inside package cards */
        #accordionPackages .card .btn {
            /* keep default Bootstrap sizing but override border/text for the unselected state if desired */
            border-color: #9daa39;
            color: #9daa39;

        }

        #accordionPackages .card .btn:hover {
            background-color: rgba(157, 170, 57, 0.15);
            /* soft green tint */
            color: #9daa39;
            border-color: #9daa39;
        }


        /* Selected state: when a package card has .border-primary, keep the button filled green */
        #accordionPackages .card.border-primary .btn,
        #accordionPackages .card.border-primary .btn.btn-outline-primary {
            background-color: #9daa39 !important;
            border-color: #9daa39 !important;
            color: #ffffff !important;
        }

        /* Ensure hover/focus doesn't alter the already-selected button */
        #accordionPackages .card.border-primary .btn:hover,
        #accordionPackages .card.border-primary .btn:focus,
        #accordionPackages .card.border-primary .btn:active {
            background-color: #9daa39 !important;
            border-color: #9daa39 !important;
            color: #ffffff !important;
            box-shadow: 0 0 0 0.25rem rgba(157, 170, 57, 0.4) !important;
            /* maintain accessible focus ring */
        }

        #accordionPackages .card.border-primary {
            border-color: #9daa39 !important;
        }

        /* 'Add Package to Cart' button (green) — make it match #9daa39 instead of default Bootstrap success */
        #accordionPackages .btn-success {
            background-color: #9daa39 !important;
            border-color: #9daa39 !important;
            color: #ffffff !important;
        }

        /* Only affects quantity inputs */
        .qty-input::-webkit-outer-spin-button,
        .qty-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .qty-input {
            -moz-appearance: textfield;
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
            $('#nav-registration').addClass('selected');
            $('#nav-registration-a').addClass('active');
            $('#nav-registration-ul').addClass('in');
            $('#subnav-registration-suppliers-li').addClass('active')
            $('#subnav-registration-suppliers-a').addClass('active')
        });
    </script>
@endpush
