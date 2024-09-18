@extends('layouts.master', ['title' => 'Sub Users List'])
@section('content')
    <div class="container">
        <div class="row">
             <div class="col-md-12 mb-5">
                    {{ Breadcrumbs::render('subuser_list') }}
                 </div>
            <div class="col-md-12">
                <h1>Sub User List</h1>
                @if (session()->has('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session()->get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <button type="button" class="btn float-right mb-2" data-toggle="modal" data-target="#addSubuserform">
                    Add Sub User
                </button>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead style="background:#E35E25;" class="text-light">
                            <tr>
                                <th>S no.</th>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Gender</th>
                                <th>Email</th>
                                <th>Desgination</th>
                                <th>Password</th>
                                <th>Created Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($subusers as $subuser)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $subuser->fname }} {{ $subuser->lname }}</td>
                                    <td>{{ $subuser->contact }}</td>
                                    <td>{{ $subuser->gender }}</td>
                                    <td>{{ $subuser->email }}</td>
                                    <td>{{ $subuser->designation }}</td>
                                    <td>{{ $subuser->password_view }}</td>
                                    <td>{{ date('d-M-y', strtotime($subuser->created_at)) }}</td>
                                    <td>
                                        @if ($subuser->active == 1)
                                            <span class="text-success">Active</span>
                                        @else
                                            <span class="text-danger">De-active</span>
                                        @endif

                                    </td>
                                    <td><span title="Edit" data-toggle="tooltip" data-placement="top"><i
                                                class="fas fa-edit mr-2" data-toggle="modal" data-target="#updateSubuser"
                                                data-whatever="{{ $subuser->id }}"></i></span>
                                        @if ($subuser->active == 1)
                                            <a class="text-dark"
                                                href="{{ route('deactivate_subuser', ['id' => $subuser->id]) }}"><i
                                                    class="fas fa-toggle-on" title="Deactivate" data-toggle="tooltip"
                                                    data-placement="top"></i></a>
                                        @else
                                            <a class="text-dark"
                                                href="{{ route('activate_subuser', ['id' => $subuser->id]) }}"><i
                                                    class="fas fa-toggle-off" title="Activate" data-toggle="tooltip"
                                                    data-placement="top"></i></a>
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
                <span class="d-flex justify-content-center mb-2">{{ $subusers->links() }}</span>
            </div>
            <!-- add client Modal -->
            <div class="modal fade" id="addSubuserform" tabindex="-1" role="dialog" aria-labelledby="addSubuserformTitle"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Add Sub User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('add_subuser') }}" method="POST" id="subuser_form">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label class="col-form-label font-weight-bold" for="">First Name</label>
                                        <input type="text" class="form-control" name="fname"
                                            value="{{ old('fname') }}" placeholder="Enter First Name" required>
                                        @error('fname')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="col-form-label font-weight-bold" for="">Last Name</label>
                                        <input type="text" class="form-control" name="lname"
                                            value="{{ old('lname') }}" placeholder="Enter Last Name" required>
                                        @error('lname')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="col-form-label font-weight-bold" for="">Contact No.</label>
                                        <input type="text" class="form-control" name="contact" maxlength="10"
                                            id="" placeholder="Enter 10 digit Mobile No." pattern="\d{10}"
                                            value="{{ old('contact') }}"
                                            oninvalid="this.setCustomValidity('Only 10 digit no. are allowed')"
                                            oninput="this.setCustomValidity('')" required>
                                        @error('contact')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="col-form-label font-weight-bold" for="">Desgination</label>
                                        <input type="text" class="form-control" name="designation"
                                            value="{{ old('designation') }}" placeholder="Enter designation" required>
                                        @error('designation')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="col-form-label font-weight-bold" for="">Email</label>
                                        <input type="email" class="form-control" name="email" id=""
                                            value="{{ old('email') }}" placeholder="Enter Email" required>
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="col-form-label font-weight-bold" for="">Gender</label>
                                        <select name="gender" class="form-control" required>
                                            <option value="">Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Others">Others</option>
                                        </select>
                                        @error('gender')
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
            <div class="modal fade" id="updateSubuser" tabindex="-1" role="dialog"
                aria-labelledby="updateSubuserLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateSubuserLabel">Update Sub User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('update_subuser') }}" method="POST">
                                @csrf
                                <div class="d-none">
                                    <input type="hidden" name="id" id="subuserid" value="{{ old('id') }}">
                                    <input type="hidden" name="oldid" id="oldsubuserid" value="{{ old('id') }}">
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label class="col-form-label font-weight-bold" for="updatefname">First
                                                Name</label>
                                            <input type="text" class="form-control" name="updatefname"
                                                id="updatefname" value="{{ old('updatefname') }}"
                                                placeholder="Enter First Name" required>
                                            @error('updatefname')
                                                <span class="text-danger updateerror">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="col-form-label font-weight-bold" for="">Last
                                                Name</label>
                                            <input type="text" class="form-control" name="updatelname"
                                                id="updatelname" value="{{ old('updatelname') }}"
                                                placeholder="Enter Last Name" required>
                                            @error('updatelname')
                                                <span class="text-danger updateerror">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="col-form-label font-weight-bold" for="">Contact
                                                No.</label>
                                            <input type="text" class="form-control" name="updatecontact"
                                                maxlength="10" value="{{ old('updatecontact') }}" id="updatecontact"
                                                placeholder="Enter 10 digit Mobile No." pattern="\d{10}"
                                                oninvalid="this.setCustomValidity('Only 10 digit no. are allowed')"
                                                oninput="this.setCustomValidity('')" required>
                                            @error('updatecontact')
                                                <span class="text-danger updateerror">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="col-form-label font-weight-bold"
                                                for="">Desgination</label>
                                            <input type="text" class="form-control" name="updatedesignation"
                                                id="updatedesignation" value="{{ old('updatedesignation') }}"
                                                placeholder="Enter Last Name" required>
                                            @error('updatedesignation')
                                                <span class="text-danger updateerror">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="col-form-label font-weight-bold" for="">Email</label>
                                            <input type="email" class="form-control" name="updateemail"
                                                id="updateemail" value="{{ old('updateemail') }}"
                                                placeholder="Enter Email" required>
                                            @error('updateemail')
                                                <span class="text-danger updateerror">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <label class="col-form-label font-weight-bold" for="">Gender</label>
                                            <Select name="updategender" value="{{ old('updategender') }}"
                                                class="form-control" id="update-gender" required>
                                                <option value="">Select Gender</option>
                                                <option value="Male"
                                                    {{ old('updategender') == 'Male' ? 'selected' : '' }}>Male</option>
                                                <option value="Female"
                                                    {{ old('updategender') == 'Female' ? 'selected' : '' }}>Female</option>
                                                <option value="Other"
                                                    {{ old('updategender') == 'Other' ? 'selected' : '' }}>Other</option>
                                            </Select>
                                            @error('updategender')
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
                                        <button type="submit" class="btn">Update changes</button>
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
    <script src="{{ asset('assets/js/subuser.js') }}"></script>

    {{-- If any bug of add subuser form is came then show add subuser modal --}}
    @if (
        $errors->has('fname') ||
            $errors->has('lname') ||
            $errors->has('email') ||
            $errors->has('contact') ||
            $errors->has('designation') ||
            $errors->has('gender'))
        <script>
            $('#addSubuserform').modal('show');
        </script>
    @endif

    {{-- If any bug of update subuser form is came then show update subuser modal --}}

    @if (
        $errors->has('updatefname') ||
            $errors->has('updatelname') ||
            $errors->has('updateemail') ||
            $errors->has('updatecontact') ||
            $errors->has('updatedesignation') ||
            $errors->has('updategender'))
        <script>
            $('#updateSubuser').modal('show');
        </script>
    @endif
@endsection
