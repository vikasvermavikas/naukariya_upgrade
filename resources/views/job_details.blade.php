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
                                <h2>{{ $data->title }}</h2>
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
            <div class="col-md-12">
                @if ($errors->has('message'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ $errors->first('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                @endif
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session()->get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session()->get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                @endif
            </div>
            <div class="container">
                <div class="row justify-content-between">
                    <!-- Left Content -->
                    <div class="col-xl-7 col-lg-8">
                        <!-- job single -->
                        <div class="single-job-items mb-50">
                            <div class="job-items">
                                <div class="company-img company-img-details col-md-12 mb-2">
                                    <a href="#"><img src="{{ asset('company_logo/' . $data->company_logo . '') }}"
                                            alt="" class="img-fluid border rounded p-1" width="80"></a>
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
                                                class="fas fa-map-marker-alt"></i>{{ $data->job_exp ? $data->job_exp : 'Not Defined' }}
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- job single End -->

                        <div class="job-post-details">
                            <div class="mb-2">
                               <span class="font-weight-bold">Skills :</span>  {{$data->job_skills}}
                            </div>
                            <div class="post-details1 mb-50">
                                <p class="font-weight-bold mb-3">Description :</p>
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
                                <li>Posted date : <span>{{ $data->start_apply_date }}</span></li>
                                <li>Location : <span>{{ $data->job_exp ? $data->job_exp : 'Not Defined' }}</span></li>
                                <li>Vacancy : <span>{{ $data->job_vaccancy }}</span></li>
                                <li>Job nature : <span>{{ $data->job_type }}</span></li>
                                <li>Salary :
                                    <span>{{ $data->sal_disclosed == 'Yes' ? round($minsalary / 100000, 2) . ' - ' . round($data->offered_sal_max / 100000, 2) . ' LPA' : 'Not Disclosed' }} </span>
                                </li>
                                <li>Job Shift : <span>{{ $data->job_shift }}</span></li>
                            </ul>
                            <div class="row">

                                <div class="col-md-12">
                                    {{-- <a href="#" class="btn btn-warning"></a> --}}
                                    @if ($isapplied)
                                        <button class="bg-success btn w-100" style="pointer-events: none" tabindex="-1"
                                            aria-disabled="true">Applied</button>
                                    @else
                                        <button type="button" class="btn w-100" data-toggle="modal" data-target="#myModal">
                                            Apply Now
                                        </button>
                                    @endif
                                </div>
                                <div class="col-md-12 mt-2">
                                    @if ($issaved)
                                        <button class="bg-success btn w-100" style="pointer-events: none" tabindex="-1"
                                            aria-disabled="true">Saved</button>
                                    @else
                                        <form action="{{ route('savejob', ['id' => $data->id]) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn w-100">Save Job</button>
                                        </form>
                                    @endif
                                    {{-- <a href="#" class="btn btn-warning mr-2">Save Job</a> --}}
                                </div>
                                <div class="text-center col-sm-12 mt-2">
                                    @if (count($follow_companies) > 0 && in_array($data->company_id, $follow_companies))
                                        <button class="bg-success btn w-100" style="pointer-events: none" tabindex="-1"
                                            aria-disabled="true">Following</button>
                                    @else
                                        <form
                                            action="{{ route('followjob', ['companyid' => $data->company_id, 'jobid' => $data->id]) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit" class="btn w-100">Follow</button>
                                        </form>
                                    @endif

                                    {{-- <a href="#" class="btn mt-2">Follow</a> --}}
                                </div>

                            </div>
                            <div class="container">
                                <!-- The Modal -->
                                <div class="modal fade" id="myModal">
                                    <div class="modal-dialog modal-dialog-scrollable">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Confirmation before Apply?</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <form role="form" action={{ route('applyjob', ['id' => $data->id]) }}
                                                method="post">
                                                @csrf
                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    <div class="form-group row inputBox">
                                                        <div class="col-sm-12">
                                                            <div class="input text">
                                                                <p><strong>Job Title</strong> :- {{ $data->title }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row inputBox">
                                                        <div class="col-sm-12">
                                                            <div class="input text">
                                                                <p><strong> Location</strong> :- {{ $data->job_exp }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row inputBox">
                                                        <div class="col-sm-12">
                                                            <div class="input text">
                                                                <p><strong>Company Name</strong> :-
                                                                    {{ $data->company_name }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="question">
                                                        <p> Do you have any of the relavant or Equivalent Qualification ?
                                                            ({{ $data->qualification }})
                                                        </p>
                                                        <fieldset class="mb-3">
                                                            <div class="form-group ask_question">
                                                                <div class="icheck-primary d-inline">
                                                                    <input type="radio" id="radioPrimary1" name="r1"
                                                                        checked="checked"> <label for="radioPrimary1"> Yes
                                                                    </label>
                                                                </div>
                                                                <div class="icheck-primary d-inline"><input type="radio"
                                                                        id="radioPrimary2" name="r1"> <label
                                                                        for="radioPrimary2"> No
                                                                    </label></div>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    <div class="question">
                                                        <p> Do you have relevant experience of this job
                                                            ({{ $exp_required }}) </p>
                                                        <fieldset class="mb-3">
                                                            <div class="form-group ask_question">
                                                                <div class="icheck-primary d-inline"><input type="radio"
                                                                        id="radioPrimary3" name="ex1"
                                                                        checked="checked">
                                                                    <label for="radioPrimary3"> Yes </label>
                                                                </div>
                                                                <div class="icheck-primary d-inline"><input type="radio"
                                                                        id="radioPrimary4" name="ex1"> <label
                                                                        for="radioPrimary4"> No
                                                                    </label></div>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    <div class="question">
                                                        <p> Do you have relevant skill for this job ?(Field Sales Executive,
                                                            sourcing new prospects, closing sales deals, negotiating,
                                                            maintaining positive customer relations, Excellent convincing
                                                            skills, client handling ability.) </p>
                                                        <fieldset class="mb-3">
                                                            <div class="form-group ask_question">
                                                                <div class="icheck-primary d-inline"><input type="radio"
                                                                        id="radioPrimary5" name="sk1"
                                                                        checked="checked">
                                                                    <label for="radioPrimary5"> Yes </label>
                                                                </div>
                                                                <div class="icheck-primary d-inline"><input type="radio"
                                                                        id="radioPrimary6" name="sk1"> <label
                                                                        for="radioPrimary6"> No
                                                                    </label></div>
                                                            </div>
                                                        </fieldset>
                                                    </div>

                                                </div>


                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">
                                                        Confirm Apply
                                                    </button>
                                                    <button type="button" class="btn btn-danger"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="post-details4  mb-50">
                            <!-- Small Section Tittle -->
                            <div class="small-section-tittle">
                                <h4>Company Information</h4>
                            </div>
                            <span>{{ $data->company_name }}</span>
                            <p>{{ $data->about }}</p>
                            <ul>
                                <li>Name: <span>{{ $data->owner_name }} </span></li>
                                <li>Web : <span> {{ $data->website }}</span></li>
                                <li>Email: <span>{{ $data->com_email }}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- job post company End -->

    </main>
@endsection
