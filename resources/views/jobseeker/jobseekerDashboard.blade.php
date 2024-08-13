@extends('layouts.master', ['title' => 'Jobseeker Dashboard'])
@section('style')
    <style>
        @media (min-width:1025px) {

            /* big landscape tablets, laptops, and desktops */
            .companyfollowing {
                margin-bottom: -16px;
            }
        }
    </style>
@endsection
@section('content')
    <section id="registration-form">
        <div class="container py-5">
            <div class="row my-5">
                <div class="col-sm-9">
                    <h1 class="text-center"><b>DASHBOARD</b></h1>
                    <div class="row mt-5">
                        <div class="col-sm-4 col-md-6 col-lg-3">
                            <a href="{{ route('applyJobList') }}" target="_blank">
                                <div class="box bg-success py-4 text-center mt-3 rounded"><span
                                        class="text-white">{{ $data['applied_jobs'] }}</span>
                                    <hr class="hr1">
                                    <p class="lead"><span class="text-white"> Applied Jobs</span></p>
                                </div>
                            </a>

                        </div>
                        {{-- <div class="col-sm-3">
                            <div class="box bg-primary py-4 text-center mt-3 rounded"><span class="text-white">0</span>
                                <hr class="hr1">
                                <p class="lead"><span class="text-white">Resume Format</span></p>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="box bg-dark py-4 text-center mt-3 rounded"><span
                                    class="text-white">{{ $data['recommended_jobs'] }}</span>
                                <hr class="hr1">
                                <p class="lead"><span class="text-white">Recommended Jobs</span></p>
                            </div>
                        </div> --}}
                        <div class="col-sm-4 col-md-6 col-lg-3">
                            <a href="{{ route('follow_list') }}" target="_blank">
                                <div class="box bg-info py-4 text-center mt-3 rounded"><span class="text-white">
                                        {{ $data['following'] }}</span>
                                    <hr class="hr1">
                                    <p class="lead companyfollowing"><span class="text-white">Companies Following</span></p>
                                </div>
                            </a>

                        </div>
                        <div class="col-sm-4 col-md-6 col-lg-3">
                            <a href="{{ route('get-saved-job') }}" target="_blank">
                                <div class="box bg-success py-4 text-center mt-3 rounded"><span
                                        class="text-white">{{ $data['saved_jobs'] }}</span>
                                    <hr class="hr1">
                                    <p class="lead"><span class="text-white">Saved Jobs</span></p>
                                </div>
                            </a>

                        </div>
                        {{-- <div class="col-sm-3">
                            <div class="box bg-success py-4 text-center mt-3 rounded"><span
                                    class="text-white">{{ $data['recruiterMessages'] }}</span>
                                <hr class="hr1">
                                <p class="lead"><span class="text-white">Recruiter Message</span></p>
                            </div>
                        </div> --}}
                        <div class="col-sm-4 col-md-6 col-lg-3">
                            <a href="{{ route('jobseeker_support_list') }}" target="_blank">
                            <div class="box bg-dark py-4 text-center mt-3 rounded"><span class="text-white"> {{ $data['helpdesk'] }}</span>
                                <hr class="hr1">
                                <p class="lead"><span class="text-white">Helpdesk</span>
                                </p>
                            </div>
                            </a>
                        </div>

                    </div>
                </div>

                {{-- Side profile layout. --}}
                <div class="col-sm-12 col-md-12 col-lg-3 my-3 bg-light">

                    <div class="card">
                        <div class="card-header text-center">
                            @if (Auth::guard('jobseeker')->user()->profile_pic_thumb)
                                <img src={{ asset('jobseeker_profile_image/' . Auth::guard('jobseeker')->user()->profile_pic_thumb . '') }}
                                    class="mini-photo img-fluid rounded-circle" style="width: 50px;">
                            @else
                                <img src={{ asset('assets/images/default-image.png') }}
                                    class="mini-photo rounded-circle avatar" style="width:50px;">
                            @endif
                            <h3 class="mt-2">
                                {{ Auth::guard('jobseeker')->user()->fname . ' ' . Auth::guard('jobseeker')->user()->lname }}
                            </h3>
                        </div>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <div id="profile-percentage">
                                    <div class="corner-div">
                                        <small>Profile Complete - <span id="profilepercentage"></span></small> </br>
                                        <small style="float: right;">Last Modified -
                                            {{ \Carbon\Carbon::parse(Auth::guard('jobseeker')->user()->updated_at)->diffForhumans() }}</small></br>
                                        <div class="progress mb-1 mt-1">
                                            <div class="progress-bar progress-class progress-bar-striped">
                                            </div>
                                        </div>
                                        <small>Complete your profile to get notified by Recruiters</small>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <a href="{{ route('profile-stages') }}" class="text-color"><i
                                        class="fas fa-user-circle"></i> Edit
                                    Profile</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>



    </section>
@endsection
@section('script')
    <script src="{{ asset('assets/js/jobseeker_dashboard.js') }}"></script>
@endsection
