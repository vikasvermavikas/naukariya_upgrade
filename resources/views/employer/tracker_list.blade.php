@extends('layouts.master', ['title' => 'Tracker List'])
@section('style')
    <link href="{{ asset('assets/css/tagsinput.css') }}" rel="stylesheet" type="text/css">
    <style>
        .card:hover {
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <p class="h3">Candidate List</p>
        @php
            $searched_exp = '';
            if (isset($requestdata['experience'])) {
                $searched_exp = $requestdata['experience'];
            }
        @endphp
        <div class="row">
             <div class="col-md-12 mb-5">
                    {{ Breadcrumbs::render('trackers_list') }}
                 </div>
            <div class="col-md-12">
                <form action="" method="GET">
                    <div class="row">
                        <div class="d-none">
                            <input type="hidden" name="userid" value="{{isset($requestdata['userid']) ? $requestdata['userid'] : ''}}">
                        </div>
                        <div class="col-md-4">
                            <label for="" class="font-weight-bold">Source</label>
                            <div class="form-group">
                                <select name="source" id="source" class="form-control">
                                    <option value="">Select Source</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="" class="font-weight-bold">Location (Preff./Curr.)</label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="location"
                                    value="{{ isset($requestdata['location']) ? $requestdata['location'] : '' }}"
                                    placeholder="Enter Location">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="" class="font-weight-bold">Skiils</label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="skills" data-role="tagsinput"
                                    placeholder="Enter multiple comma seperated skills"
                                    value="{{ isset($requestdata['skills']) ? $requestdata['skills'] : '' }}">

                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="" class="font-weight-bold">From Date</label>
                            <div class="form-group">
                                <input type="date" class="form-control" name="from_date"
                                    value="{{ isset($requestdata['from_date']) ? $requestdata['from_date'] : '' }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="" class="font-weight-bold">To Date</label>
                            <div class="form-group">
                                <input type="date" class="form-control" name="to_date"
                                    value="{{ isset($requestdata['to_date']) ? $requestdata['to_date'] : '' }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="" class="font-weight-bold">Applied Designation</label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="applied_designation"
                                    placeholder="Applied Designation"
                                    value="{{ isset($requestdata['applied_designation']) ? $requestdata['applied_designation'] : '' }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="" class="font-weight-bold">Current Designation</label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="current_designation"
                                    placeholder="Current Designation"
                                    value="{{ isset($requestdata['current_designation']) ? $requestdata['current_designation'] : '' }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="" class="font-weight-bold">Experience</label>
                            <div class="form-group">
                                <select name="experience" class="form-control">
                                    <option value="">Select Experience</option>
                                    <option value="fresher">0-1 Yr (Also Fresher)</option>
                                    <option value="1-2" {{ $searched_exp == '1-2' ? 'selected' : '' }}>1-2 Yr</option>
                                    <option value="2-4" {{ $searched_exp == '2-4' ? 'selected' : '' }}>2-4 Yr</option>
                                    <option value="4-5" {{ $searched_exp == '4-5' ? 'selected' : '' }}>4-5 Yr</option>
                                    <option value="5-8" {{ $searched_exp == '5-8' ? 'selected' : '' }}>5-8 Yr</option>
                                    <option value="8-10" {{ $searched_exp == '8-10' ? 'selected' : '' }}>8-10 Yr</option>
                                    <option value="10-15" {{ $searched_exp == '10-15' ? 'selected' : '' }}>10-15 Yr
                                    </option>
                                    <option value="15-20" {{ $searched_exp == '15-20' ? 'selected' : '' }}>15-20 Yr
                                    </option>
                                    <option value="20-25" {{ $searched_exp == '20-25' ? 'selected' : '' }}>20-25 Yr
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="" class="font-weight-bold">UG</label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Graduation" name="ug"
                                    value="{{ isset($requestdata['ug']) ? $requestdata['ug'] : '' }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="" class="font-weight-bold">PG</label>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Post Graduation" name="pg"
                                    value="{{ isset($requestdata['pg']) ? $requestdata['pg'] : '' }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="" class="font-weight-bold">Min Salary (in LPA)</label>
                            <div class="form-group">
                                <input type="number" class="form-control" placeholder="Min Salary" name="min_salary"
                                    value="{{ isset($requestdata['min_salary']) ? $requestdata['min_salary'] : '' }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="" class="font-weight-bold">Max Salary (in LPA)</label>
                            <div class="form-group">
                                <input type="number" class="form-control" placeholder="Max Salary" name="max_salary"
                                    value="{{ isset($requestdata['max_salary']) ? $requestdata['max_salary'] : '' }}">
                            </div>
                        </div>
                        <div class="col-md-4 d-flex">
                            <button type="submit" class="btn rounded mr-2">Search</button>
                            <a href="{{ route('tracker-list') }}" class="btn rounded">Reset</a>
                        </div>

                    </div>

                </form>
            </div>
            <div class="col-md-12 my-2">
                <a href="{{route('exportTracker')}}" target="_blank" class="btn p-3 rounded float-right"><svg xmlns="http://www.w3.org/2000/svg" class="mb-2" viewBox="0 0 512 512"
                        width="20px">
                        <path fill="#FFFFFF"
                            d="M288 32c0-17.7-14.3-32-32-32s-32 14.3-32 32V274.7l-73.4-73.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l128 128c12.5 12.5 32.8 12.5 45.3 0l128-128c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L288 274.7V32zM64 352c-35.3 0-64 28.7-64 64v32c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V416c0-35.3-28.7-64-64-64H346.5l-45.3 45.3c-25 25-65.5 25-90.5 0L165.5 352H64zm368 56a24 24 0 1 1 0 48 24 24 0 1 1 0-48z" />
                    </svg>
                    <span>Complete Data Export</span>
                </a>
            </div>
            <div class="col-md-12 d-flex justify-content-center my-2">
                {{ $data->onEachSide(0)->links() }}
            </div>

            @forelse ($data as $item)
                <div class="col-md-12">
                    {{-- Card Start --}}
                    <div class="card mb-2 hover-overlay rounded">
                        <div class="card-header text-capitalize">
                            {{ $item->name }}
                        </div>
                        <div class="card-body">
                            <div class="card-text">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                    width="20px" title="Experience" data-toggle="tooltip">
                                                    <path
                                                        d="M184 48H328c4.4 0 8 3.6 8 8V96H176V56c0-4.4 3.6-8 8-8zm-56 8V96H64C28.7 96 0 124.7 0 160v96H192 320 512V160c0-35.3-28.7-64-64-64H384V56c0-30.9-25.1-56-56-56H184c-30.9 0-56 25.1-56 56zM512 288H320v32c0 17.7-14.3 32-32 32H224c-17.7 0-32-14.3-32-32V288H0V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V288z" />
                                                </svg>
                                                <span style="color: #E35E25;">
                                                    @if ($item->experience == 'fresher' || empty($item->experience))
                                                        Fresher
                                                    @else
                                                        {{ $item->experience . ' Years' }}
                                                    @endif
                                                </span>
                                            </div>

                                            <div class="col-md-3 my-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                    width="20px" title="Current CTC" data-toggle="tooltip">
                                                    <path
                                                        d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V192c0-35.3-28.7-64-64-64H80c-8.8 0-16-7.2-16-16s7.2-16 16-16H448c17.7 0 32-14.3 32-32s-14.3-32-32-32H64zM416 272a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                                </svg>
                                                <span
                                                    style="color: #E35E25;">{{ $item->current_ctc ? $item->current_ctc." LPA" : 'N/A' }}</span>
                                            </div>
                                            <div class="col-md-6 my-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"
                                                    width="20px" title="Current Location" data-toggle="tooltip">
                                                    <path
                                                        d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z" />
                                                </svg>
                                                <span style="color: #E35E25;">
                                                    {{ $item->current_location ? $item->current_location : 'N/A' }}</span>
                                            </div>
                                            <div class="col-md-12 my-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"
                                                    width="20px" title="Qualification" data-toggle="tooltip">
                                                    <path
                                                        d="M320 32c-8.1 0-16.1 1.4-23.7 4.1L15.8 137.4C6.3 140.9 0 149.9 0 160s6.3 19.1 15.8 22.6l57.9 20.9C57.3 229.3 48 259.8 48 291.9v28.1c0 28.4-10.8 57.7-22.3 80.8c-6.5 13-13.9 25.8-22.5 37.6C0 442.7-.9 448.3 .9 453.4s6 8.9 11.2 10.2l64 16c4.2 1.1 8.7 .3 12.4-2s6.3-6.1 7.1-10.4c8.6-42.8 4.3-81.2-2.1-108.7C90.3 344.3 86 329.8 80 316.5V291.9c0-30.2 10.2-58.7 27.9-81.5c12.9-15.5 29.6-28 49.2-35.7l157-61.7c8.2-3.2 17.5 .8 20.7 9s-.8 17.5-9 20.7l-157 61.7c-12.4 4.9-23.3 12.4-32.2 21.6l159.6 57.6c7.6 2.7 15.6 4.1 23.7 4.1s16.1-1.4 23.7-4.1L624.2 182.6c9.5-3.4 15.8-12.5 15.8-22.6s-6.3-19.1-15.8-22.6L343.7 36.1C336.1 33.4 328.1 32 320 32zM128 408c0 35.3 86 72 192 72s192-36.7 192-72L496.7 262.6 354.5 314c-11.1 4-22.8 6-34.5 6s-23.5-2-34.5-6L143.3 262.6 128 408z" />
                                                </svg>
                                                <span style="color: #E35E25;">UG :
                                                    {{ isset($education_data[$item->id]) ? $education_data[$item->id]['graduation'] : 'N/A' }}
                                                </span> | <span style="color: #E35E25;">PG:
                                                    {{ isset($education_data[$item->id]) ? $education_data[$item->id]['post_graduation'] : 'N/A' }}</span>
                                            </div>
                                            <div class="col-md-12 my-2">
                                            </div>
                                            <div class="col-md-12 mt-2">
                                                <p> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                        width="20px" title="Skills" data-toggle="tooltip">
                                                        <path
                                                            d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z" />
                                                    </svg>
                                                    Key Skills : {{ $item->key_skills }}
                                                </p>
                                            </div>
                                        </div>



                                    </div>
                                    <div class="col-md-4 text-center" style="background:#F6F6F6;">
                                        <img src="{{ asset('assets/images/default-image.png') }}" alt="no image"
                                            class="img-circle img-fluid" style="width: 12%" srcset="">
                                        <p class="font-weight-bold">
                                            {{ $item->current_designation ? $item->current_designation : 'N/A' }}</p>
                                        <p>Applied For {{ $item->applied_designation }}</p>
                                        <p> Email : {{ $item->email }}</p>
                                        <p>Phone : {{ $item->contact }}</p>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>


                    {{-- Card End --}}
                </div>
            @empty
            <span class="text-danger">No Record Found.</span>
            @endforelse
            <div class="col-md-12 d-flex justify-content-center my-2">
                {{ $data->onEachSide(0)->links() }}
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/tracker_list.js') }}"></script>
    <script src="{{ asset('assets/js/tagsinput.js') }}"></script>
@endsection
