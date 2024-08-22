@extends('layouts.master', ['title' => 'About Page'])
@section('content')
<main>

    <!-- Hero Area Start-->
    <div class="slider-area ">
    <div class="single-slider section-overly slider-height2 d-flex align-items-center" data-background="{{asset('assets/img/hero/about.jpg')}}">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="hero-cap text-center">
                        <h2>About us</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Hero Area End -->
    <!-- Support Company Start-->
    <div class="support-company-area fix section-padding2">
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
                        <img src="{{asset('assets/img/service/support-img.jpg')}}" alt="">
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
    <!-- How  Apply Process Start-->
    <div class="apply-process-area apply-bg pt-150 pb-150" data-background="{{asset('assets/img/gallery/how-applybg.png')}}">
        <div class="container">
            <!-- Section Tittle -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-tittle white-text text-center">
                        <span>Apply process</span>
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
                                        <img src="{{asset('assets/img/testmonial/testimonial-founder.png')}}" alt="">
                                        <span>Margaret Lawson</span>
                                        <p>Creative Director</p>
                                    </div>
                                </div>
                                <div class="testimonial-top-cap">
                                    <p>“I am at an age where I just want to be fit and healthy our bodies are our responsibility! So start caring for your body and it will care for you. Eat clean it will care for you and workout hard.”</p>
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
                                        <img src="{{asset('assets/img/testmonial/testimonial-founder.png')}}" alt="">
                                        <span>Margaret Lawson</span>
                                        <p>Creative Director</p>
                                    </div>
                                </div>
                                <div class="testimonial-top-cap">
                                    <p>“I am at an age where I just want to be fit and healthy our bodies are our responsibility! So start caring for your body and it will care for you. Eat clean it will care for you and workout hard.”</p>
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
                                        <img src="{{asset('assets/img/testmonial/testimonial-founder.png')}}" alt="">
                                        <span>Margaret Lawson</span>
                                        <p>Creative Director</p>
                                    </div>
                                </div>
                                <div class="testimonial-top-cap">
                                    <p>“I am at an age where I just want to be fit and healthy our bodies are our responsibility! So start caring for your body and it will care for you. Eat clean it will care for you and workout hard.”</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Testimonial End -->
    <!-- Online CV Area Start -->
    <div class="online-cv cv-bg section-overly pt-90 pb-120 mt-5"  data-background="{{asset('assets/img/gallery/cv_bg.jpg')}}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="cv-caption text-center">
                        <p class="pera1">FEATURED TOURS Packages</p>
                        <p class="pera2"> Make a Difference with Your Online Resume!</p>
                        <a href="{{ route('login') }}" class="border-btn2 border-btn4">Upload your cv</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Online CV Area End-->

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
                                <img src="{{asset('assets/img/blog/home-blog2.jpg')}}" alt="">
                                <!-- Blog date -->
                                <div class="blog-date text-center">
                                    <span>24</span>
                                    <p>Now</p>
                                </div>
                            </div>
                            <div class="blog-cap">
                                <p>|   Properties</p>
                                <h3><a href="single-blog.html">Footprints in Time is perfect House in Kurashiki</a></h3>
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