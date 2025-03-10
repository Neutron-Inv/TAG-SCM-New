<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('rfq')->group(function () {
    Route::post('/note', "ClientRFQController@getnote")->name('getnote');
}); 

 Route::get('/get-states/{id}', function($id) {

    $states = getStatesByCountry($id);  

    return response()->json($states);
});

 Route::get('/get-cities/{id}', function($id) {
    // Call the helper function
    $cities = getCitiesByState($id);  // the helper function

    // Return a response 
    return response()->json($cities);
});

 Route::get('/get-vendor-contact/{id}', function($id) {
    // Call the helper function
    $contact = getVendorContacts($id);  // the helper function

    // Return a response 
    return response()->json($contact);
});

Route::get('/get-vendor-pricing/{rfq}/{vendorId}', function($rfq, $vendorId) {
    // Call the helper function
    $pricing = getVendorPricing($rfq, $vendorId);  // the helper function

    // Return a response 
    return response()->json($pricing);
});

Route::get('/get-pricing-lineitems/{pricingId}', function($pricingId) {
    // Call the helper function
    $pricing = getPricingLineItems($pricingId);  // the helper function

    // Return a response 
    return response()->json($pricing);
});

Route::get('/get-mail-details/{id}', function($id) {
    // Call the helper function
    $mail = getMailDetails($id);  // the helper function

    // Return a response 
    return response()->json($mail);
});