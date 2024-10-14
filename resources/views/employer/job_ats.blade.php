@extends('layouts.master', ['title' => $jobdetails->title])
@section('style')
<link href="{{asset('assets/css/employer/jobseeker_ats.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-5">
                    {{ Breadcrumbs::render('job_ats') }}
            </div>
            <div class="col-md-12">
            <h2 class="my-2">Relevent Jobseekers for <span style="color:#e35e25;">{{ $jobdetails->title }}</span></h2>
            </div>

            <div class="col-sm-12">

                <a href="{{ route('managejobs') }}" class="btn float-right mb-3 rounded">Back</a>
            </div>
            <div class="col-md-12 my-2">
                @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session()->get('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
            @endif
            </div>
           <!--  <div class="col-md-12 mb-3 rounded" style="background:#F95602">
                <ul class="nav nav-tabs nav-fill">
                    <li class="nav-item active"><a data-toggle="tab" href="#All" class="nav-link fs-12 active">All</a>
                    </li>
                    <li class="nav-item"><a data-toggle="tab" href="#NewApplied" class="nav-link fs-12 border-right-0"
                            aria-expanded="false">New Applied</a></li>
                    <li class="nav-item"><a data-toggle="tab" href="#Shortlisted" class="nav-link fs-12 border-right-0"
                            aria-expanded="false">Shortlisted</a></li>
                    <li class="nav-item"><a data-toggle="tab" href="#Rejected" class="nav-link fs-12 border-right-0"
                            aria-expanded="false">Rejected</a></li>
                    <li class="nav-item"><a data-toggle="tab" href="#InterviewScheduled"
                            class="nav-link fs-12 border-right-0" aria-expanded="false">Interview
                            Scheduled</a></li>
                    <li class="nav-item"><a data-toggle="tab" href="#Offer" class="nav-link fs-12 border-right-0"
                            aria-expanded="true">Offer</a></li>
                    <li class="nav-item"><a data-toggle="tab" href="#Hire"
                            class="nav-link fs-12 border-right-0">Joining</a></li>
                    <li class="nav-item"><a data-toggle="tab" href="#SaveForFuture"
                            class="nav-link fs-12 border-right-0">Save / Hold For Future</a></li>
                </ul>
            </div> -->

            <!-- Filter Form -->

            <div class="col-md-12 mb-5">
                <form action="" class="form-inline">
                    <div class="form-group custom-form-margin">
                        <label class="form-label">Select Category</label>
                        <select class="form-control mx-4 custom-margin" name="category">
                            <option value="all" {{$category == 'all' ? 'selected'  : ''}}>All</option>
                            <option value="1" {{$category == '1' ? 'selected'  : ''}}>New Applied</option>
                            <option value="3" {{$category == '3' ? 'selected'  : ''}}>Shortlisted</option>
                            <option value="4" {{$category == '4' ? 'selected'  : ''}}>Rejected</option>
                            <option value="2" {{$category == '2' ? 'selected'  : ''}}>Interview
                            Scheduled</option>
                            <option value="5" {{$category == '5' ? 'selected'  : ''}}>Offer</option>
                            <option value="6" {{$category == '6' ? 'selected'  : ''}}>Joining</option>
                            <option value="7" {{$category == '7' ? 'selected'  : ''}}>Save / Hold For Future</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="btn rounded p-3">Submit</button>
                    </div>
                </form>
            </div>

            <!-- Job ats -->
            <p style="color:#e35e25;">Total Candidates : <span class="text-dark">{{$totalrecord}}</span></p>
            <!-- End Filter Form -->

             <!-- Render Pagination -->
            <div class="col-md-12 my-3 d-flex justify-content-center">
                {{$data->onEachSide(0)->links()}}
            </div>

            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead style="background:#f95602;" class="text-light">
                            <tr>
                                <th>Name</th>
                                <th>Applied On</th>
                                <th>Exp.</th>
                                <th>Current Desig.</th>
                                <th>Exp. Salary</th>
                                <th>Notice Period</th>
                                <th>Staus</th>
                                <th>Match Percentage</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <div class="tab-content">
                            <tbody id="All" class="tab-pane fade active show">
                                @forelse($data as $item)
                                    <tr>
                                        <td class="text-capitalize"> {{ $item->fname }}
                                            {{ $item->lname ? $item->lname : '' }}
                                            @if ($item->resume)
                                            <p>
                                                <a href="{{ asset('resume/' . $item->resume . '') }}"
                                                    class="text-primary underline" title="Download Resume"
                                                    target="_blank">Download Resume <i class="fas fa-download"
                                                        aria-hidden="true"></i></a>
                                            </p>
                                            @endif
                                        </td>
                                        <td>{{ $item->job_id == $jobid ? $item->created_at : 'Not Applied'}}</td>
                                        <td>{{ $item->exp_year && $item->exp_month ? $item->exp_year." years " .$item->exp_month." months " : 'Not Mentioned' }}</td>
                                        <td>{{ $item->designation ? $item->designation : 'Not Mentioned' }}</td>
                                        <td>{{ $item->expected_salary ? $item->expected_salary." LPA" : 'Not Mentioned' }}</td>
                                        <td>{{ $item->notice_period ? $item->notice_period : 'Not Mentioned' }}</td>
                                        <td>
                                            @if($item->status && $item->job_id == $jobid)

                                            @if ($item->status == 1)
                                                Applied
                                            @elseif ($item->status == 2)
                                                Interview Scheduled
                                            @elseif ($item->status == 3)
                                                Shortlisted
                                            @elseif ($item->status == 4)
                                                Rejected
                                            @elseif ($item->status == 5)
                                                Offer Letter
                                            @elseif ($item->status == 6)
                                                Joining
                                            @elseif ($item->status == 7)
                                                Save / Hold
                                            @else
                                                NA
                                            @endif
                                            @else
                                            Pending
                                            @endif



                                        </td>
                                        <td>{{jobseeker_match_skill($jobid, $item->jobseekerid)}} %</td>
                                        <td>
                                            @if ($item->id && $item->job_id == $jobid)
                                            @if ($item->status == 3)
                                                <i style="color:#f95602;" class="fa fa-check" aria-hidden="true"></i>
                                            @else
                                                <a href="{{ route('application_shortlist', ['id' => $item->id]) }}"
                                                    title="shortlist">
                                                    <i style="color:#f95602;" class="fa fa-check" aria-hidden="true"></i>
                                                </a>
                                            @endif

                                            @if ($item->status == 4)
                                                <i style="color:#f95602;" class="fa fa-times" aria-hidden="true"></i>
                                            @else
                                                <a href="{{ route('application_reject', ['id' => $item->id]) }}"
                                                    title="reject">
                                                    <i style="color:#f95602;" class="fa fa-times" aria-hidden="true"></i>
                                                </a>
                                            @endif

                                            @if ($item->status == 2)
                                                <i style="color:#f95602;" class="fa fa-clock" aria-hidden="true"></i>
                                            @else
                                                <span data-toggle="modal" data-target="#interview_modal"
                                                    data-whatever="{{ $item->id }}" title="schedule Interview">
                                                    <i style="color:#f95602;" class="fa fa-clock" aria-hidden="true"></i>
                                                </span>
                                            @endif

                                            @if ($item->status == 5)
                                                <i style="color:#f95602;" class="fas fa-file-archive"
                                                    aria-hidden="true"></i>
                                            @else
                                                <a href="{{ route('application_offer', ['id' => $item->id]) }}"
                                                    title="send offer mail">
                                                    <i style="color:#f95602;" class="fas fa-file-archive"
                                                        aria-hidden="true"></i>
                                                </a>
                                            @endif

                                            @if ($item->status == 6)
                                                <i style="color:#f95602;" class="fa fa-thumbs-up" aria-hidden="true"></i>
                                            @else
                                                <a href="{{ route('application_hire', ['id' => $item->id]) }}"
                                                    title="hire applicant">
                                                    <i style="color:#f95602;" class="fa fa-thumbs-up"
                                                        aria-hidden="true"></i>
                                                </a>
                                            @endif

                                            @if ($item->status == 7)
                                                <i style="color:#f95602;" class="fa fa-star" aria-hidden="true"></i>
                                            @else
                                                <a href="{{ route('application_save', ['id' => $item->id]) }}"
                                                    title="save application">
                                                    <i style="color:#f95602;" class="fa fa-star" aria-hidden="true"></i>
                                                </a>
                                            @endif

                                            @else
                                              Not Applied
                                            @endif

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-danger" colspan="8">No Record Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                         <!--    <tbody id="NewApplied" class="tab-pane fade">
                                @php
                                    $isApplied = false;                                    
                                @endphp
                                @forelse($data as $item)
                                    @if ($item->status == 1 && $item->job_id == $jobid)
                                    @php $isApplied = true; @endphp
                                        <tr>
                                            <td> {{ $item->fname }}
                                                {{ $item->lname ? $item->lname : '' }}
                                                <p>
                                                    <a href="{{ asset('resume/' . $item->resume . '') }}"
                                                        class="text-primary underline" title="Download Resume"
                                                        target="_blank">Download Resume <i class="fas fa-download"
                                                            aria-hidden="true"></i></a>
                                                </p>
                                            </td>
                                            <td>{{ $item->job_id == $jobid ? $item->created_at : '' }}</td>
                                            <td>{{ $item->exp_year }} - {{ $item->exp_month }}</td>
                                            <td>{{ $item->designation }}</td>
                                            <td>{{ $item->expected_salary }}</td>
                                            <td>{{ $item->notice_period }}</td>
                                            <td>Applied</td>
                                            <td>
                                                <a href="{{ route('application_shortlist', ['id' => $item->id]) }}"
                                                    title="shortlist">
                                                    <i style="color:#f95602;" class="fa fa-check" aria-hidden="true"></i>
                                                </a>
                                                <a href="{{ route('application_reject', ['id' => $item->id]) }}"
                                                    title="reject">
                                                    <i style="color:#f95602;" class="fa fa-times" aria-hidden="true"></i>
                                                </a>
                                                <span data-toggle="modal" data-target="#interview_modal"
                                                    data-whatever="{{ $item->id }}" title="schedule Interview">
                                                    <i style="color:#f95602;" class="fa fa-clock" aria-hidden="true"></i>
                                                </span>

                                                <a href="{{ route('application_offer', ['id' => $item->id]) }}"
                                                    title="send offer mail">
                                                    <i style="color:#f95602;" class="fas fa-file-archive"
                                                        aria-hidden="true"></i>
                                                </a>

                                                <a href="{{ route('application_hire', ['id' => $item->id]) }}"
                                                    title="hire applicant">
                                                    <i style="color:#f95602;" class="fa fa-thumbs-up"
                                                        aria-hidden="true"></i>
                                                </a>

                                                <a href="{{ route('application_save', ['id' => $item->id]) }}"
                                                    title="save application">
                                                    <i style="color:#f95602;" class="fa fa-star" aria-hidden="true"></i>
                                                </a>

                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td class="text-danger" colspan="8">No Record Found</td>
                                    </tr>
                                @endforelse
                                @if (!$isApplied)
                                <tr>
                                    <td class="text-danger" colspan="8">No Record Found</td>
                                </tr>                                    
                                @endif
                            </tbody>
                            @php $isShortlisted = false; @endphp
                            <tbody id="Shortlisted" class="tab-pane fade">
                                @forelse($data as $item)
                                @if ($item->status == 3 && $item->job_id == $jobid)
                                
                                @php $isShortlisted = true; @endphp
                                        <tr>
                                            <td> {{ $item->fname }}
                                                {{ $item->lname ? $item->lname : '' }}
                                                <p>
                                                    <a href="{{ asset('resume/' . $item->resume . '') }}"
                                                        class="text-primary underline" title="Download Resume"
                                                        target="_blank">Download Resume <i class="fas fa-download"
                                                            aria-hidden="true"></i></a>
                                                </p>
                                            </td>
                                            <td>{{ $item->job_id == $jobid ? $item->created_at : '' }}</td>
                                            <td>{{ $item->exp_year }} - {{ $item->exp_month }}</td>
                                            <td>{{ $item->designation }}</td>
                                            <td>{{ $item->expected_salary }}</td>
                                            <td>{{ $item->notice_period }}</td>
                                            <td>Shortlisted</td>
                                            <td>

                                                <i style="color:#f95602;" class="fa fa-check" aria-hidden="true"></i>

                                                <a href="{{ route('application_reject', ['id' => $item->id]) }}"
                                                    title="reject">
                                                    <i style="color:#f95602;" class="fa fa-times" aria-hidden="true"></i>
                                                </a>
                                                <span data-toggle="modal" data-target="#interview_modal"
                                                    data-whatever="{{ $item->id }}" title="schedule Interview">
                                                    <i style="color:#f95602;" class="fa fa-clock" aria-hidden="true"></i>
                                                </span>

                                                <a href="{{ route('application_offer', ['id' => $item->id]) }}"
                                                    title="send offer mail">
                                                    <i style="color:#f95602;" class="fas fa-file-archive"
                                                        aria-hidden="true"></i>
                                                </a>

                                                <a href="{{ route('application_hire', ['id' => $item->id]) }}"
                                                    title="hire applicant">
                                                    <i style="color:#f95602;" class="fa fa-thumbs-up"
                                                        aria-hidden="true"></i>
                                                </a>

                                                <a href="{{ route('application_save', ['id' => $item->id]) }}"
                                                    title="save application">
                                                    <i style="color:#f95602;" class="fa fa-star" aria-hidden="true"></i>
                                                </a>

                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td class="text-danger" colspan="8">No Record Found</td>
                                    </tr>
                                @endforelse
                                @if (!$isShortlisted)
                                <tr>
                                    <td class="text-danger" colspan="8">No Record Found</td>
                                </tr>
                                @endif
                            </tbody>
                            <tbody id="Rejected" class="tab-pane fade">
                                @php $isRejected = false; @endphp
                                @forelse($data as $item)
                                    @if ($item->status == 4 && $item->job_id == $jobid)
                                     @php $isRejected = true; @endphp
                                        <tr>
                                            <td> {{ $item->fname }}
                                                {{ $item->lname ? $item->lname : '' }}
                                                <p>
                                                    <a href="{{ asset('resume/' . $item->resume . '') }}"
                                                        class="text-primary underline" title="Download Resume"
                                                        target="_blank">Download Resume <i class="fas fa-download"
                                                            aria-hidden="true"></i></a>
                                                </p>
                                            </td>
                                            <td>{{ $item->job_id == $jobid ? $item->created_at : '' }}</td>
                                            <td>{{ $item->exp_year }} - {{ $item->exp_month }}</td>
                                            <td>{{ $item->designation }}</td>
                                            <td>{{ $item->expected_salary }}</td>
                                            <td>{{ $item->notice_period }}</td>
                                            <td>Rejected</td>
                                            <td>
                                                <a href="{{ route('application_shortlist', ['id' => $item->id]) }}"
                                                    title="shortlist">
                                                    <i style="color:#f95602;" class="fa fa-check" aria-hidden="true"></i>
                                                </a>

                                                <i style="color:#f95602;" class="fa fa-times" aria-hidden="true"></i>

                                                <span data-toggle="modal" data-target="#interview_modal"
                                                    data-whatever="{{ $item->id }}" title="schedule Interview">
                                                    <i style="color:#f95602;" class="fa fa-clock" aria-hidden="true"></i>
                                                </span>

                                                <a href="{{ route('application_offer', ['id' => $item->id]) }}"
                                                    title="send offer mail">
                                                    <i style="color:#f95602;" class="fas fa-file-archive"
                                                        aria-hidden="true"></i>
                                                </a>

                                                <a href="{{ route('application_hire', ['id' => $item->id]) }}"
                                                    title="hire applicant">
                                                    <i style="color:#f95602;" class="fa fa-thumbs-up"
                                                        aria-hidden="true"></i>
                                                </a>

                                                <a href="{{ route('application_save', ['id' => $item->id]) }}"
                                                    title="save application">
                                                    <i style="color:#f95602;" class="fa fa-star" aria-hidden="true"></i>
                                                </a>

                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td class="text-danger" colspan="8">No Record Found</td>
                                    </tr>
                                @endforelse
                                @if (!$isRejected)
                                <tr>
                                    <td class="text-danger" colspan="8">No Record Found</td>
                                </tr>
                                @endif
                            </tbody>
                            <tbody id="InterviewScheduled" class="tab-pane fade">
                                @php $isInterviewScheduled = false; @endphp
                                @forelse($data as $item)
                                @if ($item->status == 2 && $item->job_id == $jobid)
                                @php $isInterviewScheduled = true; @endphp
                                    
                                        <tr>
                                            <td> {{ $item->fname }}
                                                {{ $item->lname ? $item->lname : '' }}
                                                <p>
                                                    <a href="{{ asset('resume/' . $item->resume . '') }}"
                                                        class="text-primary underline" title="Download Resume"
                                                        target="_blank">Download Resume <i class="fas fa-download"
                                                            aria-hidden="true"></i></a>
                                                </p>
                                            </td>
                                            <td>{{ $item->job_id == $jobid ? $item->created_at : '' }}</td>
                                            <td>{{ $item->exp_year }} - {{ $item->exp_month }}</td>
                                            <td>{{ $item->designation }}</td>
                                            <td>{{ $item->expected_salary }}</td>
                                            <td>{{ $item->notice_period }}</td>
                                            <td>Interview Scheduled</td>
                                            <td>
                                                <a href="{{ route('application_shortlist', ['id' => $item->id]) }}"
                                                    title="shortlist">
                                                    <i style="color:#f95602;" class="fa fa-check" aria-hidden="true"></i>
                                                </a>
                                                <a href="{{ route('application_reject', ['id' => $item->id]) }}"
                                                    title="reject">
                                                    <i style="color:#f95602;" class="fa fa-times" aria-hidden="true"></i>
                                                </a>
                                                <i style="color:#f95602;" class="fa fa-clock" aria-hidden="true"></i>
                                               

                                                <a href="{{ route('application_offer', ['id' => $item->id]) }}"
                                                    title="send offer mail">
                                                    <i style="color:#f95602;" class="fas fa-file-archive"
                                                        aria-hidden="true"></i>
                                                </a>

                                                <a href="{{ route('application_hire', ['id' => $item->id]) }}"
                                                    title="hire applicant">
                                                    <i style="color:#f95602;" class="fa fa-thumbs-up"
                                                        aria-hidden="true"></i>
                                                </a>

                                                <a href="{{ route('application_save', ['id' => $item->id]) }}"
                                                    title="save application">
                                                    <i style="color:#f95602;" class="fa fa-star" aria-hidden="true"></i>
                                                </a>

                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td class="text-danger" colspan="8">No Record Found</td>
                                    </tr>
                                @endforelse
                                @if (!$isInterviewScheduled)
                                <tr>
                                    <td class="text-danger" colspan="8">No Record Found</td>
                                </tr>
                                @endif
                            </tbody>
                            <tbody id="Offer" class="tab-pane fade">
                                @php $isOffered = false; @endphp
                                @forelse($data as $item)
                                @if ($item->status == 5 && $item->job_id == $jobid)
                                @php $isOffered = true; @endphp
                                        <tr>
                                            <td> {{ $item->fname }}
                                                {{ $item->lname ? $item->lname : '' }}
                                                <p>
                                                    <a href="{{ asset('resume/' . $item->resume . '') }}"
                                                        class="text-primary underline" title="Download Resume"
                                                        target="_blank">Download Resume <i class="fas fa-download"
                                                            aria-hidden="true"></i></a>
                                                </p>
                                            </td>
                                            <td>{{ $item->job_id == $jobid ? $item->created_at : '' }}</td>
                                            <td>{{ $item->exp_year }} - {{ $item->exp_month }}</td>
                                            <td>{{ $item->designation }}</td>
                                            <td>{{ $item->expected_salary }}</td>
                                            <td>{{ $item->notice_period }}</td>
                                            <td>Offer Letter</td>
                                            <td>
                                                <a href="{{ route('application_shortlist', ['id' => $item->id]) }}"
                                                    title="shortlist">
                                                    <i style="color:#f95602;" class="fa fa-check" aria-hidden="true"></i>
                                                </a>
                                                <a href="{{ route('application_reject', ['id' => $item->id]) }}"
                                                    title="reject">
                                                    <i style="color:#f95602;" class="fa fa-times" aria-hidden="true"></i>
                                                </a>
                                                <span data-toggle="modal" data-target="#interview_modal"
                                                    data-whatever="{{ $item->id }}" title="schedule Interview">
                                                    <i style="color:#f95602;" class="fa fa-clock" aria-hidden="true"></i>
                                                </span>

                                                <i style="color:#f95602;" class="fas fa-file-archive"
                                                    aria-hidden="true"></i>

                                                <a href="{{ route('application_hire', ['id' => $item->id]) }}"
                                                    title="hire applicant">
                                                    <i style="color:#f95602;" class="fa fa-thumbs-up"
                                                        aria-hidden="true"></i>
                                                </a>

                                                <a href="{{ route('application_save', ['id' => $item->id]) }}"
                                                    title="save application">
                                                    <i style="color:#f95602;" class="fa fa-star" aria-hidden="true"></i>
                                                </a>

                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td class="text-danger" colspan="8">No Record Found</td>
                                    </tr>
                                @endforelse
                                @if (!$isOffered)
                                <tr>
                                    <td class="text-danger" colspan="8">No Record Found</td>
                                </tr>
                                @endif
                            </tbody>
                            <tbody id="Hire" class="tab-pane fade">
                                @php $isHired = false; @endphp
                                @forelse($data as $item)
                                @if ($item->status == 6 && $item->job_id == $jobid)
                                @php $isHired = true; @endphp
                                        <tr>
                                            <td> {{ $item->fname }}
                                                {{ $item->lname ? $item->lname : '' }}
                                                <p>
                                                    <a href="{{ asset('resume/' . $item->resume . '') }}"
                                                        class="text-primary underline" title="Download Resume"
                                                        target="_blank">Download Resume <i class="fas fa-download"
                                                            aria-hidden="true"></i></a>
                                                </p>
                                            </td>
                                            <td>{{ $item->job_id == $jobid ? $item->created_at : '' }}</td>
                                            <td>{{ $item->exp_year }} - {{ $item->exp_month }}</td>
                                            <td>{{ $item->designation }}</td>
                                            <td>{{ $item->expected_salary }}</td>
                                            <td>{{ $item->notice_period }}</td>
                                            <td>Joining</td>
                                            <td>
                                                <a href="{{ route('application_shortlist', ['id' => $item->id]) }}"
                                                    title="shortlist">
                                                    <i style="color:#f95602;" class="fa fa-check" aria-hidden="true"></i>
                                                </a>
                                                <a href="{{ route('application_reject', ['id' => $item->id]) }}"
                                                    title="reject">
                                                    <i style="color:#f95602;" class="fa fa-times" aria-hidden="true"></i>
                                                </a>
                                                <span data-toggle="modal" data-target="#interview_modal"
                                                    data-whatever="{{ $item->id }}" title="schedule Interview">
                                                    <i style="color:#f95602;" class="fa fa-clock" aria-hidden="true"></i>
                                                </span>

                                                <a href="{{ route('application_offer', ['id' => $item->id]) }}"
                                                    title="send offer mail">
                                                    <i style="color:#f95602;" class="fas fa-file-archive"
                                                        aria-hidden="true"></i>
                                                </a>

                                                    <i style="color:#f95602;" class="fa fa-thumbs-up"
                                                        aria-hidden="true"></i>
                                             

                                                <a href="{{ route('application_save', ['id' => $item->id]) }}"
                                                    title="save application">
                                                    <i style="color:#f95602;" class="fa fa-star" aria-hidden="true"></i>
                                                </a>

                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td class="text-danger" colspan="8">No Record Found</td>
                                    </tr>
                                @endforelse
                                @if (!$isHired)
                                <tr>
                                    <td class="text-danger" colspan="8">No Record Found</td>
                                </tr>
                                @endif
                            </tbody>
                            <tbody id="SaveForFuture" class="tab-pane fade">
                                @php $isSaved = false; @endphp
                                @forelse($data as $item)
                                    @if ($item->status == 7 && $item->job_id == $jobid)
                                    @php $isSaved = true; @endphp
                                        <tr>
                                            <td> {{ $item->fname }}
                                                {{ $item->lname ? $item->lname : '' }}
                                                <p>
                                                    <a href="{{ asset('resume/' . $item->resume . '') }}"
                                                        class="text-primary underline" title="Download Resume"
                                                        target="_blank">Download Resume <i class="fas fa-download"
                                                            aria-hidden="true"></i></a>
                                                </p>
                                            </td>
                                            <td>{{ $item->job_id == $jobid ? $item->created_at : '' }}</td>
                                            <td>{{ $item->exp_year }} - {{ $item->exp_month }}</td>
                                            <td>{{ $item->designation }}</td>
                                            <td>{{ $item->expected_salary }}</td>
                                            <td>{{ $item->notice_period }}</td>
                                            <td>Save / Hold</td>
                                            <td>
                                                <a href="{{ route('application_shortlist', ['id' => $item->id]) }}"
                                                    title="shortlist">
                                                    <i style="color:#f95602;" class="fa fa-check" aria-hidden="true"></i>
                                                </a>
                                                <a href="{{ route('application_reject', ['id' => $item->id]) }}"
                                                    title="reject">
                                                    <i style="color:#f95602;" class="fa fa-times" aria-hidden="true"></i>
                                                </a>
                                                <span data-toggle="modal" data-target="#interview_modal"
                                                    data-whatever="{{ $item->id }}" title="schedule Interview">
                                                    <i style="color:#f95602;" class="fa fa-clock" aria-hidden="true"></i>
                                                </span>

                                                <a href="{{ route('application_offer', ['id' => $item->id]) }}"
                                                    title="send offer mail">
                                                    <i style="color:#f95602;" class="fas fa-file-archive"
                                                        aria-hidden="true"></i>
                                                </a>

                                                <a href="{{ route('application_hire', ['id' => $item->id]) }}"
                                                    title="hire applicant">
                                                    <i style="color:#f95602;" class="fa fa-thumbs-up"
                                                        aria-hidden="true"></i>
                                                </a>

                                                <i style="color:#f95602;" class="fa fa-star" aria-hidden="true"></i>

                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td class="text-danger" colspan="8">No Record Found</td>
                                    </tr>
                                @endforelse
                                @if (!$isSaved)
                                <tr>
                                    <td class="text-danger" colspan="8">No Record Found</td>
                                </tr>
                                @endif
                            </tbody> -->

                        </div>
                    </table>

                    {{-- Modal code start --}}
                    <div class="modal fade" id="interview_modal" tabindex="-1" role="dialog"
                        aria-labelledby="interview_modal" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="interview_modal">Interview Details</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('application_interview_scheduled') }}" method="GET"
                                        name="interview_schedule_form">
                                        @csrf
                                        <div class="d-none">
                                            <input type="hidden" name="id" id="applicationid">
                                        </div>
                                        <div class="form-group">
                                            <label for="interview_schedule_date" class="col-form-label">Choose Date &
                                                time:</label>
                                            <input type="datetime-local" name="interview_schedule_date"
                                                class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="message-text" class="col-form-label">Complete Details:</label>
                                            <textarea class="form-control" name="interview_info" id="interview_info">
                                                
                                            </textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Schedule</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Modal code end --}}
                    {{-- {{$data->links()}} --}}
                </div>
            </div>

            <!-- Render Pagination -->
            <div class="col-md-12 my-3 d-flex justify-content-center">
                {{$data->onEachSide(0)->links()}}
            </div>
            <!-- End Render Pagination -->
        </div>
    </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/ats.js') }}"></script>
@endsection
