<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CareerLevel;
use Illuminate\Support\Facades\Auth;

class CareerlevelController extends Controller
{

    public function index()
    {
        $data = CareerLevel::all();
        return response()->json(['data' => $data], 200);
    }

    public function store(Request $request)
    {
        $posted_type = new CareerLevel();
        $posted_type->career_level = $request->career_level;
        $posted_type->add_by = Auth::user()->id;
        $posted_type->save();
    }

    public function edit($id)
    {
        $data = CareerLevel::find($id);
        return response()->json(['data' => $data], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'career_level' => 'required',
        ]);
        $post = CareerLevel::find($id);
        $post->career_level = $request->career_level;
        $post->save();
    }

    public function deactive($id)
    {
        $post = CareerLevel::find($id);
        $post->status = "0";
        $post->save();
    }

    public function active($id)
    {
        $post = CareerLevel::find($id);
        $post->status = "1";
        $post->save();
    }

    public function destroy($id)
    {
        $posted_type = CareerLevel::find($id);
        $posted_type->delete();
    }
}
