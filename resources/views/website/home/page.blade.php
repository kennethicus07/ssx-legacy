@extends('layouts.website')

@section('content')
<div class="section form-header">   
    <div class="content">
        <div class="header-desc">
            <center>
                <h1 class="text-capitalize">{{ $page->title }}</h1>
            </center>
            <p>&nbsp;</p>
        </div>
    </div>
</div>

<div class="section excerpt-info">
    <div class="content">
        <p class="date text-uppercase">POSTED {{ \Carbon\Carbon::parse($page->created_at)->format('M d, Y - h:i A') }}</p>
    </div>
</div>

<div class="section ssx-info article-holder">
    <div class="content">
        {!! $page->description !!}
    </div>
</div>
<x-contactus title="Do you have an event that you want us to feature?" subtitle="Let SSX help you reach a wider audience and get your message out there!" details="Just let us know the details of your event and send it to us. Someone from our team will reach out to you to verify the information and get you on track to be featured on our channels."/>
@endsection

@push('styles')
@endpush
@push('scripts')
@endpush