@extends('layouts.master', ['title' => 'My Profile'])
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/subuser/subUserProfile.css') }}" />
    <style>
        label{
            color : #e35e25;
            font-weight: bold;
        }
    </style>
@endsection
@section('content')
    <div class="container my-5">
        <div class="row">
             <div class="col-md-12 mb-5">
                    {{ Breadcrumbs::render('subuser_myprofile') }}
                 </div>
            <div class="col-md-12">
                @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{session()->get('message')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @endif
                @if (session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{session()->get('message')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @endif
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 h-auto">

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <p class="personal" id="personal-pera">PERSONAL</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <p class="chnagePas" id="change-pas">CHANGE PASSWORD</p>
                    </div>
                </div>
                <form id="myform-left" class="form imageform" >
                    @csrf
                    <div class="row " style="padding: 0px 80px">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            @if (isset($user->profile_image))
                                <img src="{{asset('subuser_profile_image/'.$user->profile_image.'')}}" class="img-fluid rounded border" id="imgPreview" alt="no-image-found">
                                @else
                                <img src="{{ asset('subuser_profile_image/default_image.png') }}" width="30%"
                                    class="profile-img" id="imgPreview" accept="jpg,jpeg,png" class="img-fluid" alt="pic"/>
                            @endif

                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-auto">
                            <button type="button" class="btn" id="upload-btn">Upload Photo</button>
                        </div>
                        <div class="col-md-12">
                            <span id="error-image" class="text-danger small"></span>
                        </div>
                    </div>
                </form>
            </div>

          
            <!-- Right-Section -->
            <div class="col-lg-8 col-md-6 col-sm-12  h-auto">
                <form method="POST" action="{{route('update-subuser')}}" id="form-right" class="form">
                    @csrf
                    <div class="row">
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <label>First Name</label>
                            <input type="text" placeholder="Enter your Name" name="fname" value="{{$user->fname}}" required>
                            @error('fname')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <label>Last Name</label>
                            <input type="text" placeholder="Enter Last Name" name="lname" value="{{$user->lname}}" required>
                            @error('lname')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <label>Email</label>
                            <input type="email" placeholder="Enter your Email" name="email" value="{{$user->email}}" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <label>Contact No</label>
                            <input type="text" maxlength="10" minlength="10" pattern="[789][0-9]{9}" placeholder="Enter your Contact No."
                                name="contact" value="{{$user->contact}}" required>
                                @error('contact')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <label>Current Designation</label>
                            <input type="text" placeholder="Enter Current Designation" name="designation" value="{{$user->designation}}" required>
                            @error('designation')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <label>Gender</label>
                            <select name="gender" required>
                                <option value="">Select Gender...</option>
                                <option value="Male" {{$user->gender == 'Male' ? 'selected' : ''}}>Male</option>
                                <option value="Female" {{$user->gender == 'Female' ? 'selected' : ''}}>Female</option>
                                <option value="Other" {{$user->gender == 'Other' ? 'selected' : ''}}>Others</option>
                            </select>
                            @error('gender')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-center">
                                <button type="submit" class="btn" id="right-update-btn">Update</button>
                                <!-- <input type="file" placeholder="Update"/> -->
                            </div>
                        
                    </div>

                </form>

                <form id="form-fieldSet2" action="{{route('update-subuser-password')}}" class="form" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <label>New Password</label>
                            <input type="password" placeholder="Enter New Password" name="password" required>
                            @error('password')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <label>Confirm New Password</label>
                            <input type="password" placeholder="Enter Confirm Password" name="password_confirmation" required>
                            @error('password_confirmation')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-center">
                            <button type="submit" class="btn" id="second-forn-btn">Change Password</button>
                        </div>
                    </div>
                   
                    
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/js/subuser/subUserProfile.js') }}" type="text/javascript"></script>
@endsection
