@extends('admin.layouts.app')

@section('content')
<div class="admin-tag-page-content">

</div>
@include('admin.partials.delete-confirmbox')
@endsection


@section('footer-script')
<script src="{{asset('assets/admin/js/tag.js')}}"></script>
@endsection
