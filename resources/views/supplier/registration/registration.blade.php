@extends('layouts.supplier')

@section('content')
    <div class="section form-header">
        <div class="content">
            <div class="header-desc pt-5">
                <center>
                    <h1>{{ $event->event_name }} Registration</h1>
                </center>

            </div>
        </div>
    </div>
    <registration-supplier-registration :params='@json([
        'id' => Auth::guard('supplier')->user()->id,
        'event_id' => $event->id,
        'agreement' => $agreement
    ])'>
    </registration-supplier-registration>
@endsection

@push('styles')
    <style>
        /* .accordion-spaces-item {
                                              
                                                border-color: #9daa39 !important;
                                              box-shadow: none !important;
                                            }

                                            .accordion-spaces-item:not(:first-of-type) {
                                                border-top: 2px solid #dee2e6 !important;
                                                
                                            }
                                            /* .accordion-button.collapsed{
                                                    border-bottom-width: 1px !important;
                                            } */

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


        /* Facebook-like modal scroll area */
        .vertical-slider {
            max-height: 350px;
            overflow-y: auto;
            padding-right: 0.5rem;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: #adb5bd #f8f9fa;
            scroll-behavior: smooth;
        }

        /* Subtle scrollbar (Chrome, Safari, Edge) */
        .vertical-slider::-webkit-scrollbar {
            width: 6px;
        }

        .vertical-slider::-webkit-scrollbar-track {
            background: #f8f9fa;
            border-radius: 5px;
        }

        .vertical-slider::-webkit-scrollbar-thumb {
            background: #adb5bd;
            border-radius: 5px;
        }

        /* Fade shadow at top/bottom for FB-style depth */
        .vertical-slider::before,
        .vertical-slider::after {
            content: "";
            position: sticky;
            left: 0;
            right: 0;
            height: 15px;
            z-index: 2;
            pointer-events: none;
        }

        .vertical-slider::before {
            top: 0;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.08), transparent);
        }

        .vertical-slider::after {
            bottom: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.08), transparent);
        }

        /* Target the delete button inside Vue File Agent */
        .vue-file-agent .file-preview .file-delete svg {
            fill: black !important;
            height: 25px !important;
            vertical-align: middle;
            width: 25px !important;
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

        .custom-border-radius {
            border-radius: 0.75rem !important;
        }
    </style>
@endpush
@push('scripts')
@endpush
