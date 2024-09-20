@extends('layouts.master', ['title' => 'Posted Jobs'])
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-5">
                    {{ Breadcrumbs::render('posted_jobs') }}
                 </div>
            <div class="col-md-12">
                <h1>Posted Jobs</h1>
                @if (session()->has('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session()->get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            </div>
            <div class="col-md-12 my-2">
                <form action="" method="GET" class="float-right">
                    <div class="row">
                        <div class="col-md-12 float-right">
                            <Label class="font-weight-bold small">Search (Title / Status / Client Name)</Label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="search" name="keyword"
                                    value="{{ $keyword }}">
                            </div>
                            <div class="d-flex justify-content-center">
                                <button class="btn text-white p-3 rounded mr-2">Search</button>
                                <a href="{{ route('postedjobs') }}" class="btn text-white p-3 rounded ml-2">Clear</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-12 d-flex justify-content-center">
                {{ $data->onEachSide(0)->links() }}
            </div>
            @forelse ($data as $item)
                <div class="col-sm-6 col-md-4 col-lg-3 my-2">
                    <div class="card h-100">
                        @if ($item->status == 'Active')
                            <div class="card-header bg-success text-light rounded text-center">
                                <h3 class="text-center text-light">{{ $item->status }}</h3>
                            </div>
                        @else
                            <div class="card-header bg-danger text-light rounded text-center">
                                <h3 class="text-center text-light">{{ $item->status }}</h3>
                            </div>
                        @endif

                        <div class="card-body">
                            <p class="card-text">
                            <p class="text-center" style="color:#F96011"><a
                                    href="{{ route('edit_posted_job', ['id' => $item->id]) }}"
                                    class="text-dark" data-toggle="tooltip" data-placement="top" title="Edit">{{ $item->title }}</a></p>
                            <p class="text-center">{{ date('d-M-y', strtotime($item->created_at)) }}</p>
                            <p class="text-center">
                                @if ($item->status == 'Active')
                                    <a href="{{ route('deactive_posted-job', ['id' => $item->id]) }}"
                                        class="btn bg-danger">Deactivate</a>
                                @else
                                    <a href="{{ route('active_posted-job', ['id' => $item->id]) }}"
                                        class="btn bg-success">Activate</a>
                                @endif

                            </p>
                            </p>
                        </div>
                        <div class="card-footer bg-info text-light">
                            <span><b class="text-light">Client Name :</b>
                                {{ $item->name ? $item->name : 'Not Specify' }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <span class="text-danger">No Record Found</span>
            @endforelse

            <div class="col-md-12 d-flex justify-content-center my-2">
                {{ $data->onEachSide(0)->links() }}
            </div>
        </div>
    </div>
@endsection
