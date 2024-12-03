@extends('layouts.master', ['title' => 'ATS'])
@section('style')
<style>
	.homebackground{
		background: #e35e25;
    	color: white;
	}
</style>
	
@endsection
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12 mb-5">
             {{ Breadcrumbs::render('ats') }}
        </div>
		<div class="col-md-12">
			<h2>Application Tracking System</h2>
		</div>
		<div class="table-responsive my-4">
			<table class="table table-bordered">
				<thead class="homebackground">
					<tr>
						<th>S No.</th>
						<th>Title</th>
						<th>Job Post Date</th>
						<th>Job Update Date</th>
						<th>Status</th>
						<th>Relevant Resumes</th>
						<th>Applied</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@forelse($data as $value)
					<tr>
						<td>{{$loop->iteration}}</td>
						<td>{{$value->title}}</td>
						<td>{{date('d-M-y', strtotime($value->created_at))}}</td>
						<td>{{date('d-M-y', strtotime($value->updated_at))}}</td>
						<td>{{$value->status}}</td>
						<td>{{$value->total_resumes}}</td>
						<td>{{$value->total_applications}}</td>
						<td><a href="{{route('viewjobs', ['id' => $value->id])}}" class="btn rounded p-4 mt-2 mr-2" title="view job details" data-toggle="tooltip">View</a><a href="{{route('get_ats_resumes', ['id' => $value->id])}}" class="btn rounded p-4 mt-2" title="get resumes" data-toggle="tooltip">Resumes</a></td>
					</tr>
					@empty
					<tr>
						<td class="text-danger" colspan="8">No Record Found</td>
					</tr>
					@endforelse
				</tbody>
			</table>

		</div>
		<div class="col-md-12 d-flex justify-content-center mb-2">

                    {{ $data->onEachSide(0)->links() }}
         </div>
	</div>
</div>
@endsection