{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}


@extends('layouts.admin_auth')
@section('title', trans('global.forgot_password_title'))
@section('main-content')

                <div class="row justify-content-center">
                    <div class="col-xxl-8 col-lg-10">
                        <div class="card overflow-hidden">
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
                                            <h4 class="fs-20">@lang('global.forgot_password')</h4>
                                            <p class="text-muted mb-3">Enter your email address and we'll send you an email with instructions to reset your password.</p>

                                            @if (session('status'))
                                                <div class="alert alert-success" role="alert">
                                                    {{ session('status') }}
                                                </div>
                                            @endif
                                            <!-- form -->
                                            <form method="POST" action="{{ route('password.email') }}">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="emailaddress" class="form-label">@lang('global.login_email')</label>
                                                    <input class="form-control @error('email') is-invalid @enderror" type="email" id="emailaddress" required="" name="email"
                                                        placeholder="Enter your email">
                                                    @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                
                                                <div class="mb-0 text-start">
                                                    <button class="btn btn-soft-primary w-100" type="submit"><i class="ri-loop-left-line me-1 fw-bold"></i> <span class="fw-bold">Reset Password</span> </button>
                                                </div>
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
                        <p class="text-dark-emphasis">Back To <a href="{{ route('login') }}" class="text-dark fw-bold ms-1 link-offset-3 text-decoration-underline"><b>Log In</b></a></p>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->

@endsection

@section('custom_js')
@endsection