@extends('layouts.master', ['title' => 'Unsubscribe'])
@section('content')
<div class="container vh-100">
    <div class="row">
        <div class="col-md-12">
            <h3>Unsubscribe for Newsletter</h3>
        </div>
        <div class="col-md-12">
            @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
               {{session()->get('message')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            @endif
            @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
               {{session()->get('message')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            @endif
        </div>
        <div class="col-md-12 d-flex justify-content-center my-4">
            <form class="form-inline" action="{{route('unfollowNewsletter')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Email Id</label>
                    <input type="email" name="email" id="email" class="form-control mx-3" required>
                    @error('email')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <button type="submit" class="btn p-4 rounded">Unsubscribe</button>
            </form>
        </div>
    </div>
</div>
@endsection