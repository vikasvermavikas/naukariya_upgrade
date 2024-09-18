@extends('layouts.master', ['title' => 'Change Password'])
@section('content')
    <div class="container">
        <div class="row">
             <div class="col-md-12">
                    {{ Breadcrumbs::render('employer_change_password') }}
                 </div>
            <div class="col-md-12">
                @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{session()->get('success')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @endif
                @if (session()->has('errorsuccess'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{session()->get('errorsuccess')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @endif

            </div>
            <div class="col-md-12 d-flex justify-content-center my-3">
                <div class="card card-outline-secondary">
                    <div class="card-header text-center" style="background:#F95602">
                        <h3 class="mb-0 text-light">Change Password</h3>

                    </div>
                    <div class="card-body ">
                        <div class="border jumbotron">
                            <span class="text-danger">Please follow instructions</span>
                           <ul>
                            <li>Password must be minimum 8 characters long. </li>
                            <li>Password must contain at least 1 uppercase and 1 lowercase letter.</li>
                            <li>Password must contain at least 1 special symbol.</li>
                            <li>Password must not contain white spaces.</li>
                           </ul>
                        </div>
                        <form action="{{ route('employer_update_password') }}" class="form" role="form"
                            autocomplete="off" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="current_password">Current Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="current_password" name="current_password"
                                    required="">
                                @error('current_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="new_password">New Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="new_password" name="new_password"
                                    required="">
                                <span class="form-text small text-muted">
                                    The password must be 8-20 characters, and must <em>not</em> contain spaces.
                                </span>
                                @error('new_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Verify <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                                    required="">
                                <span class="form-text small text-muted">
                                    To confirm, type the new password again.
                                </span>
                                @error('confirm_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success btn-lg float-right">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
