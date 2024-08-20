@extends('layouts.master', ['title' => 'Blogs'])
@section('style')
<style>
    .zoom:hover {
  transform: scale(1.2); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
}
</style>
@endsection
@section('content')
<!-- Hero Area Start-->
<div class="slider-area ">
    <div class="single-slider section-overly slider-height2 d-flex align-items-center" data-background="{{asset('assets/img/hero/about.jpg')}}">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="hero-cap text-center">
                        <h2>Blog Details</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Hero Area End -->
<div class="container my-5">
<div class="row">
    @forelse ($blogs as $blog)
    <div class="col-sm-12 col-md-6 col-lg-4 my-3 zoom">
        <div class="card" style="width: 18rem;">
            <img class=" card-img-top" src="{{asset('blogs/'.$blog->image)}}" alt="Card image cap">
            
            <div class="card-body">
              <p class="card-text">{{Illuminate\Support\Str::limit($blog->content, 20)}} <a href="{{route('blog-details', ['id' => $blog->id])}}" class="text-danger small">Read More</a></p>
            </div>
          </div>
    </div>
    @empty
        <div class="col-md-12">
            <span class="text-center text-danger">No Record Found</span>
        </div>
    @endforelse
 
</div>
</div>
@endsection