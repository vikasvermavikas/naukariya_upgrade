@extends('layouts.master', ['title' => 'Dashboard'])
@section('content')
    <section id="registration-form">
        <div class="container py-5">
            <div class="row my-5">
                <div class="col-sm-9">
                    <h1 class="text-center"><b>DASHBOARD</b></h1>
                    <div class="row mt-5">

                        <div class="col-sm-3">
                            <div class="box rounded bg-success py-4 text-center mt-3"><span
                                    class="text-white">{{ $data['active_jobs'] }}</span>
                                <hr class="hr1"><p class="lead"><span class="text-white"> Active Jobs</span></p>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="box rounded bg-primary py-4 text-center mt-3"><span
                                    class="text-white">{{ $data['job_posted_by_me'] }}</span>
                                <hr class="hr1"><p class="lead"><span class="text-white">Job Posted by Me</span></p>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="box rounded bg-info py-4 text-center mt-3"><span
                                    class="text-white">0</span>
                                <hr class="hr1"><p class="lead"><span class="text-white">View Resume</span></p>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="box rounded bg-dark py-4 text-center mt-3"><span
                                    class="text-white">{{ $data['scheduled_interview'] }}</span>
                                <hr class="hr1"><p class="lead"><span class="text-white">Schedule Interview</span></p>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="box rounded bg-info py-4 text-center mt-3"><span class="text-white">
                                    {{ $data['reports'] }}</span>
                                <hr class="hr1"><p class="lead"><span class="text-white">Reports</span></p>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="box rounded bg-success py-4 text-center mt-3"><span
                                    class="text-white">{{ $data['package_subscription'] }}</span>
                                <hr class="hr1"><p class="lead"><span class="text-white">Subscriptions</span></p>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="box rounded bg-dark py-4 text-center mt-3"><span
                                    class="text-white">{{ $data['followers'] }}</span>
                                <hr class="hr1"><p class="lead"><span class="text-white">Followers</span></p>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="box rounded bg-primary py-4 text-center mt-3"><span
                                    class="text-white">{{ $data['helpdesk'] }}</span>
                                <hr class="hr1"><p class="lead"><span class="text-white">Helpdesk</span></p>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="box rounded bg-primary py-4 text-center mt-3"><span
                                    class="text-white">{{ $data['totalTrackercandidate'] }}</span>
                                <hr class="hr1"><p class="lead"><span class="text-white">Tracker Candidate</span></p>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="box rounded bg-dark py-4 text-center mt-3"><span
                                    class="text-white">{{ $data['totalSubuser'] }}</span>
                                <hr class="hr1"><p class="lead"><span class="text-white">Sub User</span></p>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="box rounded bg-success py-4 text-center mt-3"><span
                                    class="text-white">{{ $data['totalClient'] }}</span>
                                <hr class="hr1"><p class="lead"><span class="text-white">Client</span></p>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="box rounded bg-info py-4 text-center mt-3"><span
                                    class="text-white">{{ isset($data['consolidateData']) ? $data['consolidateData'] : '' }}</span>
                                <hr class="hr1">
                                {{-- <span class="text-white">Consolidate Data</span> --}}
                                <p class="lead">
                                    <span class="text-white">Consilidate Data</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3 bg-light">
                    <div class="user_photo m-auto text-center"><img src="{{ asset('assets/images/default-image.png') }}"
                            class="img-circle mt-3" style="width: 48px;"></div>
                    <h4 class="text-center mt-3 text-dark">
                        {{ Auth::guard('employer')->check() ? Auth::guard('employer')->user()->fname . ' ' . Auth::guard('employer')->user()->lname : Auth::guard('jobseeker')->user()->fname . ' ' . Auth::guard('jobseeker')->user()->lname }}</span>
                    </h4>
                    <ul class="list-group user_profile">
                        <li class="list-group-item "><a href="#" class="text-color"><i data-v-624b3b1f=""
                                    class="fas fa-user-circle"></i> Edit Profile</a>
                            <ul>
                                <li class="list-group-item "><a href="#" class="text-color"><i data-v-624b3b1f=""
                                            class="fas fa-chevron-right"></i> Add Personal Details</a></li>
                                <li class="list-group-item "><a href="#" class="text-color"><i data-v-624b3b1f=""
                                            class="fas fa-chevron-right"></i> Add Company Details</a></li>
                            </ul>
                        </li>

                        <li class="list-group-item"><a href="#" class="text-color"><i data-v-624b3b1f=""
                                    class="fas fa-user-circle"></i> My Profile</a></li>
                        <li class="list-group-item"><a href="#" class="text-color"><i data-v-624b3b1f=""
                                    class="fas fa-sitemap"></i> Organization</a></li>
                        <li class="list-group-item"><a href="#" class="text-color"> <i data-v-624b3b1f=""
                                    class="fas fa-inbox"></i> Inbox</a></li>
                        <li class="list-group-item"><a href="#" class="text-color"> <i data-v-624b3b1f=""
                                    class="fas fa-key"></i> Change Password</a></li>
                        <li class="list-group-item"><a href="#" class="text-color"> <i data-v-624b3b1f=""
                                    class="fas fa-sign-out-alt"></i> Logout</a></li>
                    </ul>

                </div>


            </div>
            <div class="row my-5">
                <div class="col-sm-9">

                    <div class="row">
                        <div class="col-sm-12 mb-4">
                            <h2 class="text-center">SUBUSER DATA</h2>
                        </div>

                        @foreach ($sub_user_data as $key => $value)
                            <div class="col-sm-3">

                                <div class="box rounded bg-info py-4 text-center mt-3"> <span class="text-white"><i
                                            class="fa fa-user"></i> {{ $value->total }}</span>
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