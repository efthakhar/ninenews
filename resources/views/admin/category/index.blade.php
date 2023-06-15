
@extends('admin.layouts.app')

@section('content')
<div>

  <div class="d-flex flex-wrap">
    <h4 class="h4 text-capitalize"> {{ __('messages.categories') }} </h4>
    
    {{-- <button class="btn btn-sm btn-secondary ms-auto m-1" >
      <i class="ri-filter-2-fill"></i>
      <span class="d-none d-sm-inline ms-1">Filter</span>
    </button> --}}
    <a href="/admin/categories/create" class="ms-auto">
      <button class="btn btn-sm btn-primary m-1">
        <i class="ri-add-fill"></i>
        <span class="d-none d-sm-inline ms-1"> Add New</span>
      </button>
    </a>
    
  </div>

  <div class="filter-form-container mt-2">
    <form action="{{route('admin.category.index')}}" class="row" method="GET" id="filter-form">
      <div class="form-item col-sm-4 col-md-2">
        <label for="">per page</label>
        {{ generate_perpage_options('perpage','category-filter-form-perpage', $_GET['perpage']??'',"form-control form-control-sm my-1") }}
      </div>
      <div class="form-item col-sm-4 col-md-2">
        <label>name</label>
        <input type="text" class="form-control form-control-sm my-1" name='name' id="name"
        value="{{ isset($_GET['name']) ? $_GET['name']:'' }}"  placeholder="type & enter" >
      </div>
      <div class="form-item col-sm-4 col-md-2">
        <label>slug</label>
        <input type="text" class="form-control form-control-sm my-1" name='slug' id="slug"
        value="{{ isset($_GET['slug']) ? $_GET['slug']:'' }}"  placeholder="type & enter" >
      </div>
      <div class="form-item col-sm-4 col-md-2">
        <label for="">sort by</label>
       {{ generate_select_input("sortby", "category-filter-form-sortby", $_GET['sortby']??"", $sort_options, "form-select form-select-sm  my-1")}} 
      </div>
      <div class="form-item col-sm-4 col-md-2">
        <label for="">sort type</label>
        {{ generate_select_input("sorttype", "category-filter-form-sorttype", $_GET['sorttype']??"", $sort_type_options, "form-select form-select-sm  my-1")}} 
      </div>
      <div class="form-item col-sm-4 col-md-2">
        <label for="">language</label>
        {{ generate_language_options('language','category-filter-form-language', $_GET['language']??'', true,"form-control form-control-sm my-1") }}
      </div>
      <div class="form-item col-sm-4 col-md-2">
        <label for="">post type</label>
        {{ generate_posttype_options('posttype','category-filter-form-posttype', $_GET['posttype']??'', true,"form-control form-control-sm my-1") }}
      </div>
      <button  type="submit" class="d-none">Apply Filter</button>
    </form>
  </div>
 
  <div class="admin-main-content-table-container mt-4">
    <div class="table-responsive">
      <table class="table table-bordered" >
        <thead >
          <tr>
            <th scope="col" class="fw50px text-center">
              <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
            </th>
            <th scope="col">Thunmbnail</th>
            <th scope="col" class="mw100px">Name</th>
            <th scope="col" class="mw200px">Slug</th>
            <th scope="col" class="mw100px">Language</th>
            <th scope="col" class="mw100px">Post Type</th>
            <th scope="col" class="mw200px">Parent Category</th>
            <th scope="col" class="mw200px">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($categories as $category)
          <tr>
            <td class="fw50px text-center">
              <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
            </td>
            <td>
                <img src="{{ $category->firstMedia('thumbnail')!=NULL ? $category->firstMedia('thumbnail')->getUrl(): '' }} " alt="" style="width:50px;height:50px">
            </td>
            <td>{{$category->name}}</td>
            <td>{{$category->slug}}</td>
            <td>{{$category->lang}}</td>
            <td>{{$category->post_type}}</td>
            <td>
                @if($category->parent_category)
                    <button class="btn btn-sm btn-outline-danger">
                        {{$category->parent_category->name}}
                    </button>
                @endif
            </td>
            <td>
              <div class="d-flex justify-center align-center">
                <a href="{{ route('admin.category.single', $category->id) }}" class="btn btn-sm p-0 text-info mx-1">
                  <i class="ri-eye-line h4"></i>
                </a>
                <a href="{{ route('admin.category.edit', $category->id) }}" class="btn btn-sm p-0 text-sb1 mx-1">
                  <i class="ri-edit-2-line h4"></i>
                </a>
 
                  <button  class="p-0 btn btn-sm text-danger delete-category mx-1" 
                  data-category-id="{{ $category->id }}"> 
                    <i class="ri-delete-bin-line h4"></i>
                  </button>
               
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @if(count($categories)==0)
      <h2 class="h2 text-capitalize text-warning"> {{ __('no records found') }} </h2>
      @endif
    </div>
  </div>

  <div class="pagination-container">
    {{$categories->links()}}
  </div>

@endsection


@section('footer-script')
<script src="{{asset('assets/admin/js/category.js')}}"></script>
@endsection
