<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Salary;
use Illuminate\Support\Facades\Auth;

class SalaryController extends Controller
{
    public function index()
    {
        $data = Salary::orderBy('salary_in_annum', 'ASC')->get();
        return response()->json(['data' => $data], 200);
    }

    public function store(Request $request)
    {
        $posted_type = new Salary();
        $posted_type->salary = $request->salary;
        $posted_type->salary_in_annum = $request->salary_in_annum;
        $posted_type->add_by = Auth::user()->id;
        $posted_type->save();
    }

    public function edit($id)
    {
        $data = Salary::find($id);
        return response()->json(['data' => $data], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'salary' => 'required',
            'salary_in_annum' => 'required',
        ]);

        $post = Salary::find($id);

        $post->salary = $request->salary;
        $post->salary_in_annum = $request->salary_in_annum;
        $post->save();
    }

    public function deactive($id)
    {
        $post = Salary::find($id);
        $post->status = "0";

        $post->save();
    }

    public function active($id)
    {
        $post = Salary::find($id);
        $post->status = "1";

        $post->save();
    }

    public function destroy($id)
    {
        $posted_type = Salary::find($id);
        $posted_type->delete();
    }
}
