<?php

use App\Http\Controllers\ApplicationUserController;
use App\Http\Controllers\SuperAdminController;
use Illuminate\Support\Facades\Route;
use App\Models\Cities;
use App\Models\States;
use App\Models\Donor;
use App\Http\Controllers\UserAuthenticationController;
use App\Http\Controllers\BloodBankController;
use App\Http\Controllers\DonationRequestController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\BloodBankInventoryController;
use Faker\Core\Blood;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware(['auth'])->name('verification.notice');

// The route for verifying the email address
Route::get('/email/verify/{id}/{hash}', [UserAuthenticationController::class, 'verifyEmail'])
    ->name('verification.verify');

// Route for resending the verification email
Route::post('/email/verification-notification', function () {
    // Your logic for resending verification email
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

//Route defined to open the login page
Route::get('login', [UserAuthenticationController::class, 'login'])->name('login');

//Route defined to login the user.
Route::post('authenticate', [UserAuthenticationController::class, 'authenticate'])->name('authenticate');

//Route defined to open the signup page
Route::get('signup', function () {
    //fetch all cities
    $cities = Cities::all();
    return view('userAuthentication.signup', compact('cities'));
})->name('signup');

//Route defined to register the user
Route::post('register', [UserAuthenticationController::class, 'register'])->name('register');

//Route defined to logout the user
Route::get('logout', [UserAuthenticationController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return view('bloodBank.index');
});

Route::middleware(['auth'])->group(
    function () {
        Route::get('/districts/{state}', [UserAuthenticationController::class, 'getDistricts']);
        Route::get('/cities/{district}', [UserAuthenticationController::class, 'getCities']);
        Route::get('/stateTocities/{state}', [UserAuthenticationController::class, 'stateTocities']);

        Route::resource('permissions', App\Http\Controllers\PermissionController::class);
        Route::get('permissions/{permissionId}/delete', [App\Http\Controllers\PermissionController::class, 'destroy']);

        Route::resource('roles', App\Http\Controllers\RoleController::class);
        Route::get('roles/{roleId}/delete', [App\Http\Controllers\RoleController::class, 'destroy']);
        Route::get('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'addPermissionToRole']);
        Route::put('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'givePermissionToRole']);

        Route::resource('users', App\Http\Controllers\UserController::class);
        Route::get('users/{userId}/delete', [App\Http\Controllers\UserController::class, 'destroy']);

        Route::resource('blood_banks', BloodBankController::class);
        Route::get('blood_banks/{bloodBankId}/delete', [BloodBankController::class, 'destroy']);

        Route::get('donors/export', [DonorController::class, 'exportDonors']);
        Route::get('donors/searchDonorsResult', [DonorController::class, 'searchDonorsResult'])->name('donors.searchDonorsResult');
        Route::get('donors/searchDonors', [DonorController::class, 'searchDonors'])->name('donors.searchDonors');
        Route::resource('donors', DonorController::class)->except('show');;
        Route::get('donors/{donorId}/delete', [DonorController::class, 'destroy']);
        Route::get('donors/{donorId}/verify', [DonorController::class, 'verifyDonor']);


        Route::get('donation_requests/export', [DonationRequestController::class, 'exportDonationRequest']);
        Route::resource('donation_requests', DonationRequestController::class);
        Route::get('donation_requests/{donationRequestId}/delete', [DonationRequestController::class, 'destroy']);
        Route::get('donation_requests/{donationRequestId}/openNewRequest' , [DonationRequestController::class, 'openNewRequest']);
        Route::get('donation_requests/{donationRequestId}/approveDonationRequest' , [DonationRequestController::class, 'approveDonationRequest']);

        Route::resource('blood_bank_inventory',BloodBankInventoryController::class);
        Route::get('blood_bank_inventory/{bloodBankInventoryId}/delete', [BloodBankInventoryController::class, 'destroy']);

        // Route::get('show_blood_banks', [ApplicationUserController::class, 'show_blood_banks'])
        //     ->name('blood_banks.show');

        // Route::delete('/delete_blood_bank/{id?}', function ($id = "", SuperAdminController $superAdminController) {
        //     if (!empty($id)) {
        //         $superAdminController->deleteBloodBank($id);
        //     } else {
        //         return response()->json(['status' => 'error', 'message' => 'System could not find BloodBank. Please check and try again.']);
        //     }
        // })->name('blood_bank.delete');

        // Route::get('/add_blood_bank/{blood_bank_id}', function ($blood_bank_id = "", SuperAdminController $superAdminController) {
        //     if (!empty($blood_bank_id)) {
        //         $bloodBank = $superAdminController->getBloodBank($blood_bank_id);
        //     } else {
        //         $bloodBank = null;
        //     }
        //     return view('bloodDonation.add_blood_bank', compact('bloodBank'));
        // })->name('blood_bank.add');

        // Route::get('/delete_donor/{donor_id?}', function ($donor_id = "", SuperAdminController $superAdminController) {
        //     if (!empty($donor_id)) {
        //         $superAdminController->deleteDonor($donor_id);
        //     } else {
        //         return response()->json(['status' => 'error', 'message' => 'System could not find Donor. Please check and try again.']);
        //     }
        // })->name('delete_donor');
        // Route::get('list_of_donors/{state?}/{district?}/{city?}/{blood_group?}', [ApplicationUserController::class, 'search_blood_banks'])
        //     ->name('list_of_donors');

        // Route::get('edit_donor/{donor_id?}', function ($donor_id = null) {
        //     if ($donor_id) {
        //         $donor = Donor::find($donor_id);
        //     }
        //     $states = States::all();
        //     return view('bloodDonation.register_donor', compact('states', 'donor'));
        // })->name('edit_donor');

        // Route::get('verify_donor/{donor_id}', [SuperAdminController::class, 'verify_donor'])
        //     ->name('verify_donor');

        // Route::get('show_donation_request', [SuperAdminController::class, 'show_donation_request'])
        //     ->name('show_donation_request');

        // Route::get('export_donors', [SuperAdminController::class, 'export_donors'])
        //     ->name('export_donors');

        // Route::get('/delete_donation_request/{id?}', function ($id = "", SuperAdminController $superAdminController) {
        //     if (!empty($id)) {
        //         $superAdminController->deleteDonor($id);
        //     } else {
        //         return response()->json(['status' => 'error', 'message' => 'System could not find Donation Request Id. Please check and try again.']);
        //     }
        // })->name('delete_donation_request');

        // Route::get('export_donation_request', [SuperAdminController::class, 'export_donors'])
        //     ->name('export_donation_request');

        // Route::get('show_blood_banks', [ApplicationUserController::class, 'show_blood_banks'])
        //     ->name('blood_banks.show');

        // Route::get('donation_request', [ApplicationUserController::class, 'show_donation_request_form'])->name('donation_request');

        // Route::post('request_donation', [ApplicationUserController::class, 'submit_donation_request'])
        //     ->name('request_donation');

        // Route::get('register_donor/{donor_id?}', function ($donor_id = null) {
        //     if ($donor_id) {
        //         $donor = Donor::find($donor_id);
        //     }
        //     $states = States::all();
        //     return view('bloodDonation.register_donor', compact('states', 'donor'));
        // })->name('register_donor');

        // Route::post('donor_registeration', [ApplicationUserController::class, 'donor_registeration'])
        //     ->name('donor_registeration');

        // Route::get('search', function () {
        //     $states = States::all();
        //     return view('bloodDonation.search', compact('states'));
        // })->name('search_blood_banks');

        // Route::get('list_of_donors/{state?}/{district?}/{city?}/{blood_group?}', [ApplicationUserController::class, 'search_blood_banks'])
        //     ->name('list_of_donors');
    }
);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
