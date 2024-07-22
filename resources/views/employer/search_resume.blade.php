@extends('layouts.master', ['title' => 'Search Resume'])
@section('style')
    <style>
        label {
            font-weight: bold;
        }

        .checkbox-inline {
            color: #888;
            padding-right: 10px;
        }
    </style>
@endsection
@section('content')
    <div class="container mb-2">
        <div class="row">
            <div class="col-md-12">
                <h2>Search Resume</h2>
            </div>
            <div class="col-md-8 border rounded">
                <form method="GET" action="{{route('resume_filter')}}" class="my-2">
                    {{-- @csrf --}}
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="skill">Requirement You are hiring for </label>
                            <div class="">
                                <select class="form-control js-example-basic-multiple" name="skill[]" multiple="multiple"
                                    placeholder="Type to search" style="width: 100%">
                                    @foreach ($skills as $skill)
                                        <option value="{{$skill->skill}}">{{ $skill->skill }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12 form-group">
                            <div id="accordion">
                                <div class="card">
                                    <button type="button" class="border-0 rounded collapsebutton" data-toggle="collapse"
                                        data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"
                                        style="background:#E35E25;">
                                        <div class="card-header text-left" id="headingOne">
                                            {{-- <h5 class="mb-0"> --}}
                                            Advance Search <i class="fas fa-solid fa-caret-up float-right iconclass"></i>
                                            {{-- </h5> --}}
                                        </div>
                                    </button>

                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                        data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="optional_keywords">Any Keywords</label>
                                                        <input class="form-control" type="text" name="optional_keywords"
                                                            placeholder="Optional first name,last name,email,contact,designation role seperated by comma">
                                                    </div>
                                                    <label for="min_exp">Experience</label>
                                                    <div class="row">
                                                        <div class="col-5">
                                                            <div class="form-group">
                                                                <select class="form-control custom-select" id="min_exp"
                                                                    name="min_exp">
                                                                    <option value="">Min</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-2">
                                                            <b>To</b>
                                                        </div>
                                                        <div class="col-5">
                                                            <div class="form-group">
                                                                <select class="form-control custom-select" id="max_exp"
                                                                    name="max_exp">
                                                                    <option value="">Max</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="current_location">Location</label>
                                                        <select class="form-control custom-select location-multiple"
                                                            name="current_location" placeholder="Search or add a location"
                                                            multiple="multiple">
                                                            @foreach ($locations as $location)
                                                                <optgroup label="{{ $location['state'] }}">

                                                                    @for ($i = 0; $i < count($location['location']); $i++)
                                                                        <option
                                                                            value="{{ $location['location'][$i]->location }}">
                                                                            {{ $location['location'][$i]->location }}
                                                                        </option>
                                                                    @endfor
                                                                </optgroup>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="mandate_keywords">All Keywords</label>
                                                        <input class="form-control" type="text" name="mandate_keywords"
                                                            placeholder="Mandatory first name,last name,email,contact,designation role seperated by comma">
                                                    </div>
                                                    <label for="from_salary">Salary (LPA)</label>
                                                    <div class="row">
                                                        <div class="col-5">
                                                            <div class="form-group">
                                                                <input type="number" class="form-control"
                                                                    placeholder="From" name="from_salary" min="0">
                                                            </div>
                                                        </div>
                                                        <div class="col-2">
                                                            <b>To</b>
                                                        </div>
                                                        <div class="col-5">
                                                            <div class="form-group">
                                                                <input type="number" class="form-control" placeholder="To"
                                                                    name="to_salary" min="0">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="excluding_keywords">Excluding Keywords</label>
                                                        <input class="form-control" type="text" name="excluding_keywords"
                                                            placeholder="first name,last name,email,contact,Designation role seperated by comma">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <button type="button" class="border-0 rounded collapsebutton collapsed" data-toggle="collapse"
                                        data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"
                                        style="background:#E35E25;">
                                        <div class="card-header text-left" id="headingTwo">
                                            {{-- <h5 class="mb-0"> --}}
                                            Employment Details <i class="fas fa-solid fa-caret-down float-right iconclass"></i>
                                            {{-- </h5> --}}
                                        </div>
                                    </button>
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                        data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="functionalrole">Functional area</label>
                                                        <select class="form-control custom-select" name="functionalrole"
                                                            id="functionalrole">
                                                            <option value="">Select Functional Area</option>
                                                        </select>

                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="industry">Industry</label>
                                                        <select class="form-control custom-select" name="industry"
                                                            id="industry">
                                                            <option value="">Select Industry</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="company_name">Employers</label><br>
                                                        <select class="company-name-basic-single form-control"
                                                            name="company_name" style="width: 100%" id="company_name">
                                                            <option value="">Select Company</option>

                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="designation">Designation</label>
                                                        <input class="form-control" type="text" name="designation"
                                                            placeholder="Designation">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exclude_company_name">Exclude Employers</label>
                                                        <select class="exclude-company-name-basic-single form-control"
                                                            name="exclude_company_name" style="width: 100%"
                                                            id="exclude_company_name">
                                                            <option value="">Select Company</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="notice_period">Notice Period</label>
                                                        <select class="form-control custom-select" name="notice_period">
                                                            <option value="">Notice Period</option>
                                                            <option value="immediate">Immediate Joining</option>
                                                            <option value="less than 15 Days">
                                                                Less than 15 Days
                                                            </option>
                                                            <option value="currently serving"> Currently Serving</option>
                                                            <option value="15 Days">15 Days</option>
                                                            <option value="1 Month">1 Month</option>
                                                            <option value="2 Month">2 Month</option>
                                                            <option value="3 Month">3 Month</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <button type="button" class="border-0 rounded collapsebutton collapsed" data-toggle="collapse"
                                        data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree"
                                        style="background:#E35E25;">
                                        <div class="card-header text-left" id="headingThree">
                                            {{-- <h5 class="mb-0"> --}}
                                            Educational Details <i class="fas fa-solid fa-caret-down float-right iconclass"></i>
                                            {{-- </h5> --}}
                                        </div>
                                    </button>
                                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                        data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="ug_qualification_name">Qualification</label>
                                                <select class="form-control custom-select" name="ug_qualification_name"
                                                    id="qualifications">
                                                    <option value="">Select Qualification</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="ug_institute_name">Institute Name</label>
                                                <input class="form-control" type="text" name="ug_institute_name"
                                                    placeholder="Name of Institute">
                                            </div>

                                            <div class="form-group">
                                                <label for="ug_education_type">Education Type</label>
                                                <select class="form-control custom-select" name="ug_education_type">
                                                    <option value="">Select Education Type</option>
                                                    <option>Full time</option>
                                                    <option>Part time </option>
                                                    <option>Correspondence</option>
                                                    <option>Distance</option>
                                                </select>
                                            </div>

                                            <label for="start_graduation">Passing Years Between</label>
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <center><b>From</b></center>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">

                                                        <select class="form-control custom-select" name="start_graduation"
                                                            id="start_graduation">
                                                            <option value="">From</option>
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="col-sm-2">
                                                    <center><b>To</b></center>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <select class="form-control custom-select" name="to_graduation"
                                                            id="to_graduation">
                                                            <option value="">To</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <button type="button" class="border-0 rounded collapsebutton collapsed" data-toggle="collapse"
                                        data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour"
                                        style="background:#E35E25;">
                                        <div class="card-header text-left" id="headingFour">
                                            {{-- <h5 class="mb-0"> --}}
                                            Additional Details <i class="fas fa-solid fa-caret-down float-right iconclass"></i>
                                            {{-- </h5> --}}
                                        </div>
                                    </button>
                                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour"
                                        data-parent="#accordion">
                                        <div class="card-body">
                                            {{-- Start static content --}}
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1">Candidate Category</label>
                                                <select class="form-control custom-select">
                                                    <option value="">Select Category</option>
                                                    <option>General</option>
                                                    <option>OBC-Creamy </option>
                                                    <option>OBC-NonCreamy</option>
                                                    <option>SC</option>
                                                    <option>ST</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1">Gender</label><br>
                                                <select class="form-control custom-select" v-model="form.gender">
                                                    <option value="" disabled>Select Here</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                    <option value="other">Others</option>
                                                    <option value="all">All</option>
                                                </select>
                                            </div>

                                            {{-- End static content --}}
                                            <label for="min_age">Candidate Age(In years)</label>
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <center><b>From</b></center>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <input type="number" class="form-control" name="min_age"
                                                            min="19" max="59">
                                                    </div>

                                                </div>
                                                <div class="col-sm-2">
                                                    <center><b>To</b></center>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">

                                                        <input type="number" class="form-control" name="max_age"
                                                            min="19" max="60">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <button type="button" class="border-0 rounded collapsebutton collapsed" data-toggle="collapse"
                                        data-target="#collapseFifth" aria-expanded="false" aria-controls="collapseFifth"
                                        style="background:#E35E25;">
                                        <div class="card-header text-left" id="headingFifth">
                                            {{-- <h5 class="mb-0"> --}}
                                            Display Details  <i class="fas fa-solid fa-caret-down float-right iconclass"></i>
                                            {{-- </h5> --}}
                                        </div>
                                    </button>
                                    <div id="collapseFifth" class="collapse" aria-labelledby="headingFifth"
                                        data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label>Show</label><br>
                                                <label class="checkbox-inline" for="checkednew">
                                                    <input type="checkbox" id="new" value="new"
                                                        name="checkednew">
                                                    New Registrations</label>
                                                <label class="checkbox-inline" for="checkedmodified">
                                                    <input type="checkbox" id="modified" value="modified"
                                                        name="checkedmodified"> Modified
                                                    Candidates</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1">Show Only Candidates
                                                    with</label><br>
                                                <label class="checkbox-inline"><input type="checkbox" value="">
                                                    Verified Mobile Number</label>
                                                <label class="checkbox-inline"><input type="checkbox" value="">
                                                    Verified Email ID</label>
                                                <label class="checkbox-inline"><input type="checkbox" value="">
                                                    Attached Resume</label>
                                            </div>
                                            <div class="row">

                                                <div class="col-md-3">
                                                    <b><label for="resume_per_page">Resume Per Page</label></b>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <select class="form-control custom-select" name="resume_per_page">
                                                            <option value="">Select</option>
                                                            <option value="10">10</option>
                                                            <option value="20">20</option>
                                                            <option value="40">40</option>
                                                            <option value="60">60</option>
                                                            <option value="80">80</option>
                                                            <option value="160">160</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <label for="active_in" style="line-height:2;">Active in</label>
                                        </div>
                                        <div class="col-sm-4"><select class="custom-select" name="active_in">
                                                <option value="">Select</option>
                                                <option value="1">1 Day</option>
                                                <option value="3">3 Days</option>
                                                <option value="7">7 days</option>
                                                <option value="15">15 days</option>
                                                <option value="30">1 Month</option>
                                                <option value="60">2 Months</option>
                                                <option value="90">3 Months</option>
                                                <option value="120">4 Months</option>
                                                <option value="180">6 Months</option>
                                                <option value="365">1 Year</option>
                                            </select></div>
                                    </div>

                                </div>
                                <div class="col-sm-6 d-flex justify-content-end">
                                    <button type="submit" class="btn">Search</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="col-md-4">
                <div class="card" style="width: 18rem;">
                    <div class="card-header">
                        Saved Search
                    </div>
                    <ul class="list-group list-group-flush">
                        @forelse ($savedSearches as $searches)
                        <li class="list-group-item"><a href="{{$searches->url}}" class="" style="color: #f95602;">{{$searches->search_name}}</a><span class="float-right badge badge-light text-light round bg-dark">{{date('d-M-Y', strtotime($searches->created_at))}}</span></li>
                        @empty
                             
                        @endforelse
                       
                    </ul>
                </div>
            </div>
        </div>
    </div>
    {{-- </div> --}}
@endsection
@section('script')
    <script src="{{ asset('assets/js/search_resume.js') }}"></script>
@endsection
