@extends('layouts.master', ['title' => 'Video Resume'])
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 my-3">
                <h2>Video Resume</h2>
            </div>
            <div class="col-md-12 my-2">
                <div class="card mb-2">
                    <div class="card-header pt-1 pb-1" style="background:#e35e25;" id="contentofvideoresume">
                        <h4 class="mb-0">
                            <span class="text-light" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
                                aria-controls="collapseTwo">
                                Content Of Video Resume
                            </span>
                        </h4>
                    </div>

                    <div id="headingTwo" class="collapse show" aria-labelledby="contentofvideoresume"
                        data-parent="#faqExample">
                        <div class="card-body">
                            <p>
                                <b>For creating efficient video resume one should make
                                    checklist of points to be covered. You can check below
                                    points for your reference.</b>
                            </p>
                            <p><b></b></p>
                            <p><b>Name of the Applicant</b></p>
                            <p><b>General Information</b></p>
                            <ul>
                                <li>Father&rsquo;s Name</li>
                                <li>Qualification (Graduation)</li>
                                <li>Post-Graduation</li>
                                <li>Total Experience (Years + Months)</li>
                                <li>Relevant Experience (Y+M)</li>
                                <li>Currently Working / Not Working</li>
                                <li>Date of Birth (DD/MM/YYYY)</li>
                            </ul>
                            <br>
                            <p><b>Educational Qualification</b></p>
                            <ul>
                                <li>Post-Graduation</li>
                                <li>Graduation></li>
                                <li>Higher Secondary></li>
                                <li>Intermediate ></li>
                                <li>Extra Qualification</li>
                                <li>Diploma (If Any)</li>
                            </ul>
                            <br>
                            <p><b>Employment Details</b></p>
                            <p><b>Employer with Name and Tenure </b></p>
                            <p><b>Designation </b></p>
                            <ul>
                                <li><b>Technology / Framework </b></li>
                                <li>
                                    <b>Roles and Responsibilities in the Job </b>
                                </li>
                            </ul>
                            <br>
                            <p><b>Previous Employment Details</b></p>
                            <ul>
                                <li>Previous Employer with Name and Tenure</li>
                                <li>Designation</li>
                                <li>Technology / Framework</li>
                                <li>Roles and Responsibilities in the Job></li>
                            </ul>
                            <br>
                            <p><b>Strengths</b></p>
                            <p><b>Weaknesse </b></p>
                            <p><b>Hobbies </b></p>
                            <p><b>Any other Details</b></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
