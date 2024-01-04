<?php

use Illuminate\Database\Seeder;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('scm_statuses')->insert([
        	[
                'name' => 'Received RFQ',
                'type' => 'RFQ',
            ],
        	[
                'name' => 'RFQ Acknowledged',
                'type' => 'RFQ',
            ],
        	[
                'name' => 'Awaiting Pricing',
                'type' => 'RFQ',
            ],
        	[
                'name' => 'Awaiting Shipping',
                'type' => 'RFQ',
            ],
        	[
                'name' => 'Awaiting Approval',
                'type' => 'RFQ',
            ],
        	[
                'name' => 'Approved',
                'type' => 'RFQ',
            ],
        	[
                'name' => 'Quotation Submitted',
                'type' => 'RFQ',
            ],
        	[
                'name' => 'No Bid',
                'type' => 'RFQ',
            ],
        	[
                'name' => 'Bid Closed',
                'type' => 'RFQ',
            ],
        	[
                'name' => 'PO Issued',
                'type' => 'RFQ',
            ],
        	[
                'name' => 'PO On Hold',
                'type' => 'PO',
            ],
        	[
                'name' => 'Declined',
                'type' => 'PO',
            ],
        	[
                'name' => 'PO Issued',
                'type' => 'PO',
            ],
        	[
                'name' => 'PO Acknowledged',
                'type' => 'PO',
            ],
        	[
                'name' => 'PO Analysis',
                'type' => 'PO',
            ],
        	[
                'name' => 'PO Issued to Supplier',
                'type' => 'PO',
            ],
        	[
                'name' => 'Awaiting Payments form TAG Accounts',
                'type' => 'PO',
            ],
        	[
                'name' => 'Production',
                'type' => 'PO',
            ],
        	[
                'name' => 'Awaiting Customer Feedback',
                'type' => 'PO',
            ],
        	[
                'name' => 'Awaiting Pre-shipment Inspection',
                'type' => 'PO',
            ],
        	[
                'name' => 'Undergoing Pre-shipment Inspection',
                'type' => 'PO',
            ],
        	[
                'name' => 'Processing Form M',
                'type' => 'PO',
            ],
        	[
                'name' => 'Pickup Initiated',
                'type' => 'PO',
            ],
        	[
                'name' => 'In Transit',
                'type' => 'PO',
            ],
        	[
                'name' => 'Processing PAAR',
                'type' => 'PO',
            ],
        	[
                'name' => 'Customs Clearing',
                'type' => 'PO',
            ],
        	[
                'name' => 'Delivering',
                'type' => 'PO',
            ],
        	[
                'name' => 'Delivered',
                'type' => 'PO',
            ],
        	[
                'name' => 'Partial Delivery',
                'type' => 'PO',
            ],
        	[
                'name' => 'Awaiting GRN',
                'type' => 'PO',
            ],
        	[
                'name' => 'Invoicing',
                'type' => 'PO',
            ],
        	[
                'name' => 'Invoiced',
                'type' => 'PO',
            ],
        	[
                'name' => 'Paid',
                'type' => 'PO',
            ],
        	[
                'name' => 'PO Cancelled',
                'type' => 'PO',
            ],
        ]);
    }
}
