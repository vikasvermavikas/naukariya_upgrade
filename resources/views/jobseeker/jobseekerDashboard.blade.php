@extends('layouts.master', ['title' => 'Jobseeker Dashboard'])
@section('content')
<section id="registration-form">
    <div class="container py-5">
        <div class="row my-5">
            <div class="col-sm-9">
                <h1 class="text-center"><b>DASHBOARD</b></h1>
                <div class="row mt-5">
                    <div class="col-sm-3">
                        <div class="box bg-success py-4 text-center mt-3"><span class="text-white">{{ $data['applied_jobs'] }}</span>
                            <hr class="hr1"><span class="text-white">Applied Jobs</span></div>
                    </div>
                    <div class="col-sm-3">
                        <div class="box bg-primary py-4 text-center mt-3"><span class="text-white">0</span>
                            <hr class="hr1"><span class="text-white">Resume Format</span></div>
                    </div>
                   
                    <div class="col-sm-3">
                        <div class="box bg-dark py-4 text-center mt-3"><span class="text-white">{{  $data['recommended_jobs'] }}</span>
                            <hr class="hr1"><span class="text-white">Recommended Jobs</span></div>
                    </div>
                    <div class="col-sm-3">
                        <div class="box bg-info py-4 text-center mt-3"><span class="text-white"> {{  $data['following'] }}</span>
                            <hr class="hr1"><span class="text-white">Companies Following</span> </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="box bg-success py-4 text-center mt-3"><span class="text-white">{{  $data['saved_jobs'] }}</span>
                            <hr class="hr1"><span class="text-white">Saved Jobs</span></div>
                    </div>
                    <div class="col-sm-3">
                        <div class="box bg-success py-4 text-center mt-3"><span class="text-white">{{  $data['recruiterMessages'] }}</span>
                            <hr class="hr1"><span class="text-white">Recruiter Message</span></div>
                    </div>
                    <div class="col-sm-3">
                        <div class="box bg-dark py-4 text-center mt-3"><span class="text-white"> 0</span>
                            <hr class="hr1"><span class="text-white">Helpdesk</span></div>
                    </div>
                    
                </div>
            </div>

            <div class="col-sm-3 bg-light">
            
                    <div  class="card">
                        <div  class="card-header text-center">
                            <img  src="default_images/no_image_available.png" class="mini-photo rounded-circle avatar">
                             <h3  class="mt-2">{{ Auth::guard('employer')->check() ? Auth::guard('employer')->user()->fname . ' ' . Auth::guard('employer')->user()->lname :  Auth::guard('jobseeker')->user()->fname . ' ' . Auth::guard('jobseeker')->user()->lname}}</span>
                             </h3>
                        </div> 
                        <ul  class="list-group">
                            <li  class="list-group-item">
                                <div   id="profile-percentage">
                                    <div  class="corner-div">
                                        <small >Profile Complete - 36%</small> </br>
                                        <small  style="float: right;">Last Modified - 5 months ago</small></br>
                                        <div  class="progress mb-1 mt-1">
                                            <div  class="progress-bar progress-bar-striped bg-warning" style="width: 36%;">36%</div>
                                        </div> 
                                    <small >Complete your profile to get notified by Recruiters</small>
                                </div>
                            </div>
                            </li>
                             <li  class="list-group-item">
                                <a  href="#/profile-stage" class="text-color"><i  class="fas fa-user-circle"></i> Edit Profile</a>
                            </li>
                        </ul>
                    </div>
            </div>
        </div>
    </div>



</section>

@endsection
