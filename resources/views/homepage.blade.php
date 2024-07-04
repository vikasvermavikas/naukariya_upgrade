@extends('layouts.master', ['title' => 'Home Page'])
@section('style')
    <style>
        .nav-link.active {
            background-color: #e35e25;
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

        .select2-container {
            /* width: 100%; */
            height: 100%;
            background: white;
        }

        @media only screen and (min-width: 368px) and (max-width: 768px) {
            .select2-container {
                /* width: 100%; */
            }
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
                            abra ka dabra
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
                    data-background={{ asset('assets/img/hero/h1_hero.jpg') }}>
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-6 col-lg-9 col-md-10">
                                <div class="hero__caption">
                                    <h1>Find the most exciting startup jobs</h1>
                                </div>
                            </div>
                        </div>
                        <!-- Search Box -->
                        <div class="row">
                            <div class="col-xl-8">
                                <!-- form -->
                                <form action="{{ route('loadJoblistPage') }}" method="GET" class="search-box">
                                    <div class="input-form">
                                        <input type="text" name="searchkeyword" placeholder="Job Tittle or keyword"
                                            required>
                                    </div>
                                    <div class="select-form">
                                        <div class="select-itms h-100">
                                            {{-- <input class="form-control h-100 border-0" list="locationlist" name="location"
                                                id="location" placeholder="Enter location">
                                            <datalist id="locationlist" class="bg-white" role="listbox">
                                            </datalist> --}}
                                            <select class="js-example-basic-single form-control"
                                                placeholder="Enter location" name="location" id="location">
                                                <option value="">Select Location</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="search-form">
                                        <button class="form-control btn btn-warning h-100" type="submit">Find job</button>
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
                                <span class="flaticon-tour"></span>
                            </div>
                            <div class="services-cap">
                                <h5><a href="job_listing.html">Design & Creative</a></h5>
                                <span>(653)</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <div class="single-services text-center mb-30">
                            <div class="services-ion">
                                <span class="flaticon-cms"></span>
                            </div>
                            <div class="services-cap">
                                <h5><a href="job_listing.html">Design & Development</a></h5>
                                <span>(658)</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <div class="single-services text-center mb-30">
                            <div class="services-ion">
                                <span class="flaticon-report"></span>
                            </div>
                            <div class="services-cap">
                                <h5><a href="job_listing.html">Sales & Marketing</a></h5>
                                <span>(658)</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <div class="single-services text-center mb-30">
                            <div class="services-ion">
                                <span class="flaticon-app"></span>
                            </div>
                            <div class="services-cap">
                                <h5><a href="job_listing.html">Mobile Application</a></h5>
                                <span>(658)</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <div class="single-services text-center mb-30">
                            <div class="services-ion">
                                <span class="flaticon-helmet"></span>
                            </div>
                            <div class="services-cap">
                                <h5><a href="job_listing.html">Construction</a></h5>
                                <span>(658)</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <div class="single-services text-center mb-30">
                            <div class="services-ion">
                                <span class="flaticon-high-tech"></span>
                            </div>
                            <div class="services-cap">
                                <h5><a href="job_listing.html">Information Technology</a></h5>
                                <span>(658)</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <div class="single-services text-center mb-30">
                            <div class="services-ion">
                                <span class="flaticon-real-estate"></span>
                            </div>
                            <div class="services-cap">
                                <h5><a href="job_listing.html">Real Estate</a></h5>
                                <span>(658)</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6">
                        <div class="single-services text-center mb-30">
                            <div class="services-ion">
                                <span class="flaticon-content"></span>
                            </div>
                            <div class="services-cap">
                                <h5><a href="job_listing.html">Content Writer</a></h5>
                                <span>(658)</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- More Btn -->
                <!-- Section Button -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="browse-btn2 text-center mt-50">
                            <a href="job_listing.html" class="border-btn2">Browse All Sectors</a>
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
                            <a href="#" class="border-btn2 border-btn4">Upload your cv</a>
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
                            <h2>Featured Jobs</h2>
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
                                        <div class="single-job-items mb-30">
                                            <div class="job-items">
                                                <div class="company-img">
                                                    <a href="{{ route('job_details', ['id' => $item->id]) }}"><img
                                                            src="assets/img/icon/job-list1.png" alt=""></a>
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
                                        <div class="single-job-items mb-30">
                                            <div class="job-items">
                                                <div class="company-img">
                                                    <a href="{{ route('job_details', ['id' => $item->id]) }}"><img
                                                            src="assets/img/icon/job-list2.png" alt=""></a>
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
                                        <div class="single-job-items mb-30">
                                            <div class="job-items">
                                                <div class="company-img">
                                                    <a href="{{ route('job_details', ['id' => $item->id]) }}"><img
                                                            src="assets/img/icon/job-list4.png" alt=""></a>
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
                            <a href="{{ route('job_listing') }}" class="btn btn-warning ">View All</a>
                        </span>
                    </div>
                </div>
            </div>
        </section>
        <!-- Featured_job_end -->
        <!-- How  Apply Process Start-->
        <div class="apply-process-area apply-bg pt-150 pb-150"
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
                                <h5>1. Search a job</h5>
                                <p>Sorem spsum dolor sit amsectetur adipisclit, seddo eiusmod tempor incididunt ut laborea.
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
                                <h5>2. Apply for job</h5>
                                <p>Sorem spsum dolor sit amsectetur adipisclit, seddo eiusmod tempor incididunt ut laborea.
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
                                <h5>3. Get your job</h5>
                                <p>Sorem spsum dolor sit amsectetur adipisclit, seddo eiusmod tempor incididunt ut laborea.
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
                                <p class="pera-top">Mollit anim laborum duis au dolor in voluptate velit ess cillum dolore
                                    eu lore dsu quality mollit anim laborumuis au dolor in voluptate velit cillum.</p>
                                <p>Mollit anim laborum.Duis aute irufg dhjkolohr in re voluptate velit esscillumlore eu
                                    quife nrulla parihatur. Excghcepteur signjnt occa cupidatat non inulpadeserunt mollit
                                    aboru. temnthp incididbnt ut labore mollit anim laborum suis aute.</p>
                                <a href="about.html" class="btn post-btn">Post a job</a>
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
                            <h2>Our recent news</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="home-blog-single mb-30">
                            <div class="blog-img-cap">
                                <div class="blog-img">
                                    <img src={{ asset('assets/img/blog/home-blog1.jpg') }} alt="">
                                    <!-- Blog date -->
                                    <div class="blog-date text-center">
                                        <span>24</span>
                                        <p>Now</p>
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
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <div class="home-blog-single mb-30">
                            <div class="blog-img-cap">
                                <div class="blog-img">
                                    <img src={{ asset('assets/img/blog/home-blog2.jpg') }} alt="">
                                    <!-- Blog date -->
                                    <div class="blog-date text-center">
                                        <span>24</span>
                                        <p>Now</p>
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
                    </div>
                </div>
            </div>
        </div>
        <!-- Blog Area End -->

    </main>
@endsection
@section('script')

    <script src="{{ asset('assests/js/custom_js/homepage.js') }}"></script>
    <script>

        //  @if ($message = session('succes_message')) 
    
        // @endif 
            </script>
@endsection
