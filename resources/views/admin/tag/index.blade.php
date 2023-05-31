@extends('admin.layouts.app')

@section('content')

<div class="admin-tag-page-content">


  {{-- @include('admin.partials.delete-confirmbox') --}}

</div>

@endsection


@section('footer-script')
<script src="{{asset('assets/admin/js/tag.js')}}"></script>
@endsection
