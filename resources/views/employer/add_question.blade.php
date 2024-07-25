@extends('layouts.master', ['title' => 'Add Question'])
@section('style')
    <style>
        ul li a:not(.active) {
            color: black;
        }

        .nav-pills .nav-link.active,
        .nav-pills .show>.nav-link {
            background: #e35e25;
        }

        label {
            font-weight: bold;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3>Add Question</h3>
                <a href="{{route('question_index_emp')}}" class="float-right btn my-2"><i class="fas fa-eye mr-2"></i>View Question</a>
            </div>
            <div class="col-md-12">
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session()->get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <p class="font-weight-bold">Select Question Mode</p>
                <ul class="nav nav-pills mb-3 text-dark d-flex justify-content-center" id="pills-tab" role="tablist">
                    <li class="nav-item rounded border w-25 mr-3">
                        <a class="nav-link text-center active" id="pills-mcq-tab" data-toggle="pill" href="#pills-mcq"
                            role="tab" aria-controls="pills-mcq" aria-selected="true">MCQ Type</a>
                    </li>
                    <li class="nav-item rounded border w-25 mr-3">
                        <a class="nav-link text-center" id="pills-yes_no-tab" data-toggle="pill" href="#pills-yes_no"
                            role="tab" aria-controls="pills-yes_no" aria-selected="false">Yes / No Type</a>
                    </li>
                    <li class="nav-item rounded border w-25">
                        <a class="nav-link text-center" id="pills-descriptive-tab" data-toggle="pill"
                            href="#pills-descriptive" role="tab" aria-controls="pills-descriptive"
                            aria-selected="false">Descriptive Type</a>
                    </li>
                </ul>
                <div class="tab-content border my-3" id="pills-tabContent" style="background: #F7F7F7;">
                    <div class="tab-pane  fade show active" id="pills-mcq" role="tabpanel" aria-labelledby="pills-mcq-tab">
                        <div class="container">
                            <form action="{{ route('store_mcq_emp') }}" method="post" class="form mt-2">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="question_category">Question Category</label>
                                            <input type="text" class="form-control" id="question_category"
                                                name="question_category" placeholder="Question Category"
                                                value="{{ old('question_category') }}" required>
                                            @error('question_category')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control" name="title" id="title"
                                                placeholder="Enter Title" value="{{ old('title') }}" required>
                                            @error('title')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="question_name">Question Name</label>
                                            <input type="text" class="form-control" id="question_name"
                                                placeholder="Enter Question" value="{{ old('question_name') }}"
                                                name="question_name" required>
                                            @error('question_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="industry_name">Select Industry</label>
                                            <select class="form-control" name="industry_name" id="industry_name" required>
                                                <option value="">Select One</option>
                                            </select>
                                            @error('industry_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="functionalrole_name">Select Functional Role </label>
                                            <select class="form-control" name="functionalrole_name" id="functionalrole_name"
                                                required>
                                                <option value="">Select One</option>
                                            </select>
                                            @error('functionalrole_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="marks">Marks</label>
                                            <input type="number" class="form-control" name="marks" id="marks"
                                                placeholder="Enter marks" value="{{ old('marks') }}" min="0"
                                                required>
                                            @error('marks')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="options1">Option 1</label>
                                            <input type="text" class="form-control" placeholder="Enter Options 1"
                                                name="options1" value="{{ old('options1') }}" id="options1" required>
                                            @error('options1')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="options2">Option 2</label>
                                            <input type="text" class="form-control" placeholder="Enter Options 2"
                                                name="options2" value="{{ old('options2') }}" id="options2" required>
                                            @error('options2')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="options3">Option 3</label>
                                            <input type="text" class="form-control" placeholder="Enter Options 3"
                                                name="options3" value="{{ old('options3') }}" id="options3" required>
                                            @error('options3')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="options4">Option 4</label>
                                            <input type="text" class="form-control" placeholder="Enter Options 4"
                                                name="options4" value="{{ old('options4') }}" id="options4" required>
                                            @error('options4')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="answer">Select Answer</label>
                                            <select class="form-control" name="answer" id="answer" required>
                                                <option value="">Select</option>
                                            </select>
                                            @error('answer')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 my-2">
                                        <button class="btn">Save</button>
                                    </div>


                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-yes_no" role="tabpanel" aria-labelledby="pills-yes_no-tab">
                        <div class="container">
                            <form action="{{ route('store_yesno_emp') }}" method="post" class="form mt-2">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="yes_no_question_category">Question Category</label>
                                            <input type="text" class="form-control" id="yes_no_question_category"
                                                name="yes_no_question_category" placeholder="Question Category" value="{{old('yes_no_question_category')}}" required>
                                            @error('yes_no_question_category')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="yes_no_title">Title</label>
                                            <input type="text" class="form-control" name="yes_no_title"
                                                id="yes_no_title" placeholder="Enter Title" value="{{old('yes_no_title')}}" required>
                                            @error('yes_no_title')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="yes_no_question_name">Question Name</label>
                                            <input type="text" class="form-control" id="yes_no_question_name"
                                                placeholder="Enter Question" name="yes_no_question_name" value="{{old('yes_no_question_name')}}" required>
                                            @error('yes_no_question_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="yes_no_industry_name">Select Industry</label>
                                            <select class="form-control" name="yes_no_industry_name"
                                                id="yes_no_industry_name" required>
                                                <option value="">Select One</option>
                                            </select>
                                            @error('yes_no_industry_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="yes_no_functional">Select Functional Role </label>
                                            <select class="form-control" name="yes_no_functional" id="yes_no_functional"
                                                required>
                                                <option value="">Select One</option>
                                            </select>
                                            @error('yes_no_functional')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="yes_no_marks">Marks</label>
                                            <input type="number" class="form-control" name="yes_no_marks"
                                                placeholder="Enter marks" min="0" value="{{old('yes_no_marks')}}" required>
                                            @error('yes_no_marks')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="yes_no_answer">Answer</label>
                                            <input type="text" class="form-control" name="yes_no_answer"
                                                id="yes_no_answer" placeholder="Enter Answer" value="{{old('yes_no_answer')}}" required>
                                            @error('yes_no_answer')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12 my-2">
                                        <button type="submit" class="btn">Save</button>
                                    </div>


                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-descriptive" role="tabpanel"
                        aria-labelledby="pills-descriptive-tab">
                        <div class="container">
                            <form action="{{ route('store_descriptive_emp') }}" method="post" class="form mt-2">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="descriptive_question_category">Question Category</label>
                                            <input type="text" class="form-control" id="descriptive_question_category"
                                                name="descriptive_question_category" placeholder="Question Category" value="{{old('descriptive_question_category')}}"
                                                required>
                                            @error('descriptive_question_category')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="descriptive_title">Title</label>
                                            <input type="text" class="form-control" name="descriptive_title"
                                                id="descriptive_title" placeholder="Enter Title" value="{{old('descriptive_title')}}" required>
                                            @error('descriptive_title')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="descriptive_question_name">Question Name</label>
                                            <input type="text" class="form-control" id="descriptive_question_name"
                                                placeholder="Enter Question" name="descriptive_question_name" value="{{old('descriptive_question_name')}}" required>
                                            @error('descriptive_question_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="descriptive_industry_name">Select Industry</label>
                                            <select class="form-control" name="descriptive_industry_name"
                                                id="descriptive_industry_name" required>
                                                <option value="">Select One</option>
                                            </select>
                                            @error('descriptive_industry_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="descriptive_functional">Select Functional Role </label>
                                            <select class="form-control" name="descriptive_functional"
                                                id="descriptive_functional" required>
                                                <option value="">Select One</option>
                                            </select>
                                            @error('descriptive_functional')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="descriptive_marks">Marks</label>
                                            <input type="number" class="form-control" name="descriptive_marks" id="descriptive_marks"
                                                placeholder="Enter marks" min="0" value="{{old('descriptive_marks')}}" required>
                                            @error('descriptive_marks')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="descriptive_answer">Answer</label>
                                            <input type="text" class="form-control" id="descriptive_answer"
                                                placeholder="Enter Answer" name="descriptive_answer" value="{{old('descriptive_answer')}}" required>
                                            @error('descriptive_answer')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12 my-2">
                                        <button class="btn">Save</button>
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
    <script src="{{ asset('assets/js/add_question.js') }}"></script>
@endsection
