@extends('layouts.master', ['title' => 'Dashboard'])
@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/subuser/dashboard.css')}}">
@endsection
@section('content')
    <div class="container my-3">
        <div class="row">
            <div class="col-md-12">
                <h1>Dashboard</h1>
            </div>
            <div class="col-md-4 my-3">
                <div class="card mb-3 card-profile-width">

                    @if (Auth::guard('subuser')->user()->profile_image)
                        <img src="{{ asset('subuser_profile_image/' . Auth::guard('subuser')->user()->profile_image . '') }}"
                            class="card-img-top">
                    @else
                        <img class="card-img-top" src="{{ asset('subuser_profile_image/default_image.png') }}"
                            alt="Card image cap">
                    @endif


                    <div class="card-body text-center">
                        <h5 class="card-title text-capitalize">
                            {{ Auth::guard('subuser')->user()->fname . ' ' . Auth::guard('subuser')->user()->lname }}</h5>
                        <p class="card-text  small">Working As a {{ Auth::guard('subuser')->user()->designation }}</p>
                    </div>
                </div>

              <!--   <div class="card mt-3 hover" style="width: 18rem;">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Total Added
                            <a href="{{ route('subuser-tracker-list') }}"><span
                                    class="badge badge-primary badge-pill">{{ $data['totalAdded'] }}</span></a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Resume not uploaded
                            <a href="{{ route('subuser-tracker-list', ['uploadstatus' => 'no']) }}"> <span
                                    class="badge badge-danger badge-pill">{{ $data['resumeNotUploaded'] }}</span></a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Resume Uploaded
                            <a href="{{ route('subuser-tracker-list', ['uploadstatus' => 'yes']) }}"> <span
                                    class="badge badge-secondary badge-pill">{{ $data['resumeUploaded'] }}</span></a>
                        </li>
                    </ul>
                </div> -->

            </div>
           <div class="col-md-8">
                <h6 class="card-title">Here are your actions details :</h6>
            <div class="row">

                        <div class="col-md-4 col-lg-4">
                            <a href="{{ route('subuser-tracker-list') }}" target="_blank">
                                <div class="box bg-info py-4 text-center mt-3 rounded card-height" ><span class="text-white">
                                       {{ $data['totalAdded'] }}</span>
                                    <hr class="hr1">
                                    <p class="lead companyfollowing"><span class="text-white">Total Added</span></p>
                                </div>
                            </a>

                        </div>

                          <div class="col-md-4 col-lg-4">
                            <a href="{{ route('subuser-tracker-list', ['uploadstatus' => 'no']) }}" target="_blank" ">
                                <div class="box bg-info py-4 text-center mt-3 rounded card-height" ><span class="text-white">
                                        {{ $data['resumeNotUploaded'] }}</span>
                                    <hr class="hr1">
                                    <p class="lead companyfollowing"><span class="text-white">Resume not uploaded</span></p>
                                </div>
                            </a>

                        </div>

                          <div class="col-md-4 col-lg-4">
                            <a href="{{ route('subuser-tracker-list', ['uploadstatus' => 'yes']) }}" target="_blank">
                                <div class="box bg-info py-4 text-center mt-3 rounded card-height" ><span class="text-white">
                                        {{ $data['resumeUploaded'] }}</span>
                                    <hr class="hr1">
                                    <p class="lead companyfollowing"><span class="text-white">Resume Uploaded</span></p>
                                </div>
                            </a>

                        </div>
            </div>
           

       </div>
        </div>
    </div>
    <div class="my-5"></div>
    <!-- </div> -->
@endsection
