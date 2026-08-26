@extends('layouts.admin')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Featured Programs & Offers</h4>
            <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.export-enablers.programs-offers.index') }}">Featured Programs & Offers</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Add Featured Program & Offer
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <form method="POST" action="{{ route('admin.export-enablers.programs-offers.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <h5 class="card-header">Adding new featured program & offer</h5>
                    <div class="card-body">
                        <div class="form-group mt-3">
                            <label class="form-label">Title *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" placeholder="" value="{{ old('title') }}" maxlength="100"/>
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Enablers *</label>
                            <select class="select2 form-select shadow-none" name="enabler" id="enabler">
                                <option value="" selected>-- Select --</option>
                                @foreach ($enablers as $enabler)
                                <option value="{{ $enabler->id }}" {{ (old('enabler') == $enabler->id) ? 'selected' : '' }}>{{ $enabler->co_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Details *</label>
                            <textarea name="content" class="form-control @error('content') is-invalid @enderror" id="content">{{ old('content') }}</textarea>
                            @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label mb-0">Image Banner *</label>
                            <div id="emailHelp" class="form-text">Note: Recommended image dimension is 1600 x 560 pixels and a maximum filesize of 5MB.</div>
                            <input type="file" id="image_banner" name="image_banner" class="dropify" accept="image/*" data-max-file-size="5M" data-allowed-file-extensions="gif png jpg jpeg" data-height="200" data-errors-position="outside"/>  
                            @error('image_banner')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label mb-0">Image Thumbnail</label>
                            <div id="emailHelp" class="form-text">Note: Recommended image dimension is 360 x 200 pixels and a maximum filesize of 5MB.</div>
                            <input type="file" id="image_thumb" name="image_thumb" class="dropify" accept="image/*" data-max-file-size="5M" data-allowed-file-extensions="gif png jpg jpeg" data-height="200" data-errors-position="outside"/>  
                            @error('image_thumb')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card">
                    <h5 class="card-header">SEO Meta Tags</h5>
                    <div class="card-body">
                        <div class="form-group mt-3">
                            <label class="form-label">Meta Title</label>
                            <input type="text" class="form-control" name="meta_title" placeholder="" value="{{ old('meta_title') }}" maxlength="100"/>
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label mb-0">Meta Keywords</label>
                            <div id="emailHelp" class="form-text">Note: Comma delimited.</div>
                            <textarea name="meta_keywords" class="form-control" rows="2">{{ old('meta_keywords') }}</textarea>
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Meta Description</label>
                            <textarea name="meta_description" class="form-control" rows="4">{{ old('meta_description') }}</textarea>
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
                                <label class="form-check-label align-middle" for="status">Publish this program & offer</label>
                            </div>
                            <hr class="w-100 mt-2">
                            <div class="d-grid gap-2 mt-3">
                                <button class="btn btn-success text-white" type="submit">Save</button>
                                <a href="{{ route('admin.export-enablers.programs-offers.index') }}" class="btn btn-secondary" role="button">Back</a>
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
<link href="/libs/select2/dist/css/select2.min.css" rel="stylesheet">
@endpush
@push('scripts')
<script src="/libs/tinymce/tinymce.min.js" type="text/javascript"></script> 
<script src="/libs/dropify/js/dropify.min.js"></script>   
<script src="/libs/select2/dist/js/select2.full.min.js"></script>   
<script>    
    $(document).ready(function(){
        $('#nav-export-enablers').addClass('selected');
        $('#nav-export-enablers-a').addClass('active');
        $('#nav-export-enablers-ul').addClass('in');
        $('#subnav-programs-offers-li').addClass('active')
        $('#subnav-programs-offers-a').addClass('active')

        $("#enabler").select2();
        
        var drImageBanner = $('#image_banner').dropify({
            messages: {
                'default': '',
            }
        });
        var drImageThumb = $('#image_thumb').dropify({
            messages: {
                'default': '',
            }
        });

        tinymce.init({
            selector: "#content",
            height: 600,
            plugins: [
                "advlist autolink link image imagetools lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "save table directionality emoticons template paste"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
            toolbar_sticky: true,
            paste_as_text: true,
            imagetools_toolbar: "rotateleft rotateright | flipv fliph | editimage imageoptions",
            images_upload_base_path: '/storage/widgets',
            automatic_uploads: true,
            convert_urls: false,
            image_caption: true,
            image_advtab: true,
            image_dimensions: false,
            file_picker_types: 'image media',
            images_upload_handler: function (blobInfo, success, failure) {
                var xhr, formData;
                xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', "/api/wysiwyg/upload");
                var token = '{{ csrf_token() }}';
                xhr.setRequestHeader("X-CSRF-Token", token);
                xhr.onload = function() {
                    var json;
                    if (xhr.status != 200) {
                        failure('HTTP Error: ' + xhr.status);
                        return;
                    }
                    json = JSON.parse(xhr.responseText);
                    if (!json || typeof json.location != 'string') {
                        failure('Invalid JSON: ' + xhr.responseText);
                        return;
                    }
                    success(json.location);
                };
                formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());
                xhr.send(formData);
            },
            toolbar_mode: 'sliding'
        });
    });
</script>
@endpush