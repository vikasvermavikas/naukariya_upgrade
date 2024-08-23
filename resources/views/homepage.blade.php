@extends('layouts.master', ['title' => 'Home Page'])
@section('style')
    <style>
        .nav-link.active {
            background-color: #e35e25;
            color: white !important;
        }

        .nav-link.active:hover {
            color: white !important;
        }

        .nav-link.active:not(:hover) {
            color: white !important;
        }

        .select2-selection__arrow {
            top: 22px !important;
        }

        .select2-container--default .select2-selection--single {
            /* height: 100%; */
            border: none;
            margin-top: 20px;
        }
        .leftradius{
            border-top-left-radius: 2.25rem !important;
            border-bottom-left-radius: 2.25rem !important;
        }
        .rightradius {
            border-top-right-radius: 2.25rem !important;
            border-bottom-right-radius: 2.25rem !important;
        }
        .select2-container {
            /* width: 100%; */
            height: 100%;
            background: white;
        }

        /* For mobile */
        @media only screen and (min-width: 368px) and (max-width: 768px) {
            .select2-container {
                width: 100% !important;
                padding: 0px 0px 15px 0px;
                height: 60px;
                border-top-right-radius: 2.25em !important;
                border-bottom-right-radius: 2.25em !important;
                border-top-left-radius: 2.25em !important;
                border-bottom-left-radius: 2.25em !important;
                box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
            }
            .border-right{
                border-right: none !important;
            }
            .skillradius{
                border-top-right-radius: 2.25em !important;
                border-bottom-right-radius: 2.25em !important;
                box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
            }
            .experienceborder{
                border-top-right-radius: 2.25em !important;
                border-bottom-right-radius: 2.25em !important;
                border-top-left-radius: 2.25em !important;
                border-bottom-left-radius: 2.25em !important;
                box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
            }
         
            #search_jobs{
                border-top-left-radius: 2.25em !important;
                border-bottom-left-radius: 2.25em !important;
            }
            .findjob{
                display: flex;
                justify-content: center;
            }
            span.selection {
                display: inline-block;
                width: 44%;
                margin-left: 1%;
            }
        }
        
        @media only screen and (min-width: 768px){
            #searchkeyword {
            padding-left: 18%;

        }
        }

        .dropdown-menu.show {
            overflow: auto;
            max-height: 200px;

        }

        .image-class {
            width: 114px;
            /* height: 62px; */
            border: 1px solid black;
        }

        #searchkeyword {
            height: 64px;
        }

        #experienced_level {
            height: 64px;
            border: none;
        }

        #search_jobs {
            padding: 32px 44px
        }

        .dropdown-menu.show {
            width: auto !important;
        }

        #searchkeyword,
        #experienced_level,
        #location,
        #search_jobs {
            /* width: 115%; */

        }

        .header-area .main-menu ul li {
            z-index: auto;
        }
    </style>
