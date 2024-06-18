@extends('layouts.master', ['title' => 'Job Details'])
@section('content')
    <main>

        <!-- Hero Area Start-->
        <div class="slider-area ">
            <div class="single-slider section-overly slider-height2 d-flex align-items-center"
                data-background="{{ asset('assets/img/hero/about.jpg') }}">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="hero-cap text-center">
                                <h2>UI/UX Designer</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hero Area End -->
        <!-- job post company Start -->
        @php
            $minsalary = 0;
            $exp_required = $data->main_exp . ' Yr - ' . $data->max_exp . ' Yr';
            if ($data->offered_sal_min) {
                $minsalary = $data->offered_sal_min;
            }
            if ($data->main_exp === '0' && $data->max_exp === '0') {
                $exp_required = 'Fresher';
            }

        @endphp
        <div class="job-post-company pt-120 pb-120">
            <div class="container">
                <div class="row justify-content-between">
                    <!-- Left Content -->
                    <div class="col-xl-7 col-lg-8">
                        <!-- job single -->
                        <div class="single-job-items mb-50">
                            <div class="job-items">
                                <div class="company-img company-img-details col-md-12">
                                    <a href="#"><img src="{{ asset('assets/img/icon/job-list1.png') }}"
                                            alt=""></a>
                                    <a href="#">
                                        <h4>{{ $data->title }}</h4>
                                    </a>
                                </div>
                                {{-- <div class="job-tittle">
                                </div> --}}
                                <div class="job-tittle">
                                    <ul>

                                        <li>{{ $data->company_name }}</li>
                                        <li><i
                                                class="fas fa-map-marker-alt"></i>{{ $data->location ? $data->location : 'Not Defined' }}
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- job single End -->

                        <div class="job-post-details">
                            <div class="post-details1 mb-50">

                                {!! $data->description !!}
                            </div>
                            {{-- <div class="post-details2  mb-50">
                                <!-- Small Section Tittle -->
                                <div class="small-section-tittle">
                                    <h4>Required Knowledge, Skills, and Abilities</h4>
                                </div>
                                <ul>
                                    <li>System Software Development</li>
                                    <li>Mobile Applicationin iOS/Android/Tizen or other platform</li>
                                    <li>Research and code , libraries, APIs and frameworks</li>
                                    <li>Strong knowledge on software development life cycle</li>
                                    <li>Strong problem solving and debugging skills</li>
                                </ul>
                            </div>
                            <div class="post-details2  mb-50">
                                <!-- Small Section Tittle -->
                                <div class="small-section-tittle">
                                    <h4>Education + Experience</h4>
                                </div>
                                <ul>
                                    <li>3 or more years of professional design experience</li>
                                    <li>Direct response email experience</li>
                                    <li>Ecommerce website design experience</li>
                                    <li>Familiarity with mobile and web apps preferred</li>
                                    <li>Experience using Invision a plus</li>
                                </ul>
                            </div> --}}
                        </div>

                    </div>
                    <!-- Right Content -->
                    <div class="col-xl-4 col-lg-4">
                        <div class="post-details3  mb-50">
                            <!-- Small Section Tittle -->
                            <div class="small-section-tittle">
                                <h4>Job Overview</h4>
                            </div>
                            <ul>
                                <li>Posted date : <span>{{  $data->start_apply_date }}</span></li>
                                <li>Location : <span>{{ $data->location ? $data->location : 'Not Defined' }}</span></li>
                                <li>Vacancy : <span>{{ $data->job_vaccancy }}</span></li>
                                <li>Job nature : <span>{{ $data->job_type }}</span></li>
                                <li>Salary :
                                    <span>{{ $data->sal_disclosed == 'Yes' ? 'INR ' . $minsalary . ' - ' . $data->offered_sal_max : 'Not Disclosed' }}</span>
                                </li>
                                <li>Job Shift : <span>{{ $data->job_shift }}</span></li>
                            </ul>
                            <div class="apply-btn2">
                                <a href="#" class="btn">Apply Now</a>
                            </div>
                        </div>
                        <div class="post-details4  mb-50">
                            <!-- Small Section Tittle -->
                            <div class="small-section-tittle">
                                <h4>Company Information</h4>
                            </div>
                            <span>{{ $data->company_name }}</span>
                            <p>{{$data->about}}</p>
                            <ul>
                                <li>Name: <span>{{$data->owner_name}} </span></li>
                                <li>Web : <span> {{$data->website}}</span></li>
                                <li>Email: <span>{{$data->com_email}}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- job post company End -->

    </main>
@endsection
