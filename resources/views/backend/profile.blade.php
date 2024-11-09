@extends('layouts.admin')
@section('title', trans('global.profile'))

@section('custom_css')
@endsection

@section('main-content')

    <!-- start page title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="profile-bg-picture"
                style="background-image:url('{{ asset('backend/images/bg-profile.jpg') }}')">
                <span class="picture-bg-overlay"></span>
                <!-- overlay -->
            </div>
            <!-- meta -->
            <div class="profile-user-box">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="profile-user-img">
                                <!-- <img src="{{ asset('backend/images/users/avatar-1.jpg') }}" alt="" class="avatar-lg rounded-circle"> -->
                                @if($user->profile_image_url)
                                    <img src="{{ $user->profile_image_url }}" alt="user-image"  class="avatar-lg rounded-circle">
                                @else
                                    <img src="{{ asset(config('constant.default.user_icon')) }}" alt="user-image"  class="avatar-lg rounded-circle">
                                @endif  
                        </div>
                        <div class="">
                            <h4 class="mt-4 fs-17 ellipsis">{{ $user->name }}</h4>
                            <p class="font-13"> 
                                @foreach ($user->roles as $role)
                                    {{ $role->name }}
                                @endforeach
                            </p>
                            <p class="text-muted mb-0"><small>{{ $user->email }}</small></p>
                        </div>
                    </div>
                   
                </div>
            </div>
            <!--/ meta -->
        </div>
    </div>
    <!-- end row -->
    <!-- end page title -->

    <!-- start row -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card p-0">
                <div class="card-body p-0">
                    <div class="profile-content">
                        <ul class="nav nav-underline nav-justified gap-0">
                
                            <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab"
                                    data-bs-target="#edit-profile" type="button" role="tab"
                                    aria-controls="home" aria-selected="true"
                                    href="#edit-profile">Profile</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab"
                                    data-bs-target="#change-password" type="button" role="tab"
                                    aria-controls="home" aria-selected="true"
                                    href="#change-password">Change Password</a>
                            </li>
                        </ul>

                        <div class="tab-content m-0 p-4">

                            <!-- Profile -->
                            <div id="edit-profile" class="tab-pane active">
                                <div class="user-profile-content">
                                    <form id="profile-form" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row row-cols-sm-2 row-cols-1">
                                            <div class="mb-2">
                                                <label class="form-label" for="name">Name</label>
                                                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $user->name }}">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" for="phone" >Phone</label>
                                                <input type="text"  id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ $user->phone }}">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" for="image" >Image</label>
                                                <input type="file"  id="image" name="profile_image" class="form-control fileInputBoth" accept="image/*">
                                            </div>

                                            <div class="mb-3">
                                                <div class="img-prevarea m-1">
                                                    <img src="{{ $user->profile_image_url ? $user->profile_image_url : asset(config('constant.default.user_icon')) }}" width="100px" height="100px" >
                                                </div>
                                            </div>

                                        </div>
                                        <button class="btn btn-primary submitBtn" type="submit"><i class="ri-save-line me-1 fs-16 lh-1"></i> Save</button>
                                    </form>
                                </div>
                            </div>

                            <!-- Change Password form -->
                            <div id="change-password" class="tab-pane">
                                <div class="row m-t-10">
                                    <div class="col-md-12">
                                    <form id="change-password-form">    
                                        @csrf
                                        <div class="row row-cols-sm-2 row-cols-1">
                                            <div class="mb-3">
                                                <label class="form-label" for="Password">Password</label>
                                                <div class="input-group input-group-merge">
                                                <input type="password" placeholder="Enter current password"
                                                    id="current_password" name="current_password" class="form-control">
                                                    <div class="input-group-text" data-password="false">
                                                        <span class="password-eye"></span>
                                                    </div>
                                                </div>    
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label"
                                                    for="new_password">New Password</label>
                                                <div class="input-group input-group-merge">
                                                <input type="password" placeholder="Enter password confirmation"
                                                    id="new_password" name="password" class="form-control">
                                                    <div class="input-group-text" data-password="false">
                                                        <span class="password-eye"></span>
                                                    </div>
                                                </div>    
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label"
                                                    for="password_confirmation">Confirm Password</label>
                                                <div class="input-group input-group-merge">    
                                                <input type="password" placeholder="Enter new password confirmation"
                                                    id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}" class="form-control">
                                                    <div class="input-group-text" data-password="false">
                                                        <span class="password-eye"></span>
                                                    </div>
                                                </div>    
                                            </div>
                                        </div>
                                        <button class="btn btn-primary submitBtn" type="submit"><i class="ri-save-line me-1 fs-16 lh-1"></i> Save</button>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

@endsection

@section('custom_js')
<script>
    // Image show in profile page
    $(document).on('change', ".fileInputBoth",function(e){
        var files = e.target.files;
        for (var i = 0; i < files.length; i++) {
            var reader2 = new FileReader();
            reader2.onload = function(e) {
                $('.img-prevarea img').attr('src', e.target.result);
            };
            reader2.readAsDataURL(files[i]);
        }
    });

    $(document).on('submit', '#change-password-form', function(e){

            e.preventDefault();
            $(".submitBtn").attr('disabled', true);

            $('.validation-error-block').remove();

            var formData = new FormData(this);
            // console.log(formData);
            $.ajax({
                type: 'post',
                url: "{{ route('admin.change.password') }}",
                dataType: 'json',
                contentType: false,
                processData: false,
                data: formData,
                success: function (response) {
                    $(".submitBtn").attr('disabled', false);
                    if(response.success) {
                        $('#change-password-form')[0].reset();
                        toasterAlert('success',response.message);
                    }
                },
                error: function (response) {
                    $(".submitBtn").attr('disabled', false);
                    // console.log(response);
                    if(response.responseJSON.error_type == 'something_error'){
                        toasterAlert('error',response.responseJSON.error);
                    } else {                    
                        var errorLabelTitle = '';
                        $.each(response.responseJSON.errors, function (key, item) {
                            errorLabelTitle = '<span class="validation-error-block">'+item[0]+'</sapn>';
                            
                            var elementItem = $("input[name='"+key+"']").parent();    
                            $(errorLabelTitle).insertAfter(elementItem);
                        });
                    }
                },
                complete: function(res){
                    $(".submitBtn").attr('disabled', false);
                }
            });
    });

    $(document).on('submit', '#profile-form', function(e){
        e.preventDefault();
        $(".submitBtn").attr('disabled', true);

        $('.validation-error-block').remove();

        var formData = new FormData(this);

        $.ajax({
            type: 'post',
            url: "{{ route('admin.update.profile') }}",
            dataType: 'json',
            contentType: false,
            processData: false,
            data: formData,
            success: function (response) {
                $(".submitBtn").attr('disabled', false);
                if(response.success) {
                    toasterAlert('success',response.message);
                    setTimeout(function() {
                        window.location.reload();
                    }, 20000000);
                }
            },
            error: function (response) {
                // console.log(response);
                $(".submitBtn").attr('disabled', false);
                if(response.responseJSON.error_type == 'something_error'){
                    toasterAlert('error',response.responseJSON.error);
                } else {
                    var errorLabelTitle = '';
                    $.each(response.responseJSON.errors, function (key, item) {
                        errorLabelTitle = '<span class="validation-error-block">'+item[0]+'</sapn>';

                        $(errorLabelTitle).insertAfter("input[name='"+key+"']");

                    });
                }
            },
            complete: function(res){
                $(".submitBtn").attr('disabled', false);
            }
        });
    });

</script>
@endsection