@extends('layouts.admin')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Home Page Carousel Banners</h4>
            <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.carousel-banners.index') }}">Home Page Carousel Banners</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Add Banner
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <form method="POST" action="{{ route('admin.carousel-banners.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <h5 class="card-header">Adding new banner</h5>
                    <div class="card-body">
                        <div class="form-group mt-3">
                            <label class="form-label">Title *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" placeholder="" value="{{ old('title') }}" maxlength="100"/>
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Url</label>
                            <input type="url" class="form-control" name="url" placeholder="" value="{{ old('url') }}" maxlength="150"/>
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="details" id="details" rows="3">{{ old('details') }}</textarea>
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label mb-0">Image Banner</label>
                            <div id="emailHelp" class="form-text">Note: Recommended image dimension is 1440 x 536 pixels and a maximum filesize of 5MB.</div>
                            <input type="file" id="image_banner" name="image_banner" class="dropify" accept="image/*" data-max-file-size="5MB" data-allowed-file-extensions="gif png jpg jpeg" data-height="200" data-errors-position="outside"/>  
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
                                <input type="checkbox" class="form-check-input" id="status" value="1" name="status" {{ (old('status') == 1) ? 'checked' : '' }}>
                                <label class="form-check-label align-middle" for="status">Publish this banner</label>
                            </div>
                            <hr class="w-100 mt-2">
                            <div class="d-grid gap-2 mt-3">
                                <button class="btn btn-success text-white" type="submit">Save</button>
                                <a href="{{ route('admin.carousel-banners.index') }}" class="btn btn-secondary" role="button">Back</a>
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
<link href="/libs/dropify/css/dropify.min.css" rel="stylesheet">
@endpush
@push('scripts')
<script src="/libs/tinymce/tinymce.min.js" type="text/javascript"></script> 
<script src="/libs/dropify/js/dropify.min.js"></script>   
<script>    
    $(document).ready(function(){
        $('#nav-carousel').addClass('selected');
        $('#subnav-carousel').addClass('active');

        var drImageBanner = $('#image_banner').dropify({
            messages: {
                'default': '',
            }
        });

        tinymce.init({
            selector: '#details',
            height: 500,
            plugins: 'code',
            toolbar: 'code',
        });
    });
</script>
@endpush