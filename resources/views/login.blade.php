@extends('layouts.master', ['title' => 'Login'])
@section('content')
    <!-- ================ registration form section start ================= -->
    <section id="registration-form">
        <div class="container py-5">

            <div class="row bg-white m-auto">
                <div class="col-sm-6 bg-light">
                    <img src={{asset('assets/images/login-img.png')}} class="w-100 p-5">
                </div>

                <div class="col-sm-6">

                    <div class="registration py-5">
                        <form action="#">
                            <div class="form-row row">
                                <div class="input-data">
                                    <input type="text" required>
                                    <div class="underline"></div>
                                    <label for="">User Name</label>
                                </div>
                            </div>
                            <div class="form-row row">
                                <div class="input-data">
                                    <input type="text" required>
                                    <div class="underline"></div>
                                    <label for="">Password</label>
                                </div>

                            </div>

                            <div class="form-row row">
                                <div class="checkbox col">
                                    <input type="checkbox" required>
                                    <label for="">Remember Me</label>
                                </div>

                                <div class="input-data col">
                                    <a href="#">Forgot Password?</a>
                                </div>
                            </div>
                            <div class="form-row submit-btn">
                                <div class="input-data col">
                                    <div class="inner"></div>
                                    <input type="submit" value="Sign in">
                                </div>
                            </div>
                            <div class="text-center">
                                <p>OR</p>
                                <div class='g-sign-in-button'>
                                    <div class=content-wrapper text-center>
                                        <div class='logo-wrapper'>
                                            <img src='https://developers.google.com/identity/images/g-logo.png'>
                                        </div>
                                        <span class='text-container'>
                                            <span>Sign in with Google</span>
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
