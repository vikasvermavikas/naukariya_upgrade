@extends('layouts.master', ['title' => 'Scheduled Interviews'])
@section('content')
    <div class="container mt-2">
        <div class="row">
             <div class="col-md-12 mb-5">
                    {{ Breadcrumbs::render('scheduled_interviews') }}
                 </div>
            <div class="col-md-12">
                <h1>Scheduled Interviews</h1>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="text-light" style="background:#F95602;">
                            <tr>
                                <th>SN#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Position</th>
                                <th>Date of Scheduled</th>
                                <th>Date of Interview</th>
                                <th>Send Notification</th>
                            </tr>
                        </thead>
                            <tbody>
                                @forelse ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                      {{ $item->fname }}
                                      {{ $item->lname }}
                                    </td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->contact }}</td>
                                    <td>{{ $item->applied_for }}</td>
                                    <td>{{ $item->updated_at }}</td>
                                    <td>Need to be clarify</td>
                                    <td>
                                      <span class="btn" style="pointer-events: none">Notify</span>
                                    </td>
                                </tr>
                                    
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-danger text-center">No Record Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
