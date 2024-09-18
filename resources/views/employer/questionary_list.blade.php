@extends('layouts.master', ['title' => 'Questionnaires'])
@section('content')
    <div class="container">
        <div class="row">
              <div class="col-md-12 mb-5">
                    {{ Breadcrumbs::render('questionnaires_list') }}
                 </div>
            <div class="col-md-12">
                <h1>Questionaires</h1>
                <a href="{{route('add_question')}}" class="btn float-right"><i class="fas fa-plus mr-2"></i>Add Question</a>
            </div>
            <div class="col-md-8">
                <form class="my-2" method="get">
                    <div class="row">
                        <div class="col-sm-3 mr-2">
                            <div class="form-group">
                                <select class="form-control" style="height: 52px;" title="Select Questionarrie" data-toggle="tooltip" data-placement="top" name="questionary" id="questionary" required>
                                    <option value="">Select</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-7 mr-2">
                            <button type="submit" class="btn">Search</button>
                            <button type="reset" class="btn searchreset">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-4">

            </div>
            <div class="table-responsive">
                <table class="table table-bordered my-2">
                    <thead style="background-color: #f95602;" class="text-light">
                        <tr>
                            <th>Questionnaires Name</th>
                            <th>Question Title/Question Category</th>
                            <th>Question Name</th>
                            <th>Options</th>
                            <th>Questions Mode</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->title }} / {{ $item->question_category }}</td>
                                <td>{{ $item->question_name }}</td>
                                <td>
                                    {{ $item->option1 }}/{{ $item->option2 }}/{{ $item->option3 }}/{{ $item->option4 }}
                                </td>
                                <td>{{ $item->question_mode }}</td>
                                <td class="text-center">
                                    <form class="form delete_question">
                                        @csrf
                                        <div class="d-none">
                                            <input type="hidden" name="questionid" value="{{$item->id}}" required>
                                        </div>
                                        <button type="submit" style="color: #f95602;cursor: pointer;" class="border-0 bg-white" data-toggle="tooltip" title=""
                                        data-original-title="Delete"><i class="fas fa-trash"></i></button>
                                    </form>
                                    {{-- <a id="" href="" style="color: #f95602;" data-toggle="tooltip" title=""
                                        data-original-title="Delete"></a> --}}
                                    {{-- <a href="" style="color: #f95602;" data-toggle="tooltip" title=""
                                        data-original-title="Add"><i class="fas fa-plus"></i></a> --}}
                                </td>
                            </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-danger">No Record Found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="col-md-12 d-flex justify-content-center">
                <p>{{$data->onEachSide(0)->links()}}</p>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/js/questionarie.js') }}"></script>
@endsection
