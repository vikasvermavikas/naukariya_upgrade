@extends('layouts.master', ['title' => 'My Profile'])
@section('style')
<link rel="stylesheet" href="{{asset('assets/css/jobseeker/myProfile.css')}}">
@endsection
@section('content')
<div class="container mt-30 mb-40">
    <div class="row h-auto">
        <div class="col-lg-4 col-md-6 col-sm-12 h-auto ">
            <div class="card-wrapper">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <h5
                            style="margin-top:30px; font-weight: bold; text-align: center; border: 1px solid gray; background-color: gray; color: white; padding: 10px 0px;">
                            {{ $alldata->fname." ".$alldata->lname }}
                        </h5>
                        <h3 id="designation" style="border-bottom: 1px solid; margin-top: 40px;">Contacts Details
                        </h3>
                        <div class="row">
                            <div class="col-12">
                                <i class="fas fa-phone" id="icon_phone"></i>
                                <span class="contact_span">{{$alldata->contact}}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mt-10">
                                <i class="fas fa-globe"></i>
                                <span clas="contact_span">{{$alldata->email}}</span>
                            </div>
                        </div>
                        @if ($alldata->linkedin)
                        <div class="row">
                            <div class="col-12 mt-10">
                                <i class="fab fa-linkedin-in"></i>
                                <span class="contact_span">{{$alldata->linkedin}}</span>
                            </div>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-12 mt-10">
                                <i class="fas fa-birthday-cake"></i>
                                <span class="contact_span">{{$alldata->dob}}</span>
                            </div>
                        </div>

                        <h3 id="Job details" style="border-bottom: 1px solid; margin-top: 30px;">Job Details</h3>
                        <div class="row">
                            <div class="col-12">
                                <label style="font-weight: bold;">Experience :</label>
                                <span>{{ $alldata->exp_year }} Yr-{{
                                    $alldata->exp_month
                                  }}
                                  Month</span>
                            </div>
                        </div>
                        @if ($alldata->current_salary)
                        
                        <div class="row">
                            <div class="col-12">
                                <label style="font-weight: bold;">Current Salary :</label>
                                <span>{{$alldata->current_salary}} LPA</span>
                            </div>
                        </div>
                        @endif
                        @if ($alldata->expected_salary)
                        
                        <div class="row">
                            <div class="col-12">
                                <label style="font-weight: bold;">Expected Salary :</label>
                                <span>{{$alldata->expected_salary}} LPA</span>
                            </div>
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-12">
                                <label style="font-weight: bold;">Preferred-loaction :</label>
                                <span>{{$alldata->preferred_location}}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label style="font-weight: bold;">Notice-period :</label>
                                <span>{{$alldata->notice_period}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Right container -->
        <div class="col-lg-8 col-md-6 col-sm-12 h-auto" id="right-container">
            <h3 style="font-weight: bold; text-align: end;  color: black; padding: 10px 0px;">
                {{ $alldata->fname." ".$alldata->lname }}
            </h3>
            <div class="row mt-30">
                {{-- <div class="col-lg-3 col-md-12 col-sm-6" id="print-btn-div">
                    <button type="button" class="btn btn-primary" id="print-resume">Print Resume <i
                            class="fas fa-print"></i> </button>
                </div> --}}
                <div class="col-lg-3 col-md-12 col-sm-6" id="download-btn-div">
                    <a href="{{asset('/resume/'. $alldata->resume)}}" target="_blank" class="btn" id="download-resume">Download
                        resume <i class="fas fa-cloud-download-alt"></i></a>
                </div>
            </div>
            <div class="row mt-30">
                <div class="col-12 border-bottom">
                    <i class="fas fa-briefcase"></i>
                    <label>Work Experience</label>
                </div>
                <div class="col-7">
                    <p> Front End Developer</p>
                    <span>Yahoo</span>
                </div>
                <div class="col-5">
                    <p style="color: black;">Currently Working since 2024-08-01</p>
                </div>
            </div>
            <!-- Certificate -->
            <div class="row mt-30">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 border-bottom">
                            <i class="fas fa-certificate"></i>
                            <label id="education">Certificates</label>
                        </div>
                    </div>
                    <div class="container table-responsive mt-15">
                        <table class="table table-bordered table-hover">
                            <thead class="thead">
                                <tr>
                                    <th scope="col">Duration</th>
                                    <th scope="col">Certificate Name</th>
                                    <th scope="col">Certified By</th>
                                    <th scope="col">Mode</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">2024-03 to 2024-06</th>
                                    <td>Hindi</td>
                                    <td>Hindu University</td>
                                    <td>Offline</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <div class="row mt-30">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 border-bottom">
                             <i class="fas fa-graduation-cap"></i>
                            <label id="education">Education</label>
                        </div>
                    </div>
                    <div class="container table-responsive mt-15">
                        <table class="table table-bordered table-hover">
                            <thead class="thead">
                                <tr>
                                    <th scope="col">Year Of Completion</th>
                                    <th scope="col">Qualification</th>
                                    <th scope="col">Institute Name</th>
                                    <th scope="col">Education Mode</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">2021</th>
                                    <td>B.Tech</td>
                                    <td>YMCA University</td>
                                    <td>Offline</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="row mt-20">
                <div class="col-12 border-bottom ">
                    <i class="fas fa-cog"></i>
                    <label id="skills">Skills</label>
                </div>
                <div class="col-12 d-flex  align-items-center ">
                    <span class="circle">Php</span>
                    <span class="circle">Javsssssssssssssssssss</span>
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection