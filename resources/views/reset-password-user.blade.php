@extends('layouts.master', ['title' => 'Reset Password'])
@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/forgot-password.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/reset-password.css')}}">
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 my-2">
                <h2 class="home-text-color">Reset Password</h2>
            </div>

            <div class="col-md-8 my-3">
                <div class="card p-4">

                        @if(Session::has('success'))
                            <div class="form-group">
                                <p class="alert alert-success"><strong>{{ Session::get('messages') }}</strong></p>
                            </div>
                        @endif

                        @if(Session::has('error'))
                            <div class="form-group">
                                <p class="alert alert-danger"><strong>{{ Session::get('messages') }}</strong></p>
                            </div>
                        @endif
                        <div class="border jumbotron">
                            <span class="home-text-color h4">Instructions</span>
                            <p><ul>
                                <li>Password must be minimum 8 character long.<li>
                                <li>Password must contain at least one uppercase and one lowercase letter.</li>
                                <li>Password must contain at least one number.</li>
                                <li>Password must contain at least one symbol.</li>
                            </ul></p>
                        </div>
                    <form method="POST" action="{{ route('reset-password-store-user') }}" class="form">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="password">Enter New Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" placeholder="New Password" min="8" required class="form-control password">
                            <input type="hidden" name="urlToken" value="{{ $token }}">
                            <i class="fas fa-solid fa-eye-slash float-right eyeicon mr-2"></i>
                            @error('password')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>   
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" placeholder="Confirm Password" required class="form-control password">
                            <i class="fas fa-solid fa-eye-slash float-right eyeicon_confirm mr-2"></i>

                       
                        </div>
                        <div class="form-group">
                            <button type="submit" name="submit" class="btn rounded">Reset Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script type="text/javascript" src="{{asset('assets/js/login.js')}}"></script>
@endsection