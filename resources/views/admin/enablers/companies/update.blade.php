@extends('layouts.admin')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Export Enablers Companies</h4>
            <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.export-enablers.companies.index') }}">Export Enablers Companies</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Update Company
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <form method="POST" action="{{ route('admin.export-enablers.companies.update', [$enabler->id]) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <h5 class="card-header">Updating Company</h5>
                    <div class="card-body">
                    <div class="form-group mt-3">
                            <label class="form-label">Company Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="" value="{{ $enabler->co_name }}" maxlength="100"/>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label mb-0">Description *</label>
                            <div id="emailHelp" class="form-text">Note: Character limit is 300.</div>
                            <textarea class="form-control @error('details') is-invalid @enderror" name="details" id="details" rows="5" maxlength="300">{{ $enabler->co_details }}</textarea>
                            @error('details')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Company E-mail Address</label>
                            <input type="email" class="form-control" name="email" placeholder="" value="{{ $enabler->co_email }}" maxlength="200"/>
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Tag Categories</label>
                            <select class="select2 form-select shadow-none" name="categories[]" multiple="multiple" id="categories">
                                @foreach ($categories as $category)
                                <optgroup label="{{ $category->name }}" data-id="{{ $category->id }}">
                                    @if (!empty($category->enabler_sub_categories))
                                    @foreach ($category->enabler_sub_categories as $sub_category)
                                    <option value="{{ $sub_category->id }}">{{ $sub_category->name }}</option>
                                    @endforeach
                                    @endif
                                </optgroup>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Website</label>
                            <input type="text" class="form-control" name="website" placeholder="" value="{{ $enabler->website }}" maxlength="200"/>
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Facebook</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon3">https://www.facebook.com/</span>
                                <input type="text" class="form-control" name="facebook" placeholder="" value="{{ $enabler->facebook }}" maxlength="200"/>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Instagram</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon3">https://www.instagram.com/</span>
                                <input type="text" class="form-control" name="instagram" placeholder="" value="{{ $enabler->instagram }}" maxlength="200"/>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Twitter</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon3">https://www.twitter.com/</span>
                                <input type="text" class="form-control" name="twitter" placeholder="" value="{{ $enabler->twitter }}" maxlength="200"/>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">We Chat</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon3">weixin://dl/chat?</span>
                                <input type="text" class="form-control" name="wechat" placeholder="" value="{{ $enabler->wechat }}" maxlength="200"/>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Image Thumbnail</label>
                            <div id="emailHelp" class="form-text">Note: Recommended image dimension is 360 x 200 pixels and a maximum filesize of 5MB.</div>
                            <input type="file" id="thumb" name="thumb" class="dropify" accept="image/*" data-max-file-size="5M" data-allowed-file-extensions="gif png jpg jpeg"  data-default-file="{{ '/storage/export_enablers/thumb/'.$enabler->thumb_image }}" data-height="200" data-errors-position="outside"/>  
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label mb-0">Company Logo</label>
                            <div id="emailHelp" class="form-text">Note: Recommended image dimension is 200 x 200 pixels and a maximum filesize of 5MB.</div>
                            <input type="file" id="logo" name="logo" class="dropify" accept="image/*" data-max-file-size="5M" data-allowed-file-extensions="gif png jpg jpeg" data-default-file="{{ '/storage/export_enablers/logo/'.$enabler->co_logo }}" data-height="100" data-errors-position="outside"/>  
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
                                <input type="checkbox" class="form-check-input" id="status" value="1" name="status" {{ ($enabler->status == 1) ? 'checked' : '' }}>
                                <label class="form-check-label align-middle" for="status">Publish this company</label>
                            </div>
                            <div class="form-check mr-sm-2">
                                <input type="checkbox" class="form-check-input" id="featured" value="1" name="featured" {{ ($enabler->is_featured == 1) ? 'checked' : '' }}>
                                <label class="form-check-label align-middle" for="featured">Featured partner</label>
                            </div>
                            <hr class="w-100 mt-2">
                            <div class="form-group">
                                <label class="form-label">Date Created</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $enabler->created_at->format('F j, Y, g:i A') }}" readonly/>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Date Updated</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $enabler->updated_at->format('F j, Y, g:i A') }}" readonly/>
                            </div>
                            @if (!empty($enabler->created_by))
                            <div class="form-group">
                                <label class="form-label">Added By</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $enabler->created_by->name }}" readonly/>
                            </div>
                            @endif
                            @if (!empty($enabler->modified_by))
                            <div class="form-group">
                                <label class="form-label">Edited By</label>
                                <input type="text" class="form-control form-control-sm" value="{{ $enabler->modified_by->name }}" readonly/>
                            </div>
                            @endif
                            <hr class="w-100 mt-2">
                            <div class="d-grid gap-2 mt-3">
                                <button class="btn btn-success text-white" type="submit">Update</button>
                                <a href="{{ route('admin.export-enablers.companies.index') }}" class="btn btn-secondary" role="button">Back</a>
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
<script src="/libs/select2/dist/js/select2.full.min.js"></script>   
<script src="/libs/dropify/js/dropify.min.js"></script>   
<script src="/libs/maxlength/maxlength.js"></script>  
<script>    
    $(document).ready(function(){
        $('#nav-export-enablers').addClass('selected');
        $('#nav-export-enablers-a').addClass('active');
        $('#nav-export-enablers-ul').addClass('in');
        $('#subnav-companies-li').addClass('active');
        $('#subnav-companies-a').addClass('active');

        $('#details').maxlength({
            alwaysShow: true,
            warningClass: 'label label-success bg-success text-white',
            limitReachedClass: 'label label-danger',
            separator: ' out of ',
            preText: 'You typed ',
            postText: ' chars available.'
        });

        var tags_selected = <?php echo json_encode($arr_tags); ?>;

        $("#categories").select2();
        $('#categories').val(tags_selected);
        $('#categories').trigger('change');

        var drImageLogo = $('#logo').dropify({
            messages: {
                'default': '',
            }
        });

        var drImageThumb = $('#thumb').dropify({
            messages: {
                'default': '',
            }
        });

        drImageLogo.on('dropify.beforeClear', function(event, element){
            return confirm("Do you really want to delete this company logo?");
        });
        drImageLogo.on('dropify.afterClear', function(event, element){
            $.ajax({
                type:'POST',
                url:'/api/delete/image',
                data: {
                    table: 'export_enablers',
                    field: 'co_logo',
                    path: "{{ storage_path('app/public/export_enablers/logo/'.$enabler->co_logo) }}",
                    id: "{{ $enabler->id }}"
                },
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(data, status, xhr){
                    return true;
                }
            });
        });

        drImageThumb.on('dropify.beforeClear', function(event, element){
            return confirm("Do you really want to delete this thumbnail?");
        });
        drImageThumb.on('dropify.afterClear', function(event, element){
            $.ajax({
                type:'POST',
                url:'/api/delete/image',
                data: {
                    table: 'export_enablers',
                    field: 'thumb_image',
                    path: "{{ storage_path('app/public/export_enablers/thumb/'.$enabler->thumb_image) }}",
                    id: "{{ $enabler->id }}"
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