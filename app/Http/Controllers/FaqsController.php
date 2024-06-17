<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faqs;

class FaqsController extends Controller
{
    public function store(){

    }
    public function getData(){
        $getInfo = Faqs::all();
        return response()->json(['data' => $getInfo]);
        
    }
}
