@extends('layouts.admin')
@section('title', 'Create Post')

@section('custom_css')
<!-- dropify css -->
<link href="{{ asset('backend/vendor/dropify/dropify.min.css')}}" rel="stylesheet" type="text/css" />

<!-- Quill css -->
<link href="{{ asset('backend/vendor/quill/quill.snow.css')}}" rel="stylesheet" type="text/css" />


@endsection

@section('main-content')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">HIPL</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.post.index') }}">Post</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </div>
            <h4 class="page-title">Create Post</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-xl-12">
        <div class="card">
           
            <div class="card-body">
                <ul class="nav nav-tabs nav-justified nav-bordered mb-3">
                    <li class="nav-item">
                        <a data-bs-toggle="tab" aria-expanded="true" class="nav-link navTab active" href="{{ route('admin.post.stepForm',1) }}" data-step="1" data-tab-type="step1Section">
                            About
                        </a>
                    </li>
                    <li class="nav-item">
                        <a data-bs-toggle="tab" aria-expanded="false" class="nav-link navTab disabled" href="{{ route('admin.post.stepForm',2) }}" data-step="2" data-tab-type="step2Section">
                            Description
                        </a>
                    </li>
                    <li class="nav-item">
                        <a data-bs-toggle="tab" aria-expanded="false" class="nav-link navTab disabled" href="{{ route('admin.post.stepForm',3) }}" data-step="3" data-tab-type="step3Section">
                            Location
                        </a>
                    </li>
                    <li class="nav-item">
                        <a data-bs-toggle="tab" aria-expanded="false" class="nav-link navTab disabled" href="{{ route('admin.post.stepForm',4) }}" data-step="4" data-tab-type="step4Section">
                            Review
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                   



                </div>
            </div> <!-- end card-body -->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>
<!-- end row -->


@endsection

@section('custom_js')
<!-- dropify Js -->
<script src="{{ asset('backend/vendor/dropify/dropify.min.js') }}"></script>

<!-- Quill Editor js -->
<script src="{{ asset('backend/vendor/quill/quill.min.js') }}"></script>

<script>
    
    let userObj = {
        id:null
    };
    
</script>
@include('backend.post.partial.main_js')
@endsection