@extends('layouts.master', ['title' => 'My Profile'])
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/jobseeker/myProfile.css') }}">
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
                                {{ $alldata->fname . ' ' . $alldata->lname }}
                            </h5>
                            <h3 id="designation" style="border-bottom: 1px solid; margin-top: 40px;">Contacts Details
                            </h3>
                            <div class="row">
                                <div class="col-12">
                                    <i class="fas fa-phone" id="icon_phone"></i>
                                    <span class="contact_span">{{ $alldata->contact }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mt-10">
                                    <i class="fas fa-globe"></i>
                                    <span clas="contact_span">{{ $alldata->email }}</span>
                                </div>
                            </div>
                            @if ($alldata->linkedin)
                                <div class="row">
                                    <div class="col-12 mt-10">
                                        <i class="fab fa-linkedin-in"></i>
                                        <span class="contact_span">{{ $alldata->linkedin }}</span>
                                    </div>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-12 mt-10">
                                    <i class="fas fa-birthday-cake"></i>
                                    <span class="contact_span">{{ $alldata->dob }}</span>
                                </div>
                            </div>

                            <h3 id="Job details" style="border-bottom: 1px solid; margin-top: 30px;">Job Details</h3>
                            <div class="row">
                                <div class="col-12">
                                    <label style="font-weight: bold;">Experience :</label>
                                    <span>{{ $alldata->exp_year }} Yr-{{ $alldata->exp_month }}
                                        Month</span>
                                </div>
                            </div>
                            @if ($alldata->current_salary)
                                <div class="row">
                                    <div class="col-12">
                                        <label style="font-weight: bold;">Current Salary :</label>
                                        <span>{{ $alldata->current_salary }} LPA</span>
                                    </div>
                                </div>
                            @endif
                            @if ($alldata->expected_salary)
                                <div class="row">
                                    <div class="col-12">
                                        <label style="font-weight: bold;">Expected Salary :</label>
                                        <span>{{ $alldata->expected_salary }} LPA</span>
                                    </div>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-12">
                                    <label style="font-weight: bold;">Preferred-loaction :</label>
                                    <span>{{ $alldata->preferred_location }}</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <label style="font-weight: bold;">Notice-period :</label>
                                    <span>{{ $alldata->notice_period }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Right container -->
            <div class="col-lg-8 col-md-6 col-sm-12 h-auto" id="right-container">
                <h3 style="font-weight: bold; text-align: end;  color: black; padding: 10px 0px;">
                    {{ $alldata->fname . ' ' . $alldata->lname }}
                </h3>
                <div class="row mt-30">
                    {{-- <div class="col-lg-3 col-md-12 col-sm-6" id="print-btn-div">
                    <button type="button" class="btn btn-primary" id="print-resume">Print Resume <i
                            class="fas fa-print"></i> </button>
                </div> --}}
                    <div class="col-lg-3 col-md-12 col-sm-6" id="download-btn-div">
                        <a href="{{ asset('/resume/' . $alldata->resume) }}" target="_blank" class="btn"
                            id="download-resume">Download
                            resume <i class="fas fa-cloud-download-alt"></i></a>
                    </div>
                </div>

                @if (count($professionalDetails) > 0)
                    <div class="row mt-30">
                        <div class="col-12 border-bottom">
                            <i class="fas fa-briefcase"></i>
                            <label>Work Experience</label>
                        </div>
                        @foreach ($professionalDetails as $professional)
                            <div class="col-7">
                                <p>{{ $professional->designations }} <br>
                                    <span><i class="fas fa-building" title="organisation" data-toggle="tooltip"
                                            aria-hidden="true"></i> {{ $professional->organisation }}</span>
                                </p>

                            </div>
                            <div class="col-5">
                                <p style="color: black;">
                                    @if ($professional->currently_work_here != 1)
                                        {{ $professional->from_date }} to
                                        {{ $professional->to_date }}
                                    @else
                                        Currently Working since {{ $professional->from_date }}
                                    @endif

                                </p>
                            </div>
                        @endforeach

                    </div>
                @endif

                <!-- Certificate -->
                <div class="row mt-30 d-none certificates-details">
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
                                <tbody id="certificatesDetails">
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <div class="row mt-30 d-none educationDetails">
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
                                <tbody id="education-data">
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <div class="row mt-20 skillsDetails d-none">
                    <div class="col-12 border-bottom ">
                        <i class="fas fa-cog"></i>
                        <label id="skills">Skills</label>
                    </div>
                    <div class="col-12 d-flex  align-items-center skill-details">
                        <span class="circle">Php</span>
                        <span class="circle">Javsssssssssssssssssss</span>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/js/jobseeker_myProfile.js') }}"></script>
@endsection
