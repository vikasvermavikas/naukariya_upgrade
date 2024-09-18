@extends('layouts.master', ['title' => 'Company Profile'])
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/my_organisation.css') }}">
@endsection
@section('content')
    @php
        if (!$company_details) {
            $company_details = new stdclass();
            $company_details->cover_image = '';
            $company_details->owner_name = '';
            $company_details->company_logo = '';
            $company_details->about = '';
            $company_details->company_name = '';
            $company_details->address = '';
            $company_details->establish_date = '';
            $company_details->com_email = '';
            $company_details->com_email = '';
            $company_details->com_email = '';
            $company_details->com_contact = '';
            $company_details->cin_no = '';
            $company_details->status = '';
        }
    @endphp
    <div class="container-fluid">
        <div class="row">
             <div class="col-md-12">
                    {{ Breadcrumbs::render('organisation_details') }}
                 </div>
            <div class="col-md-12"
                style="background-image: url({{ asset('company_cover/' . $company_details->cover_image . '') }});background-size:cover;height:137px;">
                <p class="text-center mt-4">
                    <span class="h1 my-5 h-100  ">Company Profile</span>
                <p class="text-center font-weight-bold">Owner : {{ $company_details->owner_name }}</p>
                </p>
            </div>
            <div class="col-md-12" style="background:#EAEDFF;">
                <div class="row my-3">
                    <div class="col-md-6 d-flex justify-content-center">
                        <img src="{{ asset('company_logo/' . $company_details->company_logo . '') }}" alt=""
                            class="img-fluid rounded" style="width: 43%">
                    </div>
                    <div class="col-md-6">
                        <h3 class="dark-color">Company Details <a href="{{ route('employer_edit_profile') }}" title="Edit"
                                data-toggle="tooltip" data-placement="top"><i class="fas fa-edit small"></i></a></h3>
                        <div class="row about-list">
                            <div class="col-md-12">
                                <p>{{ $company_details->about }}</p>
                            </div>
                            <div class="col-md-12  my-2">
                                <label>Company Name:</label>
                                <span> {{ $company_details->company_name }} </span>
                            </div>
                            <div class="col-md-12  my-2">
                                <label>Company Address:</label>
                                <span>{{ $company_details->address }} </span>
                            </div>
                            <div class="col-md-6  my-2">
                                <label>Establish Date:</label>
                                <span>{{ $company_details->establish_date }} </span>
                            </div>
                            <div class="col-md-6  my-2">
                                <label>Email:</label>
                                <span> {{ $company_details->com_email }} </span>
                            </div>
                            <div class="col-md-6  my-2">
                                <label>Website:</label>
                                <span> <a href="{{ $company_details->com_email }}"
                                        class="text-primary">{{ $company_details->com_email }}</a> </span>
                            </div>
                            <div class="col-md-6  my-2">
                                <label>Contact:</label>
                                <span> {{ $company_details->com_contact }} </span>
                            </div>
                            <div class="col-md-6  my-2">
                                <label>CIN No.:</label>
                                <span> {{ $company_details->cin_no }} </span>
                            </div>
                            <div class="col-md-6  my-2">
                                <label>Status:</label>
                                <span> {{ $company_details->status == 1 ? 'Active' : '' }} </span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
