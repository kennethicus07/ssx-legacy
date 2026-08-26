@extends('layouts.website')

@section('content')
    <div class="section form-header">
        <div class="content">
            <div class="header-desc">
                <center>
                    <h1>Supplier/Exhibitor Registration</h1>
                </center>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-md-6 col-sm-12 pt-5">
                <h4 class="text-center pb-2">Thank you for signing up as Supplier/Exhibitor for Sustainability Solutions
                    Exchange.</h4>
                <p class="text-center">Please give us time to review your application.<br />You will receive confirmation of
                    the application within 72 hours.</p>
                <p class="text-center">A copy of your responses will be sent to your inbox shortly.</p>
            </div>
            <form method="POST" action="{{ route('registration.supplier.recieve.updates', [$id]) }}">
                @csrf
                @method('PUT')
                <div class="col-12 text-center">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="1" name="agree" id="agree">
                        <label class="form-check-label" for="agree">
                            By clicking OK, you agree to receive the latest email updates and special offers from SSX.
                        </label>
                    </div>
                </div>
                <div class="col-12 text-center">
                    <button class="submit_btn mb-5 mt-3" type="submit">Submit</button>
                </div>
            </form>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 col-sm-12 pb-5 pt-4">
                <div class="card">
                    <div class="card-header text-center text-uppercase lightgreen-bg text-white">Your Contacts</div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-12 border-end text-center">
                                <p class="mb-0">Exhibitor Campaign & Services</p>
                                <p class="mb-0">Operations Group 2 - Signature Events</p>
                            </div>
                            <div class="col-6 text-center border-end border-1">
                                <p class="mb-0">Local</p>
                                <p class="mb-0">Jessica Genovia</p>
                                <p class="mb-0"><a href="mailto:jgenovia@citem.com.ph" target="_blank"
                                        class="link-success">jgenovia@citem.com.ph</a></p>
                            </div>
                            <div class="col-6 text-center">
                                <p class="mb-0">Foreign</p>
                                <p class="mb-0">Adda Villena</p>
                                <p class="mb-0"><a href="mailto:msvillena@citem.com.ph" target="_blank"
                                        class="link-success">msvillena@citem.com.ph</a></p>
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
