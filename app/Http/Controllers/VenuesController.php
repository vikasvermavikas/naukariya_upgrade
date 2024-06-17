<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venues;
use Auth;
use Session;
use DB;

class VenuesController extends Controller
{
    public function index()   
    {
        $data = Venues::orderBy('created_at','desc')->get();  
        return response()->json([
            'data'=>$data
        ],200);
    }

    public function store(Request $request)   
    {
        $this->validate($request,[
              // 'company_contact' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        
        $venues = New Venues();
        $venues->venue_name = $request->venue_name;
        $venues->venue_address = $request->venue_address;
        $venues->contact_person = $request->contact_person;
        $venues->contact_no = $request->contact_no;
        $venues->email = $request->contact_email;
        $venues->instructions = $request->instructions;
        $venues->add_by = $request->session()->get('user.id');
        $venues->add_by_usertype = "Employer";
        $venues->save();
        return redirect()->back();
    }

    public function getsinglevenue($id)
    {
            $venue = Venues::find($id);
            return $venue;
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
              // 'company_contact' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        $venues = Venues::find($id);
        $venues->venue_name = $request->venue_name;
        $venues->venue_address = $request->venue_address;
        $venues->contact_person = $request->contact_person;
        $venues->contact_no = $request->contact_no;
        $venues->email = $request->email;
        $venues->instructions = $request->instructions;
        $venues->save();
    }
    public function deactive($id)
    {
        $package = Venues::find($id);
        $package->venue_status = "0";
        $package->save();
    }
    public function active($id)
    {
        $package = Venues::find($id);
        $package->venue_status = "1";
        $package->save();
    }
    public function destroy($id)
    {
        $package = Venues::find($id);
        $package->delete();
    }

    public function searchVenue($query = null) {
        $uid = Session::get('user')['id'];
        $keyword = $query;
        $venues = Venues::query();

        if (isset($keyword) && $keyword != null) {
            $venues->orWhere('venue_name', 'like', '%' . $keyword . '%');
        }
        if (isset($keyword) && $keyword != null) {
            $venues->orWhere('venue_address', 'like', '%' . $keyword . '%');
        }
        if (isset($keyword) && $keyword != null) {
            $venues->orWhere('email', 'like', '%' . $keyword . '%');
        }

        $data = $venues->where('add_by', $uid)
            ->get();

        return response()->json(['data' => $data], 200);
    }
}
