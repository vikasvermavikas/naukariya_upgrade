@extends('layouts.master', ['title' => 'Tagged View'])
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3>Tagged View</h3>
            </div>
            <div class="col-md-12 my-4">
                <form action="" class="form">
                    <div class="form-group row">
                        <div class="col-sm-4 col-4">
                            <select name="tag" id="tag" class="form-control">
                                <option value="">Select Tags</option>
                            </select>
                        </div>
                        <div class="col-sm-8 col-8">
                            <button type="submit" class="btn text-white rounded" style="padding: 21px;">
                                Search
                            </button>
                            <button type="reset" class="btn text-white rounded resetsearch" style="padding: 21px;">
                                Reset
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead style="background:#F95602;" class="text-light">
                        <tr>
                            <th>Tagged Name</th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $item)
                            @php

                                if (isset($item->resume)) {
                                    $link =
                                        'http://docs.google.com/gview?url=' .
                                        asset('resume/' . $item->resume . '&embedded=true') .
                                        '';
                                } else {
                                    $link =
                                        'http://docs.google.com/gview?url=' .
                                        asset('resume/default.pdf&embedded=true') .
                                        '';
                                }
                            @endphp
                            <tr>
                                <td>{{ $item->tag }}</td>
                                <td>{{ $item->fname }}</td>
                                <td>{{ $item->designation }}</td>
                                <td style="color:#F95602;"><span data-toggle="modal" data-target="#viewResumemodal"
                                        data-whatever="{{ $link }}"><i class="fas fa-eye mr-2" title="View Resume"
                                            data-toggle="tooltip" data-placement="top"></i></span>
                                            @if ($item->resume)
                                            <a href="{{ asset('resume/' . $item->resume . '') }}" target="_blank"
                                                style="color:#F95602;" download><i class="fas fa-download mr-2"
                                                    title="Download Resume" data-toggle="tooltip" data-placement="top"></i></a>
                                            @endif

                                    <a href="https://www.youtube.com/watch?v={{ $item->resume_video_link }}" target="_blank"
                                        style="color:#F95602;"> <i class="fas fa-video mr-2" title="Video Resume"
                                            data-toggle="tooltip" data-placement="top"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-danger text-center" colspan="4">No Record Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- End Table --}}

            {{-- Start Pagination --}}
            <div class="col-md-12 d-flex justify-content-center my-2">
                <p>{{ $data->onEachSide(0)->links() }}</p>
            </div>
            {{-- End Start Pagination --}}


        </div>

        {{-- View Resume Modal --}}
        <div class="modal fade" id="viewResumemodal" tabindex="-1" role="dialog" aria-labelledby="viewResumemodalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewResumemodalLabel">New message</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body container">
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-center">
                                <div class="embed-responsive embed-responsive-21by9" style="width: 391px; height: 500px">
                                    <iframe class="embed-responsive-item"
                                        src="https://docs.google.com/gview?url=https://naukriyan.com/tracker/resume/1700736592.pdf&embedded=true"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        {{-- <button type="button" class="btn btn-primary">Send message</button> --}}
                    </div>
                </div>
            </div>
        </div>
        {{-- end View Resume Modal --}}
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/js/tagged_view.js') }}"></script>
@endsection
