@extends('layouts.master', ['title' => 'Questionnaires'])
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Questionnaires</h1>
                <a href="#" class="btn float-right"><i class="fas fa-plus mr-2"></i>Add Question</a>
            </div>
            <div class="col-md-8">
                <form class="my-2" action="">
                    <div class="row">
                        <div class="col-sm-3 mr-2">
                        <div class="form-group">
                                <select class="form-control" style="height: 52px;width:117%;" name="tag" id="tag">
                                    <option value="">Select Questionnaire</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-7 mr-2">
                            <button class="btn">Search</button>
                            <button class="btn">Reset</button>
                        </div>
                    </div>

            </div>
            </form>
        </div>
    </div>
    </div>
@endsection
