@extends('layouts.master', ['title' => 'Relevant Trackers'])
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12 mb-4">
			{{ Breadcrumbs::render('job_ats_trackers') }}
		</div>
		<div class="col-md-12">
			<h2>Relevant Trackers for <span style="color:#e35e25;">{{$jobskills->title}}</span> </h2>
		</div>

		<div class="col-md-12 mt-3">
			<p>Total Candidates : <span class="font-weight-bold">{{$trackers->total()}}</span></p>
		</div>

		<div class="col-md-12 d-flex justify-content-center mb-2">
			{{$trackers->onEachSide(0)->links()}}
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
					</tr>
				</thead>
				<tbody>
					@forelse($trackers as $tracker)
					<tr>
						<td>{{$tracker->name}} 
							<p>
                              <a href="{{asset('tracker/resume/'.$tracker->resume)}}" class="text-primary underline" title="Download Resume" target="_blank">Download Resume <i class="fas fa-download" aria-hidden="true"></i></a>
                                            </p>
						</td>
						<td>{{$tracker->experience && $tracker->experience == 'fresher' ? 'Fresher' : $tracker->experience." years"}}</td>
						<td>{{$tracker->current_designation ? $tracker->current_designation : 'Not Mentioned'}}</td>
						<td>{{$tracker->expected_ctc ? $tracker->expected_ctc." LPA" : 'Not Mentioned'}}</td>
						<td>{{tracker_match_skill($jobid, $tracker->id)}} %</td>
					</tr>
					@empty
						<tr>
							<td colspan="5" class="text-danger text-center">No Record Found</td>
						</tr>
					@endforelse	
				</tbody>
			</table>
		</div>

		<div class="col-md-12 d-flex justify-content-center my-2">
			{{$trackers->onEachSide(0)->links()}}
		</div>
	</div>
</div>
@endsection