@extends('layouts.master', ['title' => 'Consolidated List'])
@section('content')
    <div class="container">
        <div class="row">
             <div class="col-md-12 mb-5">
                    {{ Breadcrumbs::render('consolidate_data') }}
                 </div>
            <div class="col-md-12">
                <h1 class="mb-3">Consolidate Data Candidate List</h1>
            </div>
            <div class="col-md-12">
                <form action="{{ route('get_consolidate_data') }}" method="get">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Keyword</label>
                            <input type="text" class="form-control" name="keyword" placeholder="Enter Keywords"
                                value="{{ $keyword }}">
                        </div>
                        <div class="col-md-6">
                            <label>Keywords(Exact match)</label>
                            <input type="text" class="form-control" name="multikeyword" value="{{ $multikeyword }}"
                                placeholder="Enter multiple Keywords seperated by comma">
                        </div>
                        <div class="col-md-12 d-flex justify-content-center my-3">
                            -------------------------------------------------OR------------------------------------------------------
                        </div>
                        <div class="col-md-2">
                            <label for="location">Location</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="location" name="location"
                                    value="{{ $location }}" placeholder="Enter Location">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label for="skills">Skills</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="skills" name="skills"
                                    value="{{ $skills }}" placeholder="Enter Skills">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="source">Source</label>
                            <div class="form-group">
                                <select class="form-control" id="source" name="source" value={{ $source }}>
                                    <option value="">Select Source</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="from_date">From Date</label>
                            <div class="form-group">
                                <input type="date" class="form-control" name="from_date" value="{{ $from_date }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="to_date">To Date</label>
                            <div class="form-group">
                                <input type="date" class="form-control" name="to_date" value="{{ $to_date }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn h-50 mt-4">Search</button>
                        </div>
                        <div class="col-md-2 my-2">
                            <a href="{{ route('get_consolidate_data') }}" class="btn h-50">Clear</a>
                        </div>

                    </div>
                </form>
            </div>
            <div class="col-md-12">

                <div class="row">
                    <div class="col-md-12 my-2">
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
                        <a href="{{ route('export_consolidate_data') . $query }}" target="_blank"
                            class="btn mt-2 float-right">Complete data export</a>
                    </div>
                    <div class="col-md-12 d-flex justify-content-center mb-3">
                        {{ $data->onEachSide(0)->links() }}
                    </div>

                    <div class="col-md-12">
                        <div class="table-responsive">

                            <table class="table table-bordered">
                                <thead style="background:#E35E25;" class="text-light">
                                    <tr>
                                        <th>S no.</th>
                                        <th>Source</th>
                                        <th>Name / Email / Contact</th>
                                        <th>Designation</th>
                                        <th>Current / Preffered Location</th>
                                        <th>Experience / Fresher</th>
                                        <th>Skill Sets</th>
                                        <th>Annual Salary</th>
                                        <th>Upload Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>

                                            <td>{{ $item->source }}</td>
                                            <td>
                                                {{ $item->name }} / {{ $item->email }} / {{ $item->mobile_no }}
                                            </td>
                                            <td>{{ $item->designation }}</td>
                                            <td>
                                                {{ $item->current_location }} / {{ $item->preferred_location }}
                                            </td>
                                            <td>{{ $item->work_experience }}</td>
                                            <td>{{ $item->key_skills }}</td>
                                            <td>{{ $item->annual_salary }} </td>
                                            <td>{{ date('d-M-y', strtotime($item->created_at)) }}</td>

                                        </tr>

                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-danger">No Record Found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-12 my-2">
                        <div class="d-flex justify-content-center">{{ $data->onEachSide(0)->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/js/consolidate.js') }}"></script>
@endsection
