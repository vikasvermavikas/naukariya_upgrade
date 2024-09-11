@extends('layouts.master', ['title' => 'Resume Details'])
@section('style')
<style>
    .labourcolor{
        color: #e35e25;
    }
</style>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Resume Details</h2>
        </div>
        <div class="col-md-12">
            <a href="{{route('resume_analysing')}}" class="btn p-3 rounded float-right my-2">Back</a>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Field</th>
                        <th>Value</th>
                    </tr>
                    <tr>
                        <td>Name</td>
                        <td>{{$name}}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>{{$email}}</td>
                    </tr>
                    <tr>
                        <td>Contact</td>
                        <td>{{$mobile}}</td>
                    </tr>
                    <tr>
                        <td>Qualifications</td>
                        <td>{{$qualifications}}</td>
                    </tr>
                    <tr>
                        <td>Skills</td>
                        <td>{{$skills}}</td>
                    </tr>
                    <tr>
                        <td>Experience</td>
                        <td>{{$experience}}</td>
                    </tr>
                </thead>
            </table>
        </div>
        <hr>
        <div class="col-md-12 my-3">
            <form class="form">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="name" class="labourcolor">Name</label>
                        <input class="form-control" name="name" value="{{$name}}" required />
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email" class="labourcolor">Email</label>
                        <input class="form-control" name="email" value="{{$email}}" required />
                    </div>
                    <div class="form-group col-md-6">
                        <label for="mobile" class="labourcolor">Contact</label>
                        <input class="form-control" name="mobile" value="{{$mobile}}" required />
                    </div>
                    <div class="form-group col-md-6">
                        <label for="qualifications" class="labourcolor">Qualifications</label>
                        <textarea class="form-control" name="qualifications" required>{{$qualifications}} </textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="skills" class="labourcolor">Skills</label>
                        <textarea class="form-control" name="skills" required >{{$skills}}</textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="experience" class="labourcolor">Experience</label>
                        <textarea class="form-control" name="experience" required>{{$experience}}</textarea>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection