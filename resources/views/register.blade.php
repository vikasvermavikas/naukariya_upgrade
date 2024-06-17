@extends('layouts.master', ['title' => 'Register'])
@section('content')
    <!-- ================ registration form section start ================= -->
    <section id="registration-form">
        <div class="container py-5">
            <div class="row my-5">
                <div class="registration w-75 bg-white m-auto">
                    <form action="#">
                        <div class="form-row row">
                            <div class="input-data col">
                                <input type="text" required>
                                <div class="underline"></div>
                                <label for="">First Name</label>
                            </div>
                            <div class="input-data col">
                                <input type="text" required>
                                <div class="underline"></div>
                                <label for="">Last Name</label>
                            </div>
                        </div>
                        <div class="form-row row">
                            <div class="input-data col">
                                <input type="text" required>
                                <div class="underline"></div>
                                <label for="">Email Address</label>
                            </div>
                            <div class="input-data col">
                                <input type="text" required>
                                <div class="underline"></div>
                                <label for="">Contact No.</label>
                            </div>
                        </div>
                        <div class="form-row row">
                            <div class="input-data col">
                                <input type="password" required>
                                <div class="underline"></div>
                                <label for="">Password</label>
                            </div>
                            <div class="input-data col">
                                <input type="password" required>
                                <div class="underline"></div>
                                <label for="">Confirm Password</label>
                            </div>
                        </div>

                        <div class="form-row row">
                            <div class="input-data col">
                                <select class="form-select" required>
                                    <option>Gender</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                    <option>Other</option>
                                </select>

                            </div>

                            <div class="input-data col">
                                <select class="form-select" required>
                                    <option>I am a</option>
                                    <option>Fresher</option>
                                    <option>Experience</option>
                                </select>
                            </div>


                        </div>
                        <div class="form-row row">
                            <div class="input-data col">
                                <input type="file" required>
                                <div class="underline"></div>
                                <label for=""></label>
                            </div>
                            <div class="input-data col">
                                <input type="text" required>
                                <div class="underline"></div>
                                <label for="">Enter Captcha</label>
                            </div>
                        </div>
                        <div class="form-row submit-btn">
                            <div class="input-data">
                                <div class="inner"></div>
                                <input type="submit" value="submit">
                            </div>
                        </div>
                    </form>


                    <p class="text-center">You have already account? <a href="#" class="text-danger">Sign
                            in</a></p>

                </div>

            </div>
        </div>



    </section>
@endsection
