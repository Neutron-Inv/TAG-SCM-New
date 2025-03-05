<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\PricingHistory;
use App\MailTray;
use Webklex\IMAP\Facades\Client;
use Illuminate\Support\Facades\Log;

class CheckNewEmails extends Command
{
    protected $signature = 'emails:check';
    protected $description = 'Check new emails for each PricingHistory entry and store in MailTray';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Retrieve all rows from PricingHistory
        $pricingHistories = PricingHistory::all();
        Log::info("Pricing Histories Found: {$pricingHistories}");
        foreach ($pricingHistories as $pricingHistory) {
            Log::info("Entry: {$pricingHistory->mail_id}, RFQ Code: {$pricingHistory->rfq_code}");
            $rfq_id = $pricingHistory->rfq_id;
            $vendor_id = $pricingHistory->vendor_id;
            $contact_id = $pricingHistory->contact_id;
            $mail_id = $pricingHistory->mail_id;
            $rfq_code = $pricingHistory->rfq_code;

            // Connect to the IMAP client and search for emails matching the rfq_code
            $client = Client::account('default');
            $folder = $client->getFolder('INBOX');
            foreach ($folder->query()->unseen()->subject($mail_id)->get() as $email) {
                Log::info("Subject: {$email->getSubject()}");
            }
            $emails = $folder->query()->unseen()->subject($mail_id)->setFetchFlags(false)->markAsRead()->get();
            Log::info("mail Id: {$mail_id}");
            Log::info("Emails: {$emails}");
            
            foreach ($emails as $email) {
                $subject = $email->getSubject()[0];
                $body = $email->getHTMLBody(true);
                $from = $email->getFrom()[0]->mail;
                $date = date("Y-m-d H:i:s", $email->getDate()[0]->timestamp);
                
                // Get all Cc email addresses and convert them to JSON
                $ccEmails = [];

                $num = 0;

                while (isset($email->getCc()[$num]) && !empty($email->getCc()[$num]->mail)) {
                    $ccEmails[] = $email->getCc()[$num]->mail;
                    $num++;
                }
                $ccEmailsJson = json_encode($ccEmails);

                // Create or update MailTray entry
                MailTray::create(
                    [
                        'rfq_id' => $rfq_id,
                        'vendor_id' => $vendor_id,
                        'contact_id' => $contact_id,
                        'mail_id' => $mail_id,
                        'subject' => $subject,
                        'body' => $body,
                        'sent_from' => $from,
                        'recipient_email' => $email->getTo()[0]->mail,
                        'cc_email' => $ccEmailsJson ?? null,
                        'date_received' => $date,
                    ]
                );

                Log::info("New email logged for RFQ ID: {$rfq_id}, Vendor ID: {$vendor_id}, Contact ID: {$contact_id}");
            }
        }

        $this->info("Checked and logged emails for all PricingHistory entries.");
    }
}
