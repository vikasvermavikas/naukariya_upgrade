@extends('layouts.master', ['title' => 'Employer Registeration'])
@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/employer/register.css')}}">
@endsection
@section('content')

    <!-- ================ registration form section start ================= -->
    <section id="registration-form">
        <div class="container py-5">
            <div class="row my-5">
                <div class="registration w-75 bg-white m-auto">
                    <div class="col-md-12 mt-3">
                        @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
    
                        @endif
    
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                        @endif
                    </div>
                    <div class="col-md-12">
                        <h3 style="color:#e35e25;">Employer Registration</h3>
                    </div>
                    <div class="col-md-12">
                        <form action="{{ route('employerregister') }}" method="post" enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            
                            <div class="form-row row mb-5">
                               
                                <div class="input-data col">
                                    <input type="text" name="firstname" value="{{old('firstname')}}">
                                    <div class="underline"></div>
                                    <label for="firstname">First Name</label>
                                    @error('firstname')
                                            <small class="text-danger"> {{$message }}</small>
                                    @enderror
                                </div>
                                <div class="input-data col">
                                    <input type="text" name="lastname" value="{{old('lastname')}}">
                                    <div class="underline"></div>
                                    <label for="lastname">Last Name</label>
                                    @error('lastname')
                                        <small class="text-danger"> {{$message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row row mb-5">
                                <div class="input-data col">
                                    <input type="email" name="email" value="{{old('email')}}">
                                    <div class="underline"></div>
                                    <label for="email">Email Address</label>
                                    @error('email')
                                        <small class="text-danger"> {{$message }}</small>
                                    @enderror
                                </div>
                                <div class="input-data col">
                                    <input type="text" name="mobile" maxlength="10" value="{{old('mobile')}}">
                                    <div class="underline"></div>
                                    <label for="mobile">Contact No.</label>
                                    @error('mobile')
                                        <small class="text-danger"> {{$message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row row mb-5">
                                <div class="input-data col">
                                    <input type="password" name="password" class="pr-3">
                                    <i class="fas fa-solid fa-eye-slash float-right eyeicon"></i>

                                    <div class="underline"></div>
                                    <label for="password">Password</label>
                                    @error('password')
                                        <small class="text-danger"> {{$message }}</small>
                                    @enderror
                                </div>
                                <div class="input-data col">
                                    <input type="password" name="password_confirmation" class="w-75">
                                <i class="fas fa-solid fa-eye-slash float-right eyeicon_confirm"></i>
                                    <div class="underline"></div>
                                    <label for="password_confirmation">Confirm Password</label>
                                    @error('password_confirmation')
                                        <small class="text-danger"> {{$message }}</small>
                                    @enderror
                                </div>
                            </div>
    
                            <div class="form-row row mb-5">
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
                                    <select class="form-select" name="company_id" > <!-- size attribute to show multiple options -->
                                        <option value="">-- Select Companies --</option>
                                        @foreach($companies as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->company_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('company_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
    
    
                            </div>
                            <div class="form-row row mb-5">
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
                    </div>


                    <p class="text-center">You have already account? <a href="{{route('loadLoginPage')}}" class="text-danger">Sign
                            in</a></p>

                </div>

            </div>
        </div>



    </section>
@endsection
@section('script')
<script src="{{asset('assets/js/login.js')}}"></script>
@endsection