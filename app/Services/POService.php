<?php

namespace App\Services;

use App\LineItem;
use App\ClientPo;
use App\Companies;
use App\ClientRfq;
use App\Clients;
use App\PricingHistory;
use App\RfqHistory;
use App\VendorContact;
use App\Vendors;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PoService
{
    public function processPoSubmission($request)
    {
        $rfq = $this->getRfq($request->input('rfq_id'));
        $vendor = $this->getVendor($request->input('vendor_id'));
        $vendor_contact = $this->getVendorContact($request->input('contact_id'));
        $line_items = $this->getLineItems($request->input('rfq_id'), $request->input('line_items'), $request->input('send_all'));
        $pricing = $this->getPricing($request->supplier_rfq);
        $client = $this->getClient($rfq->client_id);
        $company = $this->getCompany($rfq->company_id);
        $assigned_details = empDetails($rfq->employee_id);
        $assigned = $assigned_details->full_name;

        return $this->prepareMailData($rfq, $company, $vendor, $vendor_contact, $line_items, $request->input('extra_note'), $client->client_name, $request->input('report_recipient'), $assigned, $pricing, $request->input('quotation_file'), $pricing->mail_id, auth()->user());
    }

    public function getRfq($rfq_id)
    {
        return ClientRfq::where('rfq_id', $rfq_id)->first();
    }

    public function getVendor($vendor_id)
    {
        return Vendors::where('vendor_id', $vendor_id)->first();
    }

    public function getVendorContact($contact_id)
    {
        return VendorContact::where('contact_id', $contact_id)->first();
    }

    public function getPricing($pricing_id)
    {
        return PricingHistory::findorfail($pricing_id);
    }

    public function getClient($client_id)
    {
        return Clients::findorfail($client_id);
    }

    public function getCompany($company_id)
    {
        return Companies::findorfail($company_id);
    }
    public function getLineItems($rfq_id, $line_items_input, $send_all)
    {
        if ($send_all == 1) {
            return LineItem::where('rfq_id', $rfq_id)->orderBy('created_at', 'asc')->get();
        }

        // Process the input to extract individual or ranged serial numbers
        $serial_numbers = [];
        if ($line_items_input) {
            $ranges = explode(',', $line_items_input);
            foreach ($ranges as $range) {
                if (strpos($range, '-') !== false) {
                    list($start, $end) = explode('-', $range);
                    $serial_numbers = array_merge($serial_numbers, range((int)$start, (int)$end));
                } else {
                    $serial_numbers[] = (int)$range;
                }
            }
        }

        return LineItem::where('rfq_id', $rfq_id)
            ->whereIn('item_serialno', $serial_numbers)
            ->orderBy('item_serialno', 'asc')
            ->get();
    }

    public function prepareMailData($rfq, $company, $vendor, $vendor_contact, $line_items, $extra_note, $client_name, $report_recipient, $assigned, $pricing, $quotation_files, $mail_id, $user)
    {
        if (is_string($report_recipient)) {
            $report_recipient = explode(';', $report_recipient); // Split by semicolon
        }

        if ($quotation_files) {
            $files = $quotation_files;
            $tempFileDirs = [];
            $fileNames = [];

            foreach ($files as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $tempFileDir = storage_path('temp') . '/' . $fileName;
                $file->move(storage_path('temp'), $fileName);
                $tempFileDirs[] = $tempFileDir;
                $fileNames[] = $file->getClientOriginalName();
            }
        } else {
            $tempFileDirs = [];
            $fileNames = [];
        }

        $rfqcode = "Purchase Order TE-" . $vendor->vendor_code . '-' . preg_replace('/[^0-9]/', '', $rfq->refrence_no);
        $data = [
            'rfq' => $rfq,
            'company' => $company,
            'vendor' => $vendor,
            'vendor_contact' => $vendor_contact,
            'line_items' => $line_items,
            'extra_note' => $extra_note,
            'client_name' => $client_name,
            'report_recipient' => $report_recipient,
            'rfqcode' => $rfqcode,
            'assigned' => $assigned,
            'pricing' => $pricing,
            'quotation_files' => $quotation_files,
            'tempFileDirs' => $tempFileDirs,
            'fileNames' => $fileNames,
            'mail_id' => $mail_id,
            'user' => $user
        ];

        return $data;
    }
}
