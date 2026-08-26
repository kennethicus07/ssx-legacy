@extends('layouts.admin')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Solutions Intelligence Articles</h4>
            <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.articles.solutions-intelligence.index') }}">Solutions Intelligence Articles</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Add Solutions Intelligence Article
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <form method="POST" action="{{ route('admin.articles.solutions-intelligence.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <h5 class="card-header">Adding new solutions intelligence article</h5>
                    <div class="card-body">
                        <div class="form-group mt-3">
                            <label class="form-label">Title *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" placeholder="" value="{{ old('title') }}" maxlength="100"/>
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Sub Title *</label>
                            <textarea name="sub_title" class="form-control @error('sub_title') is-invalid @enderror" rows="4">{{ old('sub_title') }}</textarea>
                            @error('sub_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Author</label>
                            <input type="text" class="form-control" name="author" placeholder="" value="{{ old('author') }}" maxlength="100"/>
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Type*</label>
                            <select class="form-select @error('type') is-invalid @enderror" name="type" id="type">
                                <option selected>-- Select --</option>
                                @foreach ($types as $type)
                                <option value="{{ $type->id }}" {{ old('type') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                @endforeach
                            </select>
                            @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Tag Categories</label>
                            <select class="select2 form-select shadow-none" name="categories[]" multiple="multiple" id="categories">
                                @foreach ($categories as $category)
                                <optgroup label="{{ $category->name }}" data-id="{{ $category->id }}">
                                    @if (!empty($category->sub_categories))
                                    @foreach ($category->sub_categories as $sub_category)
                                    <option value="{{ $sub_category->id }}">{{ $sub_category->name }}</option>
                                    @endforeach
                                    @endif
                                </optgroup>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Content *</label>
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
                            <label class="form-label mb-0">Image Thumbnail *</label>
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
                                <label class="form-check-label align-middle" for="status">Publish this article</label>
                            </div>
                            <hr class="w-100 mt-2">
                            <div class="d-grid gap-2 mt-3">
                                <button class="btn btn-success text-white" type="submit">Save</button>
                                <a href="{{ route('admin.articles.solutions-intelligence.index') }}" class="btn btn-secondary" role="button">Back</a>
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
        $('#nav-articles').addClass('selected');
        $('#nav-articles-a').addClass('active');
        $('#nav-articles-ul').addClass('in');
        $('#subnav-solutions-intelligence-li').addClass('active')
        $('#subnav-solutions-intelligence-a').addClass('active')

        var tags_selected = <?php echo json_encode(old('categories')); ?>;

        $("#categories").select2();
        $('#categories').val(tags_selected);
        $('#categories').trigger('change');
        
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