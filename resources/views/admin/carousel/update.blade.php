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
                            Update Banner
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <form method="POST" action="{{ route('admin.carousel-banners.update', [$banner->id]) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <h5 class="card-header">Updating banner</h5>
                    <div class="card-body">
                        <div class="form-group mt-3">
                            <label class="form-label">Title *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" placeholder="" value="{{ $banner->title }}" maxlength="100"/>
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Url</label>
                            <input type="url" class="form-control" name="url" placeholder="" value="{{ $banner->url }}" maxlength="150"/>
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="details" id="details" rows="3">{{ $banner->details }}</textarea>
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label mb-0">Image Banner *</label>
                            <div id="emailHelp" class="form-text">Note: Recommended image dimension is 1440 x 536 pixels and a maximum filesize of 5MB.</div>
                            <input type="file" id="image_banner" name="image_banner" class="dropify" accept="image/*" data-max-file-size="5M" data-allowed-file-extensions="gif png jpg jpeg" data-height="200" data-default-file="{{ url('storage/carousel_banners/'.$banner->banner) }}" data-errors-position="outside"/>  
                            @error('image_banner')
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
                                <input type="checkbox" class="form-check-input" id="status" value="1" name="status" {{ ($banner->status == 1) ? 'checked' : '' }}>
                                <label class="form-check-label align-middle" for="status">Publish this banner</label>
                            </div>
                            <hr class="w-100 mt-2">
                            <div class="form-group">
                                <label class="form-label">Date Created</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $banner->created_at->format('F j, Y, g:i A') }}" readonly/>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Date Updated</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $banner->updated_at->format('F j, Y, g:i A') }}" readonly/>
                            </div>
                            @if (!empty($banner->createdby))
                            <div class="form-group">
                                <label class="form-label">Added By</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $banner->createdby->name }}" readonly/>
                            </div>
                            @endif
                            @if (!empty($banner->modifiedby))
                            <div class="form-group">
                                <label class="form-label">Edited By</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $banner->modifiedby->name }}" readonly/>
                            </div>
                            @endif
                            <hr class="w-100 mt-2">
                            <div class="d-grid gap-2 mt-3">
                                <button class="btn btn-success text-white" type="submit">Update</button>
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
        drImageBanner.on('dropify.beforeClear', function(event, element){
            return confirm("Do you really want to delete this image banner?");
        });
        drImageBanner.on('dropify.afterClear', function(event, element){
            $.ajax({
                type:'POST',
                url:'/api/delete/image',
                data: {
                    table: 'home_carousel',
                    field: 'banner',
                    path: "{{ storage_path('app/public/carousel_banners/'.$banner->banner) }}",
                    id: "{{ $banner->id }}"
                },
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(data, status, xhr){
                    return true;
                }
            });
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