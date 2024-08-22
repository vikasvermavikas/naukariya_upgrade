@extends('layouts.master', ['title' => 'Register'])
@section('style')
<style>
    .eyeicon{
        margin-top: -25px;
    }
   
      input::-ms-reveal,
      input::-ms-clear {
        display: none;
      }
</style>
@endsection
@section('content')
    <!-- ================ registration form section start ================= -->
    <section id="registration-form">
        <div class="container py-5">
            <div class="row my-5">
                <div class="registration w-75 bg-white m-auto">
                    <form action="{{ route('jobseekerregister') }}" method="post" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        
                        <div class="col-md-12">
                            <h3 style="color:#e35e25;">Jobseeker Registration</h3>
                        </div>
                        <div class="form-row row">
                            <div class="input-data col mt-3">
                                <input type="text" name="firstname">
                                <div class="underline"></div>
                                <label for="">First Name</label>
                                @error('firstname')
                                        <small class="text-danger"> {{$message }}</small>
                                @enderror
                            </div>
                            <div class="input-data col mt-3">
                                <input type="text" name="lastname">
                                <div class="underline"></div>
                                <label for="">Last Name</label>
                                @error('lastname')
                                    <small class="text-danger"> {{$message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row row mt-5">
                            <div class="input-data col mt-3">
                                <input type="text" name="email">
                                <div class="underline"></div>
                                <label for="">Email Address</label>
                                @error('email')
                                    <small class="text-danger"> {{$message }}</small>
                                @enderror
                            </div>
                            <div class="input-data col mt-3">
                                <input type="text" name="mobile" maxlength="10" pattern="[789][0-9]{9}" oninvalid="this.setCustomValidity('Invalid Contact Number.')" oninput="this.setCustomValidity('')">
                                <div class="underline"></div>
                                <label for="">Contact No.</label>
                                @error('mobile')
                                    <small class="text-danger"> {{$message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row row  mt-sm-5">
                            <div class="input-data col mt-3">
                                <input type="password" name="password">
                                <div class="underline"></div>
                                <label for="">Password</label>
                                @error('password')
                                    <small class="text-danger"> {{$message }}</small>
                                @enderror
                            </div>
                            <div class="input-data col mt-3">
                                <input type="password" name="password_confirmation">
                                <i class="fas fa-solid fa-eye-slash float-right eyeicon"></i>

                                <div class="underline"></div>
                                <label for="">Confirm Password</label>
                                @error('password_confirmation')
                                    <small class="text-danger"> {{$message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row row">
                            <div class="input-data col mt-3">
                                <select class="form-select" name="gender" required>
                                    <option>Gender</option>
                                    <option>Male</option>
                                    <option>Female</option>
                                    <option>Other</option>
                                </select>
                                @error('gender')
                                    <small class="text-danger"> {{$message }}</small>
                                @enderror
                            </div>

                            <div class="input-data col mt-3">
                                <select class="form-select" name="candidate_type">
                                    <option>I am a</option>
                                    <option>Fresher</option>
                                    <option>Experience</option>
                                </select>
                                @error('candidate_type')
                                    <small class="text-danger"> {{$message }}</small>
                                @enderror
                            </div>


                        </div>
                        <div class="form-row row">
                            <div class="input-data col mt-3">
                                <input type="file"  name="resume" accept=".docx,.pdf">
                                <div class="underline"></div>
                                <label for="resume" class="my-3">Resume</label>
                                @error('resume')
                                    <small class="text-danger"> {{$message }}</small>
                                @enderror
                            </div>
                            {{-- <div class="input-data col mt-3">
                                <input type="text" required>
                                <div class="underline"></div>
                                <label for="">Enter Captcha</label>
                            </div> --}}
                        </div>
                        <div class="form-row submit-btn">
                            <div class="input-data">
                                <div class="inner"></div>
                                <input type="submit" value="submit">
                            </div>
                        </div>
                    </form>


                    <p class="text-center">You have already account? <a href="{{route('login')}}" class="text-danger">Sign
                            in</a></p>

                </div>

            </div>
        </div>



    </section>
@endsection
@section('script')
<script src="{{asset('assets/js/register.js')}}"></script>
@endsection