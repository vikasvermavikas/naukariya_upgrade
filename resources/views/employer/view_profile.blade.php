@extends('layouts.master', ['title' => 'My Profile'])
@section('style')
  <link rel="stylesheet" href="{{asset('assets/css/my_profile.css')}}">
@endsection
@section('content')

    <div class="container-fluid about-section" style="background:#EAEDFF;">
        @php
            $user = Auth::guard('employer')->user();
        @endphp
        <div class="row align-items-center flex-row-reverse">
            <div class="col-md-12">
                    {{ Breadcrumbs::render('employer_my_profile') }}
                 </div>
            <div class="col-md-12">
                <h1 style="color: #E35E25">My Profile</h1>
            </div>
            <div class="col-md-6">
                <div class="about-text go-to">
                    <h3 class="dark-color">Basic Details <a href="{{route('employer_edit_profile')}}" title="Edit" data-toggle="tooltip" data-placement="top"><i class="fas fa-edit small"></i></a> </h3>
                   {{--  <h6 class="theme-color lead">A Lead UX &amp; UI designer based in Canada</h6>
                    <p>I <mark>design and develop</mark> services for customers of all sizes, specializing in
                        creating stylish, modern websites, web services and online stores. My passion is to design
                        digital user experiences through the bold interface and meaningful interactions.</p> --}}
                    <div class="row about-list">
                        <div class="col-6 col-sm-6 col-md-6 my-2 ">
                            <label>Name : </label>
                            <span>{{ $user->fname." ".$user->lname }}</span>
                        </div>
                        <div class="col-6 col-sm-6 col-md-6 my-2 ">
                            <label>Designation : </label>
                            <span>{{ $user->designation }}</span>
                        </div>
                        <div class="col-6 col-sm-6 col-md-6 my-2 ">
                            <label>Birthday : </label>
                            <span>{{ date('d-M-Y', strtotime($user->dob)) }}</span>
                        </div>

                        <div class="col-6 col-sm-6 col-md-6 my-2 ">
                            <label>Age : </label>
                            <span>{{ date('Y') - date('Y', strtotime($user->dob)) }} Yr</span>
                        </div>

                        <div class="col-6 col-sm-6 col-md-6 my-2 ">
                            <label>User Type : </label>
                            <span>{{ ' ' . $user->user_type }}</span>
                        </div>

                        <div class="col-6 col-sm-6 col-md-6 my-2 ">
                            <label>Status : </label>
                            <span>{{ $user->status == 1 ? 'Active' : 'InActive' }}</span>
                        </div>

                        <div class="col-6 col-sm-6 col-md-6 my-2 ">
                            <label>Gender : </label>
                            <span>{{ $user->gender }}</span>
                        </div>
                        <div class="col-6 col-sm-6 col-md-6 my-2 ">
                            <label>Phone : </label>
                            <span>{{ $user->contact }}</span>
                        </div>

                        <div class="col-md-12 my-2 ">
                            <label>E-mail : </label>
                            <span>{{ $user->email }}</span>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-flex justify-content-center">
                <img src="{{ asset('emp_profile_image/' . $user->profile_pic_thumb . '') }}" title="" alt=""
                    class="img-fluid w-50 rounded">
            </div>
        </div>

        <div class="counter">
            <div class="row">
                <div class="col-6 col-md-4">
                    <div class="count-data text-center">
                        <h6 class="count h2" id="countJobs" data-to="500" data-speed="500">{{$total_jobs}}</h6>
                        <p class="m-0px font-w-600">Jobs</p>
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="count-data text-center">
                        <h6 class="count h2" data-to="150" id="countActiveJobs" data-speed="150">{{$active_jobs}}</h6>
                        <p class="m-0px font-w-600">Active Jobs</p>
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="count-data text-center">
                        <h6 class="count h2" data-to="850" id="countFollowers" data-speed="850">{{$followers}}</h6>
                        <p class="m-0px font-w-600">Followers</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

