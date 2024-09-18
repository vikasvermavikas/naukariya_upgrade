@extends('layouts.master', ['title' => 'Venues'])
@section('style')
    <style>
        label {
            font-weight: bold;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row">
             <div class="col-md-12 mb-5">
                    {{ Breadcrumbs::render('manage_venues') }}
                 </div>
            <div class="col-md-12">
                <h3>Manage Interview Location</h3>
                @if (session()->has('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session()->get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            </div>
            <div class="col-md-8 my-3">
                <form action="" method="get">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Search Venue" name="search"
                                    value="{{ $searchvalue }}" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <button type="submit" class="btn text-white rounded" style="padding:19px;">
                                    Search
                                </button>
                                <button type="reset" class="btn text-white rounded resetsearch" style="padding:19px;">
                                    Reset
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-4 my-3">
                <button type="button" class="btn text-white float-right p-3 rounded" data-toggle="modal"
                    data-target="#addVenueModal">
                    <i class="fas fa-plus mr-2"></i>Add New
                </button>
            </div>
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead style="background:#F95602;" class="text-light">
                            <tr>
                                <th>S.No.</th>
                                <th>Venue</th>
                                <th>Contact Person</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Contact No</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->venue_name }}</td>
                                    <td>{{ $item->contact_person }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td class="text-truncate">{{ $item->venue_address }}</td>
                                    <td>{{ $item->contact_no }}</td>
                                    <td>{{ $item->venue_status == '1' ? 'Active' : 'Inactive' }}</td>
                                    <td>
                                        <button type="button" class="btn p-2 rounded" data-toggle="modal"
                                            data-target="#updateVenueModal" data-whatever="{{ $item->id }}">
                                            <i class="far fa-edit mr-2"></i> Edit
                                        </button>
                                        <button type="button" class="btn p-2 rounded deletebutton" value="{{ $item->id }}">
                                            <i class="far fa-trash-alt"></i> Delete
                                        </button>
                                        @if ($item->venue_status == 1)
                                            <button type="button" title="Deactivate" data-toggle="tooltip"
                                                class="btn p-3 text-center deactivatebtn rounded" value="{{ $item->id }}">
                                                Deactivate
                                            </button>
                                        @else
                                            <button type="button" title="Activate" data-toggle="tooltip"
                                                class="btn p-3 text-center activatebtn rounded" value="{{ $item->id }}">
                                                Acitvate
                                            </button>
                                        @endif
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

        {{-- Pagination --}}
        <div class="col-md-12 d-flex justify-content-center my-2">
            <p>{{ $data->onEachSide(0)->links() }}</p>
        </div>
        {{-- End Pagination --}}

        <!-- Add venue Modal -->
        <div class="modal fade" id="addVenueModal" tabindex="-1" role="dialog" aria-labelledby="addVenueModalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addVenueModalLongTitle">Add Location</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('add_venue') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="venue_name">Venue <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="venue_name"
                                            placeholder="Enter Your Venue" value="{{ old('venue_name') }}" required>
                                        @error('venue_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Contact Person <span class="text-danger">*</span> </label>
                                        <input type="text" name="contact_person" id="contact_person"
                                            class="form-control" placeholder="Enter Contact Person"
                                            value="{{ old('contact_person') }}" required>
                                        @error('contact_person')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Email <span class="text-danger">*</span> </label>
                                        <input type="email" class="form-control" placeholder="Enter Your Email"
                                            name="contact_email" id="contact_email" value="{{ old('contact_email') }}"
                                            required>
                                        @error('contact_email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Contact No. <span class="text-danger">*</span> </label>
                                        <input type="text" maxlength="10" class="form-control"
                                            placeholder="Enter 10 digit Mobile No." pattern="[7,8,9][0-9]{9}"
                                            name="contact_no" id="contact_no" value="{{ old('contact_no') }}"
                                            oninvalid="this.setCustomValidity('Invalid Contact Number.')"
                                            oninput="this.setCustomValidity('')" required>
                                        @error('contact_no')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Address <span class="text-danger">*</span> </label>
                                        <textarea class="form-control" placeholder="Enter Your Address...." name="venue_address" id="venue_address"
                                            maxlength="50" required>{{ old('venue_address') }}</textarea>
                                        @error('venue_address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Instruction <span class="text-danger">*</span> </label>
                                        <textarea class="form-control" placeholder="Enter Your Instruction here...." name="instructions" id="instructions"
                                            required>{{ old('instructions') }}</textarea>
                                        @error('instructions')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
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
        {{-- End add venue modal --}}

        {{-- Update venue Modal --}}
        <div class="modal fade" id="updateVenueModal" tabindex="-1" role="dialog"
            aria-labelledby="updateVenueModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateVenueModalLabel">Update Location</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="POST">
                        @csrf
                        <div class="d-none">
                            <input type="hidden" name="id" id="venueid" value="{{old('id')}}">
                            <input type="hidden" name="oldid" id="oldvenueid" value="{{old('id')}}">
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="update_venue_name">Venue <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="update_venue_name"
                                            name="update_venue_name" placeholder="Enter Your Venue"
                                            value="{{ old('update_venue_name') }}" required>
                                        @error('update_venue_name')
                                            <span class="text-danger updateerror">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Contact Person <span class="text-danger">*</span> </label>
                                        <input type="text" name="update_contact_person" id="update_contact_person"
                                            class="form-control" placeholder="Enter Contact Person"
                                            value="{{ old('update_contact_person') }}" required>
                                        @error('update_contact_person')
                                            <span class="text-danger updateerror">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Email <span class="text-danger">*</span> </label>
                                        <input type="email" class="form-control" placeholder="Enter Your Email"
                                            name="update_contact_email" id="update_contact_email"
                                            value="{{ old('update_contact_email') }}" required>
                                        @error('update_contact_email')
                                            <span class="text-danger updateerror">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Contact No. <span class="text-danger">*</span> </label>
                                        <input type="text" maxlength="10" class="form-control"
                                            placeholder="Enter Your Contact No." name="update_contact_no"
                                            id="update_contact_no" value="{{ old('update_contact_no') }}" required>
                                        @error('update_contact_no')
                                            <span class="text-danger updateerror">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Address <span class="text-danger">*</span> </label>
                                        <textarea class="form-control" placeholder="Enter Your Address...." name="update_venue_address"
                                            id="update_venue_address" required>{{ old('update_venue_address') }}</textarea>
                                        @error('update_venue_address')
                                            <span class="text-danger updateerror">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Instruction <span class="text-danger">*</span> </label>
                                        <textarea class="form-control" placeholder="Enter Your Instruction here...." name="update_instructions"
                                            id="update_instructions" required>{{ old('update_instructions') }}</textarea>
                                        @error('update_instructions')
                                            <span class="text-danger updateerror">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- End Update Venue Modal --}}

    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/js/venue_list.js') }}"></script>
    @if (
        $errors->has('venue_name') ||
            $errors->has('venue_address') ||
            $errors->has('contact_person') ||
            $errors->has('contact_email') ||
            $errors->has('instructions') ||
            $errors->has('contact_no'))
        <script>
            $('#addVenueModal').modal('show');
        </script>
    @endif

    {{-- If any bug of update subuser form is came then show update subuser modal --}}

    @if (
        $errors->has('update_venue_name') ||
            $errors->has('update_venue_address') ||
            $errors->has('update_contact_person') ||
            $errors->has('update_contact_email') ||
            $errors->has('update_instructions') ||
            $errors->has('update_contact_no'))
        <script>
            $('#updateVenueModal').modal('show');
        </script>
    @endif
@endsection
