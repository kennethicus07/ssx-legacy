@extends('layouts.website')

@section('content')
<global-search qry="{{ $keyword }}"></global-search>
@endsection

@push('styles')
@endpush
@push('scripts')
@endpush