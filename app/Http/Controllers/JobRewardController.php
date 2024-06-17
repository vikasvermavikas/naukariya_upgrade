<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jobbenefit;
use Auth;

class JobRewardController extends Controller
{

    public function index()
    {
        $data=Jobbenefit::all();
        return response()->json(['data'=>$data],200);
    }

    public function store(Request $request)
    {
        $posted_type = New Jobbenefit();
        $posted_type->name=$request->name; 
        $posted_type->add_by = Auth::user()->id;
        $posted_type->save();
    }

    public function edit($id)
    {
        $data = Jobbenefit::find($id);
        return response()->json(['data'=>$data],200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required',
        ]);
        $post = Jobbenefit::find($id);

        $post->name=$request->name;
        $post->save();
    }

    public function deactive($id)
    {
        $post = Jobbenefit::find($id);
        $post->status = "0";
       
        $post->save();
    }

    public function active($id)
    {
        $post = Jobbenefit::find($id);
        $post->status = "1";
       
        $post->save();
    }

    public function destroy($id)
    {
       $posted_type = Jobbenefit::find($id);
        $posted_type->delete();
    }
}
