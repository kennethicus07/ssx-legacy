@extends('layouts.website')

@section('content')
    <div class="section form-header">
        <div class="content">
            <div class="header-desc">
                <center>
                    <h1>Purchaser/Buyer Registration</h1>
                </center>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-sm-12 pb-3 pt-5">
                <h4 class="text-center pb-2">Thank you for submitting your application as a Purchaser/Buyer for
                    {{ $event_name }}! </h4>
                <p class="text-center">Your participation is not yet
                    confirmed until you have received the
                    official notice of acceptance from CITEM via email.</p>
                <p class="text-center">
                    Please give us time to review your application.<br />
                    You will receive confirmation within 72 hours for the approval of your application.
                </p>

                <p class="text-center">
                    We look forward to welcoming you to {{ $event_name }}!</p>
                <p class="text-center">See you there!</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 col-sm-12 pb-5 pt-4">
                <div class="card">
                    <div class="card-header text-center text-uppercase lightgreen-bg text-white">Contact Us</div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-4 text-center border-end border-1">
                                <p class="mb-0"></p>
                                <p class="mb-0">Katrina C. Pineda</p>
                                <p class="mb-0">
                                    <a href="mailto:kcpineda@citem.com.ph" target="_blank" class="link-success">
                                        kcpineda@citem.com.ph
                                    </a>
                                </p>
                            </div>
                            <div class="col-4 text-center">
                                <p class="mb-0"></p>
                                <p class="mb-0">Leilani J. Santiago</p>
                                <p class="mb-0">
                                    <a href="mailto:lsantiago@citem.com.ph" target="_blank" class="link-success">
                                        lsantiago@citem.com.ph
                                    </a>
                                </p>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
@endpush
@push('scripts')
@endpush
