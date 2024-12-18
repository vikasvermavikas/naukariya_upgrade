@extends('layouts.master', ['title' => 'Resumes'])
@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/employer/ats.css')}}">
@endsection
@section('content')
<div class="container">
	<div class="row">
		<!-- Breadcrums -->
		<div class="col-md-12 mb-2">
			{{ Breadcrumbs::render('get_resumes', $jobdetails->title) }}
		</div>
		<div class="col-md-12">
			<h2>Relevant Resumes for <span class="font-weight-bold" style="color:#e35e25;">{{$jobdetails->title}}</span></h2>
		</div>

		<!-- Filter Form -->
		<div class="col-md-12 my-4">
			<form action="" class="form-inline">
				<div class="form-group" >
					<select class="form-control mx-3" name="type" required>
						<option value="trackers" {{$type == 'trackers' ? 'selected' : ''}}>Trackers</option>
						<option value="jobseekers" {{$type == 'jobseekers' ? 'selected' : ''}}>Jobseekers</option>
					</select>
				<!-- <button type="submit" class="btn rounded mx-2 mt-2 submit">Submit</button> -->
				<div class="form-group">
						<button class="btn rounded p-3" type="submit" fdprocessedid="1e7ysb">Submit</button>
					</div>
				</div>

			</form>
		</div>

		<!-- Resume Count. -->
		<div class="col-md-12">
			@if($is_tracker)
			<p>Total Resumes : <span class="text-color">{{$trackers->total()}}</span></p>
			@else 
			<p>Total Resumes : <span class="text-color">{{$jobseekers->total()}}</span></p>
			@endif
		</div>

		<!-- Pagination -->
		<div class="col-md-12 d-flex justify-content-center my-2">
			@if($is_tracker)
			{{$trackers->onEachSide(0)->links()}}
			@else 
			{{$jobseekers->onEachSide(0)->links()}}
			@endif
		</div>

		<!-- Table -->
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead class="thead-color text-light">
					<tr>
						<td>Name</td>
						<td>Experience</td>
						<td>Current Designation</td>
						<td>Expected Salary</td>
						<td>Match Percentage</td>
						<td>Status</td>
					</tr>
				</thead>

				<!-- If filter is tracker selected. -->
				@if($is_tracker)
			 		<tbody>
                        @forelse($trackers as $tracker)
                      
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

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-danger text-center">No Record Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                 @else
                 	<!-- If filter, jobseeker selected. -->
                 	  <tbody id="All" class="tab-pane fade active show">
                                @forelse($jobseekers as $item)
                                
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
                                           <td>{{ $item->exp_year && $item->exp_month ? $item->exp_year." years " .$item->exp_month." months " : 'Not Mentioned' }}</td>
                                            <td>{{ $item->designation ? $item->designation : 'Not Mentioned' }}</td>
                                        <td>{{ $item->expected_salary ? $item->expected_salary." LPA" : 'Not Mentioned' }}</td>

                                      
                                        <td>{{jobseeker_match_skill($jobid, $item->jobseekerid)}} %</td>
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
                                      
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-danger text-center" colspan="6">No Record Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                 @endif   
			</table>
		</div>

		<!-- Pagination -->
		<div class="col-md-12 d-flex justify-content-center my-2">
			@if($is_tracker)
			{{$trackers->onEachSide(0)->links()}}
			@else 
			{{$jobseekers->onEachSide(0)->links()}}

			@endif
		</div>

	</div>
</div>
@endsection