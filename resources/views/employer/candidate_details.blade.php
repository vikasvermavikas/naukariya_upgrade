@extends('layouts.master', ['title' => 'Candidate Details'])
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/subuserInfo.css') }}">
    <style>
        label {
            font-weight: bold;
        }
    </style>
@endsection
@section('content')
    <div class="container mt-50">
        <div class="row">
            <!-- Left-Section -->
            {{-- @php
            echo "<pre>"; 
                print_r($jsInfos);    
            echo "</pre>";  
            die;  
            @endphp --}}
            <div class="col-lg-8 col-md-8 col-sm-12 shadow h-auto border">
                <h3 style="text-align: center;border: 1px solid;margin-top:10px;background-color:#5B6A78; color: white;">
                    Information
                </h3>
                <div class="row mt-20">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <label>Date of Birth</label>
                        <p><span>{{ isset($jsInfos->dob) ? $jsInfos->dob : 'Not Available' }}</span></p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <label style="text-align: center;">Gender</label>
                        <p><span class="capitalize">{{ isset($jsInfos->gender) ? $jsInfos->gender : '' }}</span></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <label>Currently Working Loaction</label>
                        <p><span
                                class="capitalize">{{ isset($jsInfos->current_working_location) ? $jsInfos->current_working_location : 'Not Available' }}</span>
                        </p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <label style="text-align: center;">Preffered Loaction</label>
                        <p><span
                                class="capitalize">{{ isset($jsInfos->preferred_location) ? $jsInfos->preferred_location : 'Not Available' }}</span>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <label>Notice Period</label>
                        <p><span
                                class="capitalize">{{ isset($jsInfos->notice_period) ? $jsInfos->notice_period : 'Not Available' }}</span>
                        </p>
                    </div>
                </div>
                <h3 style="border: 1px solid; text-align: center; background-color: #5B6A78; color: white;">Educational
                    Information</h3>
                <div class="row mt-20" style="padding:0px 13px;">
                    <div class="container table-responsive py-5">
                        <table class="table table-bordered table-hover">
                            <thead class="thead">
                                <tr>
                                    <th scope="col">Year Of Completion</th>
                                    <th scope="col">Qualification</th>
                                    <th scope="col">Degree/Stream Name</th>
                                    <th scope="col">Institute Name</th>
                                    <th scope="col">Institute Loaction</th>
                                    <th scope="col">Percentage/Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($educationalDetails as $eds)
                                    <tr>
                                        <td scope="row">{{ $eds->passing_year }}</td>
                                        <td>{{ $eds->qualification }}</td>
                                        <td>{{ $eds->degree_name }}</td>
                                        <td>{{ $eds->institute_name }}</td>
                                        <td>{{ $eds->institute_location }}</td>
                                        <td>{{ $eds->percentage_grade }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-danger text-center" colspan="6">No Qualification available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
                <h3 style="text-align: center; border: 1px solid;margin-top: 20px;color: white;background-color: #5B6A78;">
                    Professional Information</h3>

                @forelse ($professionDetails as $prfs)
                    <div class="row mt-20">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label>Designation</label>
                            <p><span>{{ $prfs->designations }}</span></p>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label>Company Name</label>
                            <p><span>{{ $prfs->organisation }}</span></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label>Experience (From-To)</label>
                            <p><span>{{ date('M d, Y', strtotime($prfs->from_date)) }} ||
                                    {{ date('M d, Y', strtotime($prfs->to_date)) }} </span></p>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label>Industry</label>
                            <p><span>{{ $prfs->industry_name }}</span></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label>Functional Area</label>
                            <p><span>{{ $prfs->functional_role }}</span></p>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label>Roles and Responsibility</label>
                            <p><span>{{ $prfs->responsibility }}</span></p>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <label>Job Type</label>
                            <p><span>{{ $prfs->job_type }}</span></p>
                        </div>
                    </div>

                @empty
                <div class="row my-3">
                    <div class="col-md-12 d-flex justify-content-center">
                        <span class="text-danger">No Data Available</span>
                    </div>
                </div>
                @endforelse

                <h3 style="border: 1px solid; text-align: center;background-color: #5B6A78; color: white;">Skills</h3>
                <div class="row mb-70 mt-30">
                    @forelse ($skillInfo as $skill)
                        <div class="col-6">
                            <label>{{ $skill->skill }}</label>
                            <div class="progress" style="height: 25px;">
                                @if ($skill->expert_level == 'beginner')
                                    <div class="progress-bar" role="progressbar" style="width: 33%;"
                                        aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">33%</div>
                                @elseif ($skill->expert_level == 'moderate')
                                    <div class="progress-bar" role="progressbar" style="width: 66%;"
                                        aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">66%</div>
                                @elseif ($skill->expert_level == 'expert')
                                    <div class="progress-bar" role="progressbar" style="width: 100%;"
                                        aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">100%</div>
                                @else
                                <div class="progress-bar" role="progressbar" style="width: 1%;"
                                aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">0%</div>
                                @endif

                            </div>
                        </div>
                    @empty
                    <div class="col-md-12 d-flex justify-content-center">
                        <span class="text-danger">No Data Available</span>
                    </div>
                    @endforelse
                </div>

            </div>
            <!-- Right-Section -->
            <div class="col-lg-4 col-md-4 col-sm-12 h-auto">
                <div class="card-wrapper">
                    <div class="row">
                        <div class="col-12 d-flex align-items-center justify-content-center "
                            style="height: 150px; background-color: #2e2963;">
                            {{-- <div class="d-flex justify-content-center align-items-center rounded-circle bg-white"
                                style="width: 8vw; height: 8vw; max-width: 130px; max-height: 130px;">
                                <h5 style="text-align: center; text-wrap: wrap;">No image Available</h5>
                            </div> --}}
                            @if (isset($jsInfos->profile_pic_thumb))
                            <img src="{{asset('jobseeker_profile_image/'.$jsInfos->profile_pic_thumb.'')}}" alt="no-image-available" srcset="" class="rounded-circle img-fluid w-25">
                            @else
                            <img src="{{asset('jobseeker_profile_image/default-image/no_image_available.png')}}" alt="no-image-available" srcset="" class="rounded-circle img-fluid w-25">
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <h5
                                style="margin-top: 20px; border-bottom: 1px solid darkgrey; padding-bottom: 12px; font-weight: bold;">
                                {{isset($jsInfos->fname) ? $jsInfos->fname : '' }} {{isset($jsInfos->lname) ? $jsInfos->lname : '' }}</h5>
                            <p id="designation">{{isset($jsInfos->designation) ? $jsInfos->designation : 'Fresher'}}</p>
                            <p><i class="fas fa-map-marker-alt"></i>  {{isset($jsInfos->address) ? $jsInfos->address : '' }}</p>
                            <p><i class="far fa-envelope"></i>  {{isset($jsInfos->email) ? $jsInfos->email : '' }}</p>
                            <p><i class="fas fa-phone"></i>   {{isset($jsInfos->contact) ? $jsInfos->contact : '' }}</p>
                        </div>
                    </div>
                </div>
                <div class="card-wrapper-2">
                    <div class="dotted-div" style="border: 1px dashed; height:auto; margin-top: 50px;">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <p class="numPdf">{{isset($jsInfos->resume) ? $jsInfos->resume : ''}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <p class="uploadYear">-Uploaded on {{$jsInfos->resume_upload_date}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 d-flex justify-content-center">
                                <a href="{{asset('resume/'.$jsInfos->resume.'')}}" target="_blank"><button class="btn">Download resume <i class="fas fa-download"></i></button></a>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="wrapper-3">
                    <div class="row">
                        <div class="col">
                            <h4>Candidate Video Resume</h4>
                            @if (isset($jsInfos->resume_video_link))
                            <div class="embed-responsive embed-responsive-4by3">
                                    
                                <iframe width="740" height="416" src="{{$jsInfos->resume_video_link}}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                
                            </div>
                            @else
                            <p class="text-danger">No video available</p>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
