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
                        {{ session()->get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session()->get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            </div>
            <div class="col-md-12 d-flex justify-content-center my-4">
                <form class="" action="{{ route('unfollowNewsletter') }}" method="POST">
                    @csrf
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                            <label for="" class="font-weight-bold">Please Select Reason</label><br>
                            <div class="row">
                              <div class="col-md-12">
                                <div class="pl-5">
                                  <input type="radio" name="reason" value="Your Emails are not relevant to me" required>
                                  <label for="reason">Your Emails are not relevant to me</label><br>
          
                                  <input type="radio" name="reason" value="Your emails are too frequent" required>
                                  <label for="reason">Your emails are too frequent</label><br>
          
                                  <input type="radio" name="reason" value="I don't remember signing up for this" required>
                                  <label for="reason">I don't remember signing up for this</label><br>
                                  
                                  <input type="radio" name="reason" value="I no longer want to receive these emails" required>
                                  <label for="reason">I no longer want to receive these emails</label><br>

                                  @error('reason')
                                  <span class="text-danger">{{ $message }}</span>
                                   @enderror

                                </div>
                              </div>
                            </div>
    
                        </div>

                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                            <label for="email" class="font-weight-bold">Email Id</label>
                            <input type="email" name="email" id="email" class="form-control mx-3" placeholder="Enter Email Id" required>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                      </div>
                    </div>
                    <button type="submit" class="btn p-4 rounded">Unsubscribe</button>
                </form>
            </div>
        </div>
    </div>
@endsection
