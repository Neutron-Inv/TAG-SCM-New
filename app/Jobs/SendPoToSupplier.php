<?php

namespace App\Jobs;

use App\Mail\SupplierPO;
use App\Services\PoService;
use Illuminate\Bus\Queueable;
use PDF;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendPoToSupplier implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function handle()
    {
        try {
            \Log::info("Job started with data: ");

            // Generate PDF
            $pdf = PDF::loadView('dashboard.printing.supplierPO', [
                'rfq' => $this->data['rfq'],
                'line_items' => $this->data['line_items'],
                'vendor' => $this->data['vendor'],
                'vendor_contact' => $this->data['vendor_contact'],
                'pricing' => $this->data['pricing']
            ])->setPaper('a4', 'portrait');
            $tempFilePath = storage_path($this->data['rfqcode'] . '.pdf');
            $pdf->save($tempFilePath);
            $this->data['tempFilePath'] = $tempFilePath;
            $tempFileDirs = $this->data['tempFileDirs'];
            // Prepare CC recipients
            $users = [];
            foreach ($this->data['report_recipient'] as $recipient) {
                $users[] = (object) [
                    'email' => $recipient,
                    'name' => ucwords(str_replace('.', ' ', explode('@', $recipient)[0]))
                ];
            }

            // Log recipients for verification
            \Log::info("Recipients: ", $users);

            // Send mail
            Mail::to($this->data['vendor_contact']->email)
                ->cc($users)
                ->send(new SupplierPO($this->data));

            // Cleanup
            unlink($tempFilePath);
            \Log::info("Temporary file deleted: " . $tempFilePath);

            if (!empty($tempFileDirs)) {
                foreach ($tempFileDirs as $filePath) {
                    if (file_exists($filePath)) {
                        unlink($filePath);
                        \Log::info("Additional temporary file deleted: " . $filePath);
                    }
                }
            }
            \Log::info("Job completed successfully.");
        } catch (\Exception $e) {
            \Log::error("Error processing PO submission: " . $e->getMessage());
            \Log::error("Trace: " . $e->getTraceAsString());
        }
    }
}
