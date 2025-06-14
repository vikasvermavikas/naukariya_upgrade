@extends('layouts.master', ['title' => 'Job Listing'])
@section('style')
    <style>
        .jobdata:hover {
            box-shadow: 0px 22px 57px 0px rgba(34, 41, 72, 0.05);
        }
    </style>
@endsection
@section('content')
    <main>
        <div class="slider-area ">
            <div class="single-slider section-overly slider-height2 d-flex align-items-center"
                style="background-image : url({{ asset('assets/img/hero/about.jpg') }})">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="hero-cap text-center">
                                <h2>Get your job through - Job Board API</h2>
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
                    <!-- Right content -->
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <!-- Featured_job_start -->
                        <section class="featured-job-area">
                            <div class="container">
                                <!-- Count of Job list Start -->
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="count-job mb-35">
                                            <span id="jobcount"> Jobs found {{ count($jobs) }}</span>
                                            <!-- Select job items start -->
                                            <div>
                                                <form>
                                                    <input type="text" name="search" placeholder="Search by job title"
                                                        value="{{ $search }}" autocomplete="off" />
                                                    <button type="submit" class="border-0 bg-white"> <i
                                                            class="fas fa-search text-color"></i></button>
                                                </form>

                                            </div>

                                            <!--  Select job items End-->
                                        </div>
                                    </div>
                                </div>
                                <div id="defaultJobLists">
                                    @forelse ($jobs as $item)
                                        <div class="joblists jobdata border rounded p-3 my-3">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-30">
                                                        <div class="job-items">
                                                            <div class="row">
                                                                <div class="col-md-2 text-center">
                                                                    <div class="company-img mt-4">
                                                                        <h4>{{ $item['title'] }}</h4>
                                                                        <br>
                                                                            <a href="{{ $item['external_url'] ? $item['external_url'] : $item['redirected_url'] }}"
                                                                                class="btn head-btn1 p-3 rounded text-light">Apply</a>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-10">
                                                                    <div class="job-tittle job-tittle2">
                                                                        <ul class="d-flex my-2">
                                                                            <li class="mx-3"><span
                                                                                    class="font-weight-bold">Company </span>
                                                                                :
                                                                                {{ $item['company_name'] }}</li>
                                                                            <li class="mx-3"><i
                                                                                    class="fas fa-map-marker-alt"></i>
                                                                                {{ $item['location'] }}
                                                                            </li>
                                                                            <li class="mx-3"><i class="fas fa-rupee-sign"
                                                                                    aria-hidden="true"></i>
                                                                                {{ $item['salary'] ? $item['salary'] : 'Not Disclosed' }}
                                                                            </li>
                                                                            <li class="mx-3"> <span
                                                                                    class="font-weight-bold">Applicant Count
                                                                                </span> :
                                                                                {{ $item['applicants_count'] }}
                                                                            </li>
                                                                            <li class="mx-3"> <span
                                                                                    class="font-weight-bold">Time posted
                                                                                </span> :
                                                                                {{ $item['time_posted'] }}
                                                                            </li>
                                                                        </ul>

                                                                        <ul class="d-flex my-2">
                                                                            <li class="mx-3"><span
                                                                                    class="font-weight-bold">Employment Type
                                                                                </span> :
                                                                                {{ $item['employment_type'] }}</li>

                                                                            <li class="mx-3"> <span
                                                                                    class="font-weight-bold">Seniority</span>
                                                                                :
                                                                                {{ $item['seniority'] }}
                                                                            </li>

                                                                        </ul>
                                                                        <span class="font-weight-bold">Description</span>
                                                                        <p class="text-muted text-wrap">
                                                                            :
                                                                            {{ Illuminate\Support\Str::words($item['description'], 100, '... Read More') }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <span class="text-danger text-center">No Record Found</span>
                                    @endforelse


                                </div>


                            </div>
                        </section>
                        <!-- Featured_job_end -->
                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection
