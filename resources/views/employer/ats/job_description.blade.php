@extends('layouts.master', ['title' => $job->title])
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-5">
                    {{ Breadcrumbs::render('ats_job_view') }}
                 </div>
            <div class="col-md-8">
                <a href="{{route('ats_listing')}}" class="btn float-right">Back</a>
                <h2>{{ $job->title }}</h2><br>
                <p> <span class="h3 font-weight-bold">Job Description</span> {!! $job->description !!}</p>
            </div>
            <div class="col-md-4">
                <h4 class="text-center">Job Overview</h4>
                <ul class="list-group">
                    <li class="list-group-item">Posted date : <span>{{ $job->start_apply_date }}</span></li>
                    <li class="list-group-item">Skill Required : <span>{{ $job->job_skills }}</span></li>
                    <li class="list-group-item">Location : <span>{{ $job->job_exp ? $job->job_exp : 'Not Defined' }}</span></li>
                    <li class="list-group-item">Vacancy : <span>{{ $job->job_vaccancy }}</span></li>
                    <li class="list-group-item">Job nature : <span>{{ $job->job_type }}</span></li>
                    <li class="list-group-item">Salary :
                        <span>{{ $job->sal_disclosed == 'Yes' ? 'INR ' . $job->offered_sal_min . ' - ' . $job->offered_sal_max : 'Not Disclosed' }}</span>
                    </li>
                    <li class="list-group-item">Job Shift : <span>{{ $job->job_shift }}</span></li>
                </ul>
            </div>
        </div>
    </div>
@endsection
