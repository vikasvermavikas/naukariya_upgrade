@extends('layouts.master', ['title' => 'Save Jobs'])
@section('content')
    <section>
        <div id="breadcrumb">
            <div class="breadcrumb-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 mb-5">
                    {{ Breadcrumbs::render('saved_jobs') }}
                </div>
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
                            <h2 class="interview">Saved Job</h2>
                        </div>

                        <div class="col-sm-3 ml-auto">
                            <div class="d-flex">
                                <input style="border-radius:0;" name="q" type="text" id="txtgoingto"
                                    placeholder="Search Keyword" class="form-control mb-0 ui-autocomplete-input"
                                    autocomplete="off" v-model="search" /><i
                                    class="fa fa-search searchButton mt-3 ml-2"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 mt-2">
                    <div class="table-responsive">
                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>{{ session()->get('message') }}</strong>
                            </div>
                        @endif
                        @if (session()->has('error'))
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>{{ session()->get('message') }}</strong>
                            </div>
                        @endif
                        <table class="table  text-wrap table-bordered">
                            <thead class="text-white" style="background:rgb(227, 94, 37)">
                                <tr>
                                    <th>S.No</th>
                                    <th>Title</th>
                                    <th>Company</th>
                                    <th>Location</th>
                                    <th>Job Type</th>
                                    <th>Experience</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $value)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ ucfirst($value->title) }}</td>
                                        <td>{{ ucfirst($value->company_name) }}</td>
                                        <td>{{ ucfirst($value->job_exp) }}</td>
                                        <td>{{ $value->job_type }}</td>
                                        <td>{{ $value->main_exp . ' Yr' . '-' . $value->max_exp . ' Yr' }}</td>
                                        <td>
                                            {{-- <a href="" target="_blank" data-id="{{ $value->id }}"class="btn-sm btn-white text-color">Apply Job</a> --}}

                                            <button type="button" class="btn w-100" data-toggle="modal"
                                                data-target="#myModal{{ $loop->iteration }}">
                                                Apply Now
                                            </button>

                                            <div class="modal fade" id="myModal{{ $loop->iteration }}">
                                                <div class="modal-dialog modal-dialog-scrollable">
                                                    <div class="modal-content">
                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Confirmation before Apply?</h4>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <form role="form"
                                                            action={{ route('applyjob', ['id' => $value->id]) }}
                                                            method="post">
                                                            @csrf
                                                            <!-- Modal body -->
                                                            <div class="modal-body">
                                                                <div class="form-group row inputBox">
                                                                    <div class="col-sm-12">
                                                                        <div class="input text">
                                                                            <p><strong>Job Title</strong> :-
                                                                                {{ $value->title }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row inputBox">
                                                                    <div class="col-sm-12">
                                                                        <div class="input text">
                                                                            <p><strong> Location</strong> :-
                                                                                {{ $value->job_exp }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row inputBox">
                                                                    <div class="col-sm-12">
                                                                        <div class="input text">
                                                                            <p><strong>Company Name</strong> :-
                                                                                {{ $value->company_name }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="question">
                                                                    <p> Do you have any of the relavant or Equivalent
                                                                        Qualification ?
                                                                        ({{ !empty($value->qualification) ? $value->qualification : '' }})
                                                                    </p>
                                                                    <fieldset class="mb-3">
                                                                        <div class="form-group ask_question">
                                                                            <div class="icheck-primary d-inline">
                                                                                <input type="radio" id="radioPrimary1"
                                                                                    name="r1" checked="checked"> <label
                                                                                    for="radioPrimary1"> Yes
                                                                                </label>
                                                                            </div>
                                                                            <div class="icheck-primary d-inline"><input
                                                                                    type="radio" id="radioPrimary2"
                                                                                    name="r1"> <label
                                                                                    for="radioPrimary2"> No
                                                                                </label></div>
                                                                        </div>
                                                                    </fieldset>
                                                                </div>
                                                                <div class="question">
                                                                    <p> Do you have relevant experience of this job
                                                                        ({{ $value->main_exp . 'Yr' . ' - ' . $value->max_exp . 'Yr' }})
                                                                    </p>
                                                                    <fieldset class="mb-3">
                                                                        <div class="form-group ask_question">
                                                                            <div class="icheck-primary d-inline"><input
                                                                                    type="radio" id="radioPrimary3"
                                                                                    name="ex1" checked="checked">
                                                                                <label for="radioPrimary3"> Yes </label>
                                                                            </div>
                                                                            <div class="icheck-primary d-inline"><input
                                                                                    type="radio" id="radioPrimary4"
                                                                                    name="ex1"> <label
                                                                                    for="radioPrimary4"> No
                                                                                </label></div>
                                                                        </div>
                                                                    </fieldset>
                                                                </div>
                                                                <div class="question">
                                                                    <p> Do you have relevant skill for this job ?(Field
                                                                        Sales Executive,
                                                                        sourcing new prospects, closing sales deals,
                                                                        negotiating,
                                                                        maintaining positive customer relations, Excellent
                                                                        convincing
                                                                        skills, client handling ability.) </p>
                                                                    <fieldset class="mb-3">
                                                                        <div class="form-group ask_question">
                                                                            <div class="icheck-primary d-inline"><input
                                                                                    type="radio" id="radioPrimary5"
                                                                                    name="sk1" checked="checked">
                                                                                <label for="radioPrimary5"> Yes </label>
                                                                            </div>
                                                                            <div class="icheck-primary d-inline"><input
                                                                                    type="radio" id="radioPrimary6"
                                                                                    name="sk1"> <label
                                                                                    for="radioPrimary6"> No
                                                                                </label></div>
                                                                        </div>
                                                                    </fieldset>
                                                                </div>

                                                            </div>


                                                            <!-- Modal footer -->
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary">
                                                                    Confirm Apply
                                                                </button>
                                                                <button type="button" class="btn btn-danger"
                                                                    data-dismiss="modal">Close</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

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


    {{-- modal apply job --}}
@endsection
