@extends('layouts.master', ['title' => 'Dashboard'])
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Dashboard</h1>
            </div>
            <div class="col-md-4 my-3">
                <div class="card mb-3" style="width: 18rem;">
                    <img class="card-img-top" src="{{asset('subuser_profile_image/default_image.png')}}" alt="Card image cap">
                    <div class="card-body text-center">
                      <h5 class="card-title"> {{ Auth::guard('subuser')->user()->fname ." ".Auth::guard('subuser')->user()->lname  }}</h5>
                      <p class="card-text  small">Working As a {{Auth::guard('subuser')->user()->designation}}</p>
                    </div>
                    </div>

                    <h6 class="card-title">Here are your actions details :</h6>
                    <div class="card mt-3 hover" style="width: 18rem;">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                         Total Added
                          <span class="badge badge-primary badge-pill">{{$data["totalAdded"]}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                          Resume not uploaded
                          <span class="badge badge-danger badge-pill">{{$data["totalAdded"]}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                         Resume Uploaded
                          <span class="badge badge-secondary badge-pill">{{$data["totalAdded"]}}</span>
                        </li>
                      </ul>
                </div>
                  
            </div>
        </div>
    </div>
    </div>
@endsection