@endsection
@section('content')
    <main>
        <!-- slider Area Start-->
        <div class="slider-area ">
            <div class="container">

                <div class="row">
                    @if (session()->has('message'))
                        <div class="alert alert-success alert-dismissible fade show w-100" role="alert">
                            {{ session()->get('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
            <!-- Mobile Menu -->
            <div class="slider-active">
                <div class="single-slider slider-height d-flex align-items-center"
                    style="background-image: url({{ asset('assets/img/hero/h1_hero.jpg') }}); background-size: 100% 100%;">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-6 col-lg-9 col-md-10">
                                <div class="hero__caption">
                                    <h1>Discover Jobs That Inspire Across the Nation</h1>
                                </div>
                            </div>
                        </div>
                        <!-- Search Box -->
                        <div class="row">
                            <div class="col-xl-10">
                                <!-- form -->
                                <form action="{{ route('loadJoblistPage') }}" method="GET" class="shadow-none">
                                    {{-- <div class="form-group">
                                        <label for="input-datalist">Timezone</label>
                                        <input type="text" class="form-control" placeholder="Timezone" list="list-timezone" id="input-datalist">
                                    </div> --}}
                                    <div class="row no-gutters">
                                        <div class="col-md-3 my-2 border-right">
                                            {{-- <div class=""> --}}
                                            <input type="text" class="border-0 form-control leftradius skillradius" name="searchkeyword"
                                                id="searchkeyword" placeholder="Job Tittle or skills"
                                                data-prefetch="{{ route('getskillsoptions') }}" title="Skills"
                                                data-toggle="tooltip" required>
                                            {{-- </div> --}}
                                        </div>
                                        <div class="col-md-3 my-2 border-right">
                                            <Select class="form-control experienceborder" title="Experience Level"
                                                data-toggle="tooltip" name="experienced_level" id="experienced_level">
                                                <option value="experienced" selected>Experienced</option>
                                                <option value="fresher">Fresher</option>
                                            </Select>
                                            {{-- <div class=""> --}}
                                            {{-- <input type="text" class="border-0" name="searchkeyword"  id="searchkeyword" placeholder="Job Tittle or skills" data-prefetch="{{route('getskillsoptions')}}"
                                                required> --}}
                                            {{-- </div> --}}
                                        </div>
                                        <div class="col-md-3 my-2 border-right">
                                            {{-- <div class="">
                                            <div class=""> --}}
                                            {{-- <input class="form-control h-100 border-0" list="locationlist" name="location"
                                                    id="location" placeholder="Enter location">
                                                <datalist id="locationlist" class="bg-white" role="listbox">
                                                </datalist> --}}
                                            <select class="js-example-basic-single form-control"
                                                placeholder="Enter location" name="location" title="locations"
                                                data-toggle="tooltip" id="location">
                                                <option value="">Select Location</option>
                                                @foreach ($locations as $location)
                                                    <option value="{{ $location->cities_name }}">
                                                        {{ $location->cities_name }}</option>
                                                @endforeach
                                            </select>
                                            {{-- </div>
                                        </div> --}}
                                        </div>
                                        <div class="col-md-3 my-2 findjob">

                                            {{-- <div class=""> --}}
                                            <button class="btn rightradius" id="search_jobs" type="submit">Find
                                                job</button>
                                            {{-- </div> --}}
                                        </div>

                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- slider Area End-->
        <!-- Our Services Start -->
        <div class="our-services pt-4">
            <div class="container">
                <!-- Section Tittle -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-tittle text-center">
                            {{-- <span>FEATURED TOURS Packages</span> --}}
                            <h2>Browse Top Categories </h2>
                        </div>
                    </div>
                </div>
                <div class="row d-flex justify-contnet-center">
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <div class="single-services text-center mb-30">
                            <div class="services-ion">
                                {{-- <span class="flaticon-tour"></span> --}}
                                <img src="{{ asset('assets/images/accounting.png') }}" style="width:30%" class="img-fluid">
                            </div>
                            <div class="services-cap" id="accounts_count">
                                <h5><a href="#">Accounts</a></h5>
                                <span></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <div class="single-services text-center mb-30">
                            <div class="services-ion">
                                {{-- <span class="flaticon-cms"></span> --}}
                                <img src="{{ asset('assets/images/agriculture.png') }}" style="width:30%" class="img-fluid">

                            </div>
                            <div class="services-cap" id="agriculture_count">
                                <h5><a href="#">Agriculture</a></h5>
                                <span></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <div class="single-services text-center mb-30">
                            <div class="services-ion">
                                {{-- <span class="flaticon-report"></span> --}}
                                <img src="{{ asset('assets/images/laboratory.png') }}" style="width:30%" class="img-fluid">

                            </div>
                            <div class="services-cap" id="chemicals_count">
                                <h5><a href="#">Chemicals</a></h5>
                                <span></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <div class="single-services text-center mb-30">
                            <div class="services-ion">
                                {{-- <span class="flaticon-app"></span> --}}
                                <img src="{{ asset('assets/images/plugin.png') }}" style="width:30%" class="img-fluid">

                            </div>
                            <div class="services-cap" id="electricals_count">
                                <h5><a href="#">Electricals</a></h5>
                                <span></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <div class="single-services text-center mb-30">
                            <div class="services-ion">
                                {{-- <span class="flaticon-helmet"></span> --}}
                                <img src="{{ asset('assets/images/hotel.png') }}" style="width:30%" class="img-fluid">

                            </div>
                            <div class="services-cap" id="hotels_count">
                                <h5><a href="#">Hotels</a></h5>
                                <span></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <div class="single-services text-center mb-30">
                            <div class="services-ion">
                                <span class="flaticon-high-tech"></span>
                                {{-- <img src="{{asset('assets/images/agriculture.png')}}" style="width:30%" class="img-fluid"> --}}

                            </div>
                            <div class="services-cap" id="it_count">
                                <h5><a href="#">Information Technology</a></h5>
                                <span></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <div class="single-services text-center mb-30">
                            <div class="services-ion">
                                {{-- <span class="flaticon-real-estate"></span> --}}
                                <img src="{{ asset('assets/images/balance.png') }}" style="width:30%" class="img-fluid">

                            </div>
                            <div class="services-cap" id="laws_count">
                                <h5><a href="#">Laws</a></h5>
                                <span></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <div class="single-services text-center mb-30">
                            <div class="services-ion">
                                {{-- <span class="flaticon-content"></span> --}}
                                <img src="{{ asset('assets/images/recruitment.png') }}" style="width:30%"
                                    class="img-fluid">

                            </div>
                            <div class="services-cap" id="recruitment_count">
                                <h5><a href="#">Recruitment</a></h5>
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- More Btn -->
                <!-- Section Button -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="browse-btn2 text-center my-3">
                            <a href="{{ route('loadJoblistPage') }}" class="border-btn2">Browse All Sectors</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Our Services End -->
        <!-- Online CV Area Start -->
        <div class="online-cv cv-bg section-overly pt-90 pb-100"
            data-background={{ asset('assets/img/gallery/cv_bg.jpg') }}>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-10">
                        <div class="cv-caption text-center">
                            {{-- <p class="pera1">FEATURED TOURS Packages</p> --}}
                            <p class="pera2"> Make a Difference with Your Online Resume!</p>
                            <a href="{{ route('login') }}" class="border-btn2 border-btn4">Upload your cv</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Online CV Area End-->
        <!-- Featured_job_start -->
        <section class="featured-job-area feature-padding">
            <div class="container">
                <!-- Section Tittle -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-tittle text-center">
                            {{-- <span>Recent Job</span> --}}
                            <h2>Naukriyan of the Week</h2>
                        </div>
                    </div>
                </div>


                <div class="row justify-content-center">

                    <div class="col-xl-10">
                        <div class="container">

                            <!-- Nav tabs -->
                            <ul class="nav d-flex justify-content-center" role="tablist">
                                <li class="nav-item border rounded">
                                    <a class="nav-link text-dark active" data-toggle="tab"
                                        href="#egovernance">E-GOVERNANCE</a>
                                </li>
                                <li class="nav-item border rounded ml-2">
                                    <a class="nav-link text-dark" data-toggle="tab" href="#corporate">CORPORATE</a>
                                </li>
                                <li class="nav-item border rounded ml-2">
                                    <a class="nav-link text-dark" data-toggle="tab" href="#government">GOVERNMENT</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div id="egovernance" class="container tab-pane active"><br>

                                    <!-- single-job-content -->
                                    @forelse ($egovernance as $item)
                                        @php
                                            $minsalary = 0;
                                            $exp_required = $item->main_exp . ' Yr - ' . $item->max_exp . ' Yr';
                                            if ($item->offered_sal_min) {
                                                $minsalary = $item->offered_sal_min;
                                            }
                                            if ($item->main_exp === '0' && $item->max_exp === '0') {
                                                $exp_required = 'Fresher';
                                            }

                                        @endphp
                                        <div class="single-job-items mb-30 shadow-sm">
                                            <div class="job-items">
                                                <div class="company-img">
                                                    <a href="{{ route('job_details', ['id' => $item->id]) }}">
                                                        <img src={{ asset('company_logo/' . $item->company_logo . '') }}
                                                            class="img-fluid image-class rounded p-1"
                                                            alt="no-image-found">
                                                        {{-- <img
                                                            src={{ asset('assets/images/prakhar_logo.png') }}
                                                            class="img-fluid image-class" alt=""> --}}

                                                    </a>
                                                </div>
                                                <div class="job-tittle">
                                                    <a href="{{ route('job_details', ['id' => $item->id]) }}">
                                                        <h4>{{ $item->title }}</h4>
                                                    </a>
                                                    <ul>
                                                        <li>{{ $item->company_name }}</li>
                                                        <li><i
                                                                class="fas fa-map-marker-alt"></i>{{ $item->job_exp ? $item->job_exp : 'Not Defined' }}
                                                        </li>
                                                        <li>{{ $item->sal_disclosed == 'Yes' ? 'INR ' . $minsalary . ' - ' . $item->offered_sal_max : 'Not Disclosed' }}
                                                        </li>

                                                    </ul>
                                                </div>
                                            </div>
                                            <span class="text-muted">Experience Required : {{ $exp_required }}</span>
                                        </div>
                                    @empty
                                        <span class="text-danger">No Job Found</span>
                                    @endforelse

                                </div>
                                <div id="corporate" class="container tab-pane"><br>

                                    <!-- single-job-content -->
                                    @forelse ($corporate as $item)
                                        @php
                                            $minsalary = 0;
                                            $exp_required = $item->main_exp . ' Yr - ' . $item->max_exp . ' Yr';
                                            if ($item->offered_sal_min) {
                                                $minsalary = $item->offered_sal_min;
                                            }
                                            if ($item->main_exp === '0' && $item->max_exp === '0') {
                                                $exp_required = 'Fresher';
                                            }

                                        @endphp
                                        <div class="single-job-items mb-30 shadow-sm">
                                            <div class="job-items">
                                                <div class="company-img">
                                                    <a href="{{ route('job_details', ['id' => $item->id]) }}"><img
                                                            src={{ asset('company_logo/' . $item->company_logo . '') }}
                                                            class="img-fluid image-class rounded p-1"
                                                            alt="no-image-found"></a>
                                                </div>
                                                <div class="job-tittle">
                                                    <a href="{{ route('job_details', ['id' => $item->id]) }}">
                                                        <h4>{{ $item->title }}</h4>
                                                    </a>
                                                    <ul>
                                                        <li>{{ $item->company_name }}</li>
                                                        <li><i
                                                                class="fas fa-map-marker-alt"></i>{{ $item->location ? $item->location : 'Not Defined' }}
                                                        </li>
                                                        <li>{{ $item->sal_disclosed == 'Yes' ? 'INR ' . $minsalary . ' - ' . $item->offered_sal_max : 'Not Disclosed' }}
                                                        </li>

                                                    </ul>
                                                </div>
                                            </div>
                                            <span class="text-muted">Experience Required : {{ $exp_required }}</span>
                                        </div>
                                    @empty
                                        <span class="text-danger">No Job Found</span>
                                    @endforelse

                                </div>

                                <div id="government" class="container tab-pane fade"><br>
                                    <!-- single-job-content -->
                                    @forelse ($government as $item)
                                        @php
                                            $minsalary = 0;
                                            $exp_required = $item->main_exp . 'Yr - ' . $item->max_exp . ' Yr';
                                            if ($item->offered_sal_min) {
                                                $minsalary = $item->offered_sal_min;
                                            }
                                            if ($item->main_exp === '0' && $item->max_exp === '0') {
                                                $exp_required = 'Fresher';
                                            }

                                        @endphp
                                        <div class="single-job-items mb-30 shadow-sm">
                                            <div class="job-items">
                                                <div class="company-img">
                                                    <a href="{{ route('job_details', ['id' => $item->id]) }}"><img
                                                            src={{ asset('company_logo/' . $item->company_logo . '') }}
                                                            class="img-fluid image-class rounded p-1"
                                                            alt="no-image-found"></a>
                                                </div>
                                                <div class="job-tittle">
                                                    <a href="{{ route('job_details', ['id' => $item->id]) }}">
                                                        <h4>{{ $item->title }}</h4>
                                                    </a>
                                                    <ul>
                                                        <li>{{ $item->company_name }}</li>
                                                        <li><i
                                                                class="fas fa-map-marker-alt"></i>{{ $item->location ? $item->location : 'Not Defined' }}
                                                        </li>
                                                        <li>{{ $item->sal_disclosed == 'Yes' ? 'INR ' . $minsalary . ' - ' . $item->offered_sal_max : 'Not Disclosed' }}
                                                        </li>

                                                    </ul>
                                                </div>
                                            </div>
                                            <span class="text-muted">Experience Required : {{ $exp_required }}</span>
                                        </div>
                                    @empty
                                        <span class="text-danger">No Job Found</span>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <span class="d-flex justify-content-center">
                            <a href="{{ route('loadJoblistPage') }}" class="btn btn-warning ">View All</a>
                        </span>
                    </div>
                </div>
            </div>
        </section>
        <!-- Featured_job_end -->
        <!-- How  Apply Process Start-->
        <div class="apply-process-area apply-bg pt-100 pb-90"
            data-background={{ asset('assets/img/gallery/how-applybg.png') }}>
            <div class="container">
                <!-- Section Tittle -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-tittle white-text text-center">
                            <span style="color: white;">Apply process</span>
                            <h2> How it works</h2>
                        </div>
                    </div>
                </div>
                <!-- Apply Process Caption -->
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="single-process text-center mb-30">
                            <div class="process-ion">
                                <span class="flaticon-search"></span>
                            </div>
                            <div class="process-cap">
                                <h5>1. Search for Jobs</h5>
                                <p>Use Naukriyan’s search function to find job listings that align with your skills,
                                    interests, and career goals. Filter results by location, industry, and job type to
                                    narrow down your options.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="single-process text-center mb-30">
                            <div class="process-ion">
                                <span class="flaticon-curriculum-vitae"></span>
                            </div>
                            <div class="process-cap">
                                <h5>2. Apply for Positions</h5>
                                <p>Review the job descriptions and select the roles that best match your qualifications.
                                    Click "Apply," attach your resume and cover letter, and complete any additional
                                    application requirements.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="single-process text-center mb-30">
                            <div class="process-ion">
                                <span class="flaticon-tour"></span>
                            </div>
                            <div class="process-cap">
                                <h5>3. Get Hired</h5>
                                <p>Monitor your application status through your Naukriyan dashboard. Follow up with
                                    potential employers as needed, and prepare for interviews to secure your desired job.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- How  Apply Process End-->
        <!-- Testimonial Start -->
        {{-- <div class="testimonial-area testimonial-padding">
            <div class="container">
                <!-- Testimonial contents -->
                <div class="row d-flex justify-content-center">
                    <div class="col-xl-8 col-lg-8 col-md-10">
                        <div class="h1-testimonial-active dot-style">
                            <!-- Single Testimonial -->
                            <div class="single-testimonial text-center">
                                <!-- Testimonial Content -->
                                <div class="testimonial-caption ">
                                    <!-- founder -->
                                    <div class="testimonial-founder  ">
                                        <div class="founder-img mb-30">
                                            <img src={{ asset('assets/img/testmonial/testimonial-founder.png') }}
                                                alt="">
                                            <span>Margaret Lawson</span>
                                            <p>Creative Director</p>
                                        </div>
                                    </div>
                                    <div class="testimonial-top-cap">
                                        <p>“I am at an age where I just want to be fit and healthy our bodies are our
                                            responsibility! So start caring for your body and it will care for you. Eat
                                            clean it will care for you and workout hard.”</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Single Testimonial -->
                            <div class="single-testimonial text-center">
                                <!-- Testimonial Content -->
                                <div class="testimonial-caption ">
                                    <!-- founder -->
                                    <div class="testimonial-founder  ">
                                        <div class="founder-img mb-30">
                                            <img src={{ asset('assets/img/testmonial/testimonial-founder.png') }}
                                                alt="">
                                            <span>Margaret Lawson</span>
                                            <p>Creative Director</p>
                                        </div>
                                    </div>
                                    <div class="testimonial-top-cap">
                                        <p>“I am at an age where I just want to be fit and healthy our bodies are our
                                            responsibility! So start caring for your body and it will care for you. Eat
                                            clean it will care for you and workout hard.”</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Single Testimonial -->
                            <div class="single-testimonial text-center">
                                <!-- Testimonial Content -->
                                <div class="testimonial-caption ">
                                    <!-- founder -->
                                    <div class="testimonial-founder  ">
                                        <div class="founder-img mb-30">
                                            <img src={{ asset('assets/img/testmonial/testimonial-founder.png') }}
                                                alt="">
                                            <span>Margaret Lawson</span>
                                            <p>Creative Director</p>
                                        </div>
                                    </div>
                                    <div class="testimonial-top-cap">
                                        <p>“I am at an age where I just want to be fit and healthy our bodies are our
                                            responsibility! So start caring for your body and it will care for you. Eat
                                            clean it will care for you and workout hard.”</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- Testimonial End -->
        <!-- Support Company Start-->
        <div class="support-company-area support-padding fix">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-lg-6">
                        <div class="right-caption">
                            <!-- Section Tittle -->
                            <div class="section-tittle section-tittle2">
                                <span>What we are doing</span>
                                <h2>24k Talented people are getting Jobs</h2>
                            </div>
                            <div class="support-caption">
                                <p class="pera-top">At Naukriyan, we're committed to connecting talent with opportunity.
                                    Currently, over thousands of skilled professionals have successfully found jobs through
                                    our platform. Our mission is to bridge the gap between talented individuals and top
                                    employers, ensuring that every job seeker finds a role that matches their skills and
                                    aspirations. Join us and be part of a thriving community where your career growth is our
                                    priority.</p>

                                <a href="{{ route('loadLoginPage') }}" class="btn post-btn">Post a job</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="support-location-img">
                            <img src={{ asset('assets/img/service/support-img.jpg') }} alt="">
                            <div class="support-img-cap text-center">
                                <p>Since</p>
                                <span>2015</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Support Company End-->
        <!-- Blog Area Start -->
        <div class="home-blog-area blog-h-padding">
            <div class="container">
                <!-- Section Tittle -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-tittle text-center">
                            <span>Our latest blog</span>
                            {{-- <h2>Our recent news</h2> --}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    @forelse ($blogs as $blog)
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="home-blog-single mb-30">
                            <div class="blog-img-cap">
                                <div class="blog-img">
                                    <img src={{ asset('blogs/'.$blog->image) }} alt="">
                                    <!-- Blog date -->
                                    <div class="blog-date text-center">
                                        <span>{{date('d', strtotime($blog->created_at))}}</span>
                                        <p>{{date('M', strtotime($blog->created_at))}}</p>
                                    </div>
                                </div>
                                <div class="blog-cap">
                                    {{-- <p>| Title</p> --}}
                                    <h3><a href="{{route('blog-details', ['id' => $blog->id])}}">{{$blog->title}}</a>
                                    </h3>
                                    <a href="{{route('blog-details', ['id' => $blog->id])}}" class="more-btn">Read more »</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                        <span class="text-danger">No Blogs</span>
                    @endforelse
                 
                    {{-- <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="home-blog-single mb-30">
                            <div class="blog-img-cap">
                                <div class="blog-img">
                                    <img src={{ asset('assets/img/blog/home-blog2.jpg') }} alt="">
                                    <!-- Blog date -->
                                    <div class="blog-date text-center">
                                        <span>24</span>
                                        <p>Nov</p>
                                    </div>
                                </div>
                                <div class="blog-cap">
                                    <p>| Properties</p>
                                    <h3><a href="single-blog.html">Footprints in Time is perfect House in Kurashiki</a>
                                    </h3>
                                    <a href="#" class="more-btn">Read more »</a>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
        <!-- Blog Area End -->

    </main>
@endsection
@section('script')
    <script src="{{ asset('assets/js/bootstrap-autocomplete.js') }}"></script>
    <script src="{{ asset('assests/js/custom_js/homepage.js') }}"></script>
@endsection
