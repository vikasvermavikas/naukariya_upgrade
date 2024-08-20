<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faqs;

class FaqsController extends Controller
{
    public function store(){

    }
    public function getData(){
        $getInfo = Faqs::select('question', 'answer')->get();
        // return response()->json(['data' => $getInfo]);
        return view('public.faqs', ['faqs' => $getInfo]);
        
    }
}
