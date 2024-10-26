@extends('layouts.master', ['title' => 'Tracker Details'])
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/subuser/addTracker.css') }}">
    <link href="{{ asset('assets/css/tagsinput.css') }}" rel="stylesheet" type="text/css">

    <style>
        .currenlyLog {
            margin-top: -0.75rem !important;
        }

        label {
            font-weight: bold;
        }

        h3 {
            color: #e35e25;
        }

        hr {
            border-bottom: 3px solid #eceff8;
        }

        .bootstrap-tagsinput .badge {
            margin-right: 2px;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                    {{ Breadcrumbs::render('subuser_edit_tracker') }}
                 </div>
            <div class="col-md-12 my-4">
                <h3>Candidate Details of {{ $trackerDetails->name }}</h3>
            </div>
            <div class="col-md-7 border  h-auto wrapper-profile">
                <h3 style="margin-top: 20px;">Profile Details</h3>
                <hr>
                <!-- Profile details row-1 -->
                <form action="{{ route('update_tracker') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="d-none">
                        <input type="hidden" name="id" value="{{$id}}">
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label><span style="color: red;">*</span> Name</label>
                            <input type="text" placeholder="Enter Name" name="name"
                                value="{{ $trackerDetails->name }}" required />
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label><span style="color: red;">*</span> Email</label>
                            <input type="email" placeholder="Enter Email" name="email"
                                value="{{ $trackerDetails->email }}" required />
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label><span style="color: red;">*</span> Contact No</label>
                            <input type="text" maxlength="10" placeholder="Enter Contact No" name="contact"
                                pattern="[1-9]{1}[0-9]{9}" value="{{ $trackerDetails->contact }}" required />
                            @error('contact')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <!-- Profile Details row-2 -->
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label><span style="color: red;">*</span> Select Gender</label>
                            <select name="gender" style="outline: none;" required>
                                <option value="">Select Gender</option>
                                <option value="male" {{ Illuminate\Support\Str::lower($trackerDetails->gender) == 'male' ? 'selected' : '' }}>Male
                                </option>
                                <option value="female" {{ Illuminate\Support\Str::lower($trackerDetails->gender) == 'female' ? 'selected' : '' }}>Female
                                </option>
                                <option value="others" {{ Illuminate\Support\Str::lower($trackerDetails->gender) == 'others' ? 'selected' : '' }}>Others
                                </option>
                            </select>
                            @error('gender')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12">
                            <label>Key skills(use Multiple Skills Seprated By Comma(,))</label>
                            <input type="text" data-role="tagsinput"
                                placeholder="Enter Skills(Multiple Skills Seprated By Comma,)" name="skills"
                                value="{{ $trackerDetails->key_skills }}">
                        </div>
                    </div>
                    <!-- profile details row-3 -->
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label>Applied Designation</label>
                            <input type="text" class="designation" placeholder="Enter Input Applied Designation"
                                name="applied_designation" data-prefetch="{{ route('getskillsoptions') }}"
                                value="{{ $trackerDetails->applied_designation }}">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label>Current Designation</label>
                            <input type="text" class="designation" placeholder="Enter Input Current Designation"
                                name="current_designation" data-prefetch="{{ route('getskillsoptions') }}"
                                value="{{ $trackerDetails->current_designation }}">
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label><span style="color: red;">*</span> Experience</label>
                            <select name="experience" style="outline: none;" required>
                                <option value="">Select Experience</option>
                                <option value="fresher" {{ $trackerDetails->experience == 'fresher' ? 'selected' : '' }}>
                                    0-1 Yr (Also Fresher)</option>
                                <option value="1-2" {{ $trackerDetails->experience == '1-2' ? 'selected' : '' }}>1-2 Yr
                                </option>
                                <option value="2-4" {{ $trackerDetails->experience == '2-4' ? 'selected' : '' }}>2-4 Yr
                                </option>
                                <option value="4-5" {{ $trackerDetails->experience == '4-5' ? 'selected' : '' }}>4-5 Yr
                                </option>
                                <option value="5-8" {{ $trackerDetails->experience == '5-8' ? 'selected' : '' }}>5-8 Yr
                                </option>
                                <option value="8-10" {{ $trackerDetails->experience == '8-10' ? 'selected' : '' }}>8-10
                                    Yr</option>
                                <option value="10-15" {{ $trackerDetails->experience == '10-15' ? 'selected' : '' }}>10-15
                                    Yr</option>
                                <option value="15-20" {{ $trackerDetails->experience == '15-20' ? 'selected' : '' }}>15-20
                                    Yr</option>
                                <option value="20-25" {{ $trackerDetails->experience == '20-25' ? 'selected' : '' }}>20-25
                                    Yr</option>
                            </select>
                        </div>
                    </div>
                    <!-- Company details section -->
                    <!-- Row-1 -->
                    <h3 style="margin-top: 20px;">Company Details</h3>
                    <hr>
                    <i class="fas fa-info-circle mb-2" style="color: red" aria-hidden="true">
                        Please add experience in reverse chronological order, from last to first</i>
                    <div class="parentcompany">
                        <input type="hidden" name="removed_experiences[]" id="removedexperiences">
                        @forelse ($experienceDetails as $experience)
                        <div class="row childcompany">
                            <input type="hidden" class="companydetails" name="experienceid[]" id="experiencedid" value="{{$experience->id}}">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <label>Comapny Name</label>
                                <input type="text" class="companydetails" placeholder="Enter Company Name"
                                    name="company_name[]" value="{{$experience->company_name}}"/>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <label>Designation in Company</label>
                                <input type="text" class="companydetails" placeholder="Working As" name="working_as[]" value="{{$experience->designation}}"/>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <label>From</label>
                                <input type="month" class="companydetails" name="from[]" max="{{ date('Y-m') }}" value="{{$experience->from}}">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                @if ($experience->currently_working)
                                <span class="float-right small d-flex currenlyLog"><input type="checkbox"
                                        class="currentlyworking" name="currentlyWork" value="1"
                                        {{$experience->currently_working ? 'checked' : ''}}>Currently Working
                                </span>
                                @endif
                                <label>To</label>
                                <input type="month" class="companydetails" name="to[]" max="{{ date('Y-m') }}" value="{{$experience->to}}" {{$experience->currently_working ? 'disabled' : ''}}>
                            </div>
                            @if ($loop->iteration > 1)
                            <div class='col-md-12 mb-2'><button type="button" class='btn rounded p-3 float-right removecompany'>Remove</button></div>
                            @endif

                        </div>
                        @empty
                        <div class="row childcompany">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <label>Comapny Name</label>
                                <input type="text" class="companydetails" placeholder="Enter Company Name"
                                    name="company_name[]" />
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <label>Designation in Company</label>
                                <input type="text" class="companydetails" placeholder="Working As" name="working_as[]" />
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <label>From</label>
                                <input type="month" class="companydetails" name="from[]" max="{{ date('Y-m') }}">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <span class="float-right small d-flex currenlyLog"><input type="checkbox"
                                        class="currentlyworking" name="currentlyWork" value="1"
                                        value="{{ old('currentlyWork') }}">Currently Working
                                </span>
                                <label>To</label>
                                <input type="month" class="companydetails" name="to[]" max="{{ date('Y-m') }}">
                            </div>

                        </div>
                        @endforelse
                        

                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <button type="button" class="btn rounded p-3 float-right addmore">Add More</button>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label>Current CTC (In LPA)</label>
                            <input type="number" min="1" name="current_ctc" step=".01" 
                                placeholder="Enter Current CTC" value="{{ $trackerDetails->current_ctc }}">

                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label>Expected CTC (In LPA)</label>
                            <input type="number" min="1" name="expected_ctc" step=".01" 
                                placeholder="Enter Expected CTC" value="{{ $trackerDetails->expected_ctc }}">

                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label>Intrested Job Type</label>
                            <select name="intrested_job_type">
                                <option value="">Select Intrested Job Type</option>
                                <option value="part-time"
                                    {{ $trackerDetails->intrested_job_type == 'part-time' ? 'selected' : '' }}>Part Time
                                </option>
                                <option value="full-time"
                                    {{ $trackerDetails->intrested_job_type == 'full-time' ? 'selected' : '' }}>Full Time
                                </option>
                            </select>

                        </div>

                    </div>
                    <h3 style="margin-top: 20px;">Education Details</h3>
                    <hr>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label>10th Board name</label>
                            <input type="text" placeholder="Enter 10th Board" name="tenth_board"
                                value="{{ $trackerDetails->tenth_board_name }}" />
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label>10th Percentage</label>
                            <input type="number" placeholder="Enter 10th  %" min="40" max="100"
                                name="tenth_percentage" value="{{ $trackerDetails->tenth_percentage }}" />
                            @error('tenth_percentage')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label>10th Passing Year</label>
                            <input type="number" placeholder="Enter 10th Passing Year" min="{{ date('Y') - 50 }}"
                                max="{{ date('Y') }}" name="tenth_year"
                                value="{{ $trackerDetails->tenth_year }}" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label>12th Board name</label>
                            <input type="text" placeholder="Enter 12th Board" name="twelth_board"
                                value="{{ $trackerDetails->twelve_board_name }}" />
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label>12th Percentage</label>
                            <input type="number" placeholder="Enter 12th  %" min="40" max="100"
                                name="twelth_percentage" value="{{ $trackerDetails->twelve_percentage }}" />
                            @error('twelth_percentage')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label>12th Passing Year</label>
                            <input type="number" placeholder="Enter 12th Passing Year" min="{{ date('Y') - 50 }}"
                                max="{{ date('Y') }}" name="twelth_year"
                                value="{{ $trackerDetails->twelve_year }}" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label>Diploma Board</label>
                            <input type="text" placeholder="Diploma Board" name="diploma_board"
                                value="{{ $trackerDetails->diploma_board }}" />
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label>Diploma Percentage</label>
                            <input type="number" placeholder="Diploma %" min="40" max="100"
                                name="diploma_percentage" value="{{ $trackerDetails->diploma_percentage }}" />
                            @error('diploma_percentage')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label>Diploma In</label>
                            <input type="text" placeholder="Diploma In" name="diploma_field"
                                value="{{ $trackerDetails->diploma_field }}" />
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <label>Diploma Passing Year</label>
                            <input type="number" placeholder="Diploma passing year" min="{{ date('Y') - 50 }}"
                                max="{{ date('Y') }}" name="diploma_year"
                                value="{{ $trackerDetails->diploma_year }}" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label>Graduation Mode</label>
                            <select name="graduation_mode">
                                <option value="">Graduation Mode</option>
                                <option value="part-time"
                                    {{ $trackerDetails->graduation_mode == 'part-time' ? 'selected' : '' }}>Part Time
                                </option>
                                <option value="full-time"
                                    {{ $trackerDetails->graduation_mode == 'full-time' ? 'selected' : '' }}>Full Time
                                </option>
                            </select>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label>Degree Name</label>
                            <input type="text" placeholder="Degree Name" name="graduation"
                                value="{{ $trackerDetails->graduation }}" />
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label>Graduation Stream</label>
                            <input type="text" placeholder="Graduation Stream" name="graduation_stream"
                                value="{{ $trackerDetails->graduation_stream }}" />
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label>Graduation Percentage</label>
                            <input type="number" placeholder="Graduation %" min="40" max="100"
                                name="graduation_percentage" value="{{ $trackerDetails->graduation_percentage }}" />
                            @error('graduation_percentage')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label>Graduation Passing Year</label>
                            <input type="number" placeholder="Graduation Passing year" name="graduation_year"
                                min="{{ date('Y') - 50 }}" max="{{ date('Y') }}"
                                value="{{ $trackerDetails->graduation_year }}" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label>PG Mode</label>
                            <select name="post_graduation_mode">
                                <option value="">Post Graduation Mode</option>
                                <option value="part-time"
                                    {{ $trackerDetails->post_graduation_mode == 'part-time' ? 'selected' : '' }}>Part Time
                                </option>
                                <option value="full-time"
                                    {{ $trackerDetails->post_graduation_mode == 'full-time' ? 'selected' : '' }}>Full Time
                                </option>
                            </select>

                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label>PG Degree Name</label>
                            <input type="text" placeholder="Post Graduation Degree Name" name="post_graduation"
                                value="{{ $trackerDetails->post_graduation }}" />
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label>PG Stream</label>
                            <input type="text" placeholder="Post Graduation Stream Name" name="post_graduate_stream"
                                value="{{ $trackerDetails->post_graduate_stream }}" />
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label>PG Percentage(%)</label>
                            <input type="number" min="40" max="100" placeholder="Post Graduation %"
                                name="post_graduation_percentage"
                                value="{{ $trackerDetails->post_graduation_percentage }}" />
                            @error('post_graduation_percentage')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <label>PG Passing Year</label>
                            <input type="number" min="{{ date('Y') - 50 }}" max="{{ date('Y') }}"
                                placeholder="Post Graduation Passing year" name="post_graduation_year"
                                value="{{ $trackerDetails->post_graduation_year }}" />
                        </div>

                    </div>
                    <h3>Loaction Details</h3>
                    <hr>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label>Current Location</label>
                            <select name="current_location" id="current_location" required>
                                @for ($i = 0; $i < count($locations); $i++)
                                    <optgroup label="{{ $locations[$i]['state'] }}">
                                        @foreach ($locations[$i]['location'] as $locationvalue)
                                            <option value="{{ $locationvalue->location }}"
                                                {{ $trackerDetails->current_location == $locationvalue->location ? 'selected' : '' }}>
                                                {{ $locationvalue->location }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endfor
                            </select>

                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label>Preffered Loaction</label>
                            <select name="preffered_location" id="preffered_location" required>
                                @for ($i = 0; $i < count($locations); $i++)
                                    <optgroup label="{{ $locations[$i]['state'] }}">
                                        @foreach ($locations[$i]['location'] as $locationvalue)
                                            <option value="{{ $locationvalue->location }}"
                                                {{ $trackerDetails->preffered_location == $locationvalue->location ? 'selected' : '' }}>
                                                {{ $locationvalue->location }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label>Hometown State</label>
                            <select class="form-control" name="hometown_state" id="hometown_state">
                                <option value="">Select State</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->states_name }}"
                                        {{ $trackerDetails->hometown_state == $state->states_name ? 'selected' : '' }}>
                                        {{ $state->states_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label>Hometown City</label>
                            <input type="hidden" id="cityid" value="{{$trackerDetails->hometown_city}}">
                            <select class="form-control" name="hometown_city" id="hometown_city">
                                <option value="">Select City</option>
                            </select>
                        </div>
                    </div>
                    <h3 style="margin-top: 10px;">Personal Information</h3>
                    <hr>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label>Maritial Status</label>
                            <select style="outline: none;" name="maritial_status">
                                <option value="" disabled>Select Maritial Status</option>
                                <option value="unmarried"
                                    {{ $trackerDetails->maritial_status == 'unmarried' ? 'selected' : '' }}>Unmarried
                                </option>
                                <option value="married"
                                    {{ $trackerDetails->maritial_status == 'married' ? 'selected' : '' }}>Married</option>
                                <option value="other"
                                    {{ $trackerDetails->maritial_status == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label>Date of Birth</label>
                            <input type="date" name="dob" max="{{ date('Y-m-d') }}"
                                value="{{ $trackerDetails->dob }}" />
                            @error('dob')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        {{-- <div class="col-lg-4 col-md-6 col-sm-12">
                            <label>Resume</label>
                            <span style="color: red;"><i aria-hidden="true" class="fa fa-info ml-2 mr-1"></i></span>
                            <input type="file"
                                accept="application/pdf,application/msword,
                        application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                                name="resume">
                            @error('resume')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div> --}}
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label>Notice Period</label>
                            <select name="notice_period" style="outline: none;">
                                <option value="">Select From Here</option>
                                <option value="immediate"
                                    {{ $trackerDetails->notice_period == 'immediate' ? 'selected' : '' }}>Immediate
                                </option>
                                <option value="15" {{ $trackerDetails->notice_period == '15' ? 'selected' : '' }}>
                                    Within 15 days</option>
                                <option value="30" {{ $trackerDetails->notice_period == '30' ? 'selected' : '' }}>30
                                    days</option>
                                <option value="45" {{ $trackerDetails->notice_period == '45' ? 'selected' : '' }}>45
                                    days</option>
                                <option value="60" {{ $trackerDetails->notice_period == '60' ? 'selected' : '' }}>60
                                    days</option>
                                <option value="90" {{ $trackerDetails->notice_period == '90' ? 'selected' : '' }}>90
                                    days</option>
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <label><span class="text-danger">*</span> Reference </label>
                            <input type="hidden" id="referenceid" value="{{$trackerDetails->reference}}">
                            <select name="reference" id="reference" required>
                                <option value="">Select Reference Name</option>
                            </select>
                            @error('reference')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <label>Remarks</label>
                            <textarea placeholder="Remarks Here..." name="remarks">{{ $trackerDetails->remarks }}</textarea>
                        </div>

                    </div>
                    <div class="text-center mb-50">
                        <button type="submit" class="btn">Update</button>
                    </div>
                </form>
            </div>
            <!-- Recruitment Tracker container -->
            <div class="col-md-5">

                <div class="row">

                    <div class="col-md-12">
                        <form action="{{route('upload_tracker_resume')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="d-none">
                                <input type="hidden" name="id" value="{{$id}}">
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <label>Add / Update Resume </label>
                                    <input type="file" name="resume"
                                        accept="application/pdf,application/msword,
                                    application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                                        class="form-control" required/>
                                    @error('resume')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4 p-4 d-flex justify-content-center">
                                    <button type="submit" class="btn p-3 rounded">Upload</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12 mt-2">
                        <a class="btn p-3 rounded float-right" href="{{asset('tracker/resume/'.$trackerDetails->resume.'')}}" target="_blank" download><i
                                class="fas fa-download"></i> Resume</a>
                    </div>
                </div>
                <hr />
                <div class="col-md-12">
                    <div class="embed-responsive embed-responsive-1by1">
                        <iframe class="embed-responsive-item"
                            src="https://docs.google.com/gview?url={{asset('tracker/resume/'.$trackerDetails->resume.'')}}&embedded=true"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add reference Modal -->
    <div class="modal fade" id="addReference" tabindex="-1" role="dialog" aria-labelledby="addReferenceTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Reference</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form add_reference_form">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Reference Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="Enter Reference Name"
                                name="reference_name" required>
                        </div>
                        <div class="form-group">
                            <label for="">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control" placeholder="Enter Description" name="description" required>
                  </textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="{{ asset('assets/js/subuser/edit_tracker.js') }}"></script>
    <script src="{{ asset('assets/js/tagsinput.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-autocomplete.js') }}"></script>
@endsection
