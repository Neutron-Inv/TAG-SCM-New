<?php

namespace App\Services;

use App\Vendors;
use App\LineItem;
use App\PricingHistory;
use App\VendorContact;
use App\ClientRfq;
use App\RfqHistory;
use App\Mail\QuoteRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use PDF;
use Str;
use Auth;

class SupplierService
{
    public function sendRfqToVendor(array $data)
    {
        $rfq = $this->fetchRfq($data['rfq_id']);
        $vendor = Vendors::find($data['vendor_id']);
        $vendorContact = VendorContact::find($data['contact_id']);

        $lineItems = $this->getLineItems($rfq->rfq_id, $data);
        $lineItemsInput = $this->getLineItemsInput($lineItems, $data);

        $this->checkForDuplicateHistory($rfq->rfq_id, $data['vendor_id'], $data['contact_id'], $lineItemsInput);

        $recipients = $this->getRecipients($data['report_recipient'], $vendorContact);
        $mailId = $this->generateCustomMailId();

        $pdfPath = $this->generatePdf($rfq, $lineItems, $vendor, $vendorContact);

        $fileAttachments = $this->handleAttachments($data);

        $this->sendMail($recipients, $rfq, $vendor, $mailId, $pdfPath, $fileAttachments);

        $this->savePricingHistory($rfq->rfq_id, $data['vendor_id'], $data['contact_id'], $lineItemsInput, $mailId);

        $this->logRfqHistory($rfq->rfq_id, $vendor->vendor_name);

        $this->updateRfqStatus($rfq->rfq_id, $vendor->vendor_name, $data['extra_note']);

        $this->cleanupFiles($pdfPath, $fileAttachments);
    }

    // Define the rest of the private methods (fetchRfq, getLineItems, getRecipients, etc.)
    private function fetchRfq($rfqId)
    {
        $rfq = ClientRfq::find($rfqId);
        return $rfq;
    }

    private function getLineItems($rfqId, array $data)
    {
        if ($data['send_all'] == 1) {
            return LineItem::where('rfq_id', $rfqId)->orderBy('created_at', 'asc')->get();
        }

        $lineItemsInput = $this->getLineItemsInput($data['line_items']);

        return LineItem::where('rfq_id', $rfqId)
            ->whereIn('item_serialno', $lineItemsInput)
            ->orderBy('item_serialno', 'asc')
            ->get();
    }

    private function getLineItemsInput($lineItems)
    {
        if (empty($lineItems)) return [];

        $serialNumbers = [];
        $ranges = explode(',', $lineItems);

        foreach ($ranges as $range) {
            if (strpos($range, '-') !== false) {
                [$start, $end] = explode('-', $range);
                $serialNumbers = array_merge($serialNumbers, range((int)$start, (int)$end));
            } else {
                $serialNumbers[] = (int)$range;
            }
        }

        return array_values($serialNumbers);
    }

    private function checkForDuplicateHistory($rfqId, $vendorId, $contactId, $lineItemsInput)
    {
        $historyCheck = PricingHistory::where('rfq_id', $rfqId)
            ->where('vendor_id', $vendorId)
            ->where('contact_id', $contactId)
            ->where('line_items', json_encode($lineItemsInput))
            ->first();

        if ($historyCheck && $historyCheck->vendor_id != 266) {
            throw new \Exception("Same Request has been sent to {$historyCheck->vendor_name} before on {$historyCheck->created_at}. Kindly follow up on the previous request.");
        }
    }

    private function getRecipients($reportRecipient, $vendorContact)
    {
        $recipients = [];
        $cut = explode("; ", $reportRecipient);

        foreach ($cut as $email) {
            $name = ucwords(str_replace(".", " ", explode("@", $email)[0]));
            $recipients[] = (object)['email' => $email, 'name' => $name];
        }

        $recipients[] = (object)[
            'email' => $vendorContact->email,
            'name' => $vendorContact->first_name . ' ' . $vendorContact->last_name
        ];

        $recipients[] = (object)[
            'email' => config('mail.email'),
            'name' => "TAGFlow"
        ];

        return $recipients;
    }

    private function generateCustomMailId()
    {
        $letters1 = strtoupper(Str::random(3));
        $digits = mt_rand(1000, 9999);
        $letters2 = strtoupper(Str::random(4));

        return "{$letters1}-{$digits}-{$letters2}";
    }

    private function generatePdf($rfq, $lineItems, $vendor, $vendorContact)
    {
        $pdf = PDF::loadView('dashboard.printing.supplierRFQ', compact('rfq', 'lineItems', 'vendor', 'vendorContact'))
            ->setPaper('a4', 'portrait');

        $pdfName = "TAG Energy Request for Quotation TE-" . preg_replace('/[^0-9]/', '', $rfq->refrence_no) . ".pdf";
        $pdfName = str_replace("/", "-", $pdfName);

        $tempFilePath = storage_path($pdfName);
        $pdf->save($tempFilePath);

        return $tempFilePath;
    }

    private function handleAttachments($data)
    {
        if (!request()->hasFile('quotation_file')) return [];

        $files = request()->file('quotation_file');
        $attachments = [];

        foreach ($files as $file) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = storage_path('temp') . '/' . $fileName;
            $file->move(storage_path('temp'), $fileName);

            $attachments[] = [
                'path' => $filePath,
                'name' => $file->getClientOriginalName()
            ];
        }

        return $attachments;
    }

    private function sendMail($recipients, $rfq, $vendor, $mailId, $pdfPath, $attachments)
    {
        if (request()->input('send_mail') != '1') return;

        $mailSubject = "Request for Pricing Information: - TE-RFQ " . preg_replace('/[^0-9]/', '', $rfq->refrence_no) . " " . $rfq->description;
        $data = [
            'rfq' => $rfq,
            'company' => Companies::where('company_id', $rfq->company_id)->first(),
            'tempFilePath' => $pdfPath,
            'attachments' => $attachments,
            'mail_id' => $mailId
        ];

        Mail::to($vendor->contact_email)
            ->cc($recipients)
            ->send(new QuoteRequest($data));
    }

    private function savePricingHistory($rfqId, $vendorId, $contactId, $lineItemsInput, $mailId)
    {
        PricingHistory::create([
            'rfq_id' => $rfqId,
            'vendor_id' => $vendorId,
            'contact_id' => $contactId,
            'line_items' => json_encode($lineItemsInput),
            'mail_id' => $mailId,
            'status' => "Awaiting Pricing",
            'issued_by' => Auth::user()->user_id
        ]);
    }

    private function logRfqHistory($rfqId, $vendorName)
    {
        RfqHistory::create([
            'user_id' => Auth::user()->user_id,
            'rfq_id' => $rfqId,
            'action' => "Sent Request for Pricing to $vendorName"
        ]);
    }

    private function updateRfqStatus($rfqId, $vendorName, $extraNote)
    {
        $statusNote = $extraNote
            ? " with an extra note stating: $extraNote"
            : "";

        $newNote = date('d/m/Y') . ' ' . Auth::user()->first_name . ' ' . Auth::user()->last_name .
            " Sent Request for Quotation to $vendorName$statusNote and changed the status to Awaiting Pricing";

        DB::table('client_rfqs')->where(['rfq_id' => $rfqId])->update([
            'note' => $newNote,
            'status' => 'Awaiting Pricing'
        ]);
    }

    private function cleanupFiles($pdfPath, $attachments)
    {
        if (file_exists($pdfPath)) {
            unlink($pdfPath);
        }

        foreach ($attachments as $attachment) {
            if (file_exists($attachment['path'])) {
                unlink($attachment['path']);
            }
        }
    }
}
