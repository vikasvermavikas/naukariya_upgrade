@extends('layouts.master', ['title' => 'Resume Analysing'])
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 my-3">
            <h2>Resume Analysing</h2>
        </div>
        <div class="col-md-12">
            @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{session()->get('message')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            @endif
        </div>
        <div class="col-md-12 border p-3 my-3 d-flex justify-content-center">
            <form id="parseresume" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="resume">Upload Resume</label>
                    <input type="file" class="form-control" id="file" name="file" accept=".pdf,.doc" required>
                    @error('file')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <button type="submit" class="btn p-3 rounded submit">Submit</button>
            </form>
        </div>
    </div>
</div>
    
@endsection
@section('script')
<script src="{{asset('assets/js/resumeparse.js')}}"></script>
@endsection