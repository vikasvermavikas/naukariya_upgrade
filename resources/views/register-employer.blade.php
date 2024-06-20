@extends('layouts.master', ['title' => 'Register'])
@section('content')

    <!-- ================ registration form section start ================= -->
    <section id="registration-form">
        <div class="container py-5">
            <div class="row my-5">
                <div class="registration w-75 bg-white m-auto">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('employerregister') }}" method="post" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        
                        <div class="form-row row">
                            <div class="input-data col">
                                <input type="text" name="firstname">
                                <div class="underline"></div>
                                <label for="">First Name</label>
                                @error('firstname')
                                        <small class="text-danger"> {{$message }}</small>
                                @enderror
                            </div>
                            <div class="input-data col">
                                <input type="text" name="lastname">
                                <div class="underline"></div>
                                <label for="">Last Name</label>
                                @error('lastname')
                                    <small class="text-danger"> {{$message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row row mt-2">
                            <div class="input-data col">
                                <input type="text" name="email">
                                <div class="underline"></div>
                                <label for="">Email Address</label>
                                @error('email')
                                    <small class="text-danger"> {{$message }}</small>
                                @enderror
                            </div>
                            <div class="input-data col">
                                <input type="text" name="mobile" >
                                <div class="underline"></div>
                                <label for="">Contact No.</label>
                                @error('mobile')
                                    <small class="text-danger"> {{$message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row row">
                            <div class="input-data col">
                                <input type="password" name="password">
                                <div class="underline"></div>
                                <label for="">Password</label>
                                @error('password')
                                    <small class="text-danger"> {{$message }}</small>
                                @enderror
                            </div>
                            <div class="input-data col">
                                <input type="password" name="password_confirmation">
                                <div class="underline"></div>
                                <label for="">Confirm Password</label>
                                @error('password_confirmation')
                                    <small class="text-danger"> {{$message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row row">
                            <div class="input-data col">
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

                            <div class="input-data col">
                                <select class="form-select" name="company_id"> <!-- size attribute to show multiple options -->
                                    <option>-- Select Companies --</option>
                                    @foreach($companies as $key => $value)
                                        <option value="{{ $value->id }}">{{ $value->company_name }}</option>
                                    @endforeach
                                </select>
                                @error('company_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>


                        </div>
                        <div class="form-row row">
                            <input type="hidden" name="user_type" value="Employer">
                            {{-- <div class="input-data col">
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


                    <p class="text-center">You have already account? <a href="#" class="text-danger">Sign
                            in</a></p>

                </div>

            </div>
        </div>



    </section>
@endsection
