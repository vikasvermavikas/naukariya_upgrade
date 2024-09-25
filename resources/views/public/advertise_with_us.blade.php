@extends('layouts.master', ['title' => 'Advertise With Us'])
@Section('content')
   <!-- Hero Area Start-->
    <div class="slider-area ">
    <div class="single-slider section-overly slider-height2 d-flex align-items-center" data-background="{{asset('assets/img/hero/about.jpg')}}">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="hero-cap text-center">
                        <h2>Advertise With Us</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Hero Area End -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 my-2">
                <div class="card">
                    <div class="card-body">
                        @if ($advertise_with_us->advertise_with_us)
                        {!! $advertise_with_us->advertise_with_us !!}
                        @else
                            <p class="text-danger text-center">No Data Found</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
