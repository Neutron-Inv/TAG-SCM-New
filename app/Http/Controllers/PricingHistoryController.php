<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Companies, User,Log,ClientRfq, ClientPo, Clients, Shippers, PricingHistory, LineItem, Employers, MailTray};
class PricingHistoryController extends Controller
{
    public function index($id)
    {
            $rfq = ClientRFQ::where('rfq_id', $id)->first();
            $histories = PricingHistory::where('rfq_id', $id)->get();
            return view('dashboard.pricing_history.index')->with([
                'rfq' => $rfq, "histories" => $histories
            ]);
    }

    public function edit($id)
    {
            $pricing = PricingHistory::where('id', $id)->first();
            $rfq = ClientRFQ::where('rfq_id', $pricing->rfq_id)->first();
            $histories = PricingHistory::where('rfq_id', $pricing->rfq_id)->get();
            return view('dashboard.pricing_history.edit')->with([
                'rfq' => $rfq, "histories" => $histories, "pricing" => $pricing
            ]);
    }

    public function correspondence($id)
    {       
            $history = PricingHistory::where('id', $id)->first();
            $rfq = ClientRFQ::where('rfq_id', $history->rfq_id)->first();
            $mails = MailTray::where('mail_id', $history->mail_id)->orderBy('date_received', 'desc')->get();
            return view('dashboard.pricing_history.correspondence')->with([
                'rfq' => $rfq, "history" => $history, "mails" => $mails
            ]);
    }
    
    public function update(Request $request, $id)
    {
        try {
            // Validate the request
            $request->validate([
                'response_time' => 'required|integer|min:1|max:5',
                'pricing' => 'required|integer|min:1|max:5',
                'conformity' => 'required|integer|min:1|max:5',
                'accuracy' => 'required|integer|min:1|max:5',
                'negotiation' => 'required|integer|min:1|max:5',
                'total_quote' => 'required|numeric|min:0',
                'reference_number' => 'required|string',
            ]);
    
            // Find the existing record
            $pricing = PricingHistory::findOrFail($id);
            $user_id = \Auth::user()->user_id;

            // Assuming you have retrieved the values from the form
            $miscCostSupplierValues = $request->input('misc_cost_title');
            $miscAmountSupplierValues = $request->input('misc_cost_amount');
            //dd($miscCostSupplierValues);
            // Create an array to hold the values
            $data_supplier = [];

            // Loop through one of the arrays (assuming they have the same length)
            foreach ($miscCostSupplierValues as $key => $costValue) {
                // Check if the corresponding index exists in the other array
                if (isset($miscAmountSupplierValues[$key])) {
                    // Add the values to the data array
                    $data_supplier[] = [
                        'desc' => $costValue,
                        'amount' => $miscAmountSupplierValues[$key],
                    ];
                }
            }

            $json_supplier = json_encode($data_supplier);
            
            // Update the record
            $pricing->update([
                'response_time' => $request->input('response_time'),
                'pricing' => $request->input('pricing'),
                'conformity' => $request->input('conformity'),
                'accuracy' => $request->input('accuracy'),
                'negotiation' => $request->input('negotiation'),
                'total_quote' => $request->input('total_quote'),
                'reference_number' => $request->input('reference_number'),
                'misc_cost' => $json_supplier,
                'rated_by' => $user_id
            ]);
    
            return redirect()->back()->with('success', 'Supplier rating updated successfully.');
    
        } catch (\Exception $e) {
            // Log error
            \Log::error('Pricing Update Failed: ' . $e->getMessage());
    
            // Return error message to the user
            return redirect()->back()->with('error', 'Failed to update supplier rating. Error: ' . $e->getMessage());
        }
    }


    public function destroy_mail($mail_id){

        $mail = MailTray::find($mail_id);
        if ($mail) {
            $mail->delete(); // Corrected with parentheses to call the delete method
            return redirect()->back()->with("success", "Mail Deleted Successfully.");
        } else {
            return redirect()->back()->with("error", "Mail not found.");
        }
    }
}
