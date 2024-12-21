<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DonationRequest;
use App\Models\Donor;
use App\Models\States;
use Illuminate\Support\Facades\Log;
use App\Mail\DonationApproved;
use Illuminate\Support\Facades\Mail;
use App\Exports\DonationRequestExport;
use Maatwebsite\Excel\Facades\Excel;

class DonationRequestController extends Controller
{
    public  function __construct()
    {
        $this->middleware('permission:view DonationRequest', ['only' => ['index']]);
        $this->middleware('permission:create DonationRequest', ['only' => ['create', 'store']]);
        $this->middleware('permission:update DonationRequest', ['only' => ['update', 'edit']]);
        $this->middleware('permission:delete DonationRequest', ['only' => ['destroy']]);
        $this->middleware('permission:approve DonationRequest', ['only' => ['approveDonationRequest']]);
        $this->middleware('permission:export DonationRequest', ['only' => ['exportDonationRequest']]);
        $this->middleware('permission:open DonationRequest', ['only' => ['openNewRequest']]);
    }

    public function index()
    {
        $query = DonationRequest::query();
        $query->join('states', 'donation_requests.state', '=', 'states.id')
            ->join('cities', 'donation_requests.city', '=', 'cities.id')
            ->select('donation_requests.id', 'donor_name', 'blood_group', 'mobile', 'email', 'cities.name as city_name', 'states.name as state_name', 'status');
        $donation_requests = $query->paginate(20);
        return view('donationRequest.index', ['donation_requests' => $donation_requests]);
    }

    public function create()
    {
        $donor = Donor::where('user_id', auth()->user()->id)->first();
        if ($donor) {
            $states = States::all();
            return view('donationRequest.create', compact('donor', 'states'));
        } else {
            return redirect()->back()->with('error', 'You are not registered as Donor, please register as donor then submit donation request.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validate = $request->validate([
                'name' => 'required|string',
                'mobile' => 'required|numeric|digits:10',
                'email' => 'required|email',
                'blood_group' => 'required',
                'state' => 'required',
                'city' => 'required',
                'medical_condition' => 'required',
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage(), ['exception' => $e]);
            return redirect('donation_requests/create')->with('error', 'Error in submitting request. Please try again.');
        }

        if ($validate) {
            try {
                $donor_id = Donor::where('user_id', auth()->user()->id)->first()->id;
                $donationRequest = new DonationRequest();
                $donationRequest->donor_id = $donor_id;
                $donationRequest->donor_name = $request->name;
                $donationRequest->mobile = $request->mobile;
                $donationRequest->email = $request->email;
                $donationRequest->state = $request->state;
                $donationRequest->city = $request->city;
                $donationRequest->blood_group = $request->blood_group;
                $donationRequest->medical_condition = $request->medical_condition;
                $donationRequest->save();
            } catch (\Exception $e) {
                Log::error($e->getMessage(), ['exception' => $e]);
                return redirect('donation_requests/create')->with('error', 'Error in submitting request. Please try again.');
            }
            return redirect('/blood_banks')->with('success', 'Donation Request Submitted Successfully, Someone from team will approve the request and contact you soon. Thank you for your request');
        } else {
            return redirect('donation_requests/create')->with('error', 'Error in submitting request. Please try again.');
        }
    }

    public function destroy($id)
    {
        try {
            $donationRequest = DonationRequest::findOrFail($id);
        } catch (\Exception $e) {
            Log::error($e->getMessage(), ['exception' => $e]);
            return redirect('/donation_requests')->with('error', 'Donation request not found');
        }
        // Attempt to delete the donation request record
        try {
            $donationRequest->delete();
            return redirect('/donation_requests')->with('success', 'Donation request deleted successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage(), ['exception' => $e]);
            return redirect('/donation_requests')->with('error', 'Failed to delete donation request');
        }
    }

    public function approveDonationRequest($id)
    {
        $donationRequest = DonationRequest::where('id', $id)->first();

        if ($donationRequest) {
            $donor = Donor::where('id', $donationRequest->donor_id)->first();

            if ($donor) {
                // Update status
                $donationRequest->id = $id;
                $donationRequest->status = 'approved';
                $donationRequest->save();

                return redirect('/donation_requests')->with('success', 'Donation request approved successfully');
            }
        }

        return redirect()->back()->with('error', 'Donation request not found');
    }

    public function openNewRequest($id)
    {
        $donationRequest = DonationRequest::findOrFail($id);
        return view('donationRequest.newRequest', compact('donationRequest'));
    }

    public function exportDonationRequest()
    {
        // Fetch data from the database
        $query = DonationRequest::query();
        $query->join('states', 'donation_requests.state', '=', 'states.id')
            ->join('cities', 'donation_requests.city', '=', 'cities.id')
            ->select('donation_requests.id', 'donor_name', 'mobile', 'email', 'states.name as state_name', 'cities.name as city_name', 'blood_group', 'medical_condition', 'status');
        $donationRequest = $query->get();
        if ($donationRequest->isEmpty()) {
            return redirect('/donors')->with('error', 'No data found for the selected criteria.');
        }
        // Generate a filename
        $filename = 'donation_request_list' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        Excel::store(new DonationRequestExport($donationRequest), 'public/DonationRequest/' . $filename);

        // Generate the full path to the saved file
        $filePath = storage_path('app/public/DonationRequest/' . $filename);

        // Return a download response
        return response()->download($filePath, $filename);
    }
}
