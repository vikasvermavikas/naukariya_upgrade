@extends('layouts.master', ['title' => 'Privacy Policies'])
@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/guest/policies.css')}}">
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 my-3">
                <h1 style="color:#e35e25;">Privacy Policies</h1>
            </div>
            <div class="col-md-12 my-2">
                <div class="card">
                    <div class="card-body">
                        {!! $policies->privacy_policy !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
