<?php

namespace App\Listeners;

use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Log;
use App\Mail\SupplierPO;

class CleanupTempFilesAfterMailSent
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Mail\Events\MessageSent  $event
     * @return void
     */
    public function handle(MessageSent $event)
    {
        $mailable = $event->data;

        // Check if the mailable is of the type we care about
        if ($mailable instanceof SupplierPO) {
            $tempFilePath = $mailable->tempFilePath ?? null;
            $tempFileDirs = $mailable->tempFileDirs ?? [];

            Log::info("Cleanup listener triggered for SupplierPO.");

            // Delete the primary file if it exists
            if (!empty($tempFilePath) && file_exists($tempFilePath)) {
                unlink($tempFilePath);
                Log::info("Temporary PDF file deleted: " . $tempFilePath);
            }

            // Delete additional files if they exist
            foreach ($tempFileDirs as $filePath) {
                if (!empty($filePath) && file_exists($filePath)) {
                    unlink($filePath);
                    Log::info("Additional temporary file deleted: " . $filePath);
                }
            }
        }
    }
}
