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
                    <div class="col-sm-9">
                        <h2 class="interview">Helpdesk</h2>
                    </div>

                    <div class="col-sm-3 ml-auto">
                        {{-- <div class="d-flex">
                            <input style="border-radius:0;" name="q" type="text" id="txtgoingto" placeholder="Search Keyword" class="form-control mb-0 ui-autocomplete-input" autocomplete="off" v-model="search" /><i class="fa fa-search searchButton mt-3 ml-2"></i>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 mt-2">
              <div class="table-responsive">
                @if(session()->has('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>{{ session()->get('success') }}</strong>
                    </div>
                @endif
                <table class="table  text-wrap table-bordered">
                    <thead class="text-white" style="background:rgb(227, 94, 37)">
                        <tr>
                            <th>Complain ID.</th>
                            <th>Subject</th>
                            <th>Description</th>
                            <th>Open Date</th>
                            <th>Close Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($data as $key => $value)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ ucfirst($value->company_name) }}</td>
                            <td>{{ $value->com_email }}</td>
                            <td>{{ $value->com_contact }}</td>
                            <td>
                                <a href="{{ route('unfollow_companies', [$value->job_id, $value->employer_id]) }}" target="_blank" class="btn-sm btn-success text-color">Unfollow</a>
                            </td>                        
                        </tr>
                        @endforeach
                    </tbody>
                </table>
              </div>
            </div>

        </div>
    </div>
    <!-- /.row -->
</section>
@endsection
