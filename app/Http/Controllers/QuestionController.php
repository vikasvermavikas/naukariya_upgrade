<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Image;

class QuestionController extends Controller
{

    public function index()
    {

        $data = DB::table('questions') //current table
        ->leftjoin('industries', 'industries.id', '=', 'questions.industry_id')//tablename,table.id,current table.field_name
        ->leftjoin('functional_roles', 'functional_roles.id', '=', 'questions.functionalrole_id')
            ->leftjoin('empcompaniesdetails', 'empcompaniesdetails.id', '=', 'questions.company_id')
            ->select('questions.id', 'questions.question_mode', 'questions.question_category', 'questions.question_name', 'questions.title', 'questions.option1', 'questions.option2', 'questions.option3', 'questions.option4', 'questions.answer', 'questions.marks', 'questions.active', 'questions.industry_id', 'questions.functionalrole_id', 'functional_roles.subcategory_name', 'industries.category_name', 'empcompaniesdetails.company_name')->orderBy('id', 'desc')//use for displaying data in table i.e List.vue to remove same column name from two tables eg.active  id and name both shows for ind...roles...company

            ->get();
        return response()->json(['data' => $data], 200);
    }

    public function store_mcq(Request $request)
    {
        $this->validate($request, [
            'question_category' => 'required',
            'question_name' => 'required',
            'title' => 'required',
            'industry_name' => 'required',
            'functionalrole_name' => 'required',
            'answer' => 'required',
            //'company_name' => 'required'
            'marks' => 'required',
            'options1' => 'required',
            'options2' => 'required',
            'options3' => 'required',
            'options4' => 'required',
        ]);

        //For MCQ
        $question = new Question();

        $question->question_mode = 'MCQ';
        $question->question_category = $request->question_category;
        $question->title = $request->title;
        $question->question_name = $request->question_name;
        $question->option1 = $request->options1;
        $question->option2 = $request->options2;
        $question->option3 = $request->options3;
        $question->option4 = $request->options4;
        $question->marks = $request->marks;
        $question->answer = $request->answer;
        $question->industry_id = $request->industry_name;
        $question->functionalrole_id = $request->functionalrole_name;
        $question->company_id = $request->company_name;
        $question->add_by = Auth::user()->id;
        $question->save();

    }

    public function store_yesno(Request $request)
    {
        $this->validate($request, [
            'yes_no_question_category' => 'required',
            'yes_no_question_name' => 'required',
            'yes_no_title' => 'required',
            'yes_no_industry_name' => 'required',
            'yes_no_functional' => 'required',
            'yes_no_answer' => 'required',
            //'company_name' => 'required'
            'yes_no_marks' => 'required',
        ]);


        $question = new Question();

        $question->question_mode = 'Yes/No';
        $question->question_category = $request->yes_no_question_category;
        $question->title = $request->yes_no_title;
        $question->question_name = $request->yes_no_question_name;
        $question->marks = $request->yes_no_marks;
        $question->answer = $request->yes_no_answer;
        $question->industry_id = $request->yes_no_industry_name;
        $question->functionalrole_id = $request->yes_no_functional;
        $question->company_id = $request->yes_no_company_name;
        $question->add_by = Auth::user()->id;
        $question->save();

    }

    public function store_descriptive(Request $request)
    {
        $this->validate($request, [
            'descriptive_question_category' => 'required',
            'descriptive_question_name' => 'required',
            'descriptive_title' => 'required',
            'descriptive_industry_name' => 'required',
            'descriptive_functional' => 'required',
            'descriptive_answer' => 'required',
            //'company_name' => 'required'
            'descriptive_marks' => 'required',
        ]);


        $question = new Question();

        $question->question_mode = 'Descriptive';
        $question->question_category = $request->descriptive_question_category;
        $question->title = $request->descriptive_title;
        $question->question_name = $request->descriptive_question_name;
        $question->marks = $request->descriptive_marks;
        $question->answer = $request->descriptive_answer;
        $question->industry_id = $request->descriptive_industry_name;
        $question->functionalrole_id = $request->descriptive_functional;
        $question->company_id = $request->descriptive_company_name;
        $question->add_by = Auth::user()->id;
        $question->save();

    }

    // For Employer start
    public function store_mcq_emp(Request $request)
    {
        $company_id = Session::get('user')['company_id'];
        $emp_id = Session::get('user')['id'];

        $this->validate($request, [
            'question_category' => 'required',
            'question_name' => 'required',
            'title' => 'required',
            'industry_name' => 'required',
            'functionalrole_name' => 'required',
            'answer' => 'required',
            //'company_name' => 'required'
            'marks' => 'required',
            'options1' => 'required',
            'options2' => 'required',
            'options3' => 'required',
            'options4' => 'required',
        ]);

        //For MCQ
        $question = new Question();

        $question->question_mode = 'MCQ';
        $question->question_category = $request->question_category;
        $question->title = $request->title;
        $question->question_name = $request->question_name;
        $question->option1 = $request->options1;
        $question->option2 = $request->options2;
        $question->option3 = $request->options3;
        $question->option4 = $request->options4;
        $question->marks = $request->marks;
        $question->answer = $request->answer;
        $question->industry_id = $request->industry_name;
        $question->functionalrole_id = $request->functionalrole_name;
        $question->company_id = $company_id;
        $question->user_id = $emp_id;
        $question->save();

    }

