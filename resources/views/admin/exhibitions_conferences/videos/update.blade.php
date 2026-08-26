@extends('layouts.admin')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Exhibitions & Conferences Videos</h4>
            <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.conferences-videos.index') }}">Exhibitions & Conferences Videos</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Update Exhibition & Conference Videos
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <form method="POST" action="{{ route('admin.conferences-videos.update', [$video->id]) }}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <h5 class="card-header">Updating exhibition & conference video</h5>
                    <div class="card-body">
                        <div class="form-group mt-3">
                            <label class="form-label">Conference*</label>
                            <select class="select2 form-select shadow-none @error('conference') is-invalid @enderror" name="conference" id="conference">
                                <option value="" selected>-- Select --</option>
                                @foreach ($conferences as $con)
                                <option value="{{ $con->id }}" {{ ($video->conference_id == $con->id) ? 'selected' : '' }}>{{ $con->title }} ({{ $con->conference_date->format('M d, Y') }})</option>
                                @endforeach
                            </select>
                            @error('conference')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Youtube Video URL*</label>
                            <input type="url" class="form-control @error('url_video') is-invalid @enderror" name="url_video" placeholder="" value="{{ $video->video_link }}"/>
                            <div id="emailHelp" class="form-text">Ex: https://www.youtube.com/watch?v=e_04ZrNroTo</div>
                            @error('url_video')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Short Description*</label>
                            <textarea name="details" class="form-control @error('details') is-invalid @enderror" rows="5" id="details">{{ $video->details }}</textarea>
                            @error('details')
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
                                <input type="checkbox" class="form-check-input" id="status" value="1" name="status" {{ ($video->status == 1) ? 'checked' : '' }}>
                                <label class="form-check-label align-middle" for="status">Publish this conference</label>
                            </div>
                            <div class="form-group mt-2">
                                <label class="form-label">Date Created</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $video->created_at->format('F j, Y, g:i A') }}" readonly/>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Date Updated</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $video->updated_at->format('F j, Y, g:i A') }}" readonly/>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Added By</label>
                                <input type="text" class="form-control form-control-sm" value="{{ (!empty($video->createdby)) ? $video->createdby->name : '' }}" readonly/>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Edited By</label>
                                <input type="text" class="form-control form-control-sm" value="{{ (!empty($video->modifiedby)) ? $video->modifiedby->name : '' }}" readonly/>
                            </div>
                            <hr class="w-100 mt-2">
                            <div class="d-grid gap-2 mt-3">
                                <button class="btn btn-success text-white" type="submit">Update</button>
                                <a href="{{ route('admin.conferences-videos.index') }}" class="btn btn-secondary" role="button">Back</a>
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
<link href="/libs/select2/dist/css/select2.min.css" rel="stylesheet">
@endpush
@push('scripts')
<script src="/libs/select2/dist/js/select2.full.min.js"></script> 
<script src="/libs/tinymce/tinymce.min.js" type="text/javascript"></script> 
<script>    
    $(document).ready(function(){
        $('#nav-exhibitions').addClass('selected');
        $('#nav-exhibitions-a').addClass('active');
        $('#nav-exhibitions-ul').addClass('in');
        $('#subnav-videos-li').addClass('active')
        $('#subnav-videos-a').addClass('active')

        $("#conference").select2();

        tinymce.init({
            selector: '#details',
            height: 300,
            plugins: 'code',
            toolbar: 'code',
        });
    });
</script>
@endpush