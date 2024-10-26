@extends('layouts.admin_auth')
@section('title', trans('global.register'))
@section('main-content')

            <div class="row justify-content-center">
                <div class="col-xxl-8 col-lg-10">
                    <div class="card overflow-hidden bg-opacity-25">
                        <div class="row g-0">
                            <div class="col-lg-6 d-none d-lg-block p-2">
                                <img src="{{ asset('backend/images/auth-img.jpg') }}" alt="" class="img-fluid rounded h-100">
                            </div>
                            <div class="col-lg-6">
                                <div class="d-flex flex-column h-100">
                                    <div class="auth-brand p-4">
                                        <a href="index.html" class="logo-light">
                                            <img src="{{ asset('backend/images/logo.png') }}" alt="logo" height="22">
                                        </a>
                                        <a href="index.html" class="logo-dark">
                                            <img src="{{ asset('backend/images/logo-dark.png') }}" alt="dark logo" height="22">
                                        </a>
                                    </div>
                                    <div class="p-4 my-auto">
                                        <h4 class="fs-20">@lang('global.create_new_account')</h4>
                                        <p class="text-muted mb-3">Welcome to User Information.</p>

                                        <!-- form --> 
                                        <form action="{{ route('register') }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="fullname" class="form-label">@lang('global.name')</label>
                                                <input class="form-control @error('name') is-invalid @enderror" type="text" id="fullname" name="name"
                                                    placeholder="Enter your name" required="" value="{{ old('name') }}">
                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="emailaddress" class="form-label">@lang('global.login_email')</label>
                                                <input class="form-control @error('email') is-invalid @enderror" type="email" id="emailaddress" required="" name="email"
                                                    placeholder="Enter your email" value="{{ old('email') }}">
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="password" class="form-label">@lang('global.login_password')</label>
                                                <div class="input-group input-group-merge">
                                                    <input class="form-control @error('password') is-invalid @enderror" type="password" required="" id="password" name="password"
                                                    placeholder="Enter your password">
                                                    <div class="input-group-text" data-password="false">
                                                        <span class="password-eye"></span>
                                                    </div>
                                                </div>
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="phone" class="form-label">@lang('global.phone')</label>
                                                <input class="form-control @error('phone') is-invalid @enderror" type="number" id="phone" name="phone"
                                                    placeholder="Enter your phone number" value="{{ old('phone') }}">
                                                @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="role" class="form-label">Role</label>
                                                <select class="form-select @error('role') is-invalid @enderror" name="role" id="role">
                                                    <option value="">@lang('global.pleaseSelect')</option>
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->id }}"  @if(old('role') == $role->id) selected @endif>{{ ucfirst($role->name) }}</option>
                                                    @endforeach
                                                </select>
                                                @error('role')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>

                                            <!-- <div class="mb-3">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input"
                                                        id="checkbox-signup" name="term">
                                                    <label class="form-check-label" for="checkbox-signup">I accept <a
                                                            href="javascript: void(0);" class="text-muted">Terms and
                                                            Conditions</a></label>
                                                </div>
                                            </div> -->
                                            <div class="mb-0 d-grid text-center">
                                                <button class="btn btn-primary fw-semibold" type="submit">@lang('global.register')</button>
                                            </div>

                                            <!-- <div class="text-center mt-4">
                                                <p class="text-muted fs-16">Sign in with</p>
                                                <div class="d-flex gap-2 justify-content-center mt-3">
                                                    <a href="javascript: void(0);" class="btn btn-soft-primary"><i
                                                            class="ri-facebook-circle-fill"></i></a>
                                                    <a href="javascript: void(0);" class="btn btn-soft-danger"><i
                                                            class="ri-google-fill"></i></a>
                                                    <a href="javascript: void(0);" class="btn btn-soft-info"><i
                                                            class="ri-twitter-fill"></i></a>
                                                    <a href="javascript: void(0);" class="btn btn-soft-dark"><i
                                                            class="ri-github-fill"></i></a>
                                                </div>
                                            </div> -->
                                        </form>
                                        <!-- end form-->
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <p class="text-dark-emphasis">Already have an account? <a href="{{ route('login') }}"
                            class="text-dark fw-bold ms-1 link-offset-3 text-decoration-underline"><b>@lang('global.login')</b></a>
                    </p>
                </div> <!-- end col -->
            </div>

@endsection
@section('custom_js')
@endsection