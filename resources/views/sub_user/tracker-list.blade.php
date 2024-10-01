@extends('layouts.master', ['title' => 'Trackers List'])
@section('content')
    <div class="container">
        <div class="row">
             <div class="col-md-12">
                    {{ Breadcrumbs::render('subuser_trackers') }}
                 </div>
            {{-- Heading --}}
            <div class="col-md-12">
                <h3>Trackers List</h3>
                <a href="{{ route('add_tracker') }}" class="btn float-right p-3 rounded mb-2"><i
                        class="fas fa-plus mr-2"></i>Add Candidate</a>
            </div>
          
            {{-- Filter Form --}}
            <div class="col-md-12">
                <form class="form" action="" method="get">
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="source">Source</label>
                            <select class="form-control" id="source" name="source">
                                <option value="">Select Source</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Location<small> (Preff./Curr.)</small></label>
                            <input type="text" class="form-control" name="location" value="{{$location}}" placeholder="Enter Location">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Skills<small> (Multiple Skills Seperated by comma(,))</small></label>
                            <input type="text" class="form-control" name="skills" value="{{$skills}}" placeholder="Enter Multiple Skills also Separated by Comma">
                        </div>
                        <div class="form-group col-md-3">
                            <label>From Date</label>
                            <input type="date" class="form-control" name="from_date" value="{{$from_date}}" placeholder="Enter From Date">
                        </div>
                        <div class="form-group col-md-3">
                            <label>To Date<small> (Preff./Curr.)</small></label>
                            <input type="date" class="form-control" name="to_date" value="{{$to_date}}" placeholder="Enter To Date">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email" value="{{$email}}" placeholder="Enter email">
                        </div>
                        <div class="col-md-3 mt-4 p-2">
                           <button type="submit" class="btn rounded p-3">Search</button>
                           <a href="{{route('subuser-tracker-list')}}" class="btn rounded p-3">Reset</a>
                        </div>
                    </div>
                    
                </form>
            </div>

            {{-- Export Button --}}
            <div class="col-md-12 my-2">
                <button class="btn-success rounded pr-3 exportexcel" ><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" fill="white" class="mb-3" height="20"><path d="M0 64C0 28.7 28.7 0 64 0L224 0l0 128c0 17.7 14.3 32 32 32l128 0 0 128-168 0c-13.3 0-24 10.7-24 24s10.7 24 24 24l168 0 0 112c0 35.3-28.7 64-64 64L64 512c-35.3 0-64-28.7-64-64L0 64zM384 336l0-48 110.1 0-39-39c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l80 80c9.4 9.4 9.4 24.6 0 33.9l-80 80c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l39-39L384 336zm0-208l-128 0L256 0 384 128z"/></svg> Export Data</button>
            </div>

            <div class="col-md-12 my-2">
                <h3 class="h5" style="color:#e35e25;">Total Candidates : <span class="text-dark">{{$data->count()}}</span></h3>
                
            </div>
            {{-- Showing Notifications if any. --}}
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

            {{-- Listing Table. --}}
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
                                        <input type="checkbox" name="emp_check" class="trackerids" value="{{ $track->id }}" />
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="text-capitalize">

                                        {{ $track->name }}
                                    </td>
                                    <td>{{ $track->email }} /{{ $track->contact }}</td>

                                    <td>
                                        {{ $track->preffered_location }} {{!empty($track->preffered_location) && !empty($track->current_location) ? '/' : ''}} 
                                        {{ $track->current_location}}
                                    </td>
                                    <td class="text-capitalize	">{{ $track->gender }}</td>
                                    <td>{{ $track->applied_designation }}  {{!empty($track->applied_designation) && !empty($track->current_designation) ? '/' : ''}} 
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
                            <tr>
                                <td class="text-danger text-center" colspan="14">No Record Found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination --}}
            <div class="col-md-12 my-3">
                {{$data->links()}}
            </div>
        </div>
    </div>
@endsection
@section('script')
<script src="{{asset('assets/js/subuser/tracker-list.js')}}"></script>
@endsection
