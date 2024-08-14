@extends('layouts.master', ['title' => 'Edit Profile'])
@section('style')
    <style>
        a {
            color: black;
        }

        a:hover {
            color: #000;
        }

        .nav-link.active {
            background-color: #e5500b !important;
            color: white !important;
        }

        label {
            font-weight: bold;
        }

        legend {
            color: #e5500b;
            font-weight: bold;
        }
    </style>
@endsection
@section('content')
    @php
        if (!$companyDetails) {
            $companyDetails = new stdclass();
            $companyDetails->company_logo = '';
            $companyDetails->cover_image = '';
            $companyDetails->company_name = '';
            $companyDetails->tagline = '';
            $companyDetails->company_industry = '';
            $companyDetails->owner_name = '';
            $companyDetails->com_email = '';
            $companyDetails->com_contact = '';
            $companyDetails->website = '';
            $companyDetails->no_of_employee = '';
            $companyDetails->establish_date = '';
            $companyDetails->address = '';
            $companyDetails->company_country = '';
            $companyDetails->company_state = '';
            $companyDetails->company_city = '';
            $companyDetails->company_capital = '';
            $companyDetails->cin_no = '';
            $companyDetails->facebook_url = '';
            $companyDetails->twitter_url = '';
            $companyDetails->linkedin_url = '';
            $companyDetails->about = '';
            $companyDetails->additional = '';
            $companyDetails->company_video = '';
        }
    @endphp
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Edit Profile</h1>
                <hr>
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session()->get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            </div>
            @php
                $user = Auth::guard('employer')->user();
            @endphp
            <div class="col-md-12">
                <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active text-center border" id="personal-tab" data-toggle="tab" href="#personal"
                            role="tab" aria-controls="personal" aria-selected="true">Personal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-center border" id="company-tab" data-toggle="tab" href="#company"
                            role="tab" aria-controls="company" aria-selected="false">Company</a>
                    </li>
                </ul>
                <div class="tab-content my-3" id="myTabContent">
                    <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="personal-tab">
                        <form action="{{ route('update_employer_personaldetail') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="col-sm-12 border">
                                <legend>Profile Image</legend>

                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label class="" for="emp_image">
                                            Upload Image</label>
                                        <input type="file" class="form-control" id="emp_image" name="emp_image"
                                            accept="image/*" />
                                        <span class="small text-muted">(Image should be less than 1 mb and 500 * 500
                                            dimension)</span>
                                        @error('emp_image')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-center my-2">
                                        @if ($user->profile_pic_thumb)
                                            <img src="{{ asset('emp_profile_image/' . $user->profile_pic_thumb . '') }}"
                                                alt="" class="img-fluid border rounded" width="100">
                                        @else
                                            <img src="{{ asset('assets/images/default-image.png') }}" alt=""
                                                class="img-fluid rounded" width="100">
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 border">
                                <legend>Personal Information</legend>

                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="fname">First Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="fname" name="fname"
                                            placeholder="Enter Your First Name" value="{{ $user->fname }}" required>
                                        @error('fname')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                    <div class="col-md-4">
                                        <label for="lname">Last Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="lname" name="lname"
                                            placeholder="Enter Your Last Name" value="{{ $user->lname }}" required>
                                        @error('lname')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                    <div class="col-md-4">
                                        <label for="email">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Enter Your Email" value="{{ $user->email }}" required>
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                    <div class="col-md-4">
                                        <label for="contact">Contact No. <span class="text-danger">*</span></label>
                                        <input type="text" minlength="10" maxlength="10"
                                            placeholder="Enter Your Contact No." class="form-control" id="contact"
                                            name="contact" value="{{ $user->contact }}" required>
                                        @error('contact')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="dob">Date of Birth</label>
                                        <input type="date" class="form-control" id="dob" name="dob"
                                            value="{{ $user->dob }}">
                                        @error('dob')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="gender">Gender <span class="text-danger">*</span></label>
                                        <select class="form-control" name="gender" id="gender" required>
                                            <option value="Male" {{ $user->gender == 'Male' ? 'selected' : '' }}>Male
                                            </option>
                                            <option value="Female" {{ $user->gender == 'Female' ? 'selected' : '' }}>
                                                Female
                                            </option>
                                            <option value="Others" {{ $user->gender == 'Others' ? 'selected' : '' }}>
                                                Others
                                            </option>
                                        </select>
                                        @error('gender')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="aadhar_no">Aadhar No.</label>
                                        <input type="text" class="form-control" id="aadhar_no" name="aadhar_no"
                                            placeholder="Enter Your Adhaar No." minlength="12" maxlength="12"
                                            value="{{ $user->aadhar_no }}">
                                        @error('aadhar_no')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="designation">Current Designation</label>
                                        <input type="text" class="form-control" id="designation" name="designation"
                                            placeholder="Enter Your Current Designation"
                                            value="{{ $user->designation }}">
                                        @error('designation')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="industry_id">Select Industry <sub>(Please select one)</sub></label>
                                        <select class="form-control" name="industry_id" id="industry_id">
                                            <option value="">Select Industry</option>
                                            @foreach ($industries as $industry)
                                                <option value="{{ $industry->id }}"
                                                    {{ $user->industry_id == $industry->id ? 'selected' : '' }}>
                                                    {{ $industry->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="functionalrole_id">Functional Area <sub> (Please select
                                                one)</sub></label>
                                        <select class="form-control" id="functionalrole_id" name="functionalrole_id">
                                            <option value="">Select Functional Area</option>
                                            @foreach ($functional_roles as $functional)
                                                <option value="{{ $functional->id }}"
                                                    {{ $user->functionalrole_id == $functional->id ? 'selected' : '' }}>
                                                    {{ $functional->subcategory_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-12 border">
                                <legend>Social Accounts</legend>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="facebook_url">Facebook</label>
                                        <input type="text" class="form-control" name="facebook_url" id="facebook_url"
                                            placeholder="Enter Your Facebook Link" value="{{ $user->facebook_url }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="twitter_url">Twitter</label>
                                        <input type="text" class="form-control" name="twitter_url" id="twitter_url"
                                            placeholder="Enter Your Twitter Link" value="{{ $user->twitter_url }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="linkedin_url">LinkedIn</label>
                                        <input type="text" class="form-control" name="linkedin_url" id="linkedin_url"
                                            placeholder="Enter Your LinkedIn Link" value="{{ $user->linkedin_url }}">
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-12 border">
                                <button type="submit" class="btn my-2">Update</button>
                                <a href="{{ route('dashboardemployer') }}" class="btn my-2">Cancel</a>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="company" role="tabpanel" aria-labelledby="company-tab">
                        <form action="{{ route('update_employer_companydetail') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-12 border">
                                <legend>Company Logo & Banner</legend>
                                <div class="form-group row">

                                    <div class="col-md-3">
                                        <label for="emp_logo">Upload Logo</label>
                                        <input type="file" class="form-control" name="emp_logo" accept="image/*">
                                        @error('emp_logo')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <img src="{{ asset('company_logo/' . $companyDetails->company_logo) }}"
                                            alt="Logo" class="img-fluid border rounded" width="100">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="emp_banner">Upload Banner</label>
                                        <input type="file" class="form-control" name="emp_banner" accept="image/*">
                                        @error('emp_banner')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3 text-center">
                                        <img src="{{ asset('company_cover/' . $companyDetails->cover_image) }}"
                                            alt="Logo" class="img-fluid border rounded mx-auto d-block"
                                            width="100">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 border">
                                <legend>Company Information</legend>
                                <div class="form-group row">

                                    <div class="col-md-4">
                                        <label for="company_name">Company Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="company_name"
                                            placeholder="Enter Your Company Name"
                                            value="{{ $companyDetails->company_name }}" required>
                                        @error('company_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="tagline">Company Tagline <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="tagline"
                                            placeholder="Enter Your Company Tagline"
                                            value="{{ $companyDetails->tagline }}" required>
                                        @error('tagline')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="com_industry">Select Industry <span class="text-danger">*</span></label>
                                        <select class="form-control" name="com_industry" required>
                                            <option value="">Select Industry</option>
                                            @foreach ($industries as $industry)
                                                <option value="{{ $industry->id }}"
                                                    {{ $companyDetails->company_industry == $industry->id ? 'selected' : '' }}>
                                                    {{ $industry->category_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('com_industry')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="owner_name">Owner Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="owner_name"
                                            placeholder="Enter Owner Name" value="{{ $companyDetails->owner_name }}"
                                            required>
                                        @error('owner_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="com_email">Company Email <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="com_email"
                                            placeholder="Enter Email Id" value="{{ $companyDetails->com_email }}"
                                            required>
                                        @error('com_email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="com_contact">Company Contact No. <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="com_contact"
                                            placeholder="Enter Your Contact No."
                                            value="{{ $companyDetails->com_contact }}" required>
                                        @error('com_contact')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="website">Website</label>
                                        <input type="text" class="form-control" name="website"
                                            placeholder="Enter Your Website Link" value="{{ $companyDetails->website }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="employee_no">Employees <span class="text-danger">*</span></label>
                                        <select class="form-control" name="employee_no" required>
                                            <option value="" disabled="">Select Employeee</option>

                                            <option value="1-10"
                                                {{ $companyDetails->no_of_employee == '1-10' ? 'selected' : '' }}>1-10
                                            </option>

                                            <option value="11-100"
                                                {{ $companyDetails->no_of_employee == '11-100' ? 'selected' : '' }}>11-100
                                            </option>
                                            <option value="101-1000"
                                                {{ $companyDetails->no_of_employee == '101-1000' ? 'selected' : '' }}>
                                                101-1000</option>
                                            <option value="1001-10000"
                                                {{ $companyDetails->no_of_employee == '1001-10000' ? 'selected' : '' }}>
                                                1001-10000</option>
                                            <option value="10001-100000"
                                                {{ $companyDetails->no_of_employee == '10001-100000' ? 'selected' : '' }}>
                                                10001-100000</option>
                                        </select>
                                        @error('employee_no')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="established_year">Established Date <sub>Please Enter Year</sub> <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="established_year"
                                            placeholder="Enter Establish Year"
                                            value="{{ $companyDetails->establish_date }}" required>
                                        @error('established_year')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 border">
                                <legend>Company Address</legend>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="address">Address <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter Address"
                                            name="address" value="{{ $companyDetails->address }}" required>
                                        @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="country">Country <span class="text-danger">*</span></label>
                                        <select class="form-control" name="country" required>
                                            <option value="">Select Country</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->country_id }}"
                                                    {{ $companyDetails->company_country == $country->country_id ? 'selected' : '' }}>
                                                    {{ $country->country_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('country')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="state">State <span class="text-danger">*</span></label>
                                        <select class="form-control" name="state" id="company_state" required>
                                            <option value="">Select State</option>
                                            @foreach ($states as $state)
                                                <option value="{{ $state->id }}"
                                                    {{ $companyDetails->company_state == $state->id ? 'selected' : '' }}>
                                                    {{ $state->states_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('state')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="city">City <span class="text-danger">*</span></label>
                                        <select class="form-control" name="city" id="company_cities" required>
                                            <option value="">Select City</option>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}"
                                                    {{ $companyDetails->company_city == $city->id ? 'selected' : '' }}>
                                                    {{ $city->cities_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('city')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="revenue">Revenue</label>
                                        <input type="text" class="form-control" placeholder="Enter Revenue"
                                            name="revenue" value="{{ $companyDetails->company_capital }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="cin_no">Corporate Identification Number/License Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control"
                                            placeholder="Enter Your CIN/License Number" name="cin_no"
                                            value="{{ $companyDetails->cin_no }}" required>
                                        @error('cin_no')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 border">
                                <legend>Social Accounts</legend>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="com_facebook">Facebook</label>
                                        <input type="text" class="form-control" name="com_facebook" id="com_facebook"
                                            placeholder="Enter Facebook Link"
                                            value="{{ $companyDetails->facebook_url }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="com_twitter">Twitter</label>
                                        <input type="text" class="form-control" name="com_twitter" id="com_twitter"
                                            placeholder="Enter Twitter Link" value="{{ $companyDetails->twitter_url }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="com_linkedin">LinkedIn</label>
                                        <input type="text" class="form-control" name="com_linkedin" id="com_linkedin"
                                            placeholder="Enter LinkedIn Link"
                                            value="{{ $companyDetails->linkedin_url }}">
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-12 border">
                                <legend>Company Summary</legend>
                                <div class="form-group">
                                    <label for="com_summary">About Company</label>
                                    <textarea class="form-control" name="com_summary" id="com_summary" cols="30" rows="5"
                                        placeholder="About Company............" value="{{ $companyDetails->about }}"></textarea>
                                </div>
                            </div>

                            <div class="col-md-12 border">
                                <legend>Other Information</legend>
                                <div class="form-group">
                                    <label for="additional">Additional Information</label>
                                    <textarea class="form-control" name="additional" id="additional" cols="30" rows="5"
                                        placeholder="Enter Additional Information............" value="{{ $companyDetails->additional }}"></textarea>
                                </div>
                            </div>

                            <div class="col-md-12 border">
                                <legend>Youtube Video Link</legend>
                                <div class="form-group">
                                    <label for="company_video">Video link</label>
                                    <input class="form-control" name="company_video" id="company_video"
                                        placeholder="Enter Video Link" value="{{ $companyDetails->company_video }}">
                                </div>
                            </div>

                            <div class="col-md-12 border">
                                <button type="submit" class="btn my-2">Update</button>
                                <a href="{{ route('dashboardemployer') }}" class="btn my-2">Cancel</a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/employer_edit.js') }}"></script>
@endsection
