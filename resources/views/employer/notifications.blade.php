@extends('layouts.master', ['title' => 'Job Notifications'])
@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/forgot-password.css')}}">
@endsection
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12 mb-3">
			{{Breadcrumbs::render('employer_notifications')}}
		</div>
		<div class="col-md-12 mb-3">
			<h2>Job Notifications</h2>
		</div>
		<div class="table-responsive">
			<table class="table  border">
				<thead class="home-bg-color text-light">
					<tr>
						<th>S No.</th>
						<th>Notification</th>
						<th>Date</th>
						<th>Job Post Date</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@forelse($notifications as $notification)
					<tr>
						<td>{{$loop->iteration}}</td>
						<td>{{$notification->fname." ".$notification->lname}} applied for {{$notification->title}}</td>
						<td>{{date('d-m-Y', strtotime($notification->created_at))}}</td>
						<td>{{$notification->Jobpostdate ? date('d-m-Y', strtotime($notification->Jobpostdate)) : '-'}}</td>
						<td><a href="{{route('job_ats', ['id' => $notification->id]) }}" class="btn rounded p-3 text-light">View</a></td>
					</tr>
					@empty
					<tr>
						<td colspan="5" class="text-danger text-center">Sorry you don't have any notifications yet.</td>
					</tr>
					@endforelse
				</tbody>

			</table>
		</div>
	</div>
</div>
@endsection