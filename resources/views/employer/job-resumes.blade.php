@extends('layouts.master', ['title' => 'Job Resumes'])
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12 mb-4">
                  {{ Breadcrumbs::render('job_resumes', $job_title) }}
        </div>
		<div class="col-md-12">
			<h2>Job Resume for {{$job_title}}</h2>
		</div>
		<div class="col-md-12 my-2">
			<p style="color:#e35e25;">Total Resumes : <span class="text-dark">{{$resumes->total()}}</span></p>
		</div>
		<div class="table-responsive mt-2">
			<table class="table table-bordered">
				<thead class="text-white" style="background:rgb(227, 94, 37)">
					<tr>
						<th>S No.</th>
						<th>Jobseeker Name</th>
						<th>Apply Date</th>
						<th>Resume</th>
					</tr>
				</thead>
				<tbody>
					@forelse($resumes as $resume)
					<tr>
						<td>{{$loop->iteration}}</td>
						<td>{{$resume->fname." ".$resume->lname}}</td>
						<td>{{date('d-M-Y', strtotime($resume->created_at))}}</td>
						<td>
							@if($resume = get_jobseeker_resume($resume->id, $jobid))
							<a href="{{asset('resume/'.$resume.'')}}" class="btn rounded p-2" target="_blank" download>Resume <i class="fas fa-download"></i></a>
							@else
							<span class="text-danger">Resume not uploaded</span>
							@endif
						</td>
					</tr>
					@empty
					<tr>
						<td class="text-danger text-center" colspan="4">No Record Found.</td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>
		<div class="col-md-12 d-flex justify-content-center my-2">
			{{$resumes->links()}}
		</div>
	</div>
</div>
@endsection