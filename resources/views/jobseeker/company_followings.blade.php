@extends('layouts.master', ['title' => 'Company Follow'])
@section('content')
<section>
    <div id="breadcrumb">
        <div class="breadcrumb-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-8">
                        {{-- <ol class="breadcrumb">
                <li>
                  <a href="#"><i class="fa fa-home mr-1"></i>Home</a>
                </li>
                <li><a href="#">Jobseeker Dashboard</a></li>
                <li class="active">Applied Job</li>
              </ol> --}}
                    </div>

                    <div class="col-xs-12 col-sm-4 hidden-xs">
                        {{-- <p class="hot-line">
                <i
                  class="fa fa-headphones mr-1 Phone is-animating"
                  aria-hidden="true"
                ></i>
                <a href="tel:+91 11 7962 6411">Hot Line: +91 11 7962 6411 </a>
              </p> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section pb-5 pt-5">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 ">

                <div class="row">
                    <div class="col-md-12">
                        <h2 class="interview">Follow Company Details</h2>
                    </div>
                    {{-- Show error messages --}}
                    <div class="col-md-12">
                        @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{session()->get('message')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                        @endif
                        @if (session()->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{session()->get('message')}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                        @endif
                    </div>

                    {{-- <div class="col-sm-3 ml-auto">
                        <div class="d-flex">
                            <input style="border-radius:0;" name="q" type="text" id="txtgoingto" placeholder="Search Keyword" class="form-control mb-0 ui-autocomplete-input" autocomplete="off" v-model="search" /><i class="fa fa-search searchButton mt-3 ml-2"></i>
                        </div>
                    </div> --}}
                </div>
            </div>
            <div class="col-sm-12 col-md-12 mt-2">
              <div class="table-responsive">
                <table class="table  text-wrap table-bordered">
                    <thead class="text-white" style="background:rgb(227, 94, 37)">
                        <tr>
                            <th>S.No</th>
                            <th>Company Name</th>
                            <th>Email</th>
                            <th>Contact No.</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse($data as $key => $value)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ ucfirst($value->company_name) }}</td>
                            <td>{{ $value->com_email }}</td>
                            <td>{{ $value->com_contact }}</td>
                            <td class="text-center">
                                <a href="{{ route('unfollow_companies', [$value->job_id, $value->employer_id]) }}" target="_blank" class="btn small text-light p-3 rounded">Unfollow</a>
                            </td>                        
                        </tr>
                        @empty
                            <tr>
                                <td class="text-danger text-center" colspan="5">No Record Found</td>
                            </tr>
                        @endforelse
                   
                    </tbody>
                </table>
              </div>
            </div>

            {{-- Start Pagination --}}
            <div class="col-md-12 d-flex justify-content-center">
                {{ $data->onEachSide(0)->links() }}
            </div>

        </div>
    </div>
    <!-- /.row -->
</section>
@endsection
