@php
  $configData = Helper::appClasses();
  $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Login - CORPU')

@section('vendor-style')
  @vite([
    'resources/assets/vendor/libs/@form-validation/form-validation.scss'
  ])
@endsection

@section('page-style')
  @vite([
    'resources/assets/vendor/scss/pages/page-auth.scss'
  ])
@endsection

@section('vendor-script')
  @vite([
    'resources/assets/vendor/libs/@form-validation/popular.js',
    'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
    'resources/assets/vendor/libs/@form-validation/auto-focus.js'
  ])
@endsection

@section('page-script')
  <script async src="https://www.google.com/recaptcha/api.js"></script>
  @vite([
    'resources/assets/js/pages-auth.js'
  ])
@endsection

@section('content')
<link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
<div class="position-relative">
  <div class="authentication-wrapper authentication-basic container-p-y p-4 p-sm-0">
    <div class="authentication-inner py-6">

      <!-- Login -->
      <div class=
            " card p-md-7 p-1">
        <!-- Logo -->
        <div class="app-brand justify-content-center mt-5">
          <a href="{{url('/')}}" class="app-brand-link gap-2">
          <span class="app-brand-logo demo">
        <img src="{{asset('assets/img/logo/favicon.png')}}" alt="Tangsel Corpu Logo" width="25" />
        </span>
        <span class="app-brand-text demo menu-text fw-semibold ms-2 ps-1">TANGSEL CORPU</span>
          </a>
        </div>
        <!-- /Logo -->

        <div class="card-body mt-1">
          <h4 class="mb-1">Halo ASN Tangsel! 👋</h4>
          <p class="mb-5">Gunakan NIP anda untuk login</p>

               
          <form id="formAuthentication" class="mb-5" action="{{ route('login') }}" method="POST">
    @csrf
    
    <div class="form-floating form-floating-outline mb-5">
        <input type="text" class="form-control" id="nip" name="nip" placeholder="Masukkan NIP anda" autofocus>
        <label for="nip">NIP</label>
        @error('nip')
            <div class="text-danger mt-2">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-5">
        <div class="form-password-toggle">
            <div class="input-group input-group-merge">
                <div class="form-floating form-floating-outline">
                    <input type="password" id="password" class="form-control" name="password" placeholder="Password" />
                    <label for="password">Password</label>
                </div>
                <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line"></i></span>
            </div>
        </div>
        @error('password')
            <div class="text-danger mt-2">{{ $message }}</div>
        @enderror
    </div>
    <!-- Google Recaptcha Widget-->
    <div class="g-recaptcha mt-4 mb-4" data-sitekey="{{config('services.recaptcha.key')}}"></div>
    <div class="mb-5">
        <button class="btn btn-primary d-grid w-100" type="submit">Masuk</button>
    </div>
</form>
          <!-- <p class="text-center">
            <span>New on our platform?</span>
            <a href="{{url('auth/register-basic')}}">
              <span>Create an account</span>
            </a>
          </p> -->

          <!-- <div class="divider my-5">
            <div class="divider-text">or</div>
          </div>

          <div class="d-flex justify-content-center gap-2">
            <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-facebook">
              <i class="tf-icons ri-facebook-fill"></i>
            </a>

            <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-twitter">
              <i class="tf-icons ri-twitter-fill"></i>
            </a>

            <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-github">
              <i class="tf-icons ri-github-fill"></i>
            </a>

            <a href="javascript:;" class="btn btn-icon rounded-circle btn-text-google-plus">
              <i class="tf-icons ri-google-fill"></i>
            </a>
          </div> -->

       
       
               </div>
      </div>
      <!-- /Login -->
      <img alt="mask" src="{{asset('assets/img/illustrations/auth-basic-login-mask-' . $configData['style'] . '.png') }}" class="authentication-image d-none d-lg-block" data-app-light-img="illustrations/auth-basic-login-mask-light.png" data-app-dark-img="illustrations/auth-basic-login-mask-dark.png" />
    </div>
  </div>
</div>
@endsection
