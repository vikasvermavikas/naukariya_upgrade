@extends('layouts.master', ['title' => 'Sub User Login'])
@section('style')
    <style>
        #rc-anchor-container {
            max-width: 100%;
            widows: 70%;
        }
    </style>
@endsection
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
                        <form method="POST" action="{{ route('subuser-login') }}" autocomplete="off">
                            @csrf

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

                            <!-- Google Recaptcha -->

                            <div class="form-row submit-btn">
                                <div class="input-data col">
                                    <div class="inner"></div>
                                    <input type="submit" value="Sign in">
                                </div>

                            </div>
                            <div class="input-data col">
                                <a href="#" class="text-dark justify-content-center">Forgot Password?</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
