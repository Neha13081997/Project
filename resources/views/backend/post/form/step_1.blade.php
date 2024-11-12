<div class="tab-pane show active" id="step1Section">
    <form id="stepForm1" method="post" class="step-form" data-step-form-no="1" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="mb-3 col-md-6 col-lg-6">
                <label for="title" class="form-label">Title<span class="required text-danger"> *</span></label>
                <input type="text" id="title" name="title" class="form-control" placeholder="Enter Title" value="{{ isset($post) ? $post->title : '' }}">
            </div>

            <div class="mb-3 col-md-6 col-lg-6">
                <label for="sub_title" class="form-label">Sub Title</label>
                <input type="text" id="sub_title" name="sub_title" class="form-control" placeholder="Enter Sub title" value="{{ isset($post) ? $post->sub_title : '' }}">
            </div>

            <div class="mb-3 col-md-6 col-lg-6">
                <label class="form-label" for="post_image">Image</label>
                @php
                $postImageUrl = '';

                if(isset($post)){

                if($post->post_image_url){
                $postImageUrl = $post->post_image_url;
                }
                }
                @endphp
                <input name="post_image" id="post_image" type="file" class="dropify" id="post-image" data-height="100" data-default-file="{{ $postImageUrl }}" data-show-loader="true" data-errors-position="outside" data-allowed-file-extensions="jpeg png jpg" data-min-file-size-preview="1M" data-max-file-size-preview="3M" accept="image/jpeg, image/png, image/jpg" />
            </div>
        </div>

        <ul class="list-inline wizard mb-0">
            <li class="next list-inline-item float-end">
                <button type="submit" class="btn btn-success submitBtn">@lang('global.save')<i class="ri-arrow-right-line ms-1"></i></button>
            </li>
        </ul>
    </form>
</div>