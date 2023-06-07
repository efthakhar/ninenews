@extends('admin.layouts.app')

@section('content')
<div>
    <div>
        <h3 class="text-capitalize">{{__('messages.tag.edit')}}</h3>
    </div>
    @if(session()->has('tagUpdateSuccess'))
    <div class="alert bg-success-1 text-success-1">
        {{ session()->get('tagUpdateSuccess') }}
    </div>
    @endif
    <div class="form-container">
        <form method="POST" action="{{ route('admin.tag.update',$tag->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="form_item col-md-6">
                    <label class="mt-3 mb-1">Language</label>
                    @error('language')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror 
                    {{ generate_language_options('language','language', old('language') ?? $tag->lang,false,"form-control") }}
                </div>
                <div class="form_item col-md-6">
                    <label class="mt-3 mb-1">Tag name</label>
                    @error('name')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror 
                    <input type="text" class="form-control" name='name' value="{{ old('name') ?? $tag->name}}"  >
                </div>
                <div class="form_item col-md-6">
                    <label class="mt-3 mb-1">Tag slug</label>
                    @error('slug')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror 
                    <input type="text" class="form-control" name='slug' value=" {{ old('slug') ?? $tag->slug}} "  >
                </div>
                <div class="form_item col-md-6">
                    <label class="mt-3 mb-1">Description</label>
                    @error('description')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror 
                    <textarea name="description" class="form-control">{{ old('description') ?? $tag->description}}</textarea>
                </div>
            </div>
            <div class="row">
                <div class="form_item col-md-6">
                    <label class="mt-3 mb-1">Meta Description</label>
                    @error('meta_tag_description')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror 
                    <textarea name="meta_tag_description" class="form-control">{{  old('meta_tag_description') ?? $tag->meta_tag_description }}</textarea>
                </div>
                <div class="form_item col-md-6">
                    <label class="mt-3 mb-1">Meta keywords</label>
                    @error('meta_tag_keywords')
                    <p class="text-danger">{{ $message }}</p>
                    @enderror 
                    <textarea name="meta_tag_keywords" class="form-control">{{  old('meta_tag_keywords') ?? $tag->meta_tag_keywords}}</textarea>
                </div>
            </div>

            <div class="submit-form-btn-container">
                <button type="submit" class="btn btn-primary mt-3">
                    Update Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection