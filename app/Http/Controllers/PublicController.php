<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
class PublicController extends Controller
{
    /*
    * Show about page.
    */
    public function about(){
        $blogs = Blog::orderBy('id', 'desc')->offset(0)->limit(2)->get();
        return view('about', compact('blogs'));
    }

}
