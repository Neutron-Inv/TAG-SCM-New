<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ClientNote extends Model
{
    use SoftDeletes;
    protected $table = 'client_notes';
    public $primaryKey = 'id';
    protected $guard_name = 'web';
    protected $fillable = [
        'company_id', 'client_id', 'rfq_id', 'rfq_number', 'status', 'po_number', 'description', 'po_date', 'po_receipt_date', 'est_production_time',
        'est_ddp_lead_time', 'delivery_due_date', 'est_delivery_date', 'delivery_location',  'delivery_terms', 'po_value_foreign', 'po_value_naira',
        'payment_terms', 'contact_id', 'supplier_proforma_foreign', 'supplier_proforma_naira', 'shipping_cost', 'po_issued_to_supplier', 'payment_details_received',
        'payment_made', 'payment_confirmed', 'work_order', 'shipment_initiated', 'shipment_arrived', 'docs_to_shipper', 'delivered_to_customer',
        'delivery_note_submitted', 'customer_paid', 'payment_due', 'note', 'status_2'
    ];
}
