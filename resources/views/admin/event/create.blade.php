@extends('layouts.admin')

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">Events & Activities</h4>
            <div class="ms-auto text-end">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.events-activities.index') }}">Events & Activities</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Add Event & Activity
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <form method="POST" action="{{ route('admin.events-activities.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <h5 class="card-header">Adding new event</h5>
                    <div class="card-body">
                        <div class="form-group mt-3">
                            <label class="form-label">Title*</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" placeholder="" value="{{ old('title') }}" maxlength="100"/>
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Event Happening In*</label>
                            <select class="form-select @error('event_happening') is-invalid @enderror" name="event_happening" id="event_happening">
                                <option selected value="">-- Select --</option>
                                <option value="global" {{ old('event_happening') === 'global' ? 'selected' : '' }}>Global</option>
                                <option value="local" {{ old('event_happening') === 'local' ? 'selected' : '' }}>Local</option>
                            </select>
                            @error('event_happening')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Event Type*</label>
                            <select class="form-select @error('event_type') is-invalid @enderror" name="event_type" id="event_type">
                                <option selected value="">-- Select --</option>
                                <option value="digital" {{ old('event_type') === 'digital' ? 'selected' : '' }}>Digital</option>
                                <option value="on-site" {{ old('event_type') === 'on-site' ? 'selected' : '' }}>On-Site</option>
                            </select>
                            @error('event_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Platform</label>
                            <select class="form-select @error('platform') is-invalid @enderror" name="platform" id="platform">
                                <option selected value="">-- Select --</option>
                                <option value="hopin" {{ old('platform') === 'hopin' ? 'selected' : '' }}>Hopin</option>
                                <option value="google hangout" {{ old('platform') === 'google hangout' ? 'selected' : '' }}>Google Hangout</option>
                                <option value="viber" {{ old('platform') === 'viber' ? 'selected' : '' }}>Viber</option>
                                <option value="zoom" {{ old('platform') === 'zoom' ? 'selected' : '' }}>Zoom</option>
                            </select>
                            @error('platform')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Location</label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" name="location" placeholder="" value="{{ old('location') }}" maxlength="100"/>
                            @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Event Date* <small class="text-muted">dd/mm/yyyy</small></label>
                            <div class="input-group">
                                <span class="input-group-text">From</span>
                                <input type="text" name="event_date_from" id="event_date_from" placeholder="Enter Date" class="form-control" value="{{ old('event_date_from') }}">
                                <span class="input-group-text">To</span>
                                <input type="text" name="event_date_to" id="event_date_to" placeholder="Enter Date" class="form-control" value="{{ old('event_date_to') }}">
                            </div>
                            @error('event_date_from')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Event Organizer*</label>
                            <input type="text" class="form-control @error('organizer') is-invalid @enderror" name="organizer" placeholder="" value="{{ old('organizer') }}" maxlength="100"/>
                            @error('organizer')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Event Link*</label>
                            <input type="url" class="form-control @error('event_link') is-invalid @enderror" name="event_link" placeholder="" value="{{ old('event_link') }}" maxlength="100"/>
                            @error('event_link')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                           <label class="form-label">Tag Category</label>
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
                            <label class="form-label">Description*</label>
                            <textarea name="details" class="form-control @error('details') is-invalid @enderror" id="details">{{ old('details') }}</textarea>
                            @error('details')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label mb-0">Organizer Logo</label>
                            <div id="emailHelp" class="form-text">Note: Recommended image dimension is 200 x 200 pixels and a maximum filesize of 5MB.</div>
                            <input type="file" id="organizer_logo" name="organizer_logo" class="dropify" accept="image/*" data-max-file-size="5M" data-allowed-file-extensions="gif png jpg jpeg" data-height="200" data-errors-position="outside"/>  
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label mb-0">Event Banner</label>
                            <div id="emailHelp" class="form-text">Note: Recommended image dimension is 650 x 650 pixels and a maximum filesize of 5MB.</div>
                            <input type="file" id="event_banner" name="event_banner" class="dropify" accept="image/*" data-max-file-size="5M" data-allowed-file-extensions="gif png jpg jpeg" data-height="200" data-errors-position="outside"/>  
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
                                <label class="form-check-label align-middle" for="status">Publish this event</label>
                            </div>
                            <div class="form-check mr-sm-2">
                                <input type="checkbox" class="form-check-input" id="is_featured" value="1" name="is_featured" {{ (old('is_featured') == 1) ? 'checked' : '' }}>
                                <label class="form-check-label align-middle" for="is_featured">Featured this event</label>
                            </div>
                            <div class="form-check mr-sm-2">
                                <input type="checkbox" class="form-check-input" id="is_educate" value="1" name="is_educate" {{ (old('is_educate') == 1) ? 'checked' : '' }}>
                                <label class="form-check-label align-middle" for="is_educate">Show this in Educate section (Homepage)</label>
                            </div>
                            <div class="form-check mr-sm-2">
                                <input type="checkbox" class="form-check-input" id="is_aboutus" value="1" name="is_aboutus" {{ (old('is_aboutus') == 1) ? 'checked' : '' }}>
                                <label class="form-check-label align-middle" for="is_aboutus">Show this in About Us Page</label>
                            </div>
                            <hr class="w-100 mt-2">
                            <div class="d-grid gap-2 mt-3">
                                <button class="btn btn-success text-white" type="submit">Save</button>
                                <a href="{{ route('admin.events-activities.index') }}" class="btn btn-secondary" role="button">Back</a>
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
<script src="/libs/inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
<script>    
    $(document).ready(function(){
        $('#nav-events').addClass('selected');
        $('#subnav-events').addClass('active');

        var tags_selected = <?php echo json_encode(old('categories')); ?>;

        $("#categories").select2();
        $('#categories').val(tags_selected);
        $('#categories').trigger('change');

        var drOrgLogo = $('#organizer_logo').dropify({
            messages: {
                'default': '',
            }
        });
        var drEventBanner = $('#event_banner').dropify({
            messages: {
                'default': '',
            }
        });

        tinymce.init({
            selector: '#details',
            height: 300,
            plugins: 'code',
            toolbar: 'code',
        });

        $("#event_date_from").inputmask("dd/mm/yyyy");
        $("#event_date_to").inputmask("dd/mm/yyyy");
    });
</script>
@endpush