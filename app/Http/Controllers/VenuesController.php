<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venues;
use Illuminate\Support\Facades\Auth;
use Session;
use DB;

class VenuesController extends Controller
{
    public function index(Request $request)
    {
        $searchvalue = '';
        $data = Venues::query();
        if (isset($request['search'])) {
            $searchvalue = $request['search'];
            $data->orWhere('venue_name', 'like', '%' . $searchvalue . '%');
            $data->orWhere('venue_address', 'like', '%' . $searchvalue . '%');
            $data->orWhere('email', 'like', '%' . $searchvalue . '%');
        }

        $data = $data->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        return view('employer.venue_list', ['data' => $data, 'searchvalue' => $searchvalue]);
    }

    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'venue_name' => 'required',
                'venue_address' => 'required|max:70',
                'contact_person' => 'required|regex:/^[a-zA-z\s]+$/',
                'contact_no' => 'required|numeric',
                'contact_email' => 'required|email:filter',
                'instructions' => 'required',
            ],
            [
                'contact_person' => 'Contact person contain only letters'
            ]
        );

        $venues = new Venues();
        $venues->venue_name = $request->venue_name;
        $venues->venue_address = $request->venue_address;
        $venues->contact_person = $request->contact_person;
        $venues->contact_no = $request->contact_no;
        $venues->email = $request->contact_email;
        $venues->instructions = $request->instructions;
        $venues->add_by = Auth::guard('employer')->user()->id;
        $venues->add_by_usertype = "Employer";
        if ($venues->save()) {
            return redirect()->route('venue_list')->with(['status' => true, 'message' => 'Venue Added Successfully']);
        }
    }

    public function getsinglevenue($id)
    {
        $venue = Venues::find($id);
        return $venue;
    }

    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'update_venue_name' => 'required',
                'update_venue_address' => 'required|max:70',
                'update_contact_person' => 'required|regex:/^[a-zA-z\s]+$/',
                'update_contact_no' => 'required|numeric',
                'update_contact_email' => 'required|email:filter',
                'update_instructions' => 'required',
            ],
            [
                'update_contact_person' => 'Contact person contain only letters'
            ]
        );

        $venues = Venues::find($id);
        $venues->venue_name = $request->update_venue_name;
        $venues->venue_address = $request->update_venue_address;
        $venues->contact_person = $request->update_contact_person;
        $venues->contact_no = $request->update_contact_no;
        $venues->email = $request->update_contact_email;
        $venues->instructions = $request->update_instructions;
        if ($venues->save()) {
            return redirect()->route('venue_list')->with(['status' => true, 'message' => 'Venue Updated Successfully']);
        }
    }
    public function deactive($id)
    {
        $package = Venues::find($id);
        $package->venue_status = "0";
        $package->save();
        return response()->json(['status' => true], 200);
    }
    public function active($id)
    {
        $package = Venues::find($id);
        $package->venue_status = "1";
        $package->save();
        return response()->json(['status' => true], 200);
    }
    public function destroy($id)
    {
        $package = Venues::find($id);
        $package->delete();
        return response()->json(['status' => true], 200);
    }

    public function searchVenue($query = null)
    {
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
