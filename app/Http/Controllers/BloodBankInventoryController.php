<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BloodBank;
use App\Models\BloodBankInventory;
use Illuminate\Support\Facades\Log;

class BloodBankInventoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view BloodBankInventory', ['only' => ['index']]);
        $this->middleware('permission:create BloodBankInventory', ['only' => ['create', 'store']]);
    }

    public function index()
    {
        $blood_groups = array('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-');
        $blood_banks = BloodBank::all();
        $query = BloodBankInventory::query();
        $query->selectRaw('sum(quantity) as bags_count, blood_group')
            ->groupBy('blood_group');
        $bloodBankInventories = $query->get();
        return view('bloodBankInventory.index', ['bloodBankInventories' => $bloodBankInventories, 'blood_banks' => $blood_banks, 'blood_groups' => $blood_groups]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'blood_bank' => [
                    'required'
                ],
                'blood_group' => [
                    'required',
                    'string'
                ],
                'quantity' => [
                    'required',
                    'numeric',
                    'min:1'
                ],
                'collectionDate' => [
                    'required',
                    'date'
                ]
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage(), ['exception' => $e]);
            return redirect()->back()->with('error', 'Error in adding blood bank inventory. Please try again.');
        }
        $bloodBankInventory = new BloodBankInventory();
        $bloodBankInventory->blood_bank_id = $request->blood_bank;
        $bloodBankInventory->blood_group = $request->blood_group;
        $bloodBankInventory->quantity = $request->quantity;
        $bloodBankInventory->date_of_collection = $request->collectionDate;
        $bloodBankInventory->save();
        return redirect('/blood_bank_inventory')->with('success', 'Blood bank inventory added successfully');
    }

}
