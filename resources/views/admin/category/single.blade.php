@extends('admin.layouts.app')

@section('content')
    <div class="admin-single-view">
        <div>
            <h3 class="text-capitalize"> Category Details</h3>
        </div>

        <div class="form-container">
            <form >
                <div class="row">
                    <div class="form_item col-md-4">
                        <label class="mt-3 mb-1">Language</label>
                        <input type="text" class="form-control form-control-sm" disabled name='name'
                        value="{{ $category->lang }}">
                    </div>
                    <div class="form_item col-md-4">
                        <label class="mt-3 mb-1">Post Type</label>
                        <input type="text" class="form-control form-control-sm" disabled name='name'
                        value="{{ $category->post_type }}">
                    </div>
                    <div class="form_item col-md-4">
                        <label class="mt-3 mb-1">Parent Category</label>
                        <input type="text" class="form-control form-control-sm" disabled name='name'
                        value="{{ $category->parent_category?$category->parent_category->name:'' }}">
                    </div>
                    <div class="form_item col-md-6">
                        <label class="mt-3 mb-1">Category name</label>
                        <input type="text" class="form-control form-control-sm" disabled name='name'
                            value=" {{ $category->name }}">
                    </div>
                    <div class="form_item col-md-6">
                        <label class="mt-3 mb-1">Category slug</label>
                        <input type="text" class="form-control form-control-sm" disabled name='slug'
                            value=" {{  $category->slug }} ">
                    </div>
                    <div class="form_item col-md-6">
                        <label class="mt-3 mb-1">Description</label>
                        <textarea name="description" class="form-control form-control-sm" disabled>{{$category->description }}</textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="form_item col-md-6">
                        <label class="mt-3 mb-1">Meta Description</label>
                        <textarea name="meta_tag_description" class="form-control form-control-sm" disabled>{{ $category->meta_tag_description }}</textarea>
                    </div>
                    <div class="form_item col-md-6">
                        <label class="mt-3 mb-1">Meta keywords</label>
                        <textarea name="meta_tag_keywords" class="form-control form-control-sm" disabled>{{  $category->meta_tag_keywords }}</textarea>
                    </div>
                    <div class="form_item col-md-12 my-2">
                        <label class="mt-3 mb-1">Category Image</label>
                        <div id="category_thumbnail_img_container" class="inserted_img_container">
                            @if ($category->firstMedia('thumbnail') != null)
                                <div class="inserted_img">
                                    <input type="hidden" name="category_thumbnail"
                                        value="{{ $category->firstMedia('thumbnail') != null ? $category->firstMedia('thumbnail')->id : '' }}">
                                    <img
                                        src="{{ $category->firstMedia('thumbnail') != null ? $category->firstMedia('thumbnail')->getUrl() : '' }}" />
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer-script')
    <script src="{{ asset('assets/admin/js/category.js') }}"></script>
@endsection


