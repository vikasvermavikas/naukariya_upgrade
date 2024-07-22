@extends('layouts.master', ['title' => 'Job Listing'])
@section('content')
    <main>
        <!-- Hero Area Start-->
        <div class="slider-area ">
            <div class="single-slider section-overly slider-height2 d-flex align-items-center"
                style="background-image : url({{asset('assets/img/hero/about.jpg')}})">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="hero-cap text-center">
                                <h2>Get your job</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hero Area End -->
        <!-- Job List Area Start -->
        <div class="job-listing-area pt-120 pb-120">
            <div class="container">
                <div class="row">
                    <!-- Left content -->
                    <div class="col-xl-3 col-lg-3 col-md-4">
                        <div class="row">
                            <div class="col-12">
                                <div class="small-section-tittle2 mb-45">
                                    <div class="ion"> <svg xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="20px" height="12px">
                                            <path fill-rule="evenodd" fill="rgb(27, 207, 107)"
                                                d="M7.778,12.000 L12.222,12.000 L12.222,10.000 L7.778,10.000 L7.778,12.000 ZM-0.000,-0.000 L-0.000,2.000 L20.000,2.000 L20.000,-0.000 L-0.000,-0.000 ZM3.333,7.000 L16.667,7.000 L16.667,5.000 L3.333,5.000 L3.333,7.000 Z" />
                                        </svg>
                                    </div>
                                    <h4>Filter Jobs</h4>
                                </div>
                            </div>
                        </div>
                        <!-- Job Category Listing start -->
                        <div class="job-category-listing mb-50">
                            <!-- single one -->
                            <div class="single-listing">
                                <div class="small-section-tittle2">
                                    <h4>Job Category</h4>
                                </div>
                                <!-- Select job items start -->
                                <div class="select-job-items2">
                                    <select class="form-control" name="job_category" id="industries">
                                        <option value="">Select Industry</option>
                                    </select>
                                </div>
                                <div class="small-section-tittle2 pt-80">
                                    <h4>Skill</h4>
                                </div>
                                <div class="select-job-items2">
                                    <select class="js-example-responsive form-control skill" name="skill[]" multiple="multiple" style="width:100%" id="skill" >
                                        <option value="">Select Skill</option>
                                    </select>
                                </div>
                                <!--  Select job items End-->
                                <!-- select-Categories start -->
                                <div class="select-Categories pt-80 pb-50">
                                    <div class="small-section-tittle2">
                                        <h4>Job Type</h4>
                                    </div>
                                    <label class="container">Full Time
                                        <input type="checkbox" class="jobtype" id="full_time" name="fulltime"
                                            value="2">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="container">Part Time
                                        <input type="checkbox" class="jobtype" id="parttime" name="parttime"
                                            value="1">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="container">Internship
                                        <input type="checkbox" class="jobtype" id="internship" name="internship"
                                            value="4">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="container">Freelancer
                                        <input type="checkbox" class="jobtype" id="freelance" name="freelance"
                                            value="3">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <!-- select-Categories End -->
                            </div>
                            <!-- single two -->
                            <div class="single-listing">
                                {{-- <div class="small-section-tittle2">
                                    <h4>Job Location</h4>
                                </div>
                                <!-- Select job items start -->
                                <div class="select-job-items2">
                                    <select name="select">
                                        <option value="1">Basic</option>
                                        <option value="2">Hot</option>
                                        <option value="3">Featured</option>
                                    </select>
                                </div> --}}
                                <!--  Select job items End-->
                                <!-- select-Categories start -->
                                <div class="select-Categories pb-50">
                                    <div class="small-section-tittle2">
                                        <h4>Experience</h4>
                                    </div>
                                    <label class="container">1-2 Years
                                        <input type="checkbox" class="experience" id="experience" name="experience"
                                            value="1-2">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="container">2-3 Years
                                        <input type="checkbox" class="experience" id="experience" name="experience"
                                            value="2-3">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="container">3-6 Years
                                        <input type="checkbox" class="experience" id="experience" name="experience"
                                            value="3-6">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="container">6-more..
                                        <input type="checkbox" class="experience" id="experience" name="experience"
                                            value="6">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <!-- select-Categories End -->
                            </div>
                            <!-- single three -->
                            <div class="single-listing">
                                <!-- select-Categories start -->
                                <div class="select-Categories">
                                    <div class="small-section-tittle2">
                                        <h4>Posted Within</h4>
                                    </div>
                                    {{-- <label class="container">Any
                                        <input type="checkbox" class="experience" id="experience" name="postwithin" value="3-6">
                                        <span class="checkmark"></span>
                                    </label> --}}
                                    <label class="container">Today
                                        <input type="radio" class="postedWithin" id="experience" name="postwithin"
                                            value="{{ date('Y-m-d') }}">
                                        <span class="checkmark"></span>
                                    </label>

                                    @php
                                        $twodate = \Carbon\Carbon::now()->subDays(2);
                                        $threedate = \Carbon\Carbon::now()->subDays(3);
                                        $fivedate = \Carbon\Carbon::now()->subDays(5);
                                        $tendate = \Carbon\Carbon::now()->subDays(10);
                                    @endphp
                                    <label class="container">Last 2 days
                                        <input type="radio" class="postedWithin" id="experience" name="postwithin"
                                            value="{{ date_format($twodate, 'Y-m-d') }}">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="container">Last 3 days
                                        <input type="radio" class="postedWithin" id="experience" name="postwithin"
                                            value="{{ date_format($threedate, 'Y-m-d') }}">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="container">Last 5 days
                                        <input type="radio" class="postedWithin" id="experience" name="postwithin"
                                            value="{{ date_format($fivedate, 'Y-m-d') }}">
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="container">Last 10 days
                                        <input type="radio" class="postedWithin" id="experience" name="postwithin"
                                            value="{{ date_format($tendate, 'Y-m-d') }}">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <!-- select-Categories End -->
                            </div>
                            {{-- <div class="single-listing">
                                <!-- Range Slider Start -->
                                <aside class="left_widgets p_filter_widgets price_rangs_aside sidebar_box_shadow">
                                    <div class="small-section-tittle2">
                                        <h4>Filter Jobs</h4>
                                    </div>
                                    <div class="widgets_inner">
                                        <div class="range_item">
                                            <!-- <div id="slider-range"></div> -->
                                            <input type="text" class="js-range-slider" value="" />
                                            <div class="d-flex align-items-center">
                                                <div class="price_text">
                                                    <p>Price :</p>
                                                </div>
                                                <div class="price_value d-flex justify-content-center">
                                                    <input type="text" class="js-input-from" id="amount"
                                                        readonly />
                                                    <span>to</span>
                                                    <input type="text" class="js-input-to" id="amount" readonly />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </aside>
                                <!-- Range Slider End -->
                            </div> --}}
                        </div>
                        <!-- Job Category Listing End -->
                    </div>
                    <!-- Right content -->
                    <div class="col-xl-9 col-lg-9 col-md-8">
                        <!-- Featured_job_start -->
                        <section class="featured-job-area">
                            <div class="container">
                                <!-- Count of Job list Start -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="count-job mb-35">
                                            <span id="jobcount"> Jobs found ({{ $data->count() }}) </span>
                                            <!-- Select job items start -->
                                            <div>
                                                {{-- <form action="{{ route('loadLoginPage') }}" method="GET" --}}
                                                    {{-- class="form-inline"> --}}

                                                    <input type="text" name="searchkeyword" id="searchkeyword"
                                                        placeholder="Search by Keyword"
                                                        value="{{ $searchTerm ? $searchTerm : '' }}" 
                                                        required autocomplete="off"/>
                                                        <span onclick="fetchJobListings()"> <i class="fas fa-search text-color"></i></span>

                                                    {{-- @error('searchkeyword')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                   
                                                    <a href="{{ route('loadLoginPage') }}"
                                                        class="ml-2 form-control text-white"
                                                        style="background:#e35e25;border:0;">Clear</a> --}}

                                                {{-- </form> --}}
                                            </div>
                                            {{-- <div class="select-job-items">
                                                <span>Sort by</span>
                                                <select class="form-control" name="select">
                                                    <option value="">None</option>
                                                    <option value="">job list</option>
                                                    <option value="">job list</option>
                                                    <option value="">job list</option>
                                                </select>
                                            </div> --}}
                                            <!--  Select job items End-->
                                        </div>
                                    </div>
                                </div>
                                <div id="defaultJobLists">
                                    <!-- Count of Job list End -->
                                    <!-- single-job-content -->
                                    @forelse ($data as $item)
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

                                        <div class="joblists">
                                            <div class="single-job-items mb-30">
                                                <div class="job-items">
                                                    <div class="company-img">
                                                        <a href="{{ route('job_details', ['id' => $item->id]) }}"><img
                                                                src={{asset("assets/img/icon/job-list1.png")}} alt=""></a>
                                                    </div>
                                                    <div class="job-tittle job-tittle2">
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
                                                        <span class="text-muted">Experience Required :
                                                            {{ $exp_required }}</span>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    @empty
                                        <span class="text-danger text-center">No Jobs Found</span>
                                    @endforelse
                                </div>
                                <div class="joblists1">

                                </div>

                            </div>
                        </section>
                        <!-- Featured_job_end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Job List Area End -->
        <!--Pagination Start  -->
        <div class="pagination-area pb-115 text-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="text-center">
                        <div class="single-wrap default_pagination">
                            {{ $data->links() }}

                        </div>
                        <div class="single-wrap filter_pagination">


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Pagination End  -->

    </main>
@endsection

@section('script')

    <script src="{{ asset('assests/js/custom_js/job-listing.js') }}"></script>
@endsection
