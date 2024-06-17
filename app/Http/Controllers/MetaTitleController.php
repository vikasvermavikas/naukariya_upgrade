<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Metatitle;

class MetaTitleController extends Controller
{
    public function get_title(Request $request){
      $requestdata = $request->all();
   
      $data = DB::table($requestdata['table'])->where('id', $requestdata['id'])->first();
      // die;
      // $data = Metatitle::where('page', $pagename)->get();
      return response()->json(['data' => $data]);
    }

}
