@extends('layouts.master', ['title' => 'Trackers List'])
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3>Trackers List</h3>
                <a href="{{ route('add_tracker') }}" class="btn float-right p-3 rounded mb-2"><i
                        class="fas fa-plus mr-2"></i>Add Candidate</a>
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
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="text-light" style="background: #e35e25;">
                            <tr>
                                <th>S No.</th>
                                <th>Name</th>
                                <th>Email/Contact</th>
                                <th>Preffered/Current Location</th>
                                <th>Gender</th>
                                <th>Applied Designation/Current Designation</th>
                                <th>Key Skills</th>
                                <th>Experience (in Yr)</th>
                                <th>Notice Period</th>
                                <th>Resume</th>
                                <th>Remarks</th>
                                <th>Reference</th>
                                <th>Added On</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $track)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="emp_check" value="{{ $track->id }}" />
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="case-capitalize">

                                        {{ $track->name }}
                                    </td>
                                    <td>{{ $track->email }} /{{ $track->contact }}</td>

                                    <td>
                                        {{ $track->preffered_location }} /
                                        {{ $track->current_location }}
                                    </td>
                                    <td>{{ $track->gender }}</td>
                                    <td>{{ $track->applied_designation }} /
                                        {{ $track->current_designation }}
                                    </td>
                                    <td>{{ $track->key_skills }}</td>
                                    <td>{{ $track->experience }}</td>
                                    <td>{{ $track->notice_period }}</td>
                                    <td>
                                        @if ($track->resume != null)
                                            <a href="{{ asset('/tracker/resume/' . $track->resume) }}" target="_blank"
                                                class="badge badge-secondary badge-sm text-white"><i class="fa fa-download"
                                                    aria-hidden="true"></i>
                                                Resume</a>
                                        @endif
                                    </td>
                                    <td>{{ $track->remarks }}</td>
                                    <td class="text-capitalize">{{ $track->reference }}</td>
                                    <td>{{ $track->created_at }}</td>
                                    <td>
                                        <a href="{{route('edit_tracker', ['id' => $track->id])}}" class="badge badge-primary text-white"
                                            target="_blank" rel="noopener noreferrer"><i class="fa fa-eye"
                                                aria-hidden="true"></i> View</a>

                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
