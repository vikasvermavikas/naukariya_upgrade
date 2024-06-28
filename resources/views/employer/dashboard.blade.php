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
                        <div class="box bg-primary py-4 text-center mt-3"><span class="text-white">{{$data['job_posted_by_me']}}</span>
                            <hr class="hr1"><span class="text-white">Job Posted by Me</span></div>
                    </div>
                    <div class="col-sm-3">
                        <div class="box bg-info py-4 text-center mt-3"><span class="text-white">0</span>
                            <hr class="hr1"><span class="text-white">View Resume</span></div>
                    </div>
                    <div class="col-sm-3">
                        <div class="box bg-dark py-4 text-center mt-3"><span class="text-white">{{  $data['scheduled_interview'] }}</span>
                            <hr class="hr1"><span class="text-white">Schedule Interview</span></div>
                    </div>
                    <div class="col-sm-3">
                        <div class="box bg-info py-4 text-center mt-3"><span class="text-white"> {{  $data['reports'] }}</span>
                            <hr class="hr1"><span class="text-white">Reports</span></div>
                    </div>
                    <div class="col-sm-3">
                        <div class="box bg-success py-4 text-center mt-3"><span class="text-white">{{  $data['package_subscription'] }}</span>
                            <hr class="hr1"><span class="text-white">Subscriptions</span></div>
                    </div>
                    <div class="col-sm-3">
                        <div class="box bg-dark py-4 text-center mt-3"><span class="text-white">{{ $data['followers'] }}</span>
                            <hr class="hr1"><span class="text-white">Followers</span></div>
                    </div>
                    <div class="col-sm-3">
                        <div class="box bg-primary py-4 text-center mt-3"><span class="text-white">{{ $data['helpdesk'] }}</span>
                            <hr class="hr1"><span class="text-white">Helpdesk</span></div>
                    </div>
                    <div class="col-sm-3">
                        <div class="box bg-primary py-4 text-center mt-3"><span class="text-white">{{ $data['totalTrackercandidate'] }}</span>
                            <hr class="hr1"><span class="text-white">Tracker Candidate</span></div>
                    </div>
                    <div class="col-sm-3">
                        <div class="box bg-dark py-4 text-center mt-3"><span class="text-white">{{ $data['totalSubuser'] }}</span>
                            <hr class="hr1"><span class="text-white">Sub User</span></div>
                    </div>
                    <div class="col-sm-3">
                        <div class="box bg-success py-4 text-center mt-3"><span class="text-white">{{ $data['totalClient'] }}</span>
                            <hr class="hr1"><span class="text-white">Client</span></div>
                    </div>
                    <div class="col-sm-3">
                        <div class="box bg-info py-4 text-center mt-3"><span class="text-white">{{ isset($data['consolidateData']) ? $data['consolidateData'] : ''  }}</span>
                            <hr class="hr1"><span class="text-white">Consolidate Data</span></div>
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
        <div class="row my-5">
            <div class="col-sm-9">
                
                <div class="row">
                    <div class="col-sm-12 mb-4">
                        <h2 class="text-center">SUBUSER DATA</h2>
                    </div>

                    @foreach($sub_user_data as $key => $value)
                        <div class="col-sm-3">
                           
                            <div class="box bg-info py-4 text-center mt-3"> <span class="text-white"><i class="fa fa-user"></i> {{ $value->total }}</span>
                                <hr class="hr1">
                                <p class="lead">
                                    <span class="text-white">{{ $value->fname }} {{ $value->lname }}</span>
                                  </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-sm-9">
            </div>
        </div>



    </div>



</section>

@endsection
