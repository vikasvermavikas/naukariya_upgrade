@extends('layouts.master', ['title' => 'Blog Detail'])
@section('content')
  <!-- Hero Area Start-->
  <div class="slider-area ">
    <div class="single-slider section-overly slider-height2 d-flex align-items-center" data-background="{{asset('assets/img/hero/about.jpg')}}">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="hero-cap text-center">
                        <h2>{{$blog->title}}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </div>
 <!-- Hero Area End -->

 <div class="container blog_area single-post-area section-padding">
    <div class="row">
        <div class="col-md-4">
            <div class="feature-img">
            <img src="{{asset('blogs/'.$blog->image)}}" alt="" class="img-fluid">
            </div>
        </div>
        <div class="col-md-8">
            <span class="h2">{{$blog->title}}</span>
            <p>{{$blog->content}}</p>
        </div>
        
    </div>
 </div>

@endsection