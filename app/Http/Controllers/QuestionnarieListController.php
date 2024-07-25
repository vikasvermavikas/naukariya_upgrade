<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuestionnarieName;
use App\Models\Question; // Add question model.
use App\Models\QuestionnarieQuestion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Image;

class QuestionnarieListController extends Controller
{

    // For Admin start
    public function questionnarie_name()
    {
        $admin_id = Auth::user()->id;
        $data = QuestionnarieName::where('add_by', $admin_id)
            ->where('status', '1')
            ->get();

        return response()->json(['data' => $data], 200);
    }

    public function add_new_questionnarie_name($name)
    {
        //$uid = Session::get('user')['id'];
        $tg = new QuestionnarieName();
        $tg->name = $name;
        $tg->add_by = Auth::user()->id;
        $tg->save();
    }

    public function add_question_to_questionnarie($name, $question_id)
    {
        $employer_id = Session::get('user')['id'];
        $company_id = Session::get('user')['company_id'];
        $user_type = Session::get('user')['user_type'];

        $question_arr = explode(",", $question_id);
        array_shift($question_arr);

        foreach ($question_arr as $key => $value) {
            $question_qt = new QuestionnarieQuestion();
            $question_qt->questionnarie_id = $name;
            $question_qt->user_id = $employer_id;
            $question_qt->company_id = $company_id;
            $question_qt->question_id = $value;
            $question_qt->user_type = $user_type;
            $question_qt->add_by = Auth::user()->id;
            $question_qt->save();
        }
    }

    public function getquestionnarie_question()
    {
        //$uid = Session::get('user')['id'];
        $admin_id = Auth::user()->id;
        $data = DB::table('questionnarie_questions')
            ->leftjoin('questions', 'questions.id', '=', 'questionnarie_questions.question_id')
            ->leftjoin('questionnarie_names', 'questionnarie_names.id', '=', 'questionnarie_questions.questionnarie_id')
            ->select('questionnarie_names.*', 'questions.*', 'questionnarie_questions.*')
            ->where('questionnarie_questions.add_by', $admin_id)//for admin
            ->get();
        return response()->json(['data' =>
            $data], 200);
    }

    public function searchquestionnarie($questionnarie_id)
    {
        $admin_id = Auth::user()->id;
        $data = DB::table('questionnarie_questions')
            ->leftjoin('questions', 'questions.id', '=', 'questionnarie_questions.question_id')
            ->leftjoin('questionnarie_names', 'questionnarie_names.id', '=', 'questionnarie_questions.questionnarie_id')
            ->select('questionnarie_names.*', 'questions.*', 'questionnarie_questions.*')
            ->where('questionnarie_questions.add_by', $admin_id)//for admin
            ->where('questionnarie_questions.questionnarie_id', $questionnarie_id)
            ->get();
        return response()->json(['data' =>
            $data], 200);
    }

    // For Employer start
    public function questionnarie_name_emp()
    {
        // $employer_id = Session::get('user')['id'];
        $employer_id = Auth::guard('employer')->user()->id;
        $data = QuestionnarieName::select('id', 'name')->where('user_id', $employer_id)
            ->where('status', '1')
            ->get();
        return response()->json(['data' => $data], 200);
    }

    public function add_new_questionnarie_name_emp($name)
    {
        // $uid = Session::get('user')['id'];
        $uid = Auth::guard('employer')->user()->id;
        $tg = new QuestionnarieName();
        $tg->name = $name;
        $tg->user_id = $uid;
        if($tg->save()){
        return response()->json(['success' => true, 'message' => 'Questionnarie New Created Successfully'], 200);
        }
        
        
    }

    public function add_question_to_questionnarie_emp($name, $question_id)
    {
        $employer_id = Auth::guard('employer')->user()->id;
        $company_id = Auth::guard('employer')->user()->company_id;
        $user_type = Auth::guard('employer')->user()->user_type;

        // $employer_id = Session::get('user')['id'];
        // $company_id = Session::get('user')['company_id'];
        // $user_type = Session::get('user')['user_type'];

        $question_arr = explode(",", $question_id);
        // array_shift($question_arr);

        foreach ($question_arr as $key => $value) {
            $question_qt = new QuestionnarieQuestion();
            $question_qt->questionnarie_id = $name;
            $question_qt->user_id = $employer_id;
            $question_qt->company_id = $company_id;
            $question_qt->question_id = $value;
            $question_qt->user_type = $user_type;
            $question_qt->user_id = $employer_id;
            $question_qt->save();
        }

        return response()->json(['success' => true, 'message' => 'Questionnarie Added Successfully'], 200);
    }

    public function getquestionnarie_question_emp(Request $request)
    {
        // $uid = Session::get('user')['id'];
        $uid = Auth::guard('employer')->user()->id;

        $data = DB::table('questionnarie_questions')
            ->leftjoin('questions', 'questions.id', '=', 'questionnarie_questions.question_id')
            ->leftjoin('questionnarie_names', 'questionnarie_names.id', '=', 'questionnarie_questions.questionnarie_id')
            ->select('questionnarie_questions.id as questionnarie_questions_id', 'questionnarie_names.*', 'questions.*', 'questionnarie_questions.*')
            ->where('questionnarie_questions.user_id', $uid);//for admin
            if ($request->questionary) {
                $data = $data->where('questionnarie_questions.questionnarie_id', $request->questionary);
            }
          $data = $data->paginate(10)->withQueryString();
    
        return view('employer.questionary_list', ['data' => $data, 'questionary_id' => $request->questionary]);
    }

    public function searchquestionnarie_emp($questionnarie_id)
    {
        //$admin_id=Auth::user()->id;
        $uid = Session::get('user')['id'];
        $data = DB::table('questionnarie_questions')
            ->leftjoin('questions', 'questions.id', '=', 'questionnarie_questions.question_id')
            ->leftjoin('questionnarie_names', 'questionnarie_names.id', '=', 'questionnarie_questions.questionnarie_id')
            ->select('questionnarie_names.*', 'questions.*', 'questionnarie_questions.*')
            ->where('questionnarie_questions.user_id', $uid)//for admin
            ->where('questionnarie_questions.questionnarie_id', $questionnarie_id)
            ->get();
        return response()->json(['data' =>$data], 200);
    }

    public function destroy_emp($id)
    {
        $question = QuestionnarieQuestion::find($id);
        $question->delete();

        return response()->json(['message' => 'Question deleted successfully.'], 200);
    }

    public function add_question(){
        return view('employer.add_question');
    }
}
