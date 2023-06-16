@extends('admin.layouts.app')

@section('content')
    <div>
        <div>
            <h3 class="text-capitalize"> Edit Category</h3>
        </div>
        @if(session()->has('CategoryUpdateSuccess'))
        <div class="alert bg-success-1 text-success-1">
            {{ session()->get('CategoryUpdateSuccess') }}
        </div>
        @endif
        <div class="form-container">
            <form method="post" action="{{ route('admin.category.update', $category->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="form_item col-md-4">
                        <label class="mt-3 mb-1">Language</label>
                        @error('lang')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        {{ generate_language_options('lang', 'edit_cat_lang', old('lang') ?? $category->lang, false, 'form-control form-control-sm') }}
                    </div>
                    <div class="form_item col-md-4">
                        <label class="mt-3 mb-1">Post Type</label>
                        @error('post_type')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        {{ generate_posttype_options('post_type', 'edit_cat_post_type', old('post_type') ?? $category->post_type, false, 'form-control form-control-sm') }}
                    </div>
                    <div class="form_item col-md-4">
                        <label class="mt-3 mb-1">Parent Category</label>
                        <select disabled name="parent_category" id="edit_cat_parent_category" data-cat-id="{{$category->id}}"
                            class="form-control form-control-sm text-lowercase">
                        </select>

                    </div>
                    <div class="form_item col-md-6">
                        <label class="mt-3 mb-1">Category name</label>
                        @error('name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <input type="text" class="form-control form-control-sm" name='name'
                            value=" {{ old('name') ?? $category->name }}">
                    </div>
                    <div class="form_item col-md-6">
                        <label class="mt-3 mb-1">Category slug</label>
                        @error('slug')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <input type="text" class="form-control form-control-sm" name='slug'
                            value=" {{ old('slug') ?? $category->slug }} ">
                    </div>
                    <div class="form_item col-md-6">
                        <label class="mt-3 mb-1">Description</label>
                        @error('description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <textarea name="description" class="form-control form-control-sm">
                        {{ old('description') ?? $category->description }}
                    </textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="form_item col-md-6">
                        <label class="mt-3 mb-1">Meta Description</label>
                        @error('meta_tag_description')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <textarea name="meta_tag_description" class="form-control form-control-sm">{{ old('meta_tag_description') ?? $category->meta_tag_description }}</textarea>
                    </div>
                    <div class="form_item col-md-6">
                        <label class="mt-3 mb-1">Meta keywords</label>
                        @error('meta_tag_keywords')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                        <textarea name="meta_tag_keywords" class="form-control form-control-sm">{{ old('meta_tag_keywords') ?? $category->meta_tag_keywords }}</textarea>
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
                                    <span class="cross-btn p-0">
                                        {{ cross_svg() }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        <span class="btn btn-dark btn-sm media-window-open-btn mt-1">
                            <i class="ri-image-add-fill"></i>
                            Add Image
                        </span>
                    </div>
                </div>

                <div class="submit-form-btn-container">
                    <button type="submit" class="btn btn-primary mt-3 ">
                        Update Data
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('footer-script')
    <script src="{{ asset('assets/admin/js/media-window.js') }}"></script>
    <script src="{{ asset('assets/admin/js/category.js') }}"></script>
@endsection
