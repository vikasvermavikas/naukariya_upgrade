@extends('layouts.master', ['title' => 'Blogs'])
@section('content')
<div class="container">
    <div class="row">

        {{-- Page Titles --}}
        <div class="col-md-12">
            <h2>Blogs</h2>
            <a href="{{route('add_blog')}}" class="btn rounded p-3 float-right">Add Blog</a>
        </div>

        {{-- Notifications --}}
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

        {{-- Table Listing --}}
        <div class="col-lg-12">

            <div class="table-responsive-lg my-4">
                <table class="table border table-hover text-center">
                    <thead class="text-light" style="background:#e35e25;">
                        <tr>
                            <td>S.No.</td>
                            <td>Blog Title</td>
                            <td class="text-center">Blog Image</td>
                            <td>Date</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($blogs as $blog)
                        <tr class="main">
                            <td>{{$loop->iteration}}</td>
                            <td>{{$blog->title}}</td>  
                            <td class="text-center"><img src="{{asset('blogs/'.$blog->image.'')}}" class="img-fluid rounded" height="100" width="100" alt="no-image-found"></td>
                            <td>{{date('d-M-Y', strtotime($blog->created_at))}}</td>
                            <td><a href="{{route('edit_blog', ['id' => $blog->id])}}" class="mx-2 text-dark" title="Edit" data-toggle="tooltip"><i class="fas fa-edit"></i></a>

                                <i class="fas fa-trash mx-1 delete" title="Delete" data-id="{{$blog->id}}" data-toggle="tooltip"></i>
                            
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td class="text-danger text-center" colspan="5">
                                    No Record Found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="col-md-12 text-center">
            {{ $blogs->onEachSide(0)->links() }}
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{asset('assets/js/blog/blog.js')}}"></script>
@endsection