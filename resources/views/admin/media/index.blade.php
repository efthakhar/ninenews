@extends('admin.layouts.app')

@section('content')
<div class="admin-media-index">
    <div class="d-flex flex-wrap">
        <h3 class="h4">Media Items</h3>
        <div class="d-flex flex-column align-items-end ms-auto">
          <div class="media-filter-input">
            <form  class="" action="{{route('admin.media.index')}}" method="GET"  >
              <input type="text" class="form-control form-control-sm my-1" name='filename' id="filename"
              value="{{ isset($_GET['filename']) ? $_GET['filename']:'' }}"  placeholder="type & enter" >
            </form>
          </div>
          <span class="open-file-upload-window">
            <button class="btn btn-sm btn-outline-primary border border-2 rounded h5">
              <i class="ri-upload-2-fill me-1"></i>
             <span> Upload Media</span>
            </button>
          </span>
          <form  class="d-none" action="" enctype="multipart/form-data" id="mw-upload-form" >
            <input type="file" name="mw_uploads[]" id="mw_uploads" multiple>
          </form>
        </div>
    </div>
    <div class="">
      <div class="mt-5">
        <div class="row media-items">    
          @foreach ($media_items as $media)
           <div class="media-item p-1 col-md-3 col-sm-4" data-id="{{$media->id}}" >
            <div class="card " style="height:100% !important">
              <img src="{{ $media->getUrl() }}" class="card-img-top" alt="{{ $media->filename }}">
              <div class="card-body p-1 d-flex flex-column justify-content-between">
                <div>
                  <a href="{{ $media->getUrl() }}" class="p">{{ $media->filename }}</a>
                </div>
                <div>
                    <span class="btn btn-sm btn-primary">{{ round(($media->size/1000),2)}} kb</span>
                    <button class="btn btn-sm btn-danger delete-media-item" data-id="{{$media->id}}">
                     Delete
                    </button>
                </div>
              </div>
            </div>
           </div>
          @endforeach
        </div>
        <div class="mt-3">
          {{$media_items->links()}}
        </div>
      </div>
    </div>
</div>
@endsection

@section('footer-script')
<script src="{{asset('assets/admin/js/media.js')}}"></script>
@endsection
