@extends('layouts.master', ['title' => 'Manage Jobs'])
@section('content')
    <section class="section pb-5 pt-5">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 ">

                    <div class="row">
                    <div class="col-md-12 mb-5">
                    {{ Breadcrumbs::render('manage_jobs') }}
                 </div>
                        <div class="col-sm-9">
                            <h2 class="interview">Manage Job</h2>
                        </div>

                        {{-- <div class="col-sm-3 ml-auto">
                        <div class="d-flex">
                            <input style="border-radius:0;" name="q" type="text" id="txtgoingto" placeholder="Search Keyword" class="form-control mb-0 ui-autocomplete-input" autocomplete="off" v-model="search" /><i class="fa fa-search searchButton mt-3 ml-2"></i>
                        </div>
                    </div> --}}
                    </div>
                </div>
                <div class="col-md-12 mt-2">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="text-white" style="background:rgb(227, 94, 37)">
                                <tr>
                                    <th>S.No</th>
                                    <th>Title</th>
                                    <th>Job Post Date</th>
                                    <th>Job Update Date</th>
                                    <th>Status</th>
                                    <th>Application</th>
                                    <th>Shortlist</th>
                                    <th>Interview</th>
                                    <th>Offer</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($data as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td>{{ date('d-M-y', strtotime($item->created_at)) }}</td>
                                        <td>{{ date('d-M-y', strtotime($item->updated_at)) }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>{{ $item->total_applications }}</td>
                                        <td>{{ $item->shortlisted }}</td>
                                        <td>{{ $item->interviewed }}</td>
                                        <td>{{ $item->offers }}</td>
                                        <td>
                                            <a href="{{ route('viewjobs', ['id' => $item->id]) }}" data-toggle="tooltip"
                                                data-placement="top" class="text-dark" title="View"><i class="fas fa-eye"
                                                    aria-hidden="true"></i></a>
                                            <a href="{{ route('job_ats', ['id' => $item->id]) }}" data-toggle="tooltip"
                                                data-placement="top" class="text-dark" title="ATS"><i
                                                    class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-danger" colspan="8">Record not found</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                        {{ $data->links() }}
                    </div>
                </div>

            </div>
        </div>
        <!-- /.row -->
    </section>
@endsection
