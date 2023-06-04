@extends('admin.layouts.app')

@section('content')
<div class="admin-media-index">
    <div class="d-flex flex-wrap">
        <h3 class="h4">Media Items</h3>
        <form  class="d-none" action="" enctype="multipart/form-data" id="file-upload" >
          <input type="file" name="files[]" id="files" multiple>
        </form>
        <span class="ms-auto open-file-upload-window">
          <button class="btn btn-sm btn-outline-primary border border-2 rounded h5">
            <i class="ri-upload-2-fill me-1"></i>
           <span> Upload Media</span>
          </button>
        </span>
    </div>
    <div class="media-items row">
    
      
      <div class="mt-5">
        <div class="row ">    
          @foreach ($media_items as $media)
           <div class="media-item p-1 col-md-3 col-sm-4">
            <div class="card " style="height:100% !important">
              <img src="{{ $media->getUrl() }}" class="card-img-top" alt="{{ $media->filename }}">
              <div class="card-body p-1">
                <a href="{{ $media->getUrl() }}" class="p">{{ $media->filename }}</a>
                <br>
                <span class="btn btn-sm btn-info">{{ round(($media->size/1000),2)}} kb</span>
                <form action="{{ route('admin.media.delete', $media->id) }}" method="POST" class="delete-media-form d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger" 
                  class="delete-media-item"><i class="ri-delete-bin-line h6"></i>
                  </button>
                </form>
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
