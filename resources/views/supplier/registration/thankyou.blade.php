@extends('layouts.supplier')

@section('content')
    <div class="section form-header">
        <div class="content">
            <div class="header-desc ">
                <center>
                    <h1>Supplier/Exhibitor Registration</h1>
                </center>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-md-6 col-sm-12 pt-5">
                <h4 class="text-center pb-2">
                    Thank you for signing up as Supplier/Exhibitor for Sustainability Solutions Exchange –
                    {{ $event->event_name }}.
                </h4>
                <p class="text-center">
                    Please give us time to review your application.<br />
                    You will receive confirmation of the application within 72 hours.
                </p>
                {{-- <p class="text-center">
                    A copy of your responses will be sent to your inbox shortly.
                </p> --}}
            </div>
            {{-- <form id="receiveUpdatesForm" method="POST"
                action="{{ route('supplier.registration.supplier.receive.updates', [$id]) }}">
                @csrf
                @method('PUT')
                <div class="col-12 text-center">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" value="1" name="agree" id="agree">
                        <label class="form-check-label" for="agree">
                            By clicking OK, you agree to receive the latest email updates and special offers from
                            Sustainability Solutions Exchange – {{ $event->event_name }}.
                        </label>
                    </div>
                </div>
                <div class="col-12 text-center">
                    <button class="submit_btn mb-5 mt-3" type="submit" id="submitBtn" disabled>Submit</button>
                </div>
            </form> --}}

        </div>
        <div class="row justify-content-center">
            <div class="col-md-8 col-sm-12 pb-5 pt-4">
                <div class="card">
                    <div class="card-header text-center text-uppercase lightgreen-bg text-white">
                        Contact Info:
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-12 border-end text-center">
                                <p class="mb-0">Exhibitor Campaign & Services</p>
                                <p class="mb-0">Consumer Business Department</p>
                            </div>
                            <div class="col-4 text-center border-end border-1">
                                <p class="mb-0"></p>
                                <p class="mb-0">Gustav Joscef V. Ramirez</p>
                                <p class="mb-0">
                                    <a href="mailto:gjramirez@citem.com.ph" target="_blank" class="link-success">
                                        gjramirez@citem.com.ph
                                    </a>
                                </p>
                            </div>
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
                                <p class="mb-0">Chol D. Dela Paz</p>
                                <p class="mb-0">
                                    <a href="mailto:cdpaz@citem.com.ph" target="_blank" class="link-success">
                                        cdpaz@citem.com.ph
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
    <style>
        .form-header {
            background: #9daa39 url(/assets/images/ssx-info-bg.png);
            background-position: -10%;
            background-size: cover;
            padding: 40px;
            color: white;
        }

        .submit_btn {
            background: #000;
            border: 1px solid #000;
            border-radius: 8px;
            color: #fff;
            display: inline-block;
            font-family: Brown, DIN, Arial, sans-serif;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: .5px;
            padding: 7.5px 15px;
            transition: .5s;
        }

        .lightgreen-bg {
            background: #9daa39;

        }

        .card-header:first-child {
            border-radius: 30px 30px 0 0;
        }

        .submit_btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('agree');
            const submitBtn = document.getElementById('submitBtn');

            checkbox.addEventListener('change', function() {
                submitBtn.disabled = !this.checked;
                submitBtn.style.opacity = this.checked ? '1' : '0.6';
                submitBtn.style.cursor = this.checked ? 'pointer' : 'not-allowed';
            });
        });
    </script>
@endpush
