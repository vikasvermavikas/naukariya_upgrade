@extends('layouts.master', ['title' => 'Employer Login'])
@section('content')
    <!-- ================ registration form section start ================= -->
    <section id="registration-form">
        <div class="container py-5">

            <div class="row bg-white m-auto">
                <div class="col-sm-6 bg-light">
                    <img src={{ asset('assets/images/login-img.png') }} class="w-100 p-5">
                </div>

                <div class="col-sm-6">

                    <div class="registration py-5">
                        @if (session()->has('error'))
                            <span class="alert text-danger">{{ session()->get('error') }}</span>
                        @endif
                        <form method="POST" action="{{ route('jobseekerlogin') }}" autocomplete="off">
                            @csrf
                            <div class="d-none">
                                <input type="hidden" name="user_type" value="Employer">
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
                                    <input type="password" autocomplete="new-password" name="password" required>
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
                            <div class="form-row submit-btn">
                                <div class="input-data col">
                                    <div class="inner"></div>
                                    <input type="submit" value="Sign in">
                                </div>
                            </div>
                            <div class="input-data col">
                                <a href="#" class="text-dark text-center">Forgot Password?</a>
                            </div>
                            <div class="text-center">
                                <p>OR</p>
                                <div class='g-sign-in-button'>
                                    <div class=content-wrapper text-center>
                                        <div class='logo-wrapper'>
                                            <img src='https://developers.google.com/identity/images/g-logo.png'>
                                        </div>
                                        <span class='text-container'>
                            
                                            <a href="{{route('sociallogin', ['provider' => 'google', 'userType' => 'Employer'])}}">Sign in with Google</a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>



    </section>
@endsection
