@extends('layouts.master', ['title' => 'Jobseeker Login'])
@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/jobseeker_login.css')}}">

@endsection
@section('content')
    <!-- ================ registration form section start ================= -->
    <section id="registration-form">
        <div class="container py-5">

            <div class="row bg-white m-auto">
                <div class="col-sm-6 bg-light">
                    <img src={{ asset('assets/images/login-img.png') }} class="img-fluid">
                </div>

                <div class="col-sm-6">

                    <div class="registration py-5">

                        @if (session()->has('error'))
                            <span class="alert text-danger">{{ session()->get('message') }}</span>
                        @endif

                        <form method="POST" action="{{ route('jobseekerlogin') }}" autocomplete="off">
                            @csrf
                            <div class="d-none">
                                <input type="hidden" name="user_type" value="Jobseeker">
                                @if (isset($_GET['job']))
                                    <input type="hidden" name="jobid" value="{{ $_GET['job'] }}">
                                @endif
                            </div>
                            <div class="form-row row">
                                <div class="input-data">
                                    <input type="email" name="email" value="{{ old('email') }}" required>
                                    <div class="underline"></div>
                                    <label for="">Email</label>
                                </div>
                                @error('email')
                                    <span class="alert text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-row row">
                                <div class="input-data ">
                                    <input type="password" autocomplete="new-password" name="password" class="pr-3" required>
                                    <i class="fas fa-solid fa-eye-slash float-right eyeicon"></i>

                                    <div class="underline"></div>
                                    <label for="">Password</label>
                                </div>

                                @error('password')
                                    <span class="alert text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="g-recaptcha mt-4 ml-3" data-sitekey={{ config('services.recaptcha.key') }}>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row row">
                                <div class="checkbox col">
                                    <input type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label for="">Remember Me</label>
                                </div>


                            </div>
                            <!-- Google Recaptcha -->

                            <div class="form-row submit-btn">
                                <div class="input-data col">
                                    <div class="inner"></div>
                                    <input type="submit" value="Sign in">
                                </div>
                                {{-- <div class="d-grid">
                                    <button class="g-recaptcha btn btn-primary btn-lg "
                                            data-sitekey="{{ config('services.recaptcha_v3.siteKey') }}"
                                            data-callback="onSubmit"
                                            data-action="submitContact">Submit</button>
                                </div> --}}
                            </div>
                             </form>
                            <div class="input-data col">
                                <form action="{{route('fogot-password-form')}}" method="get">
                                    @csrf
                                    <button type="submit" class="btn rounded p-3">Forgot Password?</button>
                                </form>
                                
                            </div>
                            <div class="text-center">
                                <p>OR</p>
                                <div class='g-sign-in-button'>
                                    <a
                                        href="{{ isset($_GET['job']) ? route('sociallogin', ['provider' => 'google', 'userType' => 'Jobseeker', 'jobid' => $_GET['job']]) : route('sociallogin', ['provider' => 'google', 'userType' => 'Jobseeker']) }}">
                                        <div class=content-wrapper text-center>

                                            <div class='logo-wrapper'>
                                                <img src='https://developers.google.com/identity/images/g-logo.png'>
                                            </div>
                                            <span class='text-container'>
                                                Sign
                                                in with Google
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script src="{{ asset('assets/js/login.js') }}"></script>
@endsection
