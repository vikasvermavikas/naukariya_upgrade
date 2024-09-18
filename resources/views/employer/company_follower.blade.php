@extends('layouts.master', ['title' => 'Followers'])    
@section('content')
<div class="container">
    <div class="row">
         <div class="col-md-12 mb-5">
                    {{ Breadcrumbs::render('follower_list') }}
                 </div>
        <div class="col-md-12">
            <h1>Follower Details</h1>
        </div>
        
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead style="background:#F95602;" class="text-light">
                        <tr>
                            <th>S.No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Designation</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($followlist as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->fname }} {{ $item->lname }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->contact }}</td>
                                <td>{{ ($item->designation) ? $item->designation : 'N/A' }}</td>
                                <td>{{ date('d-M-y', strtotime($item->created_at))}}</td>
                            </tr>
                        @empty
                                <tr>
                                    <td colspan="6" class="text-danger">No record Found</td>
                                </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-12 d-flex justify-content-center mb-2">
            {{$followlist->onEachSide(0)->links()}}
        </div>
    </div>
</div>
    
@endsection