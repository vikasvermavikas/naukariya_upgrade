@extends('layouts.master', ['title' => 'Terms and Conditions'])\
@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/guest/terms_and_conditions.css')}}">
@endsection
@Section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 my-3">
                <h1 style="color:#e35e25;">Terms and Conditions</h1>
            </div>
            <div class="col-md-12 my-2">
                <div class="card">
                    <div class="card-body">
                        @if ($conditions->terms_and_condition)
                        {!! $conditions->terms_and_condition !!}
                        @else
                            <p class="text-danger text-center">No Data Found</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
