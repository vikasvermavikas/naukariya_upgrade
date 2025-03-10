@extends('layouts.master', ['title' => 'Edit Post Job'])
@section('style')
    <style>
        label {
            font-weight: bold;
        }
        h3{
            color : #e5500b;
            font-weight: bold;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            @if(session()->has('error'))
            <div class="col-md-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{session()->get('message')}}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            </div>
            @endif
            <div class="col-md-12">
                <h1>Edit Post Job</h1>
            </div>
            <div class="col-md-12 border my-2">
                <form action="{{route('update_posted_job', ['id' => $id])}}" method="post">
                    @csrf
                    {{-- <legend>Job Post As</legend> --}}
                    <div class="row">
                        <div class="col-md-12 form-group row my-3">
                            <div class="col-md-12">
                                <h3 class="font-weight-bold" style="text-decoration: underline;">Job Post As</h3>
                            </div>

                            <div class="col-md-4">
                                <label class="col-form-label" for="">Select Job For <span class="text-danger">*</span></label>
                                <select class="form-control" name="job_for" id="job_for" required>
                                    <option value="">Select Job For</option>
                                    <option value="Jobseeker" {{$data->job_for == 'Jobseeker' ? 'selected' : ''}}>Candidate/Jobseeker</option>
                                    <option value="Consultant" {{$data->job_for == 'Consultant' ? 'selected' : ''}}>Consultant</option>
                                </select>
                                @error('job_for')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="">Select Job Sector <span class="text-danger">*</span></label>
                                <select class="form-control" name="job_sector_id" id="job_sector_id" required>
                                    <option value="">Select Job Sector</option>
                                    @foreach ($sector as $jobsector)
                                        <option value="{{ $jobsector->id }}" {{$data->job_sector_id == $jobsector->id ? 'selected' : ''}}>{{ $jobsector->job_sector }}</option>
                                    @endforeach
                                </select>
                                 @error('job_sector_id')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="">Client Name <sub class="text-danger">(Not in
                                        List ?? Select 'others' and add new) *</sub></label>
                                <select class="form-control" name="client_id" id="client_id" required>
                                    <option value="">Select Client Name</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}" {{$data->client_id == $client->id ? 'selected' : ''}}>{{ $client->name }}</option>
                                    @endforeach
                                    {{-- <option value="add_client">Others</option> --}}

                                </select>
                                 @error('client_id')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">

                            <hr class="font-weight-bold" style="border-bottom: 1px solid black;">
                            </hr>
                        </div>

                        <div class="col-md-12 form-group row">
                            <div class="col-md-12">
                                <h3 class="font-weight-bold" style="text-decoration: underline;">General Information</h3>
                            </div>

                            <div class="col-md-4">
                                <label class="col-form-label" for="job_title">Job Title <span class="text-danger">*</span></label>
                                <input type="text" maxlength="25" class="form-control" name="title" placeholder="Enter Job Title" value="{{$data->title}}" required>
                                   @error('title')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="job_industry_id">Select Industry <span class="text-danger">*</span></label>
                                <select class="form-control" name="job_industry_id" id="job_industry_id" required>
                                    <option value="">Select Industry</option>
                                    @foreach ($industries as $industry)
                                        <option value="{{ $industry->id }}" {{$data->job_industry_id == $industry->id ? 'selected' : ''}}>{{ $industry->category_name }}</option>
                                    @endforeach
                                </select>
                                 @error('job_industry_id')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="job_functional_role_id">Select Functional Area <span class="text-danger">*</span></label>
                                <select class="form-control" name="job_functional_role_id" id="job_functional_role_id" required>
                                    <option value="">Select Functional area</option>
                                    @foreach ($functional_roles as $functional_role)
                                        <option value="{{ $functional_role->id }}" {{$data->job_functional_role_id == $functional_role->id ? 'selected' : ''}}>{{ $functional_role->subcategory_name }}
                                        </option>
                                    @endforeach
                                </select>
                                 @error('job_functional_role_id')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="company_id">Company <span class="text-danger">*</span></label>
                                <select class="form-control" name="company_id" id="company_id" disabled>
                                    <option value="">Select Company</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}" {{$data->company_id == $company->id ? 'selected' : ''}}>{{ $company->company_name }}</option>
                                    @endforeach
                                </select>
                                 @error('company_id')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="job_address">Address <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="job_address" id="job_address"
                                    placeholder="Enter Address" value="{{$data->job_address}}" required>
                                     @error('job_address')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="job_state_id">State <span class="text-danger">*</span></label>
                                <select class="form-control" name="job_state_id" id="job_state_id" required>
                                    <option value="">Select State</option>
                                    @foreach ($states as $state)
                                        <option value="{{ $state->id }}" {{$data->job_state_id == $state->id ? 'selected' : ''}}>{{ $state->states_name }}</option>
                                    @endforeach
                                </select>
                                 @error('job_state_id')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="job_city_id">City <span class="text-danger">*</span></label>
                                <select class="form-control" name="job_city_id" id="job_city_id" required>
                                    <option value="">Select City</option>
                                    @foreach ($cities as $city)
                                    <option value="{{$city->id}}" {{$data->job_city_id == $city->id ? 'selected' : ''}}>{{$city->cities_name}}</option>
                                    @endforeach
                                </select>
                                 @error('job_city_id')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="job_posted_type_id">Posted <span class="text-danger">*</span></label>
                                <select class="form-control" name="job_posted_type_id" id="job_posted_type_id" required>
                                    <option value="">Select Posted</option>
                                    @foreach ($posted_type as $type)
                                        <option value="{{ $type->id }}" {{$data->job_posted_type_id == $type->id ? 'selected' : ''}}>{{ $type->job_post_as }}</option>
                                    @endforeach
                                </select>
                                 @error('job_posted_type_id')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="job_preference">Preference</label>
                                <select class="form-control" name="job_preference" id="job_preference" required>
                                    <option disabled value="">Select Preference</option>
                                    <option value="All" {{$data->job_preference == 'All' ? 'selected' : ''}}>All</option>
                                    <option value="Men" {{$data->job_preference == 'Men' ? 'selected' : ''}}>Men</option>
                                    <option value="women" {{$data->job_preference == 'women' ? 'selected' : ''}}>Women</option>
                                    <option value="Handicapped" {{$data->job_preference == 'Handicapped' ? 'selected' : ''}}>Handicapped</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="col-form-label" for="job_category_id">Select Category <span class="text-danger">*</span></label>
                                        <select class="form-control" name="job_category_id" id="job_category_id" required>
                                            <option value="">Select Category</option>
                                            @foreach ($jobcategory as $category)
                                                <option value="{{ $category->id }}" {{$data->job_category_id == $category->id ? 'selected' : ''}}>{{ $category->job_category }}
                                                </option>
                                            @endforeach
                                        </select>
                                         @error('job_category_id')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label" for="job_carreer_level">Select Career Level <span class="text-danger">*</span></label>
                                        <select class="form-control" name="job_carreer_level" id="job_carreer_level" required>
                                            <option value="">Select Carrier Level</option>
                                            @foreach ($careerlevel as $career)
                                                <option value="{{ $career->id }}" {{$data->job_carreer_level == $career->id ? 'selected' : ''}}>{{ $career->career_level }}</option>
                                            @endforeach

                                        </select>
                                         @error('job_carreer_level')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="job_role">Role <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="job_role" id="job_role"
                                    placeholder="Enter Role" value="{{$data->job_role}}" required>
                                     @error('job_role')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="job_vaccancy">No. Of Vacancy <span class="text-danger">*</span></label>
                                <input type="number" name="job_vaccancy" id="job_vaccancy" class="form-control"
                                    placeholder="Enter No. of Vacancy" min="1" value="{{$data->job_vaccancy}}" required>
                                     @error('job_vaccancy')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="col-form-label" for="main_exp">Select Experience <span class="text-danger">*</span></label>
                                        <select class="form-control" name="main_exp" id="main_exp" required>
                                            <option value="">Select Experience</option>
                                            @for ($i = 0; $i < 20; $i++)
                                                <option value="{{ $i }}" {{$data->main_exp == $i ? 'selected' : ''}}>{{ $i }}</option>
                                            @endfor
                                        </select>
                                         @error('main_exp')
                                <span class="text-danger">{{$message}}</span>
                                @enderror

                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label invisible" for="max_exp">Max Experience <span class="text-danger">*</span></label>
                                        <select class="form-control" name="max_exp" id="max_exp" required>
                                            <option value="">Select Max Experience</option>
                                            @for ($i = 0; $i < 20; $i++)
                                                <option value="{{ $i }}"  {{$data->max_exp == $i ? 'selected' : ''}}>{{ $i }}</option>
                                            @endfor
                                        </select> 
                                         @error('max_exp')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="start_apply_date">Start Apply Date</label>
                                <input type="date" class="form-control" name="start_apply_date"
                                    id="start_apply_date" value="{{$data->start_apply_date}}">
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="last_apply_date">Last Apply Date</label>
                                <input type="date" class="form-control" name="last_apply_date" id="last_apply_date" value="{{$data->last_apply_date}}">
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="col-form-label" for="grad_start_year">Graduation Year</label>
                                        <select class="form-control" name="grad_start_year" id="grad_start_year">
                                            <option value="">From</option>
                                            @for ($i = date('Y') - 60; $i < date('Y') + 1; $i++)
                                                <option value="{{ $i }}"  {{$data->grad_start_year == $i ? 'selected' : ''}}>{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label invisible" for="grad_end_year">Graduation end
                                            year</label>
                                        <select class="form-control" name="grad_end_year" id="grad_end_year">
                                            <option value="">to</option>
                                            @for ($i = date('Y') - 60; $i < date('Y') + 1; $i++)
                                                <option value="{{ $i }}" {{$data->grad_end_year == $i ? 'selected' : ''}}>{{ $i }}</option>
                                            @endfor
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="">Select Job Type <span class="text-danger">*</span></label>
                                <select class="form-control" name="job_type_id" id="job_type_id" required>
                                    <option value="">Select Job Type</option>
                                    @foreach ($jobtypes as $jobtype)
                                        <option value="{{ $jobtype->id }}"  {{$data->job_type_id == $jobtype->id ? 'selected' : ''}}>{{ $jobtype->job_type }}</option>
                                    @endforeach

                                </select>
                                 @error('job_type_id')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="">Select Job Shift <span class="text-danger">*</span></label>
                                <select class="form-control" name="job_shift_id" id="job_shift_id" required>
                                    <option disabled value="">Select Shift</option>
                                    @foreach ($jobshifts as $jobshift)
                                        <option value="{{ $jobshift->id }}"  {{$data->job_shift_id == $jobshift->id ? 'selected' : ''}}>{{ $jobshift->job_shift }}</option>
                                    @endforeach
                                </select>
                                 @error('job_shift_id')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="">Location <span class="text-danger">*</span></label>
                                <select class="form-control" name="job_exp" id="job_exp" required>
                                    @for ($i = 0; $i < count($locations); $i++)
                                    <optgroup label="{{$locations[$i]['state']}}">
                                        @foreach ($locations[$i]['location'] as $locationvalue)
                                        <option value="{{$locationvalue->location}}" {{$data->job_exp == $locationvalue->location ? 'selected' : ''}}>
                                            {{$locationvalue->location}}
                                        </option>
                                        @endforeach
                                    </optgroup>
                                    @endfor
                                </select>
                                 @error('job_exp')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="job_qualification_id">Select Qualification <span class="text-danger">*</span></label>
                                <select class="form-control" name="job_qualification_id" id="job_qualification_id" required>
                                    <option value="">Select Qualification</option>
                                    @foreach ($qualifications as $qualification)
                                    <option value="{{ $qualification->id }}"  {{$data->job_qualification_id == $qualification->id ? 'selected' : ''}}>{{ $qualification->qualification }}</option>
                                @endforeach
                                </select>
                                 @error('job_qualification_id')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="sal_disclosed">Salary Disclosed</label>
                                <select class="form-control" name="sal_disclosed" id="sal_disclosed">
                                    <option value="">Select Salary Disclosed</option>
                                    <option value="Yes" {{$data->sal_disclosed == 'Yes' ? 'selected' : ''}}>Yes</option>
                                    <option value="No" {{$data->sal_disclosed == 'No' ? 'selected' : ''}}>No</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="col-form-label" for="offered_sal_min">Salary per year</label>
                                        <input type="number" min="0" class="form-control salarydisclosed" name="offered_sal_min"
                                            id="offered_sal_min" placeholder="from" value="{{$data->offered_sal_min}}" {{$data->sal_disclosed == 'No' ? 'disabled' : ''}}>
                                            @error('offered_sal_min')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label invisible" for="offered_sal_max">Max Salary</label>
                                        <input type="number" min="0" class="form-control salarydisclosed" name="offered_sal_max"
                                            id="offered_sal_max" placeholder="to" value="{{$data->offered_sal_max}}" {{$data->sal_disclosed == 'No' ? 'disabled' : ''}}>
                                             @error('offered_sal_max')
                                            <span class="text-danger">{{$message}}</span>
                                            @enderror
                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="col-md-12">
                            <hr class="font-weight-bold" style="border-bottom: 1px solid black;">
                            </hr>
                        </div>

                        <div class="col-md-12">
                            <h3 class="font-weight-bold" style="text-decoration: underline;">Job Description &
                                Responsibility</h3>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="">Job Description</label>
                            <textarea class="form-control" name="description" id="description" cols="30" rows="5" >
                                {!! $data->description !!}
                            </textarea>
                             @error('description')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                        </div>
                        <div class="col-md-12">
                            <hr class="font-weight-bold" style="border-bottom: 1px solid black;">
                            </hr>
                        </div>

                        <div class="col-md-12">
                            <h3 class="font-weight-bold" style="text-decoration: underline;">Skills</h3>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="">Skills (Separate by comma ( , ) for multiple skills) <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="job_skills" id="job_skills" cols="30" rows="5"
                                placeholder="Enter Skills And Requirements............" required>{{$data->job_skills}}</textarea>
                                 @error('job_skills')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                        </div>
                        <div class="col-md-12">
                            <hr class="font-weight-bold" style="border-bottom: 1px solid black;">
                            </hr>
                        </div>

                        <div class="col-md-12">
                            <h3 class="font-weight-bold" style="text-decoration: underline;">Keywords</h3>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="">Keywords</label>
                            <input class="form-control" type="text" name="job_keywords" id="job_keywords" value="{{$data->job_keywords}}">
                             @error('job_keywords')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                        </div>
                        <div class="col-md-12">
                            <hr class="font-weight-bold" style="border-bottom: 1px solid black;">
                            </hr>
                        </div>

                        <div class="col-md-12">
                            <h3 class="font-weight-bold" style="text-decoration: underline;">Questionarie</h3>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="">Do you want to add Questionnarie</label>
                            <select class="form-control" name="add_questionnarie" id="add_questionnarie">
                            <option value="">Select Any One</option>
                            <option value="Yes" {{$data->add_questionnarie == 'Yes' ? 'selected' : ''}}>Yes</option>
                            <option value="No" {{$data->add_questionnarie == 'No' ? 'selected' : ''}}>No</option>
                        </select>

                        </div>


                        <div class="col-md-12 select_questionarie" {{$data->add_questionnarie == 'No' || empty($data->add_questionnarie) ? 'style=display:none;' : ''}}>
                            <h3 class="font-weight-bold" style="text-decoration: underline;">Add Questionnaire</h3>
                        </div>

                        <div class="col-md-12 form-group select_questionarie" {{$data->add_questionnarie == 'No' || empty($data->add_questionnarie) ? 'style=display:none;' : ''}}>
                            <select class="form-control" name="job_questionnarie_id" id="job_questionnarie_id" >
                            <option value="" disabled="">Select Questionarie</option>
                            @foreach ($questions as $question)
                            <option value="{{ $question->id }}" {{$data->job_questionnarie_id == $question->id ? 'selected' : ''}}>{{ $question->name }}</option>
                        @endforeach
                        </select>
                        </div>


                        <button class="btn mb-2 mr-2">Update</button>
                        <a href="{{route('postedjobs')}}" class="btn mb-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/editpost.js') }}"></script>
@endsection
