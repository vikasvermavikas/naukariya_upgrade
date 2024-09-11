@extends('layouts.master', ['title' => 'Resume Details'])
@section('content')
    <div class="container">
        <div class="row border shadow mt-2">
            <div class="col-md-12 mt-3 d-flex justify-content-center">
                <h2 style="color:#e35e25;">Resume Details</h2>
            </div>

            <div class="table-responsive my-5">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Field</th>
                            <th>Value</th>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>{{ $result['candidate_name'] }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>{{ $result['candidate_email'] }}</td>
                        </tr>
                        <tr>
                            <td>Contact</td>
                            <td>{{ $result['candidate_phone'] }}</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>{{ $result['candidate_address'] }}</td>
                        </tr>
                        <tr>
                            <td>Languages</td>
                            <td>{{ implode(',', $result['candidate_spoken_languages']) }}</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>{{ $result['candidate_address'] }}</td>
                        </tr>
                        <tr>
                            <td rowspan="{{ count($result['education_qualifications']) + 1 }}" class="align-middle">
                                Qualifications</td>
                        </tr>

                        @for ($i = 0; $i < count($result['education_qualifications']); $i++)
                            <tr>
                                <td>
                                    <span>School or College :
                                        {{ $result['education_qualifications'][$i]['school_name'] }}</span> <br>
                                    <span>Board or University :
                                        {{ $result['education_qualifications'][$i]['school_type'] }}</span><br>
                                    <span>Level :
                                        {{ $result['education_qualifications'][$i]['degree_type'] }}</span><br>
                                    <span>Discription:
                                        {{ $result['education_qualifications'][$i]['education_details'] }}</span><br>
                                </td>

                            </tr>
                        @endfor

                        <tr>
                            <td rowspan="{{ count($result['positions']) + 1 }}" class="align-middle">Experience Details
                            </td>
                        </tr>

                        @for ($i = 0; $i < count($result['positions']); $i++)
                            <tr>
                                <td>
                                    <span>Position Name : {{ $result['positions'][$i]['position_name'] }}</span> <br>
                                    <span>Company Name : {{ $result['positions'][$i]['company_name'] }}</span><br>
                                    <span>Country: {{ $result['positions'][$i]['country'] }}</span><br>
                                    <span>Start Date : {{ $result['positions'][$i]['start_date'] }}</span><br>
                                    <span>End Date : {{ $result['positions'][$i]['end_date'] }}</span><br>
                                    <span>Job Discription : {{ $result['positions'][$i]['job_details'] }}</span><br>
                                </td>

                            </tr>
                        @endfor

                        <tr>
                            <td>Skills</td>
                            <td>{{ $result['skills'] }}</td>
                        </tr>
                    </thead>
                </table>
            </div>


        </div>
    </div>
@endsection
