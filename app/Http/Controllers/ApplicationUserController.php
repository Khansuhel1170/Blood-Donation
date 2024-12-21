<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BloodBank;
use App\Models\Donor;
use App\Models\DonationRequest;
use App\Models\States;
use App\Models\Cities;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ApplicationUserController extends Controller
{
    public function show_blood_banks()
    {
        $bloodBanks = BloodBank::paginate(20);
        return view('bloodDonation.blood_banks', compact('bloodBanks'));
    }

    public function donor_registeration(Request $request)
    {
        // dd($request->all());
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
            return redirect('/register_donor')->with('error', 'Error in registering donor. Please try again.');
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
                return redirect('/register_donor')->with('error', 'Error in registering donor. Please try again.');
            }
            return redirect('/donation_request')->with('success', 'Donor registered successfully! Please submit a request for blood donation.');
        } else {
            return redirect('/register_donor')->with('error', 'Error in registering donor. Please try again.');
        }
    }

    public function show_donation_request_form()
    {
        // dd(auth()->user()->role);
        $donor = Donor::where('user_id', auth()->user()->id)->first();
        if ($donor) {
            $states = States::all();
            return view('bloodDonation.donation_request', compact('donor', 'states'));
        } else {
            return redirect('/register_donor')->with('error', 'You are not registered as Donor, please register as donor then submit donation request.');
        }
    }

    public function submit_donation_request(Request $request)
    {
        
    }

    public function search_blood_banks(Request $request)
    {
        $query = Donor::query();
        $query->join('states', 'donors.state', '=', 'states.id')
            ->join('cities', 'donors.city', '=', 'cities.id')
            ->join('users', 'donors.user_id', '=', 'users.id')
            ->select('donor_name', 'blood_group', 'mobile', 'states.name as state_name', 'cities.name as city_name', 'users.address as user_address');

        if (auth()->user()->role == 'Application User') {
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
        }

        $donors = $query->paginate(20);
        //print query
        // dd($query->toSql());
        $cities = Cities::all();
        return view('bloodDonation.list_of_donors', compact('donors', 'cities'));
    }
}
