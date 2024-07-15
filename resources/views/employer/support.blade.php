@extends('layouts.master', ['title' => 'Support List'])
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 my-3">
                <h1>Support</h1>
                <button class="btn float-right" data-toggle="modal" data-target="#addSupport"><i
                        class="fas fa-plus mr-2"></i>Add Support</button>
            </div>

            <div class="col-md-12">
                @if(session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{session()->get('message')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                @endif
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead style="background:#E35E25;" class="text-light">
                            <tr>
                                <th>Support ID.</th>
                                <th>Subject</th>
                                <th>Description</th>
                                <th>Open Date</th>
                                <th>Close Date</th>
                                <th>Status</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                                @php
                                    if ($item->support_subject == '1') {
                                        $subject = 'Technical Enquiry';
                                    } elseif ($item->support_subject == '2') {
                                        $subject = 'General Enquiry';
                                    } elseif ($item->support_subject == '3') {
                                        $subject = 'Report An Issue';
                                    } elseif ($item->support_subject == '4') {
                                        $subject = 'Feedback';
                                    } else {
                                        $subject = 'Others';
                                    }

                                @endphp
                                <tr>
                                    <td>{{ $item->support_id }}</td>
                                    <td>{{ $subject }}</td>
                                    <td>{{ $item->support_comment }}</td>
                                    <td>{{ $item->support_open_date }}</td>
                                    <td>{{ $item->support_close_date === null ? 'not resolved' : $item->support_close_date }}
                                    </td>
                                    <td>{{ $item->support_status }}</td>
                                </tr>

                            @empty
                                <tr>
                                    <td class="text-danger text-danger" colspan="6">No Record Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Code for modal --}}
            <div class="modal fade" id="addSupport" tabindex="-1" role="dialog" aria-labelledby="addSupportTitle"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Add Support</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('employer_add_support')}}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="support_subject">Subject</label>
                                            <select class="form-control" id="support_subject" name="support_subject"
                                                required>
                                                <option value="">Select Subject</option>
                                                <option value="1">Technical Enquiry</option>
                                                <option value="2">General Enquiry</option>
                                                <option value="3">Report an issue</option>
                                                <option value="4">Feedback</option>
                                                <option value="5">Others</option>
                                            </select>
                                            @error('support_subject')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="support_comment">Description</label>
                                            <textarea class="form-control" name="support_comment" id="support_comment" cols="30" rows="5" required></textarea>
                                            @error('support_comment')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End Code for modal --}}
        </div>
    </div>
@endsection
