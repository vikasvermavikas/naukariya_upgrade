@extends('layouts.master', ['title' => 'Client List'])
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Client List</h1>
                @if (session()->has('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session()->get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <button type="button" class="btn float-right my-2" data-toggle="modal" data-target="#addClientform">
                    Add Client
                </button>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead style="background:#E35E25;" class="text-light">
                            <tr>
                                <th>S no.</th>
                                <th>Client Name</th>
                                <th>Contact</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Created Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($clients as $client)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $client->name }}</td>
                                    <td>{{ $client->contact }}</td>
                                    <td>{{ $client->email }}</td>
                                    <td>{{ $client->address }}</td>
                                    <td>{{ date('d-M-y', strtotime($client->created_at)) }}</td>
                                    <td>
                                        @if ($client->active == 1)
                                            <span class="text-success">Active</span>
                                        @else
                                            <span class="text-danger">De-active</span>
                                        @endif

                                    </td>
                                    <td ><span title="Edit" data-toggle="tooltip" data-placement="top"><i class="fas fa-edit mr-2" data-toggle="modal" data-target="#updateClient"
                                        data-whatever="{{ $client->id }}"></i></span>
                                        @if ($client->active == 1)
                                            <a class="text-dark" href="{{route('deactivate_client', ['id' => $client->id])}}" ><i data-toggle="tooltip" data-placement="top" class="fas fa-toggle-on" title="Deactivate"></i></a>
                                        @else
                                           <a class="text-dark" href="{{route('activate_client', ['id' => $client->id])}}" ><i data-toggle="tooltip" data-placement="top" class="fas fa-toggle-off" title="Activate"></i></a> 
                                        @endif

                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="8" class="text-danger">No Record Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <span class="d-flex justify-content-center mb-2">

                    {{ $clients->links() }}
                </span>
            </div>
            <!-- add client Modal -->
            <div class="modal fade" id="addClientform" tabindex="-1" role="dialog" aria-labelledby="addClientformTitle"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Add Client</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('add_client') }}" method="POST" id="client_form">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label class="col-form-label font-weight-bold" for="">Client Name</label>
                                        <input type="text" class="form-control" name="name" id="" value="{{ old('name') }}"
                                            placeholder="Enter Client Name" required>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="col-form-label font-weight-bold" for="">Email</label>
                                        <input type="email" class="form-control" name="email" id="" value="{{ old('email') }}"
                                            placeholder="Enter Email" required>
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="col-form-label font-weight-bold" for="">Contact No.</label>
                                        <input type="text" class="form-control" name="contact" maxlength="10" id=""
                                            placeholder="Enter 10 digit Mobile No." pattern="\d{10}"
                                            value="{{ old('contact') }}" oninvalid="this.setCustomValidity('Invalid Contact Number.')" oninput="this.setCustomValidity('')" required>
                                        @error('contact')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="col-form-label font-weight-bold" for="">Address</label>
                                        <input type="text" class="form-control" name="address" id="" value="{{ old('address') }}"
                                            placeholder="Enter Address"  required>
                                        @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-12"> <i class="fa fa-info-circle" aria-hidden="true"></i><span
                                            style="color: red"> All Fields
                                            are Mandatory</span></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn" id="close_modal"
                                        data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn">Save changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- end add client Modal --}}
            {{-- Update client Modal --}}
            <div class="modal fade" id="updateClient" tabindex="-1" role="dialog" aria-labelledby="updateClientLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateClientLabel">Update Client</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('update_client') }}" method="POST">
                                @csrf
                                <div class="d-none">
                                    <input type="hidden" name="id" id="clientid" value="{{old('id')}}">
                                    <input type="hidden" name="oldid" id="oldclientid" value="{{old('id')}}">
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label class="col-form-label font-weight-bold" for="">Client
                                                Name</label>
                                            <input type="text" class="form-control" name="updatename" id="updateclientname"
                                                value="{{ old('updatename') }}" placeholder="Enter Client Name" required>
                                            @error('updatename')
                                                <span class="text-danger updateerror">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="col-form-label font-weight-bold" for="">Email</label>
                                            <input type="email" class="form-control" name="updateemail" id="updateclientemail"
                                                value="{{ old('updateemail') }}" placeholder="Enter Email" required>
                                            @error('updateemail')
                                                <span class="text-danger updateerror">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="col-form-label font-weight-bold" for="">Contact
                                                No.</label>
                                            <input type="text" class="form-control" name="updatecontact" maxlength="10" id="updateclientcontact"
                                                placeholder="Enter 10 digit Mobile No." pattern="\d{10}" oninvalid="this.setCustomValidity('Invalid Contact Number')"
                                                value="{{ old('updatecontact') }}" oninput="this.setCustomValidity('')" required>
                                            @error('updatecontact')
                                                <span class="text-danger updateerror">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="col-form-label font-weight-bold" for="">Address</label>
                                            <input type="text" class="form-control" name="updateaddress" id="updateclientaddress"
                                                value="{{ old('updateaddress') }}" placeholder="Enter Address" required>
                                            @error('updateaddress')
                                                <span class="text-danger updateerror">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-12"> <i class="fa fa-info-circle" aria-hidden="true"></i><span
                                                style="color: red"> All Fields
                                                are Mandatory</span></div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn" id="close_modal"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn">Save changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/client.js') }}"></script>

    {{-- If any bug of add subuser form is came then show add subuser modal --}}
    @if (
        $errors->has('name') ||
            $errors->has('email') ||
            $errors->has('contact') ||
            $errors->has('address') )
        <script>
            $('#addClientform').modal('show');
        </script>
    @endif

    {{-- If any bug of update subuser form is came then show update subuser modal --}}

    @if (
        $errors->has('updatename') ||
            $errors->has('updateemail') ||
            $errors->has('updatecontact') ||
            $errors->has('updateaddress'))
        <script>
            $('#updateClient').modal('show');
        </script>
    @endif
@endsection
