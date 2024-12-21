<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donor;
use App\Models\Cities;
use App\Models\States;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DonorsExport;
use Carbon\Carbon;

class DonorController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view Donor', ['only' => ['index']]);
        $this->middleware('permission:create Donor', ['only' => ['create', 'store']]);
        $this->middleware('permission:update Donor', ['only' => ['update', 'edit']]);
        $this->middleware('permission:delete Donor', ['only' => ['destroy']]);
        $this->middleware('permission:search Donor', ['only' => ['searchDonors']]);
        $this->middleware('permission:verify Donor', ['only' => ['verifyDonor']]);
        $this->middleware('permission:export Donors', ['only' => ['exportDonors']]);
    }


    public function index()
    {
        $query = Donor::query();
        $query->join('states', 'donors.state', '=', 'states.id')
            ->join('cities', 'donors.city', '=', 'cities.id')
            ->join('users', 'donors.user_id', '=', 'users.id')
            ->select('donors.id', 'donor_name','donors.status', 'blood_group', 'mobile', 'states.name as state_name', 'cities.name as city_name', 'users.address as user_address');
        $donors = $query->paginate(20);
        $cities = Cities::all();
        return view('donor.index', compact('donors', 'cities'));
    }

    public function create()
    {
        $donor = new Donor();
        $states = States::all();
        return view('donor.create', compact('donor', 'states'));
    }


    public function store(Request $request)
    {
        try {
            $validate = $request->validate([
                'name' => 'required',
                'gender' => 'required',
                'dob' => 'required|date',
                'blood_group' => 'required',
                'mobile' => 'required|numeric|digits:10',
                'email' => 'required|email',
                'state' => 'required',
                'district' => 'required',
                'city' => 'required',
                'donation_date' => 'required|date',
                'preference' => 'required',
                'donated_previously' => 'required',
                'last_six_months_procedures' => 'required',
                'form_agreement' => 'required',
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage(), ['exception' => $e]);
            return redirect('/donors/create')->with('error', 'Error in registering donor. Please try again.');
        }

        if ($validate) {
            try {
                $donor = new Donor();
                $donor->donor_name = $request->name;
                $donor->gender = $request->gender;
                $donor->dob = $request->dob;
                $donor->mobile = $request->mobile;
                $donor->email = $request->email;
                $donor->state = $request->state;
                $donor->district = $request->district;
                $donor->city = $request->city;
                $donor->blood_group = $request->blood_group;
                $donor->late_donation_date = $request->donation_date;
                $donor->total_donation_unit = $request->preference;
                $donor->has_donated_previously = $request->donated_previously;
                $donor->last_six_months_procedures = $request->last_six_months_procedures;
                $donor->user_id = auth()->user()->id;
                $donor->save();
            } catch (\Exception $e) {
                Log::error($e->getMessage(), ['exception' => $e]);
                return redirect('/donors/create')->with('error', 'Error in registering donor. Please try again.');
            }
            return redirect('/donation_requests/create')->with('success', 'Donor registered successfully! Please submit a request for blood donation.');
        } else {
            return redirect('/donors/create')->with('error', 'Error in registering donor. Please try again.');
        }
    }

    public function edit($id)
    {
        $donor = Donor::findOrFail($id);
        $states = States::all();
        return view('donor.create', compact('donor', 'states'));
    }

    public function update(Request $request, $id)
    {
        try {
            $validate =  $request->validate([
                'name' => 'required',
                'gender' => 'required',
                'dob' => 'required|date',
                'blood_group' => 'required',
                'mobile' => 'required|numeric|digits:10',
                'email' => 'required|email',
                'state' => 'required',
                'district' => 'required',
                'city' => 'required',
                'donation_date' => 'required|date',
                'preference' => 'required',
                'donated_previously' => 'required',
                'last_six_months_procedures' => 'required',
                'form_agreement' => 'required',
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage(), ['exception' => $e]);
            return redirect('/donors')->with('error', 'Error in updating donor. Please try again.');
        }
        if ($validate) {
            try {
                $donor = Donor::findOrFail($id);
                $donor->donor_name = $request->name;
                $donor->gender = $request->gender;
                $donor->dob = $request->dob;
                $donor->mobile = $request->mobile;
                $donor->email = $request->email;
                $donor->state = $request->state;
                $donor->district = $request->district;
                $donor->city = $request->city;
                $donor->blood_group = $request->blood_group;
                $donor->late_donation_date = $request->donation_date;
                $donor->total_donation_unit = $request->preference;
                $donor->has_donated_previously = $request->donated_previously;
                $donor->last_six_months_procedures = $request->last_six_months_procedures;
                $donor->user_id = auth()->user()->id;
                $donor->save();
            } catch (\Exception $e) {
                Log::error($e->getMessage(), ['exception' => $e]);
                return redirect()->back()->with('error', 'Error in updating donor. Please try again.');
            }
            return redirect('/donors')->with('success', 'Donor updated successfully');
        } else {
            return redirect()->back()->with('error', 'Error in updating donor. Please try again.');
        }
    }

    public function destroy($id)
    {
        try {
            $donor = Donor::findOrFail($id);
            $donor->delete();
            return redirect('/donors')->with('success', 'Donor deleted successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage(), ['exception' => $e]);
            return redirect('/donors')->with('error', 'Error in deleting donor. Please try again.');
        }
    }

    public function searchDonors()
    {
        $states = States::all();
        return view('donor.search', compact('states'));
    }

    public function searchDonorsResult(Request $request)
    {
        $query = Donor::query();
        $query->join('states', 'donors.state', '=', 'states.id')
            ->join('cities', 'donors.city', '=', 'cities.id')
            ->join('users', 'donors.user_id', '=', 'users.id')
            ->select('donor_name', 'blood_group', 'mobile', 'states.name as state_name', 'cities.name as city_name', 'users.address as user_address');

        $state = $request->state;
        $district = $request->district;
        $city = $request->city;
        $blood_group = $request->blood_group;

        if (empty($state) && empty($district) && empty($city) && empty($blood_group)) {
            return redirect('/search')->with('error', 'Please provide at least one search parameter.');
        }

        if (!empty($state)) {
            $query->where('donors.state', $state);
        }

        if (!empty($district)) {
            $query->where('donors.district', $district);
        }

        if (!empty($city)) {
            $query->where('donors.city', $city);
        }

        if (!empty($blood_group)) {
            $query->where('donors.blood_group', $blood_group);
        }

        $donors = $query->paginate(20);
        $cities = Cities::all();
        return view('donor.index', compact('donors', 'cities'));
    }

    public function verifyDonor($id)
    {
        try {
            $donor = Donor::findOrFail($id);
            $donor->status = 'verified';
            $donor->save();
            return redirect('/donors')->with('success', 'Donor verified successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage(), ['exception' => $e]);
            return redirect('/donors')->with('error', 'Error in verifying donor. Please try again.');
        }
    }

    public function exportDonors(Request $request)
    {
        // Fetch data from the database
        $query = Donor::query();
        $query->join('states', 'donors.state', '=', 'states.id')
            ->join('cities', 'donors.city', '=', 'cities.id')
            ->join('districts', 'donors.district', '=', 'districts.id')
            ->join('users', 'donors.user_id', '=', 'users.id')
            ->select('donors.id','donors.donor_name', 'donors.mobile', 'donors.email', 'states.name as state_name', 'districts.name as district_name', 'cities.name as city_name', 'users.address as user_address', 'donors.blood_group', 'has_donated_previously', 'late_donation_date', 'total_donation_unit');

        if ($request->city != '') {
            $query->where('donors.city', $request->city);
        }
        $donors = $query->get();
        if($donors->isEmpty()){
            return redirect('/donors')->with('error', 'No data found for the selected criteria.');
        }
        // Generate a filename
        $filename = 'donors_list_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        Excel::store(new DonorsExport($donors), 'public/Donors/' . $filename);

        // Generate the full path to the saved file
        $filePath = storage_path('app/public/Donors/' . $filename);

        // Return a download response
        return response()->download($filePath, $filename);
    }
}
