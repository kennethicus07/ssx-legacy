@extends('layouts.website')

@section('content')
    <div class="container text-center pt-5">

        {{-- Display the message --}}
        <div class="mt-5"></div>
        <div class="p-5">
            @if ($statusMessage == 2)
                <h4>Thank you!</h4>
                <p>
                    Your response has already been submitted.
                </p>
            @elseif($statusMessage == 1)
                <h4>Conforme Approved</h4>
                <p>
                    You have confirmed your agreement, and this has been noted.<br>
                    Kindly wait while we prepare your Billing Statement.
                </p>
            @elseif($statusMessage == 0)
                <h4>Conforme Response</h4>
                <p>
                    Thank you for submitting your response.<br>
                    You have indicated that you do not agree with the information specified in your Conforme.<br>
                    Your response has been recorded accordingly.<br>
                    A project officer will reach out to you to discuss any changes you may need applied.

                </p>
            @else
                <p>-</p>
            @endif
        </div>
        <div class="mt-3"></div>
        {{-- <a href="{{ route('home') }}" class="btn">Go to Homepage</a> --}}

    </div>
@endsection
@push('styles')
@endpush
@push('scripts')
@endpush
