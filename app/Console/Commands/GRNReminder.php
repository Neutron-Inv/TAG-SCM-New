<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\GRNEnquiryRequest;
use App\ClientPo;
use App\ClientRfq;
use App\ClientContact;
use App\Employers;
use App\Automation;
use Illuminate\Support\Facades\Log;
class GRNReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:GRNReminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron Job to remind Buyers to forward GRNs after Delivery';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $contact_email="";
        Log::info('GRNReminder command started.');
        // Fetch the RFQ
        $pos = ClientPo::whereIn('status', ['Delivered', 'Awaiting GRN'])
               ->whereYear('actual_delivery_date', now()->year)
               ->get();

        if (!$pos) {
            Log::info('RFQ not found');
            $this->error('RFQ not found.');
            return;
        }
        Log::info('Found '.count($pos));
        foreach($pos as $po){
            Log::info('Started Process for PO'.$po->po_id);
            $automation_check = Automation::where('po_id',$po->po_id)
                                ->where('type', 'GRN Reminder')
                                ->latest('created_at')
                                ->first();
            if(!$automation_check && Carbon::parse($po->actual_delivery_date)->diffInDays(Carbon::now()) >= 3){
                Log::info($po->po_id.' Automation checked and hasnt had its GRN Reminder Sent');
                $rfq = ClientRfq::where('rfq_id',$po->rfq_id)->first();
                $cli_title = clis($po->client_id);
                $contact_email = ClientContact::where('contact_id', $po->contact_id)
                ->value('email');
                $resultt = json_decode($cli_title, true);
                $client_name = $resultt[0]['client_name'];
                $assigned_details = empDetails($po->employee_id);
                $assigned = $assigned_details->full_name;
                $rfqcode = "TE-". $resultt[0]['short_code'] . '-RFQ' . preg_replace('/[^0-9]/', '', $rfq->refrence_no);

                $rec_mail = $contact_email;
                //$rec_mail = 'emmanuel.idowu@tagenergygroup.net';
                $cc_mail = 'sales@tagenergygroup.net';
                //$cc_mail = 'emmanuel@enabledgroup.net';
                $employee = Employers::where('employee_id', $rfq->employee_id)->first();
                //$bcc_mail = $employee->email;
                
                $bcc_mail = [
                    $employee->email,
                    'emmanuel@enabledgroup.net',
                ];

                try {
                    $data = [
                        "po_no" => $po->po_number,
                        "client_name" => $client_name,
                        "reference_no" => $rfqcode,
                        "description" => $rfq->description,
                        "assigned" => $assigned,
                        "type" => "Reminder"

                    ];
                    
                    $description = "Sent a GRN Reminder to ".$client_name." for PO ".$po->po_number." ".$rfqcode;

                    Mail::to($rec_mail)
                        ->cc($cc_mail)
                        ->bcc($bcc_mail)
                        ->send(new GRNEnquiryRequest($data));
                    
                    // Mail::to($rec_mail)
                    //     ->cc($cc_mail)
                    //     ->send(new GRNEnquiryRequest($data));
                    
                    Log::info($po->po_id.' Email Sent');

                    Automation::create([
                        'company_id' => $po->company_id,
                        'rfq_id' => $rfq->rfq_id,
                        'po_id' => $po->po_id,
                        'type' => 'GRN Reminder',
                        'description' => $description
                    ]);
                    
                    Log::info($po->po_id.' Automation Created');
                    
                    $this->info('Email Sent Successfully');
                } catch (\Exception $e) {
                    Log::info($po->po_id."Email not sent: " . $e->getMessage());
                    $this->error("Email not sent: " . $e->getMessage());
                }
            }elseif($automation_check->created_at->diffInDays(Carbon::now()) >= 14){
                // Log::info('GRNReminder last sent reminder more than 14days');
                $rfq = ClientRfq::where('rfq_id',$po->rfq_id)->first();
                $cli_title = clis($po->client_id);
                $resultt = json_decode($cli_title, true);
                $client_name = $resultt[0]['client_name'];
                $contact_email = ClientContact::where('contact_id', $po->contact_id)
                ->value('email');
                $assigned_details = empDetails($po->employee_id);
                $assigned = $assigned_details->full_name;
                $rfqcode = "TE-". $resultt[0]['short_code'] . '-RFQ' . preg_replace('/[^0-9]/', '', $rfq->refrence_no);

                $rec_mail = $contact_email;
                //$rec_mail = 'emmanuel.idowu@tagenergygroup.net';
                $cc_mail = 'sales@tagenergygroup.net';
                //$cc_mail = 'emmanuel@enabledgroup.net';
                $employee = Employers::where('employee_id', $rfq->employee_id)->first();
                // $bcc_mail = $employee->email;
                
                $bcc_mail = [
                    $employee->email,
                    'emmanuel@enabledgroup.net',
                ];

                try {
                    $data = [
                        "po_no" => $po->po_number,
                        "client_name" => $client_name,
                        "reference_no" => $rfqcode,
                        "description" => $rfq->description,
                        "assigned" => $assigned,
                        "type" => "14-Day Follow-up"

                    ];
                    
                    $description = "Sent a 14-day GRN Reminder to ".$assigned." for PO ".$po->po_number." ".$rfqcode;

                    Mail::to($rec_mail)
                        ->cc($cc_mail)
                        ->bcc($bcc_mail)
                        ->send(new GRNEnquiryRequest($data));
                    
                    // Mail::to($rec_mail)
                    //     ->cc($cc_mail)
                    //     ->send(new GRNEnquiryRequest($data));
                    
                    Log::info($po->po_id.' Email Sent');

                    Automation::create([
                        'company_id' => $po->company_id,
                        'rfq_id' => $rfq->rfq_id,
                        'po_id' => $po->po_id,
                        'type' => '14-days GRN Reminder',
                        'description' => $description
                    ]);
                    
                    Log::info($po->po_id.' Automation Created');
                    
                    $this->info('Email Sent Successfully');
                } catch (\Exception $e) {
                    Log::info($po->po_id."Email not sent: " . $e->getMessage());
                    $this->error("Email not sent: " . $e->getMessage());
                }
                
            }
            
            Log::info($contact_email.' PO '.$po->po_number.' GRN Days Difference - '.$automation_check->created_at->diffInDays(Carbon::now()).' then diff in days of Delivery date till now'.$po->Actual_delivery_date->diffInDays(Carbon::now()));
            Log::info('GRNReminder command completed.');
    }
}
}