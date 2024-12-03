@extends('layouts.master', ['title' => 'Dashboard'])
@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/employer/dashboard.css')}}">
@endsection
@section('content')
    <section id="registration-form">
        <div class="container py-3">
            <div class="d-none">
                <input type="hidden" id="data-total-subusers" value="{{$data['totalSubuser']}}">
                <input type="hidden" id="data-total-jobseekers" value="{{$data['jobseekers']}}">
                <input type="hidden" id="data-total-clients" value="{{$data['totalClient']}}">
                <input type="hidden" id="data-total-followers" value="{{$data['followers']}}">
            </div>
            <div class="row">
                 <div class="col-md-12 ">
                    {{ Breadcrumbs::render('employer_dasboard') }}
                 </div>
                    <div class="col-md-12 my-3" >
                    <h1 class="text-center"><b>Welcome to Your Hiring Hub !</b></h1>
                </div>
                <div class="col-md-9">
                    
                    <div class="row">
                        <div class="col-md-6 card rounded bg-light d-flex justify-content-center text-center align-items-center">
                            <div class="card-body text-center align-items-center d-flex justify-content-center">
                                <div class="d-block">
                                    <!-- <img src={{asset('assets/images/ats.png')}} class="img-fluid" title="ATS" data-toggle="tooltip" /> -->
                                    <a href="{{route('ats_listing')}}">
                                    <img src={{asset('assets/images/ats-icon.png')}} class="img-fluid w-75" title="ATS" data-toggle="tooltip" />
                                </a>
                                  <!-- <p class="lead font-weight-bold">  ATS </p> -->
                                </div>
                               
                            </div>
                        </div>
                         <div class="col-md-6">
                        <canvas id="chart-line" width="299" height="200" class="chartjs-render-monitor" style="display: block; width: 299px; height: 200px;"></canvas>
                        </div>

                        <div class="col-sm-6 col-md-6 col-lg-3 effectclass">
                            <a href="{{ route('managejobs') }}">
                                <div class="box rounded bg-success py-4 text-center mt-3"><span
                                        class="text-white">{{ $data['active_jobs'] }}</span>
                                    <hr class="hr1">
                                    <p class="lead"><span class="text-white"> Active Jobs</span></p>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3 effectclass">
                            <a href="{{ route('postedjobs') }}">
                                <div class="box rounded bg-primary py-4 text-center mt-3"><span
                                        class="text-white">{{ $data['job_posted_by_me'] }}</span>
                                    <hr class="hr1">
                                    <p class="lead"><span class="text-white">Job Posted by Me</span></p>
                                </div>
                            </a>
                        </div>
                        <!-- <div class="col-sm-6 col-md-6 col-lg-3 effectclass">
                            
                            <a href="{{route('ats_listing')}}">
                                <div class="box rounded bg-info text-center mt-3" style="height:91%;padding-top: 39%;">
                                    
                                    <span class="text-white lead">ATS</span>
                                    
                                </div>
                            </a>
                        </div> -->
                        <div class="col-sm-6 col-md-6 col-lg-3 effectclass">
                            <a href="{{ route('interview_list') }}">
                                <div class="box rounded bg-dark py-4 text-center mt-3"><span
                                        class="text-white">{{ $data['scheduled_interview'] }}</span>
                                    <hr class="hr1">
                                    <p class="lead"><span class="text-white">Schedule Interview</span></p>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3 effectclass">
                             <a href="{{route('resume_filter')}}">
                                <div class="box rounded bg-info py-4 text-center mt-3"><span class="text-white">{{$data['jobseekers']}}</span>
                                    <hr class="hr1">
                                    <p class="lead"><span class="text-white">View Resume</span></p>
                                </div>
                            </a>

                           <!--  <div class="box rounded bg-info py-4 text-center mt-3"><span class="text-white">
                                    {{ $data['reports'] }}</span>
                                <hr class="hr1">
                                <p class="lead"><span class="text-white">Reports</span></p>
                            </div> -->
                        </div>
                      <!--   <div class="col-sm-6 col-md-6 col-lg-3 effectclass">
                            <div class="box rounded bg-success py-4 text-center mt-3"><span
                                    class="text-white">{{ $data['package_subscription'] }}</span>
                                <hr class="hr1">
                                <p class="lead"><span class="text-white">Subscriptions</span></p>
                            </div>
                        </div> -->
                        <div class="col-sm-6 col-md-6 col-lg-3 effectclass">
                            <a href="{{ route('employer_followers') }}">
                                <div class="box rounded bg-dark py-4 text-center mt-3"><span
                                        class="text-white">{{ $data['followers'] }}</span>
                                    <hr class="hr1">
                                    <p class="lead"><span class="text-white">Followers</span></p>
                                </div>
                            </a>
                        </div>
                       <!--  <div class="col-sm-6 col-md-6 col-lg-3 effectclass">
                            <a href="{{ route('employer_support_list') }}">
                                <div class="box rounded bg-primary py-4 text-center mt-3"><span
                                        class="text-white">{{ $data['helpdesk'] }}</span>
                                    <hr class="hr1">
                                    <p class="lead"><span class="text-white">Helpdesk</span></p>
                                </div>
                            </a>
                        </div> -->
                        <div class="col-sm-6 col-md-6 col-lg-3 effectclass">
                            <a href="{{ route('tracker-list') }}">
                                <div class="box rounded bg-primary py-4 text-center mt-3"><span
                                        class="text-white">{{ $data['totalTrackercandidate'] }}</span>
                                    <hr class="hr1">
                                    <p class="lead"><span class="text-white">Tracker Candidate</span></p>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3 effectclass">
                            <a href="{{ route('get_subusers') }}">
                                <div class="box rounded bg-dark py-4 text-center mt-3"><span
                                        class="text-white">{{ $data['totalSubuser'] }}</span>
                                    <hr class="hr1">
                                    <p class="lead"><span class="text-white">Sub User</span></p>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3 effectclass">
                            <a href="{{ route('get_clients') }}">
                                <div class="box rounded bg-success py-4 text-center mt-3"><span
                                        class="text-white">{{ $data['totalClient'] }}</span>
                                    <hr class="hr1">
                                    <p class="lead"><span class="text-white">Client</span></p>
                                </div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3 effectclass">
                            <a href="{{ route('get_consolidate_data') }}">
                                <div class="box rounded bg-info py-4 text-center mt-3"><span
                                        class="text-white">{{ isset($data['consolidateData']) ? $data['consolidateData'] : 0 }}</span>
                                    <hr class="hr1">
                                    {{-- <span class="text-white">Consolidate Data</span> --}}
                                    <p class="lead">
                                        <span class="text-white">Consilidate Data</span>
                                    </p>
                                </div>
                            </a>
                        </div>

                    </div>
                </div>

                <div class="col-md-3 bg-light">
                    <div class="user_photo m-auto text-center">
                        {{-- <img src="{{ asset('assets/images/default-image.png') }}"
                            class="img-circle mt-3" style="width: 48px;"> --}}
                        @if (Auth::guard('employer')->user()->profile_pic_thumb)
                            <img src="{{ asset('emp_profile_image/' . Auth::guard('employer')->user()->profile_pic_thumb . '') }}"
                                class="rounded-circle mt-3" style="width: 48px;">
                        @else
                            <img src="{{ asset('assets/images/default-image.png') }}" class="rounded-circle mt-3"
                                style="width: 48px;">
                        @endif
                    </div>
                    <h4 class="text-center mt-3 text-dark">
                        {{ Auth::guard('employer')->check() ? Auth::guard('employer')->user()->fname . ' ' . Auth::guard('employer')->user()->lname : Auth::guard('jobseeker')->user()->fname . ' ' . Auth::guard('jobseeker')->user()->lname }}</span>
                    </h4>
                    <ul class="list-group user_profile">
                        <li class="list-group-item "><a href="{{ route('employer_edit_profile') }}" class="text-color"><i
                                    data-v-624b3b1f="" class="fas fa-user-circle"></i> Edit Profile</a>
                            {{-- <ul>
                                <li class="list-group-item "><a href="#" class="text-color"><i data-v-624b3b1f=""
                                            class="fas fa-chevron-right"></i> Add Personal Details</a></li>
                                <li class="list-group-item "><a href="#" class="text-color"><i data-v-624b3b1f=""
                                            class="fas fa-chevron-right"></i> Add Company Details</a></li>
                            </ul> --}}
                        </li>

                        <li class="list-group-item"><a href="{{ route('employer_view_profile') }}" class="text-color"><i
                                    data-v-624b3b1f="" class="fas fa-user-circle"></i> My Profile</a></li>
                        <li class="list-group-item"><a href="{{ route('employer_organisation') }}" class="text-color"><i
                                    data-v-624b3b1f="" class="fas fa-sitemap"></i> Organization</a></li>
                        {{-- <li class="list-group-item"><a href="#" class="text-color"> <i data-v-624b3b1f=""
                                    class="fas fa-inbox"></i> Inbox</a></li> --}}
                        <li class="list-group-item"><a href="{{ route('employer_change_password') }}"
                                class="text-color"> <i data-v-624b3b1f="" class="fas fa-key"></i> Change Password</a>
                        </li>
                        <li class="list-group-item"><a href="#" id="logout" class="text-color"> <i
                                    data-v-624b3b1f="" class="fas fa-sign-out-alt"></i> Logout</a></li>
                        <form id="logout-form" class="d-none" action="{{ route('jobseekerlogout') }}" method="POST">
                            @csrf
                        </form>
                    </ul>

                </div>


            </div>

            <!-- Subuser section -->
          <!--   <div class="row my-5">
                <div class="col-sm-9">

                    <div class="row">
                        <div class="col-sm-12 mb-4">
                            <h2 class="text-center">SUBUSER DATA</h2>
                        </div>

                        @foreach ($sub_user_data as $key => $value)
                            <div class="col-sm-6 col-md-6 col-lg-3 effectclass">
                                <a href="{{ route('tracker-list') . '?userid=' . $value->id . '' }}">
                                <div class="box rounded bg-info py-4 text-center mt-3 fixedheight" > <span class="text-white"><i
                                            class="fa fa-user"></i> {{ $value->total }}</span>
                                    <hr class="hr1">
                                    <p class="lead">
                                         <span
                                                class="text-white">{{ $value->fname }} {{ $value->lname }}</span>
                                    </p>
                                </div>
                            </a>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div> -->
        </div>
    </section>
@endsection

@section('script')
<script src='{{ asset("assets/js/employer/Chart.bundle.min.js")}}'></script>
<script src="{{ asset('assets/js/employer-dashboard.js') }}"></script>
@endsection
