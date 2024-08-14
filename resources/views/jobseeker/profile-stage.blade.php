@extends('layouts.master', ['title' => 'Profile Stage'])
@section('style')
    {{-- <link rel="stylesheet" href="{{asset('assets/css/jobseeker/fontawesome.css')}}" --}}

    <link rel="stylesheet" href="{{ asset('assets/css/jobseeker.css') }}">
    <link href="{{ asset('assets/css/tagsinput.css') }}" rel="stylesheet" type="text/css">
    <style>
        /* .bootstrap-tagsinput .badge {
                margin-right: 10px;
            } */

        li.active .profileclass {
            border: none;
            width: 57px;
            border-radius: 22%;
            height: 51px;
            background: #e35e25;
            padding: 15px;
            color: white;
        }

        li .profileclass {
            border: none;
            width: 57px;
            border-radius: 22%;
            height: 51px;
            background: lightgrey;
            padding: 15px;
            color: white;
        }

        /* .preferlocation .select2-search__field{
                border : none;
            } */
        .select2-container--default .select2-selection--multiple {
            margin-top: 8px;
        }

        .select2-container .select2-selection--multiple {
            min-height: 46px;
        }

        .bootstrap-tagsinput .badge {
            margin-right: 2px;
        }
    </style>
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
                            <li class="active"><i class="fas fa-user profileclass"></i><br><strong>Profile </strong></li>
                            <li id="educationid"><i
                                    class="fas fa-university profileclass"></i><br><strong>Education</strong></li>
                            <li id="professionalid"><i
                                    class="fas fa-briefcase profileclass"></i><br><strong>Professional</strong></li>
                            <li id="skillid"><i class="fas fa-cog profileclass"></i><br><strong>Skills</strong></li>
                            <li id="certificateid"><i class="fas fa-certificate profileclass"></i><br><strong>Certificate
                                </strong></li>
                        </ul>


                        <div class="profile_container">

                            {{-- Profile Form --}}
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
                                                                class="img-fluid rounded w-50 profileimage" alt="">
                                                        @else
                                                            <img id="previewImg"
                                                                src="https://i.pinimg.com/736x/aa/c9/4e/aac94e41310947cbcd5f38a41ccc0132.jpg"
                                                                style="width: 150px; height: 150px; border: 1px solid white;"
                                                                class="profileimage">
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
                                                        value="{{ $data->dob }}" required>
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

                                            <div class="col-sm-4 currentsal">

                                                <label class="col-form-label w-100"><span style="color: red;">*</span> Cur
                                                    Salary(LPA) </label>
                                                <input type="number" name="curr_sal" placeholder="Current Salary"
                                                    class="tab1" data-id="cursalary_error" id="current salary"
                                                    value="{{ $data->current_salary }}" min="0" required>
                                                <small id="cursalary_error" class="text-danger"></small>
                                            </div>

                                            <!-- Expected Salary -->

                                            <div class="col-sm-4 currentsal">
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
                                            <div class="col-md-4">
                                                <label> Preferred Location </label>
                                                <select class="location-multiple form-control" name="locationlist[]"
                                                    multiple="multiple">
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
                                            </div>
                                            {{-- <div class="col-sm-4 preferlocation">

                                                <label> <span style="color: red;">*</span> Preferred Location </label>
                                                <select class="form-control location-multiple" name="locationlist[]"
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

                                            </div> --}}
                                            {{-- <div class="col-md-4">
                                                <select class="form-multi-select" id="ms1" multiple data-coreui-search="true">
                                                    <option value="0">Angular</option>
                                                    <option value="1">Bootstrap</option>
                                                    <option value="2">React.js</option>
                                                    <option value="3">Vue.js</option>
                                                    <optgroup label="backend">
                                                      <option value="4">Django</option>
                                                      <option value="5">Laravel</option>
                                                      <option value="6">Node.js</option>
                                                    </optgroup>
                                                  </select>
                                            </div>
                                            --}}
                                            <div class="col-sm-4">
                                                <label for="linkedin" class="col-form-label">Linkedin Profile Link</label>
                                                <input type="text" name="linkedin" placeholder="Enter Linkedin Link"
                                                    id="linkdln" class="linkdln-1" value="{{ $data->linkedin }}">
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="password" class="col-form-label">Password</label>
                                                <input type="password" minlength="8" name="password"
                                                    placeholder="Enter your password" autocomplete="off">
                                            </div>
                                            <div class="col-sm-4 resume">

                                                <label for="resume" class="col-form-label">
                                                    <span style="color: red;"> * </span>Resume</label>
                                                <i aria-hidden="true" class="fa fa-info ml-2 mr-1"></i>

                                                @if (isset($getresume->resume))
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
                                                    @if (isset($getresume->resume))
                                                        <a href="{{ asset('resume/' . $getresume->resume) }}"
                                                            class="btn">
                                                            <i class="fas fa-download"></i>
                                                            Download Resume</a>
                                                    @endif

                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <button type="button" class="btn mt-4">Save</button> --}}
                                    <button type="submit" class="btn mt-4 ml-5" id="home-next">Save &
                                        Next</button>
                                </fieldset>
                            </form>


                            <!-- Education Form -->
                            <fieldset class="tab" id="field-2">
                                <h1>Education Details</h1>
                                <div class="card-outer">
                                    <form class="form" id="education_form" enctype="multipart/form-data"
                                        method="POST">
                                        @csrf
                                        <div class="container" style="width: 100%; height: auto;">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h2 class="steps">Step 2 -5</h2>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            {{-- 10th Details --}}
                                            <div class="col-md-12">
                                                <h3 class="float-left" style="color:#E35E25;"><u>10th Details</u></h3><br>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="container fieldSet-2" style="height: auto; width: 100%;">
                                                    <div class="row">
                                                        <div class="col">

                                                            <label>
                                                                <span style="color: red;"> *</span>
                                                                Qualification
                                                            </label>

                                                            <select class="tab2 form-control degrees"
                                                                data-id="qualification-error" name="degree[]">
                                                                <option value="10th">10th</option>
                                                            </select>

                                                        </div>
                                                        <div class="col">
                                                            <label>
                                                                <span style="color: red;"> *</span>
                                                                Course type
                                                            </label>
                                                            <select class="form-control tab2 course_types"
                                                                name="course_type[]" data-id="course-error" required>
                                                                <option value="">Select Course Type</option>
                                                                <option value="Full Time"
                                                                    {{ isset($highschool->course_type) && $highschool->course_type == 'Full Time' ? 'selected' : '' }}>
                                                                    Full Time</option>
                                                                <option value="Part Time"
                                                                    {{ isset($highschool->course_type) && $highschool->course_type == 'Part Time' ? 'selected' : '' }}>
                                                                    Part Time</option>
                                                                <option value="Distance Learning Program"
                                                                    {{ isset($highschool->course_type) && $highschool->course_type == 'Distance Learning Program' ? 'selected' : '' }}>
                                                                    Distance Learning Program
                                                                </option>
                                                            </select>

                                                        </div>
                                                        <div class="col">
                                                            <label>
                                                                <span style="color: red;"> *</span>
                                                                Percentage(%)
                                                            </label>
                                                            <input type="number" min="1" step="0.01"
                                                                max="100" class="tab2 percentages"
                                                                data-id="Percentage-error"
                                                                placeholder="Enter Percentage %" name="percentage[]"
                                                                value="{{ isset($highschool->percentage_grade) ? $highschool->percentage_grade : '' }}"
                                                                required>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="container" style= "height: auto; width: 100%;">

                                                    <div class="row">
                                                        <div class="col">
                                                            <label>
                                                                <span style="color: red;"> *</span>Passing year
                                                            </label>
                                                            <input type="number" name="pass_year[]"
                                                                placeholder="Select year" min="{{ date('Y') - 20 }}"
                                                                max="{{ date('Y') }}" data-id="Syear-error"
                                                                class="tab2 pass_years"
                                                                value="{{ isset($highschool->passing_year) ? $highschool->passing_year : '' }}" />
                                                            <small id="Syear-error" class="text-danger"></small>
                                                        </div>
                                                        <div class="col">
                                                            <label>
                                                                <span style="color: red;">
                                                                    *</span>University/College/Institute
                                                            </label>
                                                            <input type="text"
                                                                placeholder="University/College/Institute Name"
                                                                class="tab2" name="ins_name[]" data-id="college-error"
                                                                value="{{ isset($highschool->institute_name) ? $highschool->institute_name : '' }}"
                                                                required />
                                                            <small id="college-error" class="text-danger"></small>
                                                        </div>
                                                        <div class="col">
                                                            <label>
                                                                <span style="color: red;"> *</span>Institute Location
                                                            </label>
                                                            <input type="text" placeholder="Enter Loaction"
                                                                class="tab2" data-id="loaction-error" name="ins_loc[]"
                                                                value="{{ isset($highschool->institute_location) ? $highschool->institute_location : '' }}"
                                                                required />
                                                            <small id="loaction-error" class="text-danger"></small>
                                                        </div>

                                                    </div>


                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <hr style="border-bottom: 1px solid black">
                                            </div>
                                            {{-- 12th Details --}}
                                            <div class="col-md-12">
                                                <h3 class="float-left" style="color:#E35E25;"><u>12th Details</u></h3><br>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="container fieldSet-2" style="height: auto; width: 100%;">
                                                    <div class="row">
                                                        <div class="col">

                                                            <label>

                                                                Qualification
                                                            </label>

                                                            <select class="tab2 form-control degrees"
                                                                data-id="qualification-error" name="degree[]">
                                                                <option value="12th"> 12th</option>
                                                            </select>
                                                            <small id="qualification-error" class="text-danger"></small>

                                                        </div>
                                                        <div class="col">
                                                            <label>

                                                                Course type
                                                            </label>
                                                            <select class="form-control tab2 course_types"
                                                                name="course_type[]" data-id="course-error">
                                                                <option value="" disabled>Select Course Type</option>
                                                                <option value="Full Time"
                                                                    {{ isset($secondayschool->course_type) && $secondayschool->course_type == 'Full Time' ? 'selected' : '' }}>
                                                                    Full Time</option>
                                                                <option value="Part Time"
                                                                    {{ isset($secondayschool->course_type) && $secondayschool->course_type == 'Part Time' ? 'selected' : '' }}>
                                                                    Part Time</option>
                                                                <option value="Distance Learning Program"
                                                                    {{ isset($secondayschool->course_type) && $secondayschool->course_type == 'Distance Learning Program' ? 'selected' : '' }}>
                                                                    Distance Learning Program
                                                                </option>
                                                            </select>
                                                            <small id="course-error" class="text-danger"></small>

                                                        </div>
                                                        <div class="col">
                                                            <label>

                                                                Percentage(%)
                                                            </label>
                                                            <input type="number" min="1" step="0.01"
                                                                max="100" class="tab2 percentages"
                                                                data-id="Percentage-error"
                                                                placeholder="Enter Percentage %" name="percentage[]"
                                                                value="{{ isset($secondayschool->percentage_grade) ? $secondayschool->percentage_grade : '' }}">
                                                            <small id="Percentage-error" class="text-danger"></small>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="container" style= "height: auto; width: 100%;">

                                                    <div class="row">
                                                        <div class="col">
                                                            <label>
                                                                Passing year
                                                            </label>
                                                            <input type="number" name="pass_year[]"
                                                                placeholder="Select year" min="{{ date('Y') - 20 }}"
                                                                max="{{ date('Y') }}" data-id="Syear-error"
                                                                class="tab2 pass_years"
                                                                value="{{ isset($secondayschool->passing_year) ? $secondayschool->passing_year : '' }}" />
                                                            <small id="Syear-error" class="text-danger"></small>
                                                        </div>
                                                        <div class="col">
                                                            <label>
                                                                University/College/Institute
                                                            </label>
                                                            <input type="text"
                                                                placeholder="University/College/Institute Name"
                                                                class="tab2" name="ins_name[]" data-id="college-error"
                                                                value="{{ isset($secondayschool->institute_name) ? $secondayschool->institute_name : '' }}" />
                                                            <small id="college-error" class="text-danger"></small>
                                                        </div>
                                                        <div class="col">
                                                            <label>
                                                                Institute Location
                                                            </label>
                                                            <input type="text" placeholder="Enter Loaction"
                                                                class="tab2" data-id="loaction-error" name="ins_loc[]"
                                                                value="{{ isset($secondayschool->institute_location) ? $secondayschool->institute_location : '' }}" />
                                                            <small id="loaction-error" class="text-danger"></small>
                                                        </div>

                                                    </div>


                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <hr style="border-bottom: 1px solid black">
                                            </div>
                                            {{-- Graduation Details --}}
                                            <div class="col-md-12">
                                                <h3 class="float-left" style="color:#E35E25;"><u>Graduation Details</u>
                                                </h3><br>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="container fieldSet-2" style="height: auto; width: 100%;">
                                                    <div class="row">
                                                        <div class="col">

                                                            <label>

                                                                Qualification
                                                            </label>

                                                            <select class="tab2 form-control degrees"
                                                                data-id="qualification-error" name="degree[]">
                                                                <option value="">Select Qualification</option>
                                                                @foreach ($graduations as $qualification)
                                                                    <option value="{{ $qualification->qualification }}"
                                                                        {{ isset($graduationdetails->degree_name) && $graduationdetails->degree_name == $qualification->qualification ? 'selected' : '' }}>
                                                                        {{ $qualification->qualification }}</option>
                                                                @endforeach
                                                                <option value="Any Graduate">Any Graduate</option>
                                                                <option value="Any Diploma">Any Diploma</option>
                                                            </select>
                                                            <small id="qualification-error" class="text-danger"></small>

                                                        </div>
                                                        <div class="col">
                                                            <label>

                                                                Course type
                                                            </label>
                                                            <select class="form-control tab2 course_types"
                                                                name="course_type[]" data-id="course-error">
                                                                <option value="" disabled>Select Course Type</option>
                                                                <option value="Full Time"
                                                                    {{ isset($graduationdetails->course_type) && $graduationdetails->course_type == 'Full Time' ? 'selected' : '' }}>
                                                                    Full Time</option>
                                                                <option value="Part Time"
                                                                    {{ isset($graduationdetails->course_type) && $graduationdetails->course_type == 'Part Time' ? 'selected' : '' }}>
                                                                    Part Time</option>
                                                                <option value="Distance Learning Program"
                                                                    {{ isset($graduationdetails->course_type) && $graduationdetails->course_type == 'Distance Learning Program' ? 'selected' : '' }}>
                                                                    Distance Learning Program
                                                                </option>
                                                            </select>
                                                            <small id="course-error" class="text-danger"></small>

                                                        </div>
                                                        <div class="col">
                                                            <label>

                                                                Percentage(%)
                                                            </label>
                                                            <input type="number" min="1" step="0.01"
                                                                max="100" class="tab2 percentages"
                                                                data-id="Percentage-error"
                                                                placeholder="Enter Percentage %" name="percentage[]"
                                                                value="{{ isset($graduationdetails->percentage_grade) ? $graduationdetails->percentage_grade : '' }}">
                                                            <small id="Percentage-error" class="text-danger"></small>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="container" style= "height: auto; width: 100%;">

                                                    <div class="row">
                                                        <div class="col">
                                                            <label>
                                                                Passing year
                                                            </label>
                                                            <input type="number" name="pass_year[]"
                                                                placeholder="Select year" min="{{ date('Y') - 20 }}"
                                                                max="{{ date('Y') }}" data-id="Syear-error"
                                                                class="tab2 pass_years"
                                                                value="{{ isset($graduationdetails->passing_year) ? $graduationdetails->passing_year : '' }}" />
                                                            <small id="Syear-error" class="text-danger"></small>
                                                        </div>
                                                        <div class="col">
                                                            <label>
                                                                University/College/Institute
                                                            </label>
                                                            <input type="text"
                                                                placeholder="University/College/Institute Name"
                                                                class="tab2" name="ins_name[]" data-id="college-error"
                                                                value="{{ isset($graduationdetails->institute_name) ? $graduationdetails->institute_name : '' }}" />
                                                            <small id="college-error" class="text-danger"></small>
                                                        </div>
                                                        <div class="col">
                                                            <label>
                                                                Institute Location
                                                            </label>
                                                            <input type="text" placeholder="Enter Loaction"
                                                                class="tab2" data-id="loaction-error" name="ins_loc[]"
                                                                value="{{ isset($graduationdetails->institute_location) ? $graduationdetails->institute_location : '' }}" />
                                                            <small id="loaction-error" class="text-danger"></small>
                                                        </div>

                                                    </div>


                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <hr style="border-bottom: 1px solid black">
                                            </div>
                                            {{-- Post Graduation Details --}}
                                            <div class="col-md-12">
                                                <h3 class="float-left" style="color:#E35E25;"><u>Post Graduation
                                                        Details</u></h3><br>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="container fieldSet-2" style="height: auto; width: 100%;">
                                                    <div class="row">
                                                        <div class="col">

                                                            <label>

                                                                Qualification
                                                            </label>

                                                            <select class="tab2 form-control degrees"
                                                                data-id="qualification-error" name="degree[]">
                                                                <option value="">Select Qualification</option>
                                                                @foreach ($postgraduations as $qualification)
                                                                    <option
                                                                        value="{{ trim($qualification->qualification) }}"
                                                                        {{ isset($postgraduationDetails->degree_name) && trim($postgraduationDetails->degree_name) == trim($qualification->qualification) ? 'selected' : '' }}>
                                                                        {{ $qualification->qualification }}</option>
                                                                @endforeach
                                                                <option value="Any Post Graduate ">Any Post Graduate
                                                                </option>
                                                                <option value="Any P hD">Any PHD</option>
                                                            </select>
                                                            <small id="qualification-error" class="text-danger"></small>

                                                        </div>
                                                        <div class="col">
                                                            <label>

                                                                Course type
                                                            </label>
                                                            <select class="form-control tab2 course_types"
                                                                name="course_type[]" data-id="course-error">
                                                                <option value="" disabled>Select Course Type</option>
                                                                <option value="Full Time"
                                                                    {{ isset($postgraduationDetails->course_type) && $postgraduationDetails->course_type == 'Full Time' ? 'selected' : '' }}>
                                                                    Full Time</option>
                                                                <option value="Part Time"
                                                                    {{ isset($postgraduationDetails->course_type) && $postgraduationDetails->course_type == 'Part Time' ? 'selected' : '' }}>
                                                                    Part Time</option>
                                                                <option value="Distance Learning Program"
                                                                    {{ isset($postgraduationDetails->course_type) && $postgraduationDetails->course_type == 'Distance Learning Program' ? 'selected' : '' }}>
                                                                    Distance Learning Program
                                                                </option>
                                                            </select>
                                                            <small id="course-error" class="text-danger"></small>

                                                        </div>
                                                        <div class="col">
                                                            <label>

                                                                Percentage(%)
                                                            </label>
                                                            <input type="number" min="1" step="0.01"
                                                                max="100" class="tab2 percentages"
                                                                data-id="Percentage-error"
                                                                placeholder="Enter Percentage %" name="percentage[]"
                                                                value="{{ isset($postgraduationDetails->percentage_grade) ? $postgraduationDetails->percentage_grade : '' }}">
                                                            <small id="Percentage-error" class="text-danger"></small>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="container" style= "height: auto; width: 100%;">

                                                    <div class="row">
                                                        <div class="col">
                                                            <label>
                                                                Passing year
                                                            </label>
                                                            <input type="number" name="pass_year[]"
                                                                placeholder="Select year" min="{{ date('Y') - 20 }}"
                                                                max="{{ date('Y') }}" data-id="Syear-error"
                                                                class="tab2 pass_years"
                                                                value="{{ isset($postgraduationDetails->passing_year) ? $postgraduationDetails->passing_year : '' }}" />
                                                            <small id="Syear-error" class="text-danger"></small>
                                                        </div>
                                                        <div class="col">
                                                            <label>
                                                                University/College/Institute
                                                            </label>
                                                            <input type="text"
                                                                placeholder="University/College/Institute Name"
                                                                class="tab2" name="ins_name[]" data-id="college-error"
                                                                value="{{ isset($postgraduationDetails->institute_name) ? $postgraduationDetails->institute_name : '' }}" />
                                                            <small id="college-error" class="text-danger"></small>
                                                        </div>
                                                        <div class="col">
                                                            <label>
                                                                Institute Location
                                                            </label>
                                                            <input type="text" placeholder="Enter Loaction"
                                                                class="tab2" data-id="loaction-error" name="ins_loc[]"
                                                                value="{{ isset($postgraduationDetails->institute_location) ? $postgraduationDetails->institute_location : '' }}" />
                                                            <small id="loaction-error" class="text-danger"></small>
                                                        </div>

                                                    </div>


                                                </div>
                                            </div>
                                        </div>

                                        <button type="button" class="btn mt-4" id="home-prev">Previous</button>
                                        <button type="submit" class="btn mt-4 ml-5 " id="home-next-2">Save &
                                            Next</button>
                                    </form>
                                </div>

                            </fieldset>

                            <!-- Professional Form -->
                            <fieldset id="field-3" class="tab">
                                <h1>Professional</h1>
                                <form action="" method="POST" class="form" id="professionalForm">
                                    @csrf
                                    <div class="pro_main_node">
                                        <div class="container" style="height: auto; width: 100%;">
                                            <div class="row">

                                                <div class="col"
                                                    style="display: flex; justify-content: center; align-items: center;">
                                                    <div style="display: flex; gap: 10px;">
                                                        <label>
                                                            Select One:-
                                                        </label>
                                                        <label style="display: flex; gap: 10px">
                                                            <input type="radio" name="professional_experience"
                                                                style="margin-top: 7px;" data-id="inernship-error"
                                                                value="internship"
                                                                {{ $data->professional_stage == 'internship' ? 'checked' : '' }}
                                                                required>
                                                            Internship
                                                            <small id="inernship-error" class="text-danger"></small>
                                                        </label>
                                                        <label style="display: flex; gap: 10px">
                                                            <input type="radio" name="professional_experience"
                                                                data-id="fresher-error" id="fresher" value="fresher"
                                                                {{ $data->professional_stage == 'fresher' ? 'checked' : '' }}
                                                                required>
                                                            Fresher
                                                            <small id="fresher-error" class="text-danger"></small>
                                                        </label>
                                                        <label style="display: flex; gap: 10px">
                                                            <input type="radio" name="professional_experience"
                                                                data-id="experi-error" id="experience"
                                                                value="experienced"
                                                                {{ $data->professional_stage == 'experienced' ? 'checked' : '' }}
                                                                required>
                                                            Experienced
                                                            <small id="experi-error" class="text-danger"></small>
                                                        </label>


                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        @forelse ($professionalDetails as $professional)
                                            <div class="card-outer pro_child_node">
                                                <input type="hidden" name="professional_id[]"
                                                    class="removedprofessional" value="{{ $professional->id }}">
                                                <div class="container" style= "width: 100%;">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-4">
                                                            <label>
                                                                <span style="color: red;">*</span>
                                                                Designation
                                                            </label>
                                                            <input type="text" placeholder="Enter Designation"
                                                                data-id="designation-error" name="designation[]"
                                                                class="tab3" value="{{ $professional->designations }}"
                                                                required />
                                                            <small id="designation-error" class="text-danger"></small>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <label>
                                                                <span style="color: red;">*</span>
                                                                Organization Name
                                                            </label>
                                                            <input type="text" placeholder="Enter Organization"
                                                                data-id="Organization-error"
                                                                value="{{ $professional->organisation }}"
                                                                name="organization[]" class="tab3" required />
                                                            <small id="Organization-error" class="text-danger"></small>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <label>
                                                                <span style="color: red;">*</span>
                                                                Job Type
                                                            </label>
                                                            {{-- <input type="text" placeholder="Enter Job Type" class="tab3"
                                                        id="job" data-id="job-error" /> --}}
                                                            <select class="form-control" name="jobtype[]" required>
                                                                <option value="">Select Job Type</option>
                                                                <option value="1"
                                                                    {{ $professional->job_type == '1' ? 'selected' : '' }}>
                                                                    Part Time</option>
                                                                <option value="2"
                                                                    {{ $professional->job_type == '2' ? 'selected' : '' }}>
                                                                    Full Time</option>
                                                                <option value="3"
                                                                    {{ $professional->job_type == '3' ? 'selected' : '' }}>
                                                                    Freelancer</option>
                                                                <option value="4"
                                                                    {{ $professional->job_type == '4' ? 'selected' : '' }}>
                                                                    Internship</option>
                                                                <option value="5"
                                                                    {{ $professional->job_type == '5' ? 'selected' : '' }}>
                                                                    Consultant</option>
                                                                <option value="6"
                                                                    {{ $professional->job_type == '6' ? 'selected' : '' }}>
                                                                    Contractual</option>
                                                            </select>
                                                            <small id="job-error" class="text-danger"></small>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-4">
                                                            <label><span style="color: red;">*</span> From:</label>
                                                            <input type="date" class="tab3" name="fromdate[]"
                                                                data-id="date-error"
                                                                value="{{ $professional->from_date }}"
                                                                max="{{ date('Y-m-d', time()) }}" required>
                                                            <small id="date-error" class="text-danger"></small>

                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <label class="d-flex" style="margin-bottom: -8px;">
                                                                <span class="ml-5">To:</span>
                                                                <input type="checkbox" name="currentlyWork[]"
                                                                    class="tab3 ml-5 mr-1 currentwork"
                                                                    style="width: 12px;"
                                                                    {{ $professional->currently_work_here ? 'checked' : '' }}>
                                                                <span class="small">Currently Working</span>
                                                            </label>
                                                            <input type="date" data-id="date2-error" name="todate[]"
                                                                class="tab3 pro_todate" max="{{ date('Y-m-d', time()) }}"
                                                                value="{{ $professional->currently_work_here ? '' : $professional->to_date }}"
                                                                {{ $professional->currently_work_here ? 'disabled' : '' }}
                                                                required>
                                                            <small id="date2-error" class="text-danger"></small>

                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <label>
                                                                <span style="color: red;">*</span>

                                                                Salary(LPA)


                                                            </label>
                                                            <input type="number" placeholder="Enter Salary"
                                                                name="salary[]" data-id="salary-error" class="tab3"
                                                                value="{{ $professional->salary }}" required />
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
                                                            <input type="text"
                                                                placeholder="Enter Key Skills (comma separated)"
                                                                data-id="skills-error" name="key_skills[]" class="tab3"
                                                                value="{{ $professional->key_skill }}" required />
                                                            <small id="skills-error" class="text-danger"></small>
                                                        </div>
                                                        <div class="col" style="max-width: 33.5%">
                                                            <label>
                                                                <span style="color: red;">*</span>

                                                                Responsibility
                                                            </label>
                                                            <input type="text" placeholder="Enter Responsibility"
                                                                data-id="responsblity-error" name="responsibility[]"
                                                                class="tab3"
                                                                value="{{ $professional->responsibility }}" required />
                                                            <small id="responsblity-error" class="text-danger"></small>
                                                        </div>

                                                    </div>
                                                </div>
                                                @if ($loop->iteration > 1)
                                                    <div class='col-md-12 mb-5'><button
                                                            class='btn float-right proremove'>Remove</button></div>
                                                @endif
                                            </div>
                                        @empty

                                            <div class="card-outer pro_child_node">
                                                <input type="hidden" name="professional_id[]"
                                                    class="removedprofessional">
                                                <div class="container" style= "width: 100%;">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-4">
                                                            <label>
                                                                <span style="color: red;">*</span>
                                                                Designation
                                                            </label>
                                                            <input type="text" placeholder="Enter Designation"
                                                                data-id="designation-error" name="designation[]"
                                                                class="tab3" required />
                                                            <small id="designation-error" class="text-danger"></small>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <label>
                                                                <span style="color: red;">*</span>
                                                                Organization Name
                                                            </label>
                                                            <input type="text" placeholder="Enter Organization"
                                                                data-id="Organization-error" name="organization[]"
                                                                class="tab3" required />
                                                            <small id="Organization-error" class="text-danger"></small>
                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <label>
                                                                <span style="color: red;">*</span>
                                                                Job Type
                                                            </label>
                                                            {{-- <input type="text" placeholder="Enter Job Type" class="tab3"
                                                        id="job" data-id="job-error" /> --}}
                                                            <select class="form-control" name="jobtype[]" required>
                                                                <option value="">Select Job Type</option>
                                                                <option value="1">Part Time</option>
                                                                <option value="2">Full Time</option>
                                                                <option value="3">Freelancer</option>
                                                                <option value="4">Internship</option>
                                                                <option value="5">Consultant</option>
                                                                <option value="6">Contractual</option>
                                                            </select>
                                                            <small id="job-error" class="text-danger"></small>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-4">
                                                            <label><span style="color: red;">*</span> From:</label>
                                                            <input type="date" class="tab3" name="fromdate[]"
                                                                data-id="date-error" required>
                                                            <small id="date-error" class="text-danger"></small>

                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <label class="d-flex" style="margin-bottom: -8px;">
                                                                <span class="ml-5">To:</span>
                                                                <input type="checkbox" name="currentlyWork[]"
                                                                    class="tab3 ml-5 mr-1 currentwork"
                                                                    style="width: 12px;">
                                                                <span class="small">Currently Working</span>
                                                            </label>
                                                            <input type="date" data-id="date2-error" name="todate[]"
                                                                class="tab3 pro_todate" required>
                                                            <small id="date2-error" class="text-danger"></small>

                                                        </div>
                                                        <div class="col-sm-12 col-md-4">
                                                            <label>
                                                                <span style="color: red;">*</span>

                                                                Salary(LPA)


                                                            </label>
                                                            <input type="number" placeholder="Enter Salary"
                                                                name="salary[]" id="salary" data-id="salary-error"
                                                                class="tab3" required />
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
                                                            <input type="text"
                                                                placeholder="Enter Key Skills (comma separated)"
                                                                data-id="skills-error" name="key_skills[]" class="tab3"
                                                                required />
                                                            <small id="skills-error" class="text-danger"></small>
                                                        </div>
                                                        <div class="col" style="max-width: 33.5%">
                                                            <label>
                                                                <span style="color: red;">*</span>

                                                                Responsibility
                                                            </label>
                                                            <input type="text" placeholder="Enter Responsibility"
                                                                data-id="responsblity-error" name="responsibility[]"
                                                                class="tab3" id="Responsibility" required />
                                                            <small id="responsblity-error" class="text-danger"></small>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                        @endforelse
                                    </div>

                                    <button type="button" class="btn mt-4" id="Third-prev">Previous</button>
                                    <button type="button" class="btn mt-4" id="addExperience">Add More</button>
                                    <button type="submit" class="btn mt-4" id="Third-next">Save & Next</button>

                                </form>
                            </fieldset>

                            <!-- Skill Form -->
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
                                    <form class="add_skill_form" method="post">
                                        @csrf
                                        <div class="container"
                                            style="height: auto; width: 100%; display: flex; align-items: center;justify-content: center;">
                                            <div class="row" style="width: 50%;">
                                                <div class="col">
                                                    <label>
                                                        Add Skills
                                                    </label>
                                                    <input type="text" placeholder="Add Skills (comma seperated)"
                                                        name="skill" id="skills" data-role="tagsinput"
                                                        value="{{ isset($skillsDetails->skills) ? $skillsDetails->skills : '' }}"
                                                        required />
                                                    <small id="skillstab-error" class="text-danger"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn mt-4" id="Fourth-prev">Previous</button>
                                        <button type="submit" class="btn mt-4 ml-5 " id="Fourth-next">Save &
                                            Next</button>
                                    </form>
                                </div>

                            </fieldset>

                            <!-- Certificate Form -->
                            <fieldset id="field-5" class="tab">
                                <form id="certificate_form" action="" method="POST" class="form">
                                    @csrf

                                    <h1>Certificate</h1>
                                    <div class="container" style="width: 100%; height: auto;">
                                        <div class="row">
                                            <div class="col">
                                                <h2 class="steps">Step 5-5</h2>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="parent_certificate_card">
                                        @forelse ($certificationDetails as $certificate)
                                            <div class="card-outer child_certificate_card">
                                                <div class="d-none">
                                                    <input type="hidden" class="certificateid" name="certificateid[]"
                                                        value="{{ $certificate->id }}">
                                                </div>
                                                <div class="container" style=" width: 100%; height: auto;">
                                                    <div class="row">
                                                        <div class="col">
                                                            <label>
                                                                <span style="color: red;">*</span>
                                                                Course Name
                                                            </label>
                                                            <input type="text" placeholder="Enter Course Name"
                                                                data-id="CourseName-error" name="courseName[]"
                                                                class="tab5" value="{{ $certificate->course }}"
                                                                required />
                                                            <small id="CourseName-error" class="text-danger"></small>

                                                        </div>
                                                        <div class="col">
                                                            <label>
                                                                <span style="color: red;">*</span>
                                                                Institute Name
                                                            </label>
                                                            <input type="text" placeholder="Enter Institute Name"
                                                                data-id="institute-error" name="instituteName[]"
                                                                class="tab5"
                                                                value="{{ $certificate->certificate_institute_name }}"
                                                                required />
                                                            <small id="institute-error" class="text-danger"></small>

                                                        </div>
                                                        <div class="col">
                                                            <label>
                                                                <span style="color: red;">*</span>
                                                                Certificate licence
                                                            </label>
                                                            <input type="text" placeholder="Enter Certificate licence"
                                                                data-id="certificate-licence-error"
                                                                value="{{ $certificate->grade }}" name="score[]"
                                                                class="tab5" />
                                                            <small id="certificate-licence-error"
                                                                class="text-danger"></small>


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

                                                            <select name="certficationtype[]" class="form-control tab5"
                                                                data-id="certification-type-error" required>
                                                                <option value="" selected>Select Type</option>
                                                                <option value="1"
                                                                    {{ $certificate->certification_type == '1' ? 'selected' : '' }}>
                                                                    Offline</option>
                                                                <option value="2"
                                                                    {{ $certificate->certification_type == '2' ? 'selected' : '' }}>
                                                                    Online</option>
                                                            </select>
                                                            <small id="certification-type-error"
                                                                class="text-danger"></small>



                                                        </div>
                                                        <div class="col" style="max-width: 80%;">
                                                            <label for="start-date">
                                                                <span style="color: red;">*</span>
                                                                Time Period
                                                            </label>
                                                            <br>

                                                            <div style="display: flex; gap:15px;">



                                                                <input type="month" name="fromdate[]" class="tab5"
                                                                    data-id="time-error"
                                                                    value="{{ $certificate->cert_from_date }}"
                                                                    max="{{ date('Y-m') }}" required>
                                                                <small id="time-error" class="text-danger"></small>

                                                                <input type="month" name="todate[]" class="tab5"
                                                                    data-id="endtime-error" max="{{ date('Y-m') }}"
                                                                    value="{{ $certificate->cert_to_date }}" required>
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
                                                            <input type="text" name="certificate_link[]"
                                                                class="tab5"
                                                                value="{{ $certificate->certificate_link }}"
                                                                placeholder="Enter Certificate Link" />
                                                        </div>
                                                        <div class="col" style="max-width: 35%;">
                                                            <label>
                                                                Description(Optional)
                                                            </label>
                                                            <textarea style="height:2.5em;" name="description[]" class="tab5 textarea" placeholder="Some Text..."> {{ $certificate->description }} </textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                @if ($loop->iteration > 1)
                                                    <div class="col-md-12 mb-5"><button
                                                            class="btn float-right certremove">Remove</button></div>
                                                @endif
                                            </div>
                                        @empty
                                            <div class="card-outer child_certificate_card">
                                                <div class="d-none">
                                                    <input type="hidden" class="certificateid" name="certificateid[]">
                                                </div>
                                                <div class="container" style=" width: 100%; height: auto;">
                                                    <div class="row">
                                                        <div class="col">
                                                            <label>
                                                                <span style="color: red;">*</span>
                                                                Course Name
                                                            </label>
                                                            <input type="text" placeholder="Enter Course Name"
                                                                data-id="CourseName-error" name="courseName[]"
                                                                class="tab5" required />
                                                            <small id="CourseName-error" class="text-danger"></small>

                                                        </div>
                                                        <div class="col">
                                                            <label>
                                                                <span style="color: red;">*</span>
                                                                Institute Name
                                                            </label>
                                                            <input type="text" placeholder="Enter Institute Name"
                                                                data-id="institute-error" name="instituteName[]"
                                                                class="tab5" required />
                                                            <small id="institute-error" class="text-danger"></small>

                                                        </div>
                                                        <div class="col">
                                                            <label>
                                                                <span style="color: red;">*</span>
                                                                Certificate licence
                                                            </label>
                                                            <input type="text"
                                                                placeholder="Enter Certificate licence"
                                                                data-id="certificate-licence-error" name="score[]"
                                                                class="tab5" />
                                                            <small id="certificate-licence-error"
                                                                class="text-danger"></small>


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

                                                            <select name="certficationtype[]" id="certificate type"
                                                                class="form-control tab5"
                                                                data-id="certification-type-error" required>
                                                                <option value="" selected>Select Type</option>
                                                                <option value="1">Offline</option>
                                                                <option value="2">Online</option>
                                                            </select>
                                                            <small id="certification-type-error"
                                                                class="text-danger"></small>



                                                        </div>
                                                        <div class="col" style="max-width: 80%;">
                                                            <label for="start-date">
                                                                <span style="color: red;">*</span>
                                                                Time Period
                                                            </label>
                                                            <br>

                                                            <div style="display: flex; gap:15px;">



                                                                <input type="month" name="fromdate[]" required
                                                                    class="tab5" data-id="time-error" required>
                                                                <small id="time-error" class="text-danger"></small>

                                                                <input type="month" name="todate[]" required
                                                                    class="tab5" data-id="endtime-error" required>
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
                                                            <input type="text" name="certificate_link[]"
                                                                class="tab5" placeholder="Enter Certificate Link" />
                                                        </div>
                                                        <div class="col" style="max-width: 35%;">
                                                            <label>
                                                                Description(Optional)
                                                            </label>
                                                            <textarea style="height:2.5em;" name="description[]" class="tab5 textarea" placeholder="Some Text..."> </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforelse

                                    </div>

                                    <button type="button" class="btn mt-4" id="Fifth-prev">Previous</button>
                                    <button type="button" class="btn mt-4" id="addCertificate">Add More</button>

                                    <button type="submit" class="btn mt-4 " id="Submit">Submit</button>
                                </form>
                            </fieldset>


                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/js/profile-stage.js') }}"></script>
    <script src="{{ asset('assets/js/tagsinput.js') }}"></script>
@endsection
