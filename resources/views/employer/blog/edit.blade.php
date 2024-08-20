@extends('layouts.master', ['title' => 'Edit Blog'])
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <h2>Edit Blog - {{$blog->title}}</h2>
                <a href="{{ route('blog_list') }}" class="btn rounded p-3 float-right">Back</a>
            </div>
            <div class="col-md-12">
                <form action="{{ route('update_blog', ['id' => $blog->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6 d-flex justify-content-center">
                            <img src="{{asset('blogs/'.$blog->image)}}" alt="no-image-found" class="img-fluid rounded border w-50">
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <label for="title">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="title" maxlength="50" value="{{$blog->title}}" required>
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label for="image">Blog Image</label>
                                    <input type="file" class="form-control" name="image" accept=".jpg,.jpeg,.png" maxlength="1024" max="1024">
                                    <span class="text-muted small">(Only jpg, .jpeg and png files are allowed And max size is
                                        1mb)</span>
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                              
                            </div>
                        </div>
                        <div class="col-md-12 mb-2">
                            
                            <label for="content">Content <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="content" required>{{$blog->content}}</textarea>
                            @error('content')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                      
                    </div>
                    <button class="btn rounded my-2 float-right">Update</button>
                </form>
            </div>
        </div>
    </div>
@endsection
