<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BloodBank;
use App\Models\States;
use App\Models\Cities;
use Illuminate\Support\Facades\Log;

class BloodBankController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view BloodBank', ['only' => ['index']]);
        $this->middleware('permission:create BloodBank', ['only' => ['create', 'store']]);
        $this->middleware('permission:update BloodBank', ['only' => ['update', 'edit']]);
        $this->middleware('permission:delete BloodBank', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $query  = BloodBank::query();
        $query->select('blood_banks.id', 'blood_banks.name', 'blood_banks.phone', 'blood_banks.email', 'blood_banks.address', 'state', 'city');
        if(!empty($request->state))
        {
            $state_name = States::where('id', $request->state)->first('name');
            $query->where('state', $state_name->name);
        }
        if(!empty($request->city))
        {
            $city_name = Cities::where('id', $request->city)->first('name');
            $query->where('city', $city_name->name);
        }
        $bloodBanks = $query->paginate(10);
        //print query
        // dd($query->toSql());
        $states = States::all();
        $cities = Cities::all();
        return view('bloodBank.index', ['bloodBanks' => $bloodBanks, 'states' => $states, 'cities' => $cities]);
    }

    public function create()
    {
        $states = States::all();
        $bloodBank = new BloodBank();
        $bloodGroups = array('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-');
        return view('bloodBank.create', ['bloodBank' => $bloodBank, 'bloodGroups' => $bloodGroups, 'states' => $states]);
    }


    public function store(Request $request)
    {
        // dd($request->all());    
        
            $request->validate([
                'name' => [
                    'required',
                    'string'
                ],
                'mobile' => [
                    'required',
                    'string'
                ],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'unique:blood_banks,email'
                ],
                'address' => [
                    'required',
                    'string'
                ],
                'state' => [
                    'required'
                ],
                'district' => [
                    'required'
                ],
                'city' => [
                    'required'
                ],
                'blood_bank_type' => [
                    'required'
                ],
                'license_no' => [
                    'required'
                ],
                'blood_types' => [
                    'required'
                ]
            ]);
        

        $blood_types = implode(',', $request->blood_types);
        $city = explode('_', $request->city);
        $state = explode('_', $request->state);
        $district = explode('_', $request->district);
        try {
            $bloodBank = new BloodBank();
            $bloodBank->name = trim($request->name);
            $bloodBank->phone = trim($request->mobile);
            $bloodBank->email = trim($request->email);
            $bloodBank->address = trim($request->address);
            $bloodBank->state = trim($state[0]);
            $bloodBank->district = trim($district[0]);
            $bloodBank->city = trim($city[0]);
            $bloodBank->type = trim($request->blood_bank_type);
            $bloodBank->license_no = trim($request->license_no);
            $bloodBank->blood_type_available = "'" . trim($blood_types) . "'";
            $bloodBank->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage(), ['exception' => $e]);
            return redirect('blood_banks/create')->with('error', 'Error in updating blood bank. Please try again.');
        }
        return redirect('blood_banks')->with('success', 'Blood Bank Created Successfully');
    }

    public function edit(BloodBank $bloodBank)
    {
        $states = States::all();
        $bloodGroups = array('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-');
        return view('bloodBank.create', ['bloodBank' => $bloodBank, 'bloodGroups' => $bloodGroups, 'states' => $states]);
    }


    public function update(Request $request, BloodBank $bloodBank)
    {

        $request->validate([
            'name' => [
                'required',
                'string'
            ],
            'mobile' => [
                'required',
                'string'
            ],
            'email' => [
                'required',
                'string'
            ],
            'address' => [
                'required',
                'string'
            ],
            'state' => [
                'required'
            ],
            'district' => [
                'required'
            ],
            'city' => [
                'required'
            ],
            'blood_bank_type' => [
                'required'
            ],
            'license_no' => [
                'required'
            ],
            'blood_types' => [
                'required'
            ],
        ]);

        $blood_types = implode(',', $request->blood_types);
        $city = explode('_', $request->city);
        $state = explode('_', $request->state);
        $district = explode('_', $request->district);
        try {
            if (!empty($bloodBank->id)) {
                $bloodBank->name = trim($request->name);
                $bloodBank->phone = trim($request->mobile);
                $bloodBank->email = trim($request->email);
                $bloodBank->address = trim($request->address);
                $bloodBank->state = trim($state[0]);
                $bloodBank->district = trim($district[0]);
                $bloodBank->city = trim($city[0]);
                $bloodBank->type = trim($request->blood_bank_type);
                $bloodBank->license_no = trim($request->license_no);
                $bloodBank->blood_type_available = "'" . trim($blood_types) . "'";
                $bloodBank->save();
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage(), ['exception' => $e]);
            return redirect('blood_banks/create')->with('error', 'Error in updating blood bank. Please try again.');
        }
        return redirect('blood_banks')->with('success', 'Blood Bank Updated Successfully');
    }

    
    public function destroy($bloodBankId)
    {
        $bloodBank = BloodBank::findOrFail($bloodBankId);

        // Attempt to delete the blood bank record
        try {
            $bloodBank->delete();
        } catch (\Exception $e) {
            Log::error($e->getMessage(), ['exception' => $e]);
            return redirect('blood_banks')->with('error', 'Error in deleting blood bank. Please try again.');
        }
        return redirect('blood_banks')->with('success', 'Blood Bank Deleted Successfully');
    }
}