    public function store_yesno_emp(Request $request)
    {
        $company_id = Session::get('user')['company_id'];
        $emp_id = Session::get('user')['id'];

        $this->validate($request, [
            'yes_no_question_category' => 'required',
            'yes_no_question_name' => 'required',
            'yes_no_title' => 'required',
            'yes_no_industry_name' => 'required',
            'yes_no_functional' => 'required',
            'yes_no_answer' => 'required',
            //'company_name' => 'required'
            'yes_no_marks' => 'required',
        ]);


        $question = new Question();

        $question->question_mode = 'Yes/No';
        $question->question_category = $request->yes_no_question_category;
        $question->title = $request->yes_no_title;
        $question->question_name = $request->yes_no_question_name;
        $question->marks = $request->yes_no_marks;
        $question->answer = $request->yes_no_answer;
        $question->industry_id = $request->yes_no_industry_name;
        $question->functionalrole_id = $request->yes_no_functional;
        $question->company_id = $company_id;
        $question->user_id = $emp_id;
        $question->save();

    }

    public function store_descriptive_emp(Request $request)
    {
        $company_id = Session::get('user')['company_id'];
        $emp_id = Session::get('user')['id'];
        $this->validate($request, [
            'descriptive_question_category' => 'required',
            'descriptive_question_name' => 'required',
            'descriptive_title' => 'required',
            'descriptive_industry_name' => 'required',
            'descriptive_functional' => 'required',
            'descriptive_answer' => 'required',
            //'company_name' => 'required'
            'descriptive_marks' => 'required',
        ]);


        $question = new Question();

        $question->question_mode = 'Descriptive';
        $question->question_category = $request->descriptive_question_category;
        $question->title = $request->descriptive_title;
        $question->question_name = $request->descriptive_question_name;
        $question->marks = $request->descriptive_marks;
        $question->answer = $request->descriptive_answer;
        $question->industry_id = $request->descriptive_industry_name;
        $question->functionalrole_id = $request->descriptive_functional;
        $question->company_id = $company_id;
        $question->user_id = $emp_id;
        $question->save();

    }

    public function index_emp()
    {
        $uid = Session::get('user')['id'];
        $data = DB::table('questions') //current table
        ->leftjoin('industries', 'industries.id', '=', 'questions.industry_id')//tablename,table.id,current table.field_name
        ->leftjoin('functional_roles', 'functional_roles.id', '=', 'questions.functionalrole_id')
            ->leftjoin('empcompaniesdetails', 'empcompaniesdetails.id', '=', 'questions.company_id')
            ->select('questions.id', 'questions.question_mode', 'questions.question_category', 'questions.question_name', 'questions.title', 'questions.option1', 'questions.option2', 'questions.option3', 'questions.option4', 'questions.answer', 'questions.marks', 'questions.active', 'questions.industry_id', 'questions.functionalrole_id', 'functional_roles.subcategory_name', 'industries.category_name', 'empcompaniesdetails.company_name')
            ->where('user_id', $uid)
            ->orderBy('id', 'desc')//use for displaying data in table i.e List.vue to remove same column name from two tables eg.active  id and name both shows for ind...roles...company

            ->get();
        return response()->json(['data' => $data], 200);
    }

    public function edit($id)
    {
        $data = Question::find($id);
        return response()->json(['data' => $data], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'company_name' => 'required',
            'industry_name' => 'required',
            'functionalrole_name' => 'required',
        ]);

        $question = Question::find($id);

        $question->question = $request->question;
        $question->answer = $request->answer;
        $question->options1 = $request->options1;
        $question->options2 = $request->options2;
        $question->options3 = $request->options3;
        $question->options4 = $request->options4;
        $question->marks = $request->marks;
        $question->industry_id = $request->industry_name;
        $question->functionalrole_id = $request->functionalrole_name;
        $question->company_id = $request->company_name;

        $question->add_by = Auth::user()->id;
        $question->save();
    }

    public function destroy($id)
    {
        $question = Question::find($id);
        $question->delete();
    }

    public function deactive($id)
    {
        $question = Question::find($id);
        $question->active = "No";

        $question->save();
    }

    public function active($id)
    {
        $question = Question::find($id);
        $question->active = "Yes";

        $question->save();
    }
}
