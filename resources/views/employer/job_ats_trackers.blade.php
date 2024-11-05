@extends('layouts.master', ['title' => 'Relevant Trackers'])
@section('style')
<link rel="stylesheet" href="{{asset('assets/css/employer/tracker_ats.css')}}" type="text/css" />
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-4">
                {{ Breadcrumbs::render('job_ats_trackers') }}
            </div>
            <div class="col-md-12">
                <h2>Relevant Trackers for <span style="color:#e35e25;">{{ $jobskills->title }}</span> </h2>
            </div>

			<div class="col-md-12 my-3">
				<form action="" class="form-inline">
					<div class="form-group">
						<label for="form-label">Select Category</label>
						<Select class="form-control mx-3 custom-margin" name="category">
							<option value="all" {{$category == 'all' ? 'selected' : ''}}>All</option>
							<option value="shortlist" {{$category == 'shortlist' ? 'selected' : ''}}>Shortlisted Candidated</option>
							<option value="interested" {{$category == 'interested' ? 'selected' : ''}}>Interested Candidates</option>
							<option value="not-interested" {{$category == 'not-interested' ? 'selected' : ''}}>Not Interested Candidates</option>
							<option value="rejected" {{$category == 'rejected' ? 'selected' : ''}}>Reject Candidates</option>
							<option value="interview-scheduled" {{$category == 'interview-scheduled' ? 'selected' : ''}}>Interview Scheduled Candidates</option>
							<option value="offer-mail-sent" {{$category == 'offer-mail-sent' ? 'selected' : ''}}>Offer Mail Sent Candidates</option>
							<option value="applicant_hired" {{$category == 'applicant_hired' ? 'selected' : ''}}>Hired Candidates</option>
						</Select>
					</div>
					<div class="form-group">
						<button class="btn rounded p-3" type="submit">Submit</button>
					</div>

				</form>
			</div>

            <div class="col-md-12 mt-3">
                <p>Total Candidates : <span class="font-weight-bold">{{ $trackers->total() }}</span></p>
            </div>

            <div class="col-md-12 d-flex justify-content-center mb-2">
                {{ $trackers->onEachSide(0)->links() }}
            </div>

            <div class="table-responsive mb-3">
                <table class="table table-bordered">
                    <thead style="background:#e35e25;" class="text-light">
                        <tr>
                            <th>Name</th>
                            <th>Experience</th>
                            <th>Current Designation</th>
                            <th>Expected Salary</th>
                            <th>Match Percentage</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sorted_trackers as $tracker)
                        @php
                        $tracker = (object) $tracker;
                        @endphp
                            <tr>
                                <td>{{ $tracker->name }}
                                    @if($tracker->resume)
                                    <p>
                                        <a href="{{ asset('tracker/resume/' . $tracker->resume) }}"
                                            class="text-primary underline" title="Download Resume" target="_blank">Download
                                            Resume <i class="fas fa-download" aria-hidden="true"></i></a>
                                    </p>
                                    @endif
                                 
                                </td>
                                <td>{{ $tracker->experience && $tracker->experience == 'fresher' ? 'Fresher' : $tracker->experience . ' years' }}
                                </td>
                                <td>{{ $tracker->current_designation ? $tracker->current_designation : 'Not Mentioned' }}
                                </td>
                                <td>{{ $tracker->expected_ctc ? $tracker->expected_ctc . ' LPA' : 'Not Mentioned' }}</td>
                                <td>{{ tracker_match_skill($jobid, $tracker->id) }} %</td>
                                <td class="{{ $tracker->status ? $tracker->status == 'rejected' ?  'text-danger' : 'text-success' : 'text-warning' }} text-capitalize">
                                    {{ $tracker->status ?  $tracker->status == 'shortlist' ?  Illuminate\Support\Str::replace('_', ' ', $tracker->status."ed") : Illuminate\Support\Str::replace('_', ' ', $tracker->status) : 'pending' }}
                                </td>

                                @if ($tracker->status)
                                    <!-- If status is shortlist. -->
                                    @if ($tracker->status == 'shortlist')
                                        <td><button class="btn rounded p-3 interested mt-2 mr-1" data-id="{{ $tracker->id }}"
                                                job-id="{{ $jobid }}">Interested</button><button
                                                class="btn rounded p-3 not-interested mt-2" data-id="{{ $tracker->id }}"
                                                job-id="{{ $jobid }}">Not Interested</button></td>

                                        <!-- If status is intersted. -->
                                    @elseif($tracker->status == 'interested')
                                        <td><button class="btn rounded p-3 schedule_interview mt-2" data-toggle="modal"
                                                data-target="#interview_modal" data-whatever="{{ $tracker->id }}"
                                                data-id="{{ $jobid }}">Schedule Interview</button></td>
                                    @elseif($tracker->status == 'not-interested')
                                        <td><button class="btn rounded p-3 mt-2">Not Interested</button></td>
                                        {{-- If interview scheduled --}}
                                    @elseif($tracker->status == 'interview-scheduled')
                                        <td><button class="btn rounded p-3 mt-2" data-toggle="modal"
                                                data-target="#view_interview" data-whatever="{{ $tracker->id }}"
                                                data-id="{{ $jobid }}"><span data-toggle="tooltip"
                                                    title="View Interview Details">View</span></button>
                                            <button class="btn rounded p-3 mt-2 send_offer_mail"
                                                data-id="{{ $tracker->id }}" job-id="{{ $jobid }}">Select</button>
											<button class="btn rounded p-3 mt-2 reject"
                                                data-id="{{ $tracker->id }}" job-id="{{ $jobid }}">Reject</button>

                                        </td>
									@elseif($tracker->status == 'rejected')
                                        <td>
                                            <button class="btn rounded p-3 mt-2"
                                                >Rejected</button>
                                        </td>
                                    @elseif($tracker->status == 'offer-mail-sent')
                                        <td>
                                            <button class="btn rounded p-3 mt-2 hire_applicant"
                                                data-id="{{ $tracker->id }}" job-id="{{ $jobid }}">Hire
                                                Applicant</button>
                                        </td>
                                    @elseif($tracker->status == 'applicant_hired')
                                        <td>
                                            <button class="pe-none btn btn-success rounded p-3 mt-2">Hired</button>
                                        </td>
                                    @endif
                                @else
                                    <td><button class="btn rounded p-3 shortlist mt-2" data-id="{{ $tracker->id }}"
                                            job-id="{{ $jobid }}">Shortlist</button></td>
                                @endif



                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-danger text-center">No Record Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Modal for schedule interview code start --}}
            <div class="modal fade" id="interview_modal" tabindex="-1" role="dialog" aria-labelledby="interview_modal"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Interview Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('tracker_ats_interview') }}" method="POST">
                                @csrf
                                <div class="d-none">
                                    <input type="hidden" name="tracker_id" id="tracker_id">
                                    <input type="hidden" name="job_id" id="job_id">
                                </div>
                                <div class="form-group">
                                    <label for="interview_schedule_date" class="col-form-label">Choose Date & time:</label>

                                    <input type="datetime-local" name="interview_date" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="message-text" class="col-form-label">Complete Details:</label>
                                    <textarea class="form-control" name="interview_details" placeholder="Enter Complete Details" id="interview_info"></textarea>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Schedule</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal code end --}}

            {{-- Modal for showing interview data --}}

            <div class="modal fade" id="view_interview" tabindex="-1" role="dialog" aria-labelledby="view_interviewLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="view_interviewLabel">Interview Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <span class="font-weight-bold">Date & Time : <span
                                            class="interview_date font-weight-normal"></span> </span>

                                </div>
                                <div class="col-md-12">
                                    <span class="font-weight-bold">Description : </span>
                                    <p class="interview_details"></p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary rounded" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- End code for modal --}}
            <div class="col-md-12 d-flex justify-content-center my-2">
                {{ $trackers->onEachSide(0)->links() }}
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/employer/ats_tracker.js') }}"></script>
@endsection
