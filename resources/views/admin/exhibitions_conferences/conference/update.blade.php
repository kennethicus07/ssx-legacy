@extends('layouts.admin')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Exhibitions & Conferences</h4>
            <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.exhibitions-conferences.index') }}">Exhibitions & Conferences</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Update Exhibition & Conference
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <form method="POST" action="{{ route('admin.exhibitions-conferences.update', [$conference->id]) }}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <h5 class="card-header">Updating exhibition & conference</h5>
                    <div class="card-body">
                        <div class="form-group mt-3">
                            <label class="form-label">Title *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" placeholder="" value="{{ $conference->title }}" maxlength="100"/>
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Sub Title *</label>
                            <input type="text" class="form-control @error('sub_title') is-invalid @enderror" name="sub_title" placeholder="" value="{{ $conference->sub_title }}" maxlength="100"/>
                            @error('sub_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Conference Date *  <small class="text-muted">dd/mm/yyyy</small></label>
                            <input type="text" name="con_date" id="con_date" placeholder="Enter Date" class="form-control" value="{{ Carbon\Carbon::parse($conference->conference_date)->format('d/m/Y') }}">
                            @error('con_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <h5 class="card-header">Actions</h5>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="form-check mr-sm-2">
                                <input type="checkbox" class="form-check-input" id="status" value="1" name="status" {{ ($conference->status == 1) ? 'checked' : '' }}>
                                <label class="form-check-label align-middle" for="status">Publish this conference</label>
                            </div>
                            <div class="form-group mt-2">
                                <label class="form-label">Date Created</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $conference->created_at->format('F j, Y, g:i A') }}" readonly/>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Date Updated</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $conference->updated_at->format('F j, Y, g:i A') }}" readonly/>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Added By</label>
                                <input type="text" class="form-control form-control-sm" value="{{ (!empty($conference->createdby)) ? $conference->createdby->name : '' }}" readonly/>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Edited By</label>
                                <input type="text" class="form-control form-control-sm" value="{{ (!empty($conference->modifiedby)) ? $conference->modifiedby->name : '' }}" readonly/>
                            </div>
                            <hr class="w-100 mt-2">
                            <div class="d-grid gap-2 mt-3">
                                <button class="btn btn-success text-white" type="submit">Update</button>
                                <a href="{{ route('admin.exhibitions-conferences.index') }}" class="btn btn-secondary" role="button">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('styles')
@endpush
@push('scripts')
<script src="/libs/inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
<script>    
    $(document).ready(function(){
        $('#nav-exhibitions').addClass('selected');
        $('#nav-exhibitions-a').addClass('active');
        $('#nav-exhibitions-ul').addClass('in');
        $('#subnav-conferences-li').addClass('active')
        $('#subnav-exhibitions-conferences-a').addClass('active')

        $("#con_date").inputmask("dd/mm/yyyy");
    });
</script>
@endpush