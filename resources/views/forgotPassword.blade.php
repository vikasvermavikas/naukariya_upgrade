@extends('layouts.master', ['title' => 'Forgot Password'])
@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/forgot-password.css')}}">
@endsection
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12 my-4">
			<h2 class="home-text-color">Forgot Password</h2>
		</div>
		<div class="col-md-12 d-flex justify-content-center my-3">
			<div class="card text-center" style="width: 300px;">
    <div class="card-header h5 text-white home-bg-color">Password Reset</div>
    <div class="card-body px-5">
        <p class="card-text py-2">
            Enter your email address and we'll send you an email with instructions to reset your password.
        </p>
        @if(session()->has('error'))
            <span class="text-danger">{{session()->get('messages')}}</span>
        @endif 
        @if(session()->has('success'))
            <span class="text-success">{{session()->get('messages')}}</span>
        @endif

            <!-- action="{{route('sendresetlink')}}" -->
        <form class="form" id="resetform">
        	@csrf
        <div data-mdb-input-init class="form-outline">
            @error('email')
            <span class="text-danger">{{$message}}</span>
            @enderror

            @error('role')
            <span class="text-danger">{{$message}}</span>
            @enderror

            <select class="form-control" name="role" required>
                <option value="">Select User Type</option>
                <option value="Employer">Employer</option>
                <option value="Jobseeker">Jobseeker</option>
            </select>
            <input type="email" name="email" value="{{old('email')}}" class="form-control my-3" placeholder="Enter Email" required />
            <!-- <label class="form-label" for="typeEmail">Email input</label> -->
        </div>
        <button type="submit" data-mdb-ripple-init class="btn w-100 rounded">Reset password</button>
       <!--  <div class="d-flex justify-content-center mt-4">
            <a class="btn w-100 text-light rounded" href="{{route('login')}}">Login</a>
        </div> -->
        </form>
    </div>
</div>
		</div>
	</div>
</div>	
@endsection
@section('script')
<script src="{{asset('assets/js/forgot-password.js')}}"></script>
@endsection