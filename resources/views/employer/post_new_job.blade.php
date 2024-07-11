@extends('layouts.master', ['title' => 'Post New Job'])
@section('style')
    <style>
        label {
            font-weight: bold;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Post New Job</h1>
            </div>
            <div class="col-md-12">
                <form action="{{ route('store_new_job') }}" method="post">
                    @csrf
                    {{-- <legend>Job Post As</legend> --}}
                    <div class="row">
                        <div class="col-md-12 form-group row my-3">
                            <div class="col-md-12">
                                <h3 class="font-weight-bold" style="text-decoration: underline;">Job Post As</h3>
                            </div>

                            <div class="col-md-4">
                                <label class="col-form-label" for="">Select Job For</label>
                                <select class="form-control" name="job_for" id="job_for">
                                    <option value="">Select Job For</option>
                                    <option value="Jobseeker">Candidate/Jobseeker</option>
                                    <option value="Consultant">Consultant</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="">Select Job Sector</label>
                                <select class="form-control" name="job_sector_id" id="job_sector_id">
                                    <option value="">Select Job Sector</option>
                                    @foreach ($sector as $jobsector)
                                        <option value="{{ $jobsector->id }}">{{ $jobsector->job_sector }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="">Client Name <sub class="text-danger">(Not in
                                        List ?? Select 'others' and add new)</sub></label>
                                <select class="form-control" name="client_id" id="client_id">
                                    <option value="">Select Client Name</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                    <option value="add_client">Others</option>

                                </select>
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
                                <label class="col-form-label" for="job_title">Job Title</label>
                                <input type="text" class="form-control" name="title" placeholder="Enter Job Title">
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="job_industry_id">Select Industry</label>
                                <select class="form-control" name="job_industry_id" id="job_industry_id">
                                    <option value="">Select Industry</option>
                                    @foreach ($industries as $industry)
                                        <option value="{{ $industry->id }}">{{ $industry->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="job_functional_role_id">Select Functional Area</label>
                                <select class="form-control" name="job_functional_role_id" id="job_functional_role_id">
                                    <option value="">Select Functional area</option>
                                    @foreach ($functional_roles as $functional_role)
                                        <option value="{{ $functional_role->id }}">{{ $functional_role->subcategory_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="col-form-label" for="job_address">Address</label>
                                <input type="text" class="form-control" name="job_address" id="job_address"
                                    placeholder="Enter Address">
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="job_state_id">State</label>
                                <select class="form-control" name="job_state_id" id="job_state_id">
                                    <option value="">Select State</option>
                                    @foreach ($states as $state)
                                        <option value="{{ $state->id }}">{{ $state->states_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="job_city_id">City</label>
                                <select class="form-control" name="job_city_id" id="job_city_id">
                                    <option value="">Select City</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="job_posted_type_id">Posted</label>
                                <select class="form-control" name="job_posted_type_id" id="job_posted_type_id">
                                    <option value="">Select Posted</option>
                                    @foreach ($posted_type as $type)
                                        <option value="{{ $type->id }}">{{ $type->job_post_as }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="job_preference">Preference</label>
                                <select class="form-control" name="job_preference" id="job_preference">
                                    <option disabled value="">Select Preference</option>
                                    <option value="All">All</option>
                                    <option value="Men">Men</option>
                                    <option value="women">Women</option>
                                    <option value="Handicapped">Handicapped</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="col-form-label" for="job_category_id">Select Category</label>
                                        <select class="form-control" name="job_category_id" id="job_category_id">
                                            <option value="">Select Category</option>
                                            @foreach ($jobcategory as $category)
                                                <option value="{{ $category->id }}">{{ $category->job_category }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label" for="job_carreer_level">Select Career Level</label>
                                        <select class="form-control" name="job_carreer_level" id="job_carreer_level">
                                            <option value="">Select Carrier Level</option>
                                            @foreach ($careerlevel as $career)
                                                <option value="{{ $career->id }}">{{ $career->career_level }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="job_role">Role</label>
                                <input type="text" class="form-control" name="job_role" id="job_role"
                                    placeholder="Enter Role">
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="job_vaccancy">No. Of Vacancy</label>
                                <input type="number" name="job_vaccancy" id="job_vaccancy" class="form-control"
                                    placeholder="Enter No. of Vacancy">
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="col-form-label" for="main_exp">Select Experience</label>
                                        <select class="form-control" name="main_exp" id="main_exp">
                                            <option value="">Select Experience</option>
                                            @for ($i = 0; $i < 20; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>

                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label invisible" for="max_exp">Max Experience</label>
                                        <select class="form-control" name="max_exp" id="max_exp">
                                            <option value="">Select Max Experience</option>
                                            @for ($i = 0; $i < 20; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="start_apply_date">Start Apply Date</label>
                                <input type="date" class="form-control" min="{{ date('Y-m-d') }}"
                                    name="start_apply_date" id="start_apply_date">
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="last_apply_date">Last Apply Date</label>
                                <input type="date" class="form-control" name="last_apply_date"
                                    min="{{ date('Y-m-d') }}" id="last_apply_date">
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="col-form-label" for="grad_start_year">Graduation Year</label>
                                        <select class="form-control" name="grad_start_year" id="grad_start_year">
                                            <option value="">From</option>
                                            @for ($i = date('Y') - 60; $i < date('Y') + 1; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label invisible" for="grad_end_year">Graduation end
                                            year</label>
                                        <select class="form-control" name="grad_end_year" id="grad_end_year">
                                            <option value="">to</option>
                                            @for ($i = date('Y') - 60; $i < date('Y') + 1; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="">Select Job Type</label>
                                <select class="form-control" name="job_type_id" id="job_type_id">
                                    <option value="">Select Job Type</option>
                                    @foreach ($jobtypes as $jobtype)
                                        <option value="{{ $jobtype->id }}">{{ $jobtype->job_type }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="">Select Job Shift</label>
                                <select class="form-control" name="job_shift_id" id="job_shift_id">
                                    <option disabled value="">Select Shift</option>
                                    @foreach ($jobshifts as $jobshift)
                                        <option value="{{ $jobshift->id }}">{{ $jobshift->job_shift }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="">Location</label>
                                <select class="form-control" name="job_exp" id="job_exp">
                                    @for ($i = 0; $i < count($locations); $i++)
                                        <optgroup label="{{ $locations[$i]['state'] }}">
                                            @foreach ($locations[$i]['location'] as $locationvalue)
                                                <option value="{{ $locationvalue->location }}">
                                                    {{ $locationvalue->location }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="job_qualification_id">Select Qualification</label>
                                <select class="form-control" name="job_qualification_id" id="job_qualification_id">
                                    <option value="">Select Qualification</option>
                                    @foreach ($qualifications as $qualification)
                                        <option value="{{ $qualification->id }}">{{ $qualification->qualification }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label" for="sal_disclosed">Salary Disclosed</label>
                                <select class="form-control" name="sal_disclosed" id="sal_disclosed">
                                    <option value="">Select Salary Disclosed</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="col-form-label" for="offered_sal_min">Salary per year</label>
                                        <input type="number" min="0" class="form-control salarydisclosed"
                                            name="offered_sal_min" id="offered_sal_min" placeholder="from">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label invisible" for="offered_sal_max">Max Salary</label>
                                        <input type="number" min="0" class="form-control salarydisclosed"
                                            name="offered_sal_max" id="offered_sal_max" placeholder="to">
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
                            <textarea class="form-control" name="description" id="description" cols="30" rows="5"></textarea>
                        </div>
                        <div class="col-md-12">
                            <hr class="font-weight-bold" style="border-bottom: 1px solid black;">
                            </hr>
                        </div>

                        <div class="col-md-12">
                            <h3 class="font-weight-bold" style="text-decoration: underline;">Meta Tags</h3>
                        </div>
                        <div class="col-md-12 form-group row">
                            <div class="col-md-12">
                                <label for="meta_title">Meta Title</label>
                                <input type="text" class="form-control" name="meta_title"
                                    placeholder="Enter Meta Title" id="meta_title">
                            </div>
                            <div class="col-md-12 my-2">
                                <label for="meta_keywords">Meta Keywords</label>
                                <input type="text" class="form-control" name="meta_keywords"
                                    placeholder="Enter Meta Keywords" id="meta_keywords">
                            </div>
                            <div class="col-md-12 my-2">
                                <label for="meta_description">Meta Description</label>
                                <input type="text" class="form-control" name="meta_description"
                                    placeholder="Enter Meta Description" id="meta_description">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <hr class="font-weight-bold" style="border-bottom: 1px solid black;">
                            </hr>
                        </div>

                        <div class="col-md-12">
                            <h3 class="font-weight-bold" style="text-decoration: underline;">Skills</h3>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="">Skills</label>
                            <textarea class="form-control" name="job_skills" id="job_skills" cols="30" rows="5"
                                placeholder="Enter Skills And Requirements............">
                            </textarea>
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
                            <input class="form-control" type="text" name="job_keywords" id="job_keywords">
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
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>


                        <div class="col-md-12 select_questionarie" style="display: none">
                            <h3 class="font-weight-bold" style="text-decoration: underline;">Add Questionnaire</h3>
                        </div>

                        <div class="col-md-12 form-group select_questionarie" style="display: none;">
                            <select class="form-control" name="job_questionnarie_id" id="job_questionnarie_id">
                                <option value="" disabled="">Select Questionarie</option>
                                @foreach ($questions as $question)
                                    <option value="{{ $question->id }}">{{ $question->name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <button type="submit" class="btn mb-2">Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/editpost.js') }}"></script>
@endsection
