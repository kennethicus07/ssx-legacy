@extends('layouts.admin')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">SEO Pages Meta Tags</h4>
            <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.pages-meta-tags.index') }}">SEO Pages Meta Tags</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Update Meta Tags
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <form method="POST" action="{{ route('admin.pages-meta-tags.update', [$tag->id]) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <h5 class="card-header">Updating meta tags</h5>
                    <div class="card-body">
                        <div class="form-group mt-3">
                            <label class="form-label">Page Title *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ $tag->title }}" maxlength="100"/>
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Meta Title</label>
                            <input type="text" class="form-control" name="meta_title" placeholder="" value="{{ $tag->meta_title }}" maxlength="100"/>
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label mb-0">Meta Keywords</label>
                            <div id="emailHelp" class="form-text">Note: Comma delimited.</div>
                            <textarea class="form-control" name="meta_keywords" id="meta_keywords" rows="3">{{ $tag->meta_title }}</textarea>
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Meta Description</label>
                            <div id="emailHelp" class="form-text">Note: Character limit is 160.</div>
                            <textarea class="form-control" name="meta_description" id="meta_description" rows="4" maxlength="160">{{ $tag->meta_description }}</textarea>
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label mb-0">Meta Robots</label>
                            <div id="emailHelp" class="form-text">Note: Multiple select.</div>
                            <select class="select2 form-select shadow-none" name="meta_robots[]" multiple="multiple" id="meta_robots">
                                <option value="noindex">No Index</option>
                                <option value="index">Index</option>
                                <option value="nofollow">No Follow</option>
                                <option value="follow">Follow</option>
                                <option value="noimageindex">No Image Index</option>
                                <option value="none">None</option>
                                <option value="noarchive">No Archive</option>
                                <option value="nocache">No Cache</option>
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Author</label>
                            <input type="text" class="form-control" name="meta_author" placeholder="" value="{{ $tag->meta_author }}" maxlength="100"/>
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label mb-0">Meta Image</label>
                            <div id="emailHelp" class="form-text">Note: Recommended image dimension is 1200 x 627 pixels and a maximum filesize of 5MB.</div>
                            <input type="file" id="meta_image" name="meta_image" class="dropify" accept="image/*" data-max-file-size="5M" data-allowed-file-extensions="gif png jpg jpeg" data-height="200" data-default-file="{{ url('storage/meta_images/'.$tag->meta_image) }}" data-errors-position="outside"/>  
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <h5 class="card-header">Actions</h5>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="form-group">
                                <label class="form-label">Date Created</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $tag->created_at->format('F j, Y, g:i A') }}" readonly/>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Date Updated</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $tag->updated_at->format('F j, Y, g:i A') }}" readonly/>
                            </div>
                            @if (!empty($tag->created_by))
                            <div class="form-group">
                                <label class="form-label">Added By</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $tag->created_by->name }}" readonly/>
                            </div>
                            @endif
                            @if (!empty($tag->modified_by))
                            <div class="form-group">
                                <label class="form-label">Edited By</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $tag->modified_by->name }}" readonly/>
                            </div>
                            @endif
                            <hr class="w-100 mt-2">
                            <div class="d-grid gap-2 mt-3">
                                <button class="btn btn-success text-white" type="submit">Update</button>
                                <a href="{{ route('admin.pages-meta-tags.index') }}" class="btn btn-secondary" role="button">Back</a>
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
<script src="/libs/dropify/js/dropify.min.js"></script>   
<script src="/libs/select2/dist/js/select2.full.min.js"></script>  
<script src="/libs/maxlength/maxlength.js"></script>  
<script>    
    $(document).ready(function(){
        $('#nav-meta-tags').addClass('selected');
        $('#subnav-meta-tags').addClass('active');

        var tags_selected = <?php echo json_encode($arr_robots); ?>;

        $("#meta_robots").select2();
        $('#meta_robots').val(tags_selected);
        $('#meta_robots').trigger('change');

        $('#meta_description').maxlength({
            alwaysShow: true,
            warningClass: 'label label-success bg-success text-white',
            limitReachedClass: 'label label-danger',
            separator: ' out of ',
            preText: 'You typed ',
            postText: ' chars available.'
        });

        var drMetaImage = $('#meta_image').dropify({
            messages: {
                'default': '',
            }
        });
        drMetaImage.on('dropify.beforeClear', function(event, element){
            return confirm("Do you really want to delete this meta image?");
        });
        drMetaImage.on('dropify.afterClear', function(event, element){
            $.ajax({
                type:'POST',
                url:'/api/delete/image',
                data: {
                    table: 'seo_meta_tags_pages',
                    field: 'meta_image',
                    path: "{{ storage_path('app/public/meta_images/'.$tag->meta_image) }}",
                    id: "{{ $tag->id }}"
                },
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(data, status, xhr){
                    return true;
                }
            });
        });
    });
</script>
@endpush