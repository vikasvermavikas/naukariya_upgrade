@extends('layouts.master', ['title' => 'Profile Stage'])
@section('style')
    {{-- <link rel="stylesheet" href="{{asset('assets/css/jobseeker/fontawesome.css')}}" --}}

    <link rel="stylesheet" href="{{ asset('assets/css/jobseeker.css') }}">
@endsection
@section('content')
    <div class="container-fluid wrapper_parent">
        <div class="row">
            <div class="col-12 ">
                <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                    <p>Fill all form field to go to next step</p>
                    <form id="msform">
                        <!-- Inside the Ms Form all the field forms   -->
                        <!-- progressbar -->
                        <ul id="progressbar">
                            <li class="active" id="account"><strong>Profile</strong></li>
                            <li id="personal"><strong>Education</strong></li>
                            <li id="payment"><strong>Professional</strong></li>
                            <li id="confirm"><strong>Skills</strong></li>
                            <li id="certificate"><strong>Certificate </strong></li>
                        </ul>


                        <div class="profile_container">

                            <form id="formData" class="form" enctype="multipart/form-data" method="POST">
                                @csrf
                                <fieldset id="field-1" class="tab">
                                    <h1>Profile</h1>
                                    <h2 class="steps">Step 1 -5</h2>
                                    <div class="card-outer">
                                        <div class="row mb-2">
                                            <div class="col-sm-3">
                                                <div class="profile-pic m-0">
                                                    <label
                                                        style="display: flex; justify-content: center; align-items: center;">
                                                        @if ($data->profile_pic_thumb)
                                                            <img src="{{ asset('jobseeker_profile_image/' . $data->profile_pic_thumb . '') }}"
                                                                class="img-fluid rounded w-50" alt="">
                                                        @else
                                                            <img id="previewImg"
                                                                src="https://i.pinimg.com/736x/aa/c9/4e/aac94e41310947cbcd5f38a41ccc0132.jpg"
                                                                style="width: 150px; height: 150px; border: 1px solid white;">
                                                        @endif

                                                        <input id="file-input" name="image" accept="image/*"
                                                            type="file" class="d-none">
                                                        <button class="d-none" id="upload-btn" value="upload-image">
                                                            Upload!</button>
                                                        <i id="cam" class="fas fa-camera"
                                                            style="margin-top: 180px; position: relative; left: -85px;"></i>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-sm-9 d-sm-flex m-0 p-0">
                                                <div class="col-sm-6 m-0 p-0">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label> <span style="color: red;"> * </span>First Name</label>
                                                            <input type="text" name="fname"
                                                                placeholder="Enter First Name" class="tab1"
                                                                data-id="fname_error" id="fname"
                                                                value="{{ $data->fname }}" min="2" max="10"
                                                                required>
                                                            <small id="fname_error" class="text-danger"></small>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-12">
                                                        <label for="" class="col-form-label"> <span
                                                                style="color: red;"> * </span>Email </label>
                                                        <input type="email" name="email" placeholder="Enter Email"
                                                            class="tab1" value="{{ $data->email }}" data-id="email_error"
                                                            id="email" required>
                                                        <small id="email_error" class="text-danger"></small>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 m-0 p-0">
                                                    <div class="col-sm-12">
                                                        <label> <span style="color: red;"> * </span> Last Name </label>
                                                        <input type="text" name="lname" class="tab1"
                                                            placeholder="Enter Last Name" value="{{ $data->lname }}"
                                                            data-id="lname_error" id="lname" required>
                                                        <small id="lname_error" class="text-danger"></small>
                                                    </div>

                                                    <div class="col-sm-12" id="contact-id">
                                                        <label><span style="color: red;"> * </span> Contact No </label>
                                                        <input type="text" name="contact_no"
                                                            placeholder="Enter Full Contact No" class="tab1 form-control"
                                                            data-id="phone_error" id="phone"
                                                            value="{{ $data->contact }}" required>
                                                        <small id="phone_error" class="text-danger"></small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <label><span style="color: red;">*</span> Designation</label>
                                                <input type="text" name="designation" placeholder="Enter Designation"
                                                    class="tab1" data-id="Designation_error" id="Designation"
                                                    value="{{ $data->designation }}" required>
                                                <small id="Designation_error" class="text-danger"></small>
                                            </div>

                                            <div class="col-sm-4">
                                                <label for="date"><span style="color: red;">*</span> Date Of
                                                    Birth</label>
                                                <div class="vd-wrapper">
                                                    <input name="date" placeholder="YYYY-MM-DD" type="date"
                                                        aria-readonly="true" class="tab1" data-id="date_error"
                                                        id="date" value="{{ $data->dob }}" required>
                                                    <small id="date_error" class="text-danger"></small>

                                                </div>
                                            </div>
                                            <div class="col-sm-4  gender">
                                                <label><span style="color: red;">*</span> Gender</label>
                                                <div class="genderselect">
                                                    <select name="gender" class="tab1" data-id="gender_error"
                                                        id="Gender" required>
                                                        <option value="">Select Gender</option>
                                                        <option value="male"
                                                            {{ $data->gender == 'male' ? 'selected' : '' }}>Male</option>
                                                        <option value="female"
                                                            {{ $data->gender == 'female' ? 'selected' : '' }}>Female
                                                        </option>
                                                        <option value="others"
                                                            {{ $data->gender == 'others' ? 'selected' : '' }}>Others
                                                        </option>

                                                    </select>
                                                    <small id="gender_error" class="text-danger"></small>

                                                </div>
                                            </div>

                                            <!-- Experience section -->
                                            <div class="col-sm-2 currentsal">
                                                <label class="col-form-label w-100  experince-level"><span
                                                        style="color: red;">*</span> Experience </label>
                                                <div class="experince-level"></div>
                                                <input type="number" name="exp_year" placeholder="Years" class="tab1"
                                                    data-id="years_error" id="year" max="19" min="0"
                                                    value="{{ $data->exp_year }}" required>
                                                <small id="years_error" class="text-danger"></small>
                                            </div>
                                            <div class="col-sm-2">
                                                <label for="" class="">
                                                    <span class="g">
                                                    </span>

                                                </label>
                                                <input type="number" name="exp_mon" placeholder="Months" class="tab1"
                                                    data-id="month_error" id="month" min="1" max="12"
                                                    value="{{ $data->exp_month }}" required>
                                                <small id="month_error" class="text-danger"></small>
                                            </div>

                                            <div class="col-sm-4 select_ind_col">
                                                <label><span style="color: red;">*</span> Select Industry</label>
                                                <div class="select_ind">
                                                    <select name="job_industry_id" class="tab1"
                                                        data-id="industry_error" id="factory" required>
                                                        <option value="">Select Industry</option>
                                                        @foreach ($industries as $item)
                                                            <option value="{{ $item->id }}"
                                                                {{ $item->id == $data->industry_id ? 'selected' : '' }}>
                                                                {{ $item->category_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <small id="industry_error" class="text-danger"></small>

                                                </div>
                                            </div>

                                            <div class="col-sm-4">
                                                <label><span style="color: red;">*</span> Select Functional area</label>
                                                <div class="select_functionl"></div>
                                                <select name="job_functional_role_id" class="tab1"
                                                    data-id="functional_error" id="Area" required>
                                                    <option value="">
                                                        Select Area
                                                    </option>
                                                    @foreach ($functional_roles as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ $item->id == $data->functionalrole_id ? 'selected' : '' }}>
                                                            {{ $item->subcategory_name }}</option>
                                                    @endforeach
                                                </select>
                                                <small id="functional_error" class="text-danger"></small>
                                            </div>

                                            <div class="col-sm-2 currentsal">

                                                <label class="col-form-label w-100"><span style="color: red;">*</span> Cur
                                                    Salary(LPA) </label>
                                                <input type="number" name="curr_sal" placeholder="Current Salary"
                                                    class="tab1" data-id="cursalary_error" id="current salary"
                                                    value="{{ $data->current_salary }}" min="0" required>
                                                <small id="cursalary_error" class="text-danger"></small>
                                            </div>

                                            <!-- Expected Salary -->

                                            <div class="col-sm-2 currentsal">
                                                <label class="col-form-label w-100"><span style="color: red;">*</span> Exp
                                                    Salary(LPA) </label>
                                                <input type="number" name="exp_sal" placeholder="Expe Salary"
                                                    class="tab1" data-id="expsalary_error" id="exp salary"
                                                    value="{{ $data->expected_salary }}" min="0" required>
                                                <small id="expsalary_error" class="text-danger"></small>
                                            </div>
                                            <div class="col-sm-4">
                                                <label class="col-form-label"><span style="color: red;">*</span> Notice
                                                    Period</label>

                                                <div class="notice_period_new">

                                                    <select name="notice_period" data-id="notice-period-error"
                                                        id="notice error" class='tab1' required>
                                                        <option value="">Select Notice Period</option>
                                                        <option value="Currently Serving"
                                                            {{ $data->notice_period == 'Currently Serving' ? 'selected' : '' }}>
                                                            Currently Serving</option>
                                                        <option value="1-15 Days"
                                                            {{ $data->notice_period == '1-15 Days' ? 'selected' : '' }}>
                                                            1-15
                                                            Days</option>
                                                        <option value="1 Month"
                                                            {{ $data->notice_period == '1 Month' ? 'selected' : '' }}>1
                                                            Month</option>
                                                        <option value="2 Months"
                                                            {{ $data->notice_period == '2 Months' ? 'selected' : '' }}>2
                                                            Months</option>
                                                        <option value="3 Months"
                                                            {{ $data->notice_period == '3 Months' ? 'selected' : '' }}>3
                                                            Months</option>
                                                    </select>
                                                    <small id="notice-period-error" class="text-danger"></small>

                                                </div>

                                            </div>
                                            <div class="col-sm-4">

                                                <label> <span style="color: red;">*</span> Preferred Location </label>
                                                <select class="location-multiple" name="locationlist[]"
                                                    multiple="multiple" value="{{ $data->preferred_location }}" required>
                                                    @foreach ($locations as $location)
                                                        <optgroup label="{{ $location['state'] }}">

                                                            @for ($i = 0; $i < count($location['location']); $i++)
                                                                <option value="{{ $location['location'][$i]->location }}"
                                                                    {{ in_array($location['location'][$i]->location, explode(',', $data->preferred_location)) ? 'selected' : '' }}>
                                                                    {{ $location['location'][$i]->location }}
                                                                </option>
                                                            @endfor
                                                        </optgroup>
                                                    @endforeach
                                                </select>
                                                <small id="Loaction_error" class="text-danger"></small>

                                            </div>
                                            <div class="col-sm-3 resume">

                                                <label for="resume" class="col-form-label">
                                                    <span style="color: red;"> * </span>Resume</label>
                                                <i aria-hidden="true" class="fa fa-info ml-2 mr-1"></i>

                                                @if ($getresume->resume)
                                                    <input type="file" name="resume" id="file"
                                                        accept="application/pdf,application/msword,
                                                application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                                                        data-id="file_error">
                                                @else
                                                    <input type="file" name="resume" id="file"
                                                        accept="application/pdf,application/msword,
                                                application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                                                        data-id="file_error" class="tab1" required>
                                                @endif

                                                <small id="file_error" class="text-danger"></small>


                                                <span>
                                                    @if ($getresume->resume)
                                                        <a href="{{ asset('resume/' . $getresume->resume) }}"
                                                            class="btn btn-primary">
                                                            <i class="fas fa-download"></i>
                                                            Download Resume</a>
                                                    @endif

                                                </span>
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="linkedin" class="col-form-label">Linkedin Profile Link</label>
                                                <input type="text" name="linkedin" placeholder="Enter Linkedin Link"
                                                    id="linkdln" class="linkdln-1" value="{{ $data->linkedin }}">
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="password" class="col-form-label">Password</label>
                                                <input type="password" minlength="8" name="password"
                                                    placeholder="Enter your password">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <button type="button" class="btn btn-primary mt-4">Save</button> --}}
                                    <button type="submit" class="btn btn-primary mt-4 ml-5" id="home-next">Save &
                                        Next</button>
                                </fieldset>
                            </form>


                            <!-- fieldsets 2 -->
                            <fieldset class="tab" id="field-2">
                                <h1>Education</h1>
                                <div class="card-outer">
                                    <form class="form" id="education_form" method="POST">
                                        <div class="container" style="width: 100%; height: auto;">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h2 class="steps">Step 2 -5</h2>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="container fieldSet-2" style="height: auto; width: 100%;">
                                            <div class="row">
                                                <div class="col">

                                                    <label>
                                                        <span style="color: red;"> *</span>
                                                        Qualification
                                                    </label>

                                                    <select class="tab2 form-control" data-id="qualification-error"
                                                        id="qualification" name="degree" required>
                                                        <option value="">Select Qualification</option>
                                                        @foreach ($qualifications as $qualification)
                                                            <option value="{{ $qualification->qualification }}"
                                                                {{ isset($educationDetails->degree_name) &&  $educationDetails->degree_name == $qualification->qualification ? 'selected' : '' }}>
                                                                {{ $qualification->qualification }}</option>
                                                        @endforeach
                                                    </select>
                                                    <small id="qualification-error" class="text-danger"></small>

                                                </div>
                                                <div class="col">
                                                    <label>
                                                        <span style="color: red;"> *</span>
                                                        Course type
                                                    </label>
                                                    <select class="form-control tab2" name="course_type"
                                                        data-id="course-error" id="course" required>
                                                        <option value="">Select Course Type</option>
                                                        <option value="Full Time"
                                                            {{ isset($educationDetails->course_type) &&  $educationDetails->course_type == 'Full Time' ? 'selected' : '' }}>
                                                            Full Time</option>
                                                        <option value="Part Time"
                                                            {{isset($educationDetails->course_type) &&  $educationDetails->course_type == 'Part Time' ? 'selected' : '' }}>
                                                            Part Time</option>
                                                        <option value="Distance Learning Program"
                                                            {{ isset($educationDetails->course_type) &&  $educationDetails->course_type == 'Distance Learning Program' ? 'selected' : '' }}>
                                                            Distance Learning Program
                                                        </option>
                                                    </select>
                                                    <small id="course-error" class="text-danger"></small>

                                                </div>
                                                <div class="col">
                                                    <label>
                                                        <span style="color: red;"> *</span>
                                                        Percentage(%)
                                                    </label>
                                                    <input type="number" min="1" step="0.01" class="tab2"
                                                        data-id="Percentage-error" id="Percentage"
                                                        placeholder="Enter Percentage %" name="percentage" value="{{isset($educationDetails->percentage_grade) ? $educationDetails->percentage_grade : ''}}" required>
                                                    <small id="Percentage-error" class="text-danger"></small>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="container" style= "height: auto; width: 100%;">

                                            <div class="row">
                                                <div class="col">
                                                    <label>
                                                        <span style="color: red;"> *</span>Passing year
                                                    </label>
                                                    <input type="number" name="pass_year" placeholder="Select year"
                                                        min="{{ date('Y') - 20 }}" max="{{ date('Y') }}"
                                                        data-id="Syear-error" id="syear" class="tab2"  value="{{ isset($educationDetails->passing_year) ? $educationDetails->passing_year : ''}}"/>
                                                    <small id="Syear-error" class="text-danger"></small>
                                                </div>
                                                <div class="col">
                                                    <label>
                                                        <span style="color: red;"> *</span>University/College/Institute
                                                    </label>
                                                    <input type="text" placeholder="University/College/Institute Name"
                                                        class="tab2" name="ins_name" data-id="college-error"
                                                        id="college" value="{{ isset($educationDetails->institute_name) ?  $educationDetails->institute_name : ''}}" required />
                                                    <small id="college-error" class="text-danger"></small>
                                                </div>
                                                <div class="col">
                                                    <label>
                                                        <span style="color: red;"> *</span>Institute Loaction
                                                    </label>
                                                    <input type="text" placeholder="Enter Loaction" class="tab2"
                                                        data-id="loaction-error" name="ins_loc" id="loaction" value="{{isset($educationDetails->institute_location) ? $educationDetails->institute_location : ''}}"
                                                        required />
                                                    <small id="loaction-error" class="text-danger"></small>
                                                </div>

                                            </div>

                                        </div>
                                        <button type="button" class="btn btn-primary mt-4"
                                            id="home-prev">Previous</button>
                                        <button type="submit" class="btn btn-primary mt-4 ml-5 " id="home-next-2">Save &
                                            Next</button>
                                    </form>
                                </div>

                            </fieldset>

                            <!-- field set-3 -->

                            <fieldset id="field-3" class="tab">
                                <h1>Professional</h1>
                                <div class="card-outer">
                                    <div class="container" style="height: auto; width: 100%;">
                                        <div class="row">

                                            <div class="col"
                                                style="display: flex; justify-content: center; align-items: center;">
                                                <div style="display: flex; gap: 10px;">
                                                    <label>
                                                        Select Item:-
                                                    </label>



                                                    <label style="display: flex; gap: 10px">
                                                        <input type="radio" name="exp" style="margin-top: 7px;"
                                                            class="tab3" data-id="inernship-error" id="internship">
                                                        Internship
                                                        <small id="inernship-error" class="text-danger"></small>
                                                    </label>
                                                    <label style="display: flex; gap: 10px">
                                                        <input type="radio" name="exp" class="tab3"
                                                            data-id="fresher-error" id="fresher">
                                                        Fresher
                                                        <small id="fresher-error" class="text-danger"></small>
                                                    </label>
                                                    <label style="display: flex; gap: 10px">
                                                        <input type="radio" name="exp" data-id="experi-error"
                                                            id="experience">
                                                        Experienced
                                                        <small id="experi-error" class="text-danger"></small>
                                                    </label>


                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="container" style= "width: 100%;">
                                        <div class="row">
                                            <div class="col">
                                                <label>
                                                    <span style="color: red;">*</span>
                                                    Designation
                                                </label>
                                                <input type="text" placeholder="Enter Designation"
                                                    data-id="designation-error" id="designation" class="tab3" />
                                                <small id="designation-error" class="text-danger"></small>
                                            </div>
                                            <div class="col">
                                                <label>
                                                    <span style="color: red;">*</span>
                                                    Organization Name
                                                </label>
                                                <input type="text" placeholder="Enter Organization"
                                                    data-id="Organization-error" id="Organization" class="tab3" />
                                                <small id="Organization-error" class="text-danger"></small>
                                            </div>
                                            <div class="col">
                                                <label>
                                                    <span style="color: red;">*</span>
                                                    Job Type
                                                </label>
                                                <input type="text" placeholder="Enter Job Type" class="tab3"
                                                    id="job" data-id="job-error" />
                                                <small id="job-error" class="text-danger"></small>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="container">
                                        <div class="row">
                                            <div class="col">


                                                <label><span style="color: red;">*</span> From:</label>
                                                <input type="date" class="tab3" id="date"
                                                    data-id="date-error">
                                                <small id="date-error" class="text-danger"></small>

                                            </div>
                                            <div class="col">
                                                <label><span style="color: red;">*</span> To:</label>
                                                <input type="date" data-id="date2-error" id="todate"
                                                    class="tab3">
                                                <small id="date2-error" class="text-danger"></small>

                                            </div>
                                            <div class="col">
                                                <label>
                                                    <span style="color: red;">*</span>

                                                    Salary(LPA)


                                                </label>
                                                <input type="number" placeholder="Enter Salary" id="salary"
                                                    data-id="salary-error" class="tab3" />
                                                <small id="salary-error" class="text-danger"></small>


                                            </div>
                                        </div>
                                    </div>
                                    <div class="container" style= "width: 100%;">
                                        <div class="row">
                                            <div class="col" style="max-width: 33.5%;">
                                                <label>
                                                    <span style="color: red;">*</span>

                                                    Key Skills
                                                </label>
                                                <input type="text" placeholder="Enter Key Skills"
                                                    data-id="skills-error" class="tab3" id="skills" />
                                                <small id="skills-error" class="text-danger"></small>
                                            </div>
                                            <div class="col" style="max-width: 33.5%">
                                                <label>
                                                    <span style="color: red;">*</span>

                                                    Responsibility
                                                </label>
                                                <input type="text" placeholder="Enter Responsibility"
                                                    data-id="responsblity-error" class="tab3" id="Responsibility" />
                                                <small id="responsblity-error" class="text-danger"></small>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <button type="button" class="btn btn-primary mt-4" id="Third-prev">Previous</button>
                                <button type="button" class="btn btn-primary mt-4 ml-5 " id="Third-next">Next</button>
                            </fieldset>

                            <!-- field set-4 -->

                            <fieldset id="field-4" class="tab">
                                <h1>Skills</h1>
                                <div class="card-outer">
                                    <div class="container" style="height: auto; width: 100%;">
                                        <div class="row">
                                            <div class="col-12">
                                                <h2 class="steps">Step 4 -5</h2>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="container"
                                        style="height: auto; width: 100%; display: flex; align-items: center;justify-content: center;">
                                        <div class="row" style="width: 50%;">
                                            <div class="col">
                                                <label>
                                                    Add Skills
                                                </label>
                                                <input type="text" placeholder="Add Skills" id="skills" />
                                                <small id="skillstab-error" class="text-danger"></small>
                                            </div>
                                        </div>
                                    </div>

                                </div>




                                <button type="button" class="btn btn-primary mt-4" id="Fourth-prev">Previous</button>
                                <button type="button" class="btn btn-primary mt-4 ml-5 " id="Fourth-next">Next</button>
                            </fieldset>

                            <!-- Field-set 5 -->

                            <fieldset id="field-5" class="tab">
                                <form action="">
                                    <h1>Certificate</h1>
                                    <div class="card-outer">
                                        <div class="container" style="width: 100%; height: auto;">
                                            <div class="row">
                                                <div class="col">
                                                    <h2 class="steps">Step 5-5</h2>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="container" style=" width: 100%; height: auto;">
                                            <div class="row">
                                                <div class="col">
                                                    <label>
                                                        <span style="color: red;">*</span>
                                                        Course Name
                                                    </label>
                                                    <input type="text" placeholder="Enter Course Name"
                                                        data-id="CourseName-error" id="CourseName" class="tab5" />
                                                    <small id="CourseName-error" class="text-danger"></small>

                                                </div>
                                                <div class="col">
                                                    <label>
                                                        <span style="color: red;">*</span>
                                                        Institute Name
                                                    </label>
                                                    <input type="text" placeholder="Enter Institute Name"
                                                        data-id="institute-error" id="institute-name" class="tab5" />
                                                    <small id="institute-error" class="text-danger"></small>

                                                </div>
                                                <div class="col">
                                                    <label>
                                                        <span style="color: red;">*</span>
                                                        Certificate licence
                                                    </label>
                                                    <input type="text" placeholder="Enter Certificate licence"
                                                        data-id="certificate-licence-error" class="tab5"
                                                        id="certificate licence" />
                                                    <small id="certificate-licence-error" class="text-danger"></small>


                                                </div>
                                            </div>
                                        </div>

                                        <div class="container" style=" width: 100%; height: auto;">
                                            <div class="row">
                                                <div class="col" style="max-width: 33.5%;">
                                                    <label>
                                                        <span style="color: red;">*</span>
                                                        Certification Type
                                                    </label>

                                                    <input type="text" class="tab5"
                                                        data-id="certification-type-error" id="certificate type">

                                                    <small id="certification-type-error" class="text-danger"></small>



                                                </div>
                                                <div class="col" style="max-width: 80%;">
                                                    <label for="start-date">
                                                        <span style="color: red;">*</span>
                                                        Time Period
                                                    </label>
                                                    <br>

                                                    <div style="display: flex; gap:15px;">



                                                        <input type="date" name="start-date" required class="tab5"
                                                            data-id="time-error" id="time">
                                                        <small id="time-error" class="text-danger"></small>



                                                        <input type="date" name="end-date" required class="tab5"
                                                            data-id="endtime-error" id="end time">
                                                        <small id="endtime-error" class="text-danger"></small>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container" style= "height: auto; width: 100%;">
                                            <div class="row">
                                                <div class="col" style="max-width: 33.5%;">
                                                    <label>
                                                        Certificate Link(optional)
                                                    </label>
                                                    <input type="text" placeholder="Enter Certificate Link" />
                                                </div>
                                                <div class="col" style="max-width: 35%;">
                                                    <label>
                                                        Description(Optional)
                                                    </label>
                                                    <textarea style="height:2.5em;"> Some Text...</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-primary mt-4 ml-5"
                                        id="Fifth-prev">Previous</button>

                                    <button type="button" class="btn btn-primary mt-4 ml-5 "
                                        id="Submit">Submit</button>
                                </form>
                            </fieldset>


                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        // Validation
        $(document).ready(function() {
            $('.location-multiple').select2();

            var abc = 0;
            var bcd = [];

            // first name

            $('#fname').keypress(function(e) {
                var regex = new RegExp("^[a-zA-Z]+$");
                var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
                if (regex.test(str)) {
                    $('#fname_error').html('');
                    return true;
                } else {
                    e.preventDefault();
                    $('#fname_error').html('please enter only character');
                    return false;
                }
            });

            // last name


            $('#lname').keypress(function(e) {
                var regex = new RegExp("^[a-zA-Z]+$");
                var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
                if (regex.test(str)) {
                    $('#lname_error').html('');
                    return true;
                } else {
                    e.preventDefault();
                    $('#lname_error').html('please enter only character');
                    return false;
                }
            });

            // email  

            $(document).ready(function() {
                $('#email').on('input', function() {
                    var email = $(this).val();
                    var regex = /^([a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})$/;

                    if (regex.test(email)) {
                        $('#email_error').html('');
                    } else {
                        $('#email_error').html('Please enter a valid email');
                    }
                });
            });


            // contact

            $('#phone').keypress(function(e) {
                if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) {
                    $('#phone_error').html('Please enter only digits.');
                    return false;

                } else {
                    $('#phone_error').html('');

                }
                if ($(this).val().length >= 10) {
                    $('#phone_error').html('');
                    return false;
                }
            });

            // Designation
            $('#Designation').keypress(function(e) {
                var regex = new RegExp("^[a-zA-Z]+$");
                var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
                if (regex.test(str)) {
                    $('#Designation_error').html('');
                    return true;
                } else {
                    e.preventDefault();
                    $('#Designation_error').html('please enter only character');
                    return false;
                }
            });

            // prefered loaction

            $('#Loaction').keypress(function(e) {
                var regex = new RegExp("^[a-zA-Z]+$");
                var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
                if (regex.test(str)) {
                    $('#Loaction_error').html('');
                    return true;
                } else {
                    e.preventDefault();
                    $('#Loaction_error').html('please enter only character');
                    return false;
                }
            });




            // Education validation for character

            // Qualification

            $('#qualification').keypress(function(e) {
                var regex = new RegExp("^[a-zA-Z]+$");
                var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
                if (regex.test(str)) {
                    $('#qualification-error').html('');
                    return true;
                } else {
                    e.preventDefault();
                    $('#qualification-error').html('please enter only character');
                    return false;
                }
            });

            // course


            $('#course').keypress(function(e) {
                var regex = new RegExp("^[a-zA-Z]+$");
                var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
                if (regex.test(str)) {
                    $('#course-error').html('');
                    return true;
                } else {
                    e.preventDefault();
                    $('#course-error').html('please enter only character');
                    return false;
                }
            });

            // passsing year
            $('#syear').keypress(function(e) {
                if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) {
                    $('#Syear-error').html('Please enter only digits.');
                    return false;

                } else {
                    $('#Syear-error').html('');

                }
                if ($(this).val().length >= 4) {
                    $('#Syear-error').html('');
                    return false;
                }
            });

            // university
            $('#college').keypress(function(e) {
                var regex = new RegExp("^[a-zA-Z]+$");
                var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
                if (regex.test(str)) {
                    $('#college-error').html('');
                    return true;
                } else {
                    e.preventDefault();
                    $('#college-error').html('please enter only character');
                    return false;
                }
            });

            // Institute loaction

            $('#loaction').keypress(function(e) {
                var regex = new RegExp("^[a-zA-Z]+$");
                var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
                if (regex.test(str)) {
                    $('#loaction-error').html('');
                    return true;
                } else {
                    e.preventDefault();
                    $('#loaction-error').html('please enter only character');
                    return false;
                }
            });

            // profssional Fieldset

            // Designation


            $('#designation').keypress(function(e) {
                var regex = new RegExp("^[a-zA-Z]+$");
                var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
                if (regex.test(str)) {
                    $('#designation-error').html('');
                    return true;
                } else {
                    e.preventDefault();
                    $('#designation-error').html('please enter only character');
                    return false;
                }
            });

            // Organization Name
            $('#Organization').keypress(function(e) {
                var regex = new RegExp("^[a-zA-Z]+$");
                var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
                if (regex.test(str)) {
                    $('#Organization-error').html('');
                    return true;
                } else {
                    e.preventDefault();
                    $('#Organization-error').html('please enter only character');
                    return false;
                }
            });

            // Job type
            $('#job').keypress(function(e) {
                var regex = new RegExp("^[a-zA-Z]+$");
                var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
                if (regex.test(str)) {
                    $('#job-error').html('');
                    return true;
                } else {
                    e.preventDefault();
                    $('#job-error').html('please enter only character');
                    return false;
                }
            });


            // salary LPA

            $('#salary').keypress(function(e) {
                if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) {
                    $('#Syear-error').html('Please enter only digits.');
                    return false;

                } else {
                    $('#salary-error').html('');

                }
                if ($(this).val().length >= 7) {
                    $('#salary-error').html('');
                    return false;
                }
            });
            // key skills professional

            $('#skills').keypress(function(e) {
                var regex = new RegExp("^[a-zA-Z]+$");
                var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
                if (regex.test(str)) {
                    $('#skills-error').html('');
                    return true;
                } else {
                    e.preventDefault();
                    $('#skills-error').html('please enter only character');
                    return false;
                }
            });
            // Responsblity

            $('#Responsibility').keypress(function(e) {
                var regex = new RegExp("^[a-zA-Z]+$");
                var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
                if (regex.test(str)) {
                    $('#responsblity-error').html('');
                    return true;
                } else {
                    e.preventDefault();
                    $('#responsblity-error').html('please enter only character');
                    return false;
                }
            });


            // Certificate inputs fields validation

            // Certificate Course name

            $('#CourseName').keypress(function(e) {
                var regex = new RegExp("^[a-zA-Z]+$");
                var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
                if (regex.test(str)) {
                    $('#CourseName-error').html('');
                    return true;
                } else {
                    e.preventDefault();
                    $('#CourseName-error').html('please enter only character');
                    return false;
                }
            });

            // Certificate Institute name

            $('#institute-name').keypress(function(e) {
                var regex = new RegExp("^[a-zA-Z]+$");
                var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
                if (regex.test(str)) {
                    $('#institute-error').html('');
                    return true;
                } else {
                    e.preventDefault();
                    $('#institute-error').html('please enter only character');
                    return false;
                }
            });


            // $('#home-next').click(function() {
            $("form#msform").submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                bcd = [];

                // Server side validation.
                $(".tab1").each(function(index) {

                    if ($(this).val() == "") {
                        var error = $(this).data('id');
                        var id = $(this).attr('id');
                        var classes = $(this).attr('class');
                        //  alert(error)
                        $('#' + error).html('Please fill ' + id);

                        abc = 0;

                        bcd.push(abc);
                    } else {
                        var id = $(this).attr('id');
                        //  alert(id)
                        var error = $(this).data('id');
                        $('#' + error).html('');
                        abc = 1;
                        bcd.push(abc);

                    }
                });

                if ($.inArray(0, bcd) > -1) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Please fill all required fields",
                    });
                } else {

                    // Submit profile form.
                    $.ajax({
                        url: SITE_URL + "/jobseeker/persnol-save",
                        type: "POST",
                        data: formData,
                        success: function(response) {
                            if (response.status) {

                                // Update stage.
                                $.ajax({
                                    url: SITE_URL + "/jobseeker/skip-stage/1",
                                    type: 'GET',
                                    success: function(response) {

                                    }
                                });

                                Swal.fire({
                                    icon: "success",
                                    title: "Thank you!",
                                    text: "Your profile updated successfully",
                                });
                            }
                            // // Reset the form
                            $('#field-2').show();
                            $('#field-1').hide();
                            $('#personal').addClass('active');
                        },
                        cache: false,
                        contentType: false,
                        processData: false

                    });


                }

            })

            // Home previous button

            $('#home-prev').click(function() {
                $('#field-2').hide();
                $('#field-1').show();
                $('#personal').removeClass('active')

            })

            // Education next btn

            var abc = 0;
            var bcd = [];

            // $("#home-next-2").click(function() {
            $("form#education_form").submit(function(e) {
                e.preventDefault();
                bcd = []
                $(".tab2").each(function(index) {

                    if ($(this).val() == "") {
                        var error = $(this).data('id');
                        var id = $(this).attr('id');
                        var classes = $(this).attr('class');
                        // alert(classes)
                        // alert(id)
                        $('#' + error).html('Please fill ' + id);
                        abc = 0;
                        bcd.push(abc);
                    } else {
                        $('#' + error).html('');
                        var error = $(this).data('id');
                        $('#' + error).html('');
                        abc = 1;
                        bcd.push(abc);


                    }
                });

                if ($.inArray(0, bcd) > -1) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Please fill all required fields",
                    });
                } else {

                    $.ajax({
                        url: SITE_URL + "/jobseeker/add-education-detail",
                        type: "POST",
                        data: new FormData(this),
                        success: function(response) {
                            if (response.status) {

                            }
                        }
                    });

                    // $('#field-3').show();
                    // $('#field-2').hide();
                    // $('#payment').addClass('active');

                }

            })

            // Third Section nextbtn  ;

            var abc = 0;
            var bcd = [];
            $("#Third-next").click(function() {
                bcd = []
                $(".tab3").each(function(index) {

                    if ($(this).val() == "") {
                        var error = $(this).data('id');
                        var id = $(this).attr('id');
                        var classes = $(this).attr('class');
                        // alert(classes)
                        $('#' + error).html('Please fill ' + id);
                        abc = 0;
                        bcd.push(abc);
                    } else {
                        $('#' + error).html('');
                        var error = $(this).data('id');
                        $('#' + error).html('');
                        abc = 1;
                        bcd.push(abc);


                    }
                });

                if ($.inArray(0, bcd) > -1) {
                    alert('please fill all values')
                } else {

                    $('#field-4').show();
                    $('#field-3').hide();
                    $('#confirm').addClass('active');

                }

            });

            $('#Third-prev').click(function() {
                $('#field-2').show();
                $('#field-3').hide();
                $('#payment').removeClass('active');


            })

            $("#Fourth-next").click(function() {
                let skill = $("#skills").val();
                let error = ("#skillstab-error");
                if (skill == "") {
                    error.text("enter a skill")

                } else {
                    $('#field-5').show();
                    $('#field-4').hide();
                    $('#certificate').addClass('active');

                }

            });

            // fourth prev;

            $('#Fourth-prev').click(function() {
                $('#field-3 ').show();
                $('#field-4').hide();
                $('#confirm').removeClass('active')

            });

            $('#Fifth-prev').click(function() {
                $('#field-4 ').show();
                $('#field-5').hide();
                $('#certificate').removeClass('active')

            })

            // subit btn

            var abc = 0;
            var bcd = [];
            $("#Submit").click(function() {
                bcd = []
                $(".tab5").each(function(index) {

                    if ($(this).val() == "") {
                        var error = $(this).data('id');
                        var id = $(this).attr('id');
                        var classes = $(this).attr('class');
                        // alert(classes)
                        $('#' + error).html('Please fill ' + id);
                        abc = 0;
                        bcd.push(abc);
                    } else {
                        $('#' + error).html('');
                        var error = $(this).data('id');
                        $('#' + error).html('');
                        abc = 1;
                        bcd.push(abc);


                    }
                });
                console.log(bcd)
                if ($.inArray(0, bcd) > -1) {
                    alert('please fill all values')
                } else {

                    alert("submit succcessfully Thankyou")

                }

            });

        });
    </script>
@endsection
