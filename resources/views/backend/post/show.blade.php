@extends('layouts.admin')
@section('title', 'View Post')

@section('custom_css')
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
                    <li class="breadcrumb-item active">View</li>
                </ol>
            </div>
            <h4 class="page-title">View Post</h4>
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
                        <a href="#about" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                            About
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#description" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                            Description
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#location" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                            Location
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#review" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
                            Review
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane show active" id="about">

                        <div class="row">

                            <div class="mb-3 col-md-6 col-lg-4">
                                <label for="title" class="form-label">Title :</label>
                                <span>{{ isset($post) ? $post->title : ''}}</span>
                            </div>

                            <div class="mb-3 col-md-6 col-lg-4">
                                <label for="sub_title" class="form-label">Sub Title :</label>
                                <span>{{ isset($post) ? $post->sub_title : ''}}</span>

                            </div>

                            <div class="mb-3  col-md-6 col-lg-4">
                                <label for="sales_email" class="form-label">Created At : </label>
                                <span>{{ (isset($post)) ? dateFormat($post->created_at,'d-m-Y H:i') : ''}}</span>
                            </div>

                            <div class="mb-3  col-md-6 col-lg-4">
                                <label for="sales_email" class="form-label">Updated At : </label>
                                <span>{{ (isset($post)) ? dateFormat($post->updated_at,'d-m-Y H:i') : ''}}</span>
                            </div>

                            <div class="mb-3  col-md-6 col-lg-4">
                                <label class="form-label" for="phone">Post Image</label>
                                <div class="img-prevarea m-1">
                                    @php
                                    $postImage = asset(config('constant.default.no_image'));

                                    if(isset($post->post_image_url)){
                                    $postImage = $post->post_image_url;
                                    }
                                    @endphp

                                    <img src="{{ $postImage  }}" width="100px" height="100px">
                                </div>
                            </div>

                            <div class="mb-3 col-md-6 col-lg-4">
                                <label for="sub_title" class="form-label">User Name :</label>
                                <span>{{ isset($post) ? $post->user->name : ''}}</span>
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane" id="description">
                        {!! (isset($post->description) && !empty($post->description)) ? $post->description : '' !!}
                    </div>

                    <div class="tab-pane" id="location">
                        <div class="row">

                            <div class="mb-3 col-md-6 col-lg-4">
                                <label for="country" class="form-label">Country : </label>
                                <span>{{ $post->country ?? '' }}</span>
                            </div>

                            <div class="mb-3 col-md-6 col-lg-4">
                                <label for="city" class="form-label">City :</label>
                                <span>{{ $post->city ?? '' }}</span>
                            </div>

                            <div class="mb-3 col-md-6 col-lg-4">
                                <label for="street" class="form-label">Street :</label>
                                <span>{{ $post->street ?? '' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="review">
                        <p>Review</p>
                    </div>
                </div> <!-- end card-body -->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->


    @endsection

    @section('custom_js')
    @endsection