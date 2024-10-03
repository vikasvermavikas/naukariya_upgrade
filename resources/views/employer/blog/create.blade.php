@extends('layouts.master', ['title' => 'Add Blog'])
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Add Blog</h2>
                <a href="{{ route('blog_list') }}" class="btn rounded p-3 float-right">Back</a>
            </div>
            <div class="col-md-12">
                <form action="{{ route('save_blog') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="title">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="title" maxlength="50" value="{{old('title')}}" required>
                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="image">Blog Image <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="image" accept=".jpg,.jpeg,.png" required>
                            <span class="text-muted small">(Only jpg, .jpeg and png files are allowed And max size is
                                1mb)</span>
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-12">
                            <label for="content">Content <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="content" required>{{old('content')}}</textarea>
                            @error('content')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <button class="btn rounded my-2">Save</button>
                </form>
            </div>
        </div>
    </div>
@endsection
