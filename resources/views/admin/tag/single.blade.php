@extends('admin.layouts.app')

@section('content')
<div class="admin-single-view">
    <div>
        <h3 class="text-capitalize">{{__('messages.tag')}}</h3>
    </div>
    <div class="row">
        <div class="form_item col-md-6">
            <label class="mt-3 mb-1">Tag name</label> 
            <input disabled type="text" class="form-control" name='name' value="{{ $tag->name}}"  >
        </div>
        <div class="form_item col-md-6">
            <label class="mt-3 mb-1">Tag slug</label>
            <input disabled  type="text" class="form-control" name='slug' value=" {{ $tag->slug}} "  >
        </div>
        <div class="form_item col-md-6">
            <label class="mt-3 mb-1">Description</label> 
            <textarea disabled  name="description" class="form-control">{{$tag->description}}</textarea>
        </div>
    </div>
    <div class="row">
        <div class="form_item col-md-6">
            <label class="mt-3 mb-1">Meta Description</label>
            <textarea disabled  name="meta_tag_description" class="form-control">{{ $tag->meta_tag_description }}</textarea>
        </div>
        <div class="form_item col-md-6">
            <label class="mt-3 mb-1">Meta keywords</label> 
            <textarea disabled  name="meta_tag_keywords" class="form-control">{{$tag->meta_tag_keywords}}</textarea>
        </div>
    </div>
</div>
@endsection