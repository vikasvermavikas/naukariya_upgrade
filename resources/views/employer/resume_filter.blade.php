@extends('layouts.master', ['title' => 'Resume View'])
@section('style')
    <style>
        .marginleft {
            margin-left: -11px;

        }

        [role=button] {
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Resume View</h2>
            </div>
            <div class="col-md-12 d-flex justify-content-center my-1">
                <div style="background:#F95602;" class="text-light text-center w-50 rounded" role="button" data-toggle="modal"
                    data-target="#savesearch">
                    Save Search
                </div>
            </div>
            <div class="col-md-12 d-flex justify-content-center my-1">
                <div style="background:#F95602;" class="text-light text-center w-50 rounded" role="button"
                    data-toggle="modal" data-target="#addTagModal">
                    Add Tagged
                </div>
            </div>
            <div class="col-md-12 d-flex justify-content-center my-1">
                <div style="background:#F95602;" class="text-light text-center w-50 rounded" role="button"
                    id="export_excel">
                    Export Excel
                </div>
            </div>
            <div class="col-md-12 d-flex justify-content-center my-1">
                <div style="background:#F95602;" class="text-light text-center w-50 rounded" role="button"
                    data-toggle="modal" data-target="#sendEmailModal">
                    Send Email
                </div>
            </div>
            {{-- <div class="col-md-12 d-flex justify-content-center my-1">
                <div style="background:#F95602;" class="text-light text-center w-50 rounded" role="button" >
                    Send SMS
                </div>
            </div> --}}
            {{-- @php
                echo "<pre>";
                print_r($category);
                echo "</pre>";
                die;
            @endphp --}}
            <div class="col-md-12 d-flex justify-content-center my-2">
                {{ $category->onEachSide(0)->links() }}
            </div>

            @forelse ($category as $item)
                <div class="col-md-12">
                    {{-- Card Start --}}
                    <div class="card mb-2 hover-overlay rounded">
                        <div class="form-check ml-2">
                            <input class="form-check-input datavalues" type="checkbox" name="jobseeker_id"
                                value="{{ $item['js_id'] }}" />
                        </div>
                        <div class="card-header text-capitalize">
                            {{ $item['fname'] . ' ' . $item['lname'] }}
                        </div>
                        <a href="{{ route('get_skill_info', ['jsid' => $item['js_id']]) }}" class="text-dark">
                            <div class="card-body">
                                <div class="card-text">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="row">


                                                <div class="col-md-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                        width="20px" >
                                                        <path
                                                            d="M184 48l144 0c4.4 0 8 3.6 8 8l0 40L176 96l0-40c0-4.4 3.6-8 8-8zm-56 8l0 40L64 96C28.7 96 0 124.7 0 160l0 96 192 0 128 0 192 0 0-96c0-35.3-28.7-64-64-64l-64 0 0-40c0-30.9-25.1-56-56-56L184 0c-30.9 0-56 25.1-56 56zM512 288l-192 0 0 32c0 17.7-14.3 32-32 32l-64 0c-17.7 0-32-14.3-32-32l0-32L0 288 0 416c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-128z" />
                                                    </svg>
                                                    <span style="color: #E35E25;" title="experience" data-toggle="tooltip" data-placement="top">
                                                        @if (isset($item['exp_year']))
                                                            {{ $item['exp_year'] . ' Year' }} -
                                                            {{ $item['exp_month'] . ' Month' }}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="col-md-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                        width="20px">
                                                        <path
                                                            d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V192c0-35.3-28.7-64-64-64H80c-8.8 0-16-7.2-16-16s7.2-16 16-16H448c17.7 0 32-14.3 32-32s-14.3-32-32-32H64zM416 272a32 32 0 1 1 0 64 32 32 0 1 1 0-64z" />
                                                    </svg>
                                                    <span
                                                        style="color: #E35E25;" title="salary" data-toggle="tooltip" data-placement="top">{{ isset($item['current_salary']) ? $item['current_salary'] . ' LPA' : 'N/A' }}</span>
                                                </div>
                                                <div class="col-md-6">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"
                                                        width="20px">
                                                        <path
                                                            d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z" />
                                                    </svg>
                                                    <span style="color: #E35E25;" title="location" data-toggle="tooltip" data-placement="top">
                                                        {{ isset($item['current_working_location']) ?  $item['current_working_location'] : 'N/A'}}</span>
                                                </div>
                                                <div class="col-md-12 my-2">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"
                                                                width="20px">
                                                                <path
                                                                    d="M337.8 5.4C327-1.8 313-1.8 302.2 5.4L166.3 96 48 96C21.5 96 0 117.5 0 144L0 464c0 26.5 21.5 48 48 48l208 0 0-96c0-35.3 28.7-64 64-64s64 28.7 64 64l0 96 208 0c26.5 0 48-21.5 48-48l0-320c0-26.5-21.5-48-48-48L473.7 96 337.8 5.4zM96 192l32 0c8.8 0 16 7.2 16 16l0 64c0 8.8-7.2 16-16 16l-32 0c-8.8 0-16-7.2-16-16l0-64c0-8.8 7.2-16 16-16zm400 16c0-8.8 7.2-16 16-16l32 0c8.8 0 16 7.2 16 16l0 64c0 8.8-7.2 16-16 16l-32 0c-8.8 0-16-7.2-16-16l0-64zM96 320l32 0c8.8 0 16 7.2 16 16l0 64c0 8.8-7.2 16-16 16l-32 0c-8.8 0-16-7.2-16-16l0-64c0-8.8 7.2-16 16-16zm400 16c0-8.8 7.2-16 16-16l32 0c8.8 0 16 7.2 16 16l0 64c0 8.8-7.2 16-16 16l-32 0c-8.8 0-16-7.2-16-16l0-64zM232 176a88 88 0 1 1 176 0 88 88 0 1 1 -176 0zm88-48c-8.8 0-16 7.2-16 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16s-7.2-16-16-16l-16 0 0-16c0-8.8-7.2-16-16-16z" />
                                                            </svg> Education :
                                                        </div>
                                                        <div class="col-md-9">
                                                            <ul>
                                                                @if (count($item['educations']) > 0)
                                                                    @foreach ($item['educations'] as $edu)
                                                                        <li>{{ $edu->qualification . ' from ' . $edu->institute_name . ' in ' . $edu->passing_year }}
                                                                        </li>
                                                                    @endforeach
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </div>


                                                </div>

                                                <div class="col-md-12 my-2">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                                width="20px">
                                                                <path
                                                                    d="M184 48l144 0c4.4 0 8 3.6 8 8l0 40L176 96l0-40c0-4.4 3.6-8 8-8zm-56 8l0 40L64 96C28.7 96 0 124.7 0 160l0 96 192 0 128 0 192 0 0-96c0-35.3-28.7-64-64-64l-64 0 0-40c0-30.9-25.1-56-56-56L184 0c-30.9 0-56 25.1-56 56zM512 288l-192 0 0 32c0 17.7-14.3 32-32 32l-64 0c-17.7 0-32-14.3-32-32l0-32L0 288 0 416c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-128z" />
                                                            </svg> Work Details :
                                                        </div>
                                                        <div class="col-md-9">
                                                            <ul>
                                                                @if (count($item['professionals']) > 0)
                                                                    @foreach ($item['professionals'] as $pro)
                                                                        <li>{{ $pro->designations . ' at ' . $pro->organisation }}
                                                                        </li>
                                                                    @endforeach
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-md-12 my-2">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                                width="20px"z>
                                                                <path
                                                                    d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z" />
                                                            </svg> Skills :
                                                        </div>

                                                        <div class="col-md-9">
                                                            {{ isset($item['skill']) ? $item['skill'] : '' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-center" style="background:#F6F6F6;">
                                            <img src="{{ asset('assets/images/default-image.png') }}" alt="no image"
                                                class="img-circle img-fluid" style="width: 12%" srcset="">
                                            <p class="font-weight-bold">
                                                {{ $item['designation'] ? $item['designation'] : 'Fresher' }}</p>
                                            <span><i class="far fa-envelope"></i> Email <i
                                                    class="fas fa-check verify-check text-success"></i> </span>|
                                            <span><i class="fas fa-phone-volume"></i> Phone <i
                                                    class="fas fa-times cross text-danger"></i> </span>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </a>
                        <div class="card-footer text-muted">
                            <div class="row">
                                <div class="col-md-8">
                                    <span class="mr-3"><i class="fas fa-solid fa-eye"></i> 0</span>
                                    <span class="mr-3"><i class="fas fa-download"></i> 0</span>
                                    @if ($item['resume'] !== null)
                                        <span class="mr-3"><i class="fas fa-paperclip"></i> CV</span>
                                    @endif
                                    @if ($item['last_login'] !== null)
                                        <span class="mr-3">Active:
                                            {{ date('d-M-Y', strtotime($item['last_login'])) }}</span>
                                    @endif
                                    @if ($item['last_modified'] !== null)
                                        <span class="mr-3">Last Modified:
                                            {{ date('d-M-Y', strtotime($item['last_modified'])) }}</span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <span class="comment float-right" id="comment"> <i class="far fa-comment"></i>
                                    </span>
                                </div>
                            </div>
                        </div>


                        <div class="post-comment-section border p-3 d-none">
                            <div class="form-group">
                                <form class="form commentform" action="">
                                    <div class="d-none">
                                        <input type="hidden" name="js_id" value="{{ $item['js_id'] }}">
                                    </div>
                                    <label for="commentarea" class="font-weight-bold">Leave a comment</label>
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <textarea class="form-control" name="commentarea" id="commentarea" maxlength="250" placeholder="Maximum 250 Characters" required></textarea>
                                        </div>
                                        <div class="col-sm-4">
                                            <button class="btn btn-primary" type="submit">Post Comment</button>
                                        </div>

                                    </div>
                                </form>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <hr>
                                        <label class="font-weight-bold">Your Comments</label>
                                        <ol id="comment_listing">
                                            @forelse ($item['comments'] as $existing)
                                            <li> {{ $existing->comment }} || Time :
                                                {{ date('d-M-Y', strtotime($existing->created_at)) }}</li>
                                            @empty
                                                <li class="text-danger">No Comments.</li>
                                            @endforelse
                                        </ol>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                    {{-- Card End --}}

                </div>
            @empty
                <span class="text-danger">No Record Found</span>
            @endforelse

            <div class="col-md-12 d-flex justify-content-center my-2">
                {{ $category->onEachSide(0)->links() }}
            </div>

        </div>

        <!-- Save search Modal -->
        <div class="modal fade" id="savesearch" tabindex="-1" role="dialog" aria-labelledby="savesearchTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Welcome To Save search</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="form" id="save_search_form">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" class="form-control" id="save_Search" name="save_Search"
                                    placeholder="Type Save Search Name" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn resetform" id="clear_save_search"
                                data-dismiss="modal">Close</button>
                            <button type="submit" class="btn">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- End save search modal. --}}

        {{-- Add tagged Modal --}}
        <div class="modal fade" id="addTagModal" tabindex="-1" role="dialog" aria-labelledby="addTagModalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Welcome To Save search</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="form" id="add_tag_form">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <div class="col-sm-8">
                                            <select class="form-control custom-select mb-3" name="tag_id" id="tag_id"
                                                required>
                                                <option value="">Select Tag</option>

                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <button type="button" class="btn w-100 text-center" id="add_new_tag">
                                                <span class="marginleft"><i class="fas fa-plus"></i> Add new</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 d-none" id="newTagForm">
                                    <div class="form-group row">
                                        <div class="col-sm-8">
                                            {{-- <form action="" method="POST" id="addTagForm">
                                                @csrf --}}
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Type Tag Name"
                                                    name="tag" id="tag" />
                                            </div>
                                            <div class="form-group">
                                                <button type="button" id="create_tag" class="btn">Create Tag</button>
                                            </div>
                                            {{-- </form> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn resetform" id="clear_add_tag"
                                data-dismiss="modal">Close</button>
                            <button type="submit" class="btn">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- End Add tagged Modal --}}

        {{-- Send Email Modal --}}
        <div class="modal fade" id="sendEmailModal" tabindex="-1" role="dialog" aria-labelledby="sendEmailModalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Send Email</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="form" id="send_email_form">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold mt-2" for="empEmail">From Email <em>(You can change
                                                email from here)</em><span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="empEmail" id="empEmail"
                                            value="{{ Auth::guard('employer')->user()->email }}"
                                            placeholder="Input Your Email ID" required>

                                        <label class="font-weight-bold mt-2" for="input_subject">Subject<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="input_subject"
                                            id="input_subject" placeholder="Keep it short and interesting" maxlength="50"
                                            required>

                                        <label class="font-weight-bold mt-2" for="emailDescription">Description<span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control" name="emailDescription" id="emailDescription"></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn resetform" id=""
                                data-dismiss="modal">Close</button>
                            <button type="submit" class="btn disablemail" >Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- End Send Email Modal --}}
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/save_search.js') }}"></script>
@endsection
