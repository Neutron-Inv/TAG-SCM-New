<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdatePricingRequest;
use App\Services\PricingService;
use App\{Companies, User,Log,ClientRfq, ClientPo, Clients, Shippers, PricingHistory, LineItem, Employers, MailTray};
class PricingHistoryController extends Controller
{

    protected $pricingService;

    public function __construct(PricingService $pricingService)
    {
        $this->pricingService = $pricingService;
    }
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
    
    public function update(UpdatePricingRequest  $request, $id)
    {
        $result = $this->pricingService->updatePricing($id, $request->validated());

        return redirect()->back()->with($result['success'] ? 'success' : 'error', $result['message']);
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
