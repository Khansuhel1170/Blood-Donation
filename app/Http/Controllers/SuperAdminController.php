<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BloodBank;
use App\Models\DonationRequest;

class SuperAdminController extends Controller
{
    public function delete($id)
    {
        $bloodBank = BloodBank::findOrFail($id);

        // Attempt to delete the blood bank record
        try {
            $bloodBank->delete();
            $message = 'Blood bank "' . $bloodBank->name . '" deleted successfully';
            $status = 'success';
        } catch (\Exception $e) {
            $message = 'Failed to delete blood bank "' . $bloodBank->name . '"';
            $status = 'error';
        }

        // Return response based on success or failure
        return response()->json([
            'message' => $message,
            'status' => $status,
        ]);
    }

    public function show_donation_request($id)
    {
        if (!empty($id)) {
            try {
            $donationRequest = DonationRequest::findOrFail($id);
            } catch (\Exception $e) {
                return redirect('/show_donation_request')->with('error', 'Donation request not found');
            }
            return view('bloodDonation.approve_donation_request', compact('donationRequest'));
        } else {
            $donationRequest = DonationRequest::all();
            return view('bloodDonation.show_donation_request', compact('donationRequest'));
        }
    }
}
