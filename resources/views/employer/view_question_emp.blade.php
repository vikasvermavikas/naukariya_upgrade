@extends('layouts.master', ['title' => 'View Questions'])
@section('content')
    <div class="container">
        <div class="row">
             <div class="col-md-12 mb-5">
                    {{ Breadcrumbs::render('view_questions') }}
                 </div>
            <div class="col-md-12 mb-2">
                <h3>View Questions</h3>

                <button type="button" class="btn float-right" data-toggle="modal" data-target="#questionnarieModal">
                    Add Question to Questionnarie
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead style="background:#F95602;" class="text-light">
                        <tr>
                            <th>S.No</th>
                            <th>Question Mode</th>
                            <th>Question Title/Category</th>
                            <th>Question Name</th>
                            <th>Industry</th>
                            <th>Functional role</th>
                            <th>Options</th>
                            <th>Marks</th>
                            <th>Active</th>
                            {{-- <th>Actions</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data as $item)
                            <tr>
                                <td><input type="checkbox" class="questions_ids" id="check" name="check[]"
                                        value="{{ $item->id }}">{{ $loop->iteration }}</td>
                                <td>{{ $item->question_mode }}</td>
                                <td>{{ $item->title }}/{{ $item->question_category }}</td>
                                <td>{{ $item->question_name }}</td>
                                <td>{{ $item->category_name }}</td>
                                <td>{{ $item->subcategory_name }}</td>
                                <td>{{ $item->option1 }},{{ $item->option2 }},{{ $item->option3 }},{{ $item->option4 }}
                                </td>
                                <td>{{ $item->marks }}</td>

                                <td>{{ $item->active }}</td>
                                {{-- <td>
                                    <a class="btn btn-sm btn-primary text-white" data-toggle="tooltip" title=""
                                        data-original-title="Edit"><i class="fas fa-edit"></i></a>
                                </td> --}}

                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-danger">No record found</td>
                            </tr>
                        @endforelse


                    </tbody>
                </table>
            </div>
            <div class="col-md-12 d-flex justify-content-center mb-2">
                <p>{{ $data->onEachSide(0)->links() }}</p>
            </div>
        </div>

        {{-- Modal start here --}}
        <div class="modal fade" id="questionnarieModal" tabindex="-1" role="dialog"
            aria-labelledby="questionnarieModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Questionnarie</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class="form" id="add_question">
                        <div class="modal-body">
                            {{-- <div class="container"> --}}
                            <div class="form-group row">
                                <div class="col-sm-8">
                                    <select name="tag" id="tag" class="form-control" required>
                                        <option value="">Select Questionnarie</option>
                                    </select>
                                </div>

                                <div class="col-sm-4">
                                    <button type="button" id="add_new_questionarie" class="btn p-4">Add New</button>
                                </div>
                            </div>
                            {{-- <div class=""> --}}
                            <div class="form-group row d-none" id="add_questionarie_form">
                                <div class="col-sm-8">
                                    <input type="text" name="newquestionnarie" id="newquestionnarie" class="form-control"
                                        placeholder="Input New Questionnarie title">
                                    <span id="questionarie_error" class="text-danger"></span>
                                </div>
                                <div class="col-sm-4">
                                    <button type="button" id="save_new_questionarie" class="btn p-4">Save</button>
                                </div>
                            </div>
                            {{-- </div> --}}
                            {{-- </div> --}}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- End modal --}}
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/js/view_question.js') }}"></script>
@endsection
