@extends('layouts.master', ['title' => 'Blog Page'])
@section('content')
<section id="registration-form">
    <div class="container py-5">
        <div class="row my-5">
            <div class="col-sm-9">
                <h1 class="text-center"><b>DASHBOARD</b></h1>
                <div class="row mt-5">
                    <div class="col-sm-3">
                        <div class="box bg-success py-4 text-center mt-3">{{ $data['active_jobs'] }}
                            <hr class="hr1"> Active Jobs</div>
                    </div>
                    <div class="col-sm-3">
                        <div class="box bg-primary py-4 text-center mt-3">{{$data['job_posted_by_me']}}
                            <hr class="hr1">Job Posted by Me</div>
                    </div>
                    <div class="col-sm-3">
                        <div class="box bg-info py-4 text-center mt-3">0
                            <hr class="hr1">View Resume</div>
                    </div>
                    <div class="col-sm-3">
                        <div class="box bg-dark py-4 text-center mt-3">{{  $data['scheduled_interview'] }}
                            <hr class="hr1">Schedule Interview</div>
                    </div>
                    <div class="col-sm-3">
                        <div class="box bg-info py-4 text-center mt-3"> {{  $data['reports'] }}
                            <hr class="hr1"> Reports</div>
                    </div>
                    <div class="col-sm-3">
                        <div class="box bg-success py-4 text-center mt-3">{{  $data['package_subscription'] }}
                            <hr class="hr1">Subscriptions</div>
                    </div>
                    <div class="col-sm-3">
                        <div class="box bg-dark py-4 text-center mt-3"> {{ $data['followers'] }}
                            <hr class="hr1">Followers</div>
                    </div>
                    <div class="col-sm-3">
                        <div class="box bg-primary py-4 text-center mt-3">{{ $data['helpdesk'] }}
                            <hr class="hr1">Helpdesk</div>
                    </div>
                    <div class="col-sm-3">
                        <div class="box bg-primary py-4 text-center mt-3">  {{ $data['totalTrackercandidate'] }}
                            <hr class="hr1"> Tracker Candidate</div>
                    </div>
                    <div class="col-sm-3">
                        <div class="box bg-dark py-4 text-center mt-3"> {{ $data['totalSubuser'] }}
                            <hr class="hr1">Sub User</div>
                    </div>
                    <div class="col-sm-3">
                        <div class="box bg-success py-4 text-center mt-3"> {{ $data['totalClient'] }}
                            <hr class="hr1">Client</div>
                    </div>
                    <div class="col-sm-3">
                        <div class="box bg-info py-4 text-center mt-3"> {{ $data['consolidateData'] }}
                            <hr class="hr1">Consolidate Data</div>
                    </div>
                </div>
            </div>

            <div class="col-sm-3 bg-light">
                <div class="user_photo m-auto text-center"><img src="{{ asset('assets/images/naukriyan-logo.png') }}" class="img-circle mt-3"></div>
                <h4 class="text-center font-weight-bold mt-3 text-dark">{{ Auth::guard('employer')->check() ? Auth::guard('employer')->user()->fname . ' ' . Auth::guard('employer')->user()->lname :  Auth::guard('jobseeker')->user()->fname . ' ' . Auth::guard('jobseeker')->user()->lname}}</span></h4>
                <ul class="list-group user_profile">
                    <li class="list-group-item "><a href="#" class="text-color"><i data-v-624b3b1f="" class="fas fa-user-circle"></i> Edit Profile</a>
                        <ul>
                            <li class="list-group-item "><a href="#" class="text-color"><i data-v-624b3b1f="" class="fas fa-chevron-right"></i> Add Personal Details</a></li>
                            <li class="list-group-item "><a href="#" class="text-color"><i data-v-624b3b1f="" class="fas fa-chevron-right"></i> Add Company Details</a></li>        
                        </ul>
                    </li>
                    
                    <li class="list-group-item"><a href="#" class="text-color"><i data-v-624b3b1f="" class="fas fa-user-circle"></i> My Profile</a></li>
                    <li class="list-group-item"><a href="#" class="text-color"><i data-v-624b3b1f="" class="fas fa-sitemap"></i> Organization</a></li>
                    <li class="list-group-item"><a href="#" class="text-color"> <i data-v-624b3b1f="" class="fas fa-inbox"></i> Inbox</a></li>
                    <li class="list-group-item"><a href="#" class="text-color"> <i data-v-624b3b1f="" class="fas fa-key"></i> Change Password</a></li>
                    <li class="list-group-item"><a href="#" class="text-color"> <i data-v-624b3b1f="" class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>

            </div>


        </div>


    </div>



</section>

@endsection
