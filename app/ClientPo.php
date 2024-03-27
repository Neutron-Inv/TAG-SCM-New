<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientPo extends Model
{
    use SoftDeletes;

    protected $table = 'client_pos';
    public $primaryKey = 'po_id';
    protected $guard_name = 'web';
    protected $fillable = [

        'company_id', 'client_id', 'rfq_id', 'rfq_number', 'status', 'po_number', 'description', 'po_date', 'po_receipt_date', 'est_production_time', 
        'est_ddp_lead_time', 'delivery_due_date', 'est_delivery_date', 'delivery_location', 'delivery_terms', 'po_value_foreign', 'po_value_naira', 
        'payment_terms', 'employee_id', 'supplier_proforma_foreign', 'supplier_proforma_naira', 'shipping_cost', 'po_issued_to_supplier', 
        'payment_details_received', 'payment_made', 'payment_confirmed', 'work_order', 'shipment_initiated', 'shipment_arrived', 'docs_to_shipper', 
        'delivered_to_customer', 'delivery_note_submitted', 'customer_paid', 'payment_due', 'note', 'status_2', 'ex_works_date', 'transport_mode', 
        'shipping_reliability', 'shipping_on_time_delivery', 'shipping_pricing', 'shipping_communication', 'shipping_rater', 'shipping_comment', 
        'shipping_overall_rating', 'survey_sent', 'survey_sent_date', 'survey_completed', 'survey_completion_date', 'contact_id', 
        'tag_comment', 'supplier_ref_number', 'actual_delivery_date', 'timely_delivery', 'shipper_id',

        'delivery', 'technical_notes', 'hs_codes', 'total_packaged_weight', 'estimated_packaged_dimensions', 
        'hs_codes_po', 'delivery_location_po', 'port_of_discharge', 'payment_terms_client', 'freight_charges_suplier', 'schedule'

    ];

    public function getStatus2Attribute($value)
    {
        return $value;
    }

    public function setStatus2Attribute($value)
    {
        return $this->attributes['status_2'] = $value;
    }


    public function getCompanyIdAttribute($value)
    {
        return $value;
    }

    public function setCompanyIdAttribute($value)
    {
        return $this->attributes['company_id'] = $value;
    }

    public function getClientIdAttribute($value)
    {
        return $value;
    }

    public function setClientIdAttribute($value)
    {
        return $this->attributes['client_id'] = $value;
    }

    public function getRfqIdAttribute($value)
    {
        return $value;
    }

    public function setRfqIdAttribute($value)
    {
        return $this->attributes['rfq_id'] = $value;
    }

    public function getRfqNumberAttribute($value)
    {
        return $value;
    }

    public function setRfqNumberAttribute($value)
    {
        return $this->attributes['rfq_number'] = $value;
    }

    public function getPoNumberAttribute($value)
    {
        return $value;
    }

    public function setPoNumberAttribute($value)
    {
        return $this->attributes['po_number'] = $value;
    }

    public function getDescriptionAttribute($value)
    {
        return $value;
    }

    public function setDescriptionAttribute($value)
    {
        return $this->attributes['description'] = $value;
    }

    public function getPoDateAttribute($value)
    {
        return $value;
    }

    public function setPoDateAttribute($value)
    {
        return $this->attributes['po_date'] = $value;
    }

    public function getPoReceiptDateAttribute($value)
    {
        return $value;
    }

    public function setPoReceiptDateAttribute($value)
    {
        return $this->attributes['po_receipt_date'] = $value;
    }

    public function getEstProductionTimeAttribute($value)
    {
        return $value;
    }

    public function setEstProductionTimeAttribute($value)
    {
        return $this->attributes['est_production_time'] = $value;
    }

    public function getEstDdpLeadTimeAttribute($value)
    {
        return $value;
    }

    public function setEstDdpLeadTimeAttribute($value)
    {
        return $this->attributes['est_ddp_lead_time'] = $value;
    }

    public function getDeliveryDueDateAttribute($value)
    {
        return $value;
    }

    public function setDeliveryDueDateAttribute($value)
    {
        return $this->attributes['delivery_due_date'] = $value;
    }

    public function getEstDeliveryDateAttribute($value)
    {
        return $value;
    }

    public function setEstDeliveryDateAttribute($value)
    {
        return $this->attributes['est_delivery_date'] = $value;
    }

    public function getDeliveryLocationAttribute($value)
    {
        return $value;
    }

    public function setDeliveryLocationAttribute($value)
    {
        return $this->attributes['delivery_location'] = $value;
    }

    public function getDeliveryTermsAttribute($value)
    {
        return $value;
    }

    public function setDeliveryTermsAttribute($value)
    {
        return $this->attributes['delivery_terms'] = $value;
    }

    public function getPoValueForeignAttribute($value)
    {
        return $value;
    }

    public function setPoValueForeignAttribute($value)
    {
        return $this->attributes['po_value_foreign'] = $value;
    }

    public function getPoValueNairaAttribute($value)
    {
        return $value;
    }

    public function setPoValueNairaAttribute($value)
    {
        return $this->attributes['po_value_naira'] = $value;
    }

    public function getPaymentTermsAttribute($value)
    {
        return $value;
    }

    public function setPaymentTermsAttribute($value)
    {
        return $this->attributes['payment_terms'] = $value;
    }

    public function getContactIdAttribute($value)
    {
        return $value;
    }

    public function setContactIdAttribute($value)
    {
        return $this->attributes['contact_id'] = $value;
    }

    public function getSupplierProformaForeignAttribute($value)
    {
        return $value;
    }

    public function setSupplierProformaForignAttribute($value)
    {
        return $this->attributes['supplier_proforma_foreign'] = $value;
    }

    public function getSupplierProformaNairaAttribute($value)
    {
        return $value;
    }

    public function setSupplierProformaNairaAttribute($value)
    {
        return $this->attributes['supplier_proforma_naira'] = $value;
    }

    public function getShippingCostAttribute($value)
    {
        return $value;
    }

    public function setShippingCostAttribute($value)
    {
        return $this->attributes['shipping_cost'] = $value;
    }

    public function getPoIssuesToSupplierAttribute($value)
    {
        return $value;
    }

    public function setPoIssuesToSupplierAttribute($value)
    {
        return $this->attributes['po_issued_to_supplier'] = $value;
    }

    public function getPaymentDetailsReceivedAttribute($value)
    {
        return $value;
    }

    public function setPaymentDetailsReceivedAttribute($value)
    {
        return $this->attributes['payment_details_received'] = $value;
    }

    public function getPaymentMadeAttribute($value)
    {
        return $value;
    }

    public function setPaymentMadeAttribute($value)
    {
        return $this->attributes['payment_made'] = $value;
    }

    public function getPaymentConfirmedAttribute($value)
    {
        return $value;
    }

    public function setPaymentConfirmedAttribute($value)
    {
        return $this->attributes['payment_confirmed'] = $value;
    }

    public function getWorkOrderAttribute($value)
    {
        return $value;
    }

    public function setWorkOrderAttribute($value)
    {
        return $this->attributes['work_order'] = $value;
    }

    public function getShipmentInitiatedAttribute($value)
    {
        return $value;
    }

    public function setShipmentInitiatedAttribute($value)
    {
        return $this->attributes['shipment_initiated'] = $value;
    }

    public function getShipmentArrivedAttribute($value)
    {
        return $value;
    }

    public function setShipmentArrivedAttribute($value)
    {
        return $this->attributes['shipment_arrived'] = $value;
    }

    public function getDocsToShipperAttribute($value)
    {
        return $value;
    }

    public function setDocsToShipperAttribute($value)
    {
        return $this->attributes['docs_to_shipper'] = $value;
    }

    public function getDeliveredToCustomerAttribute($value)
    {
        return $value;
    }

    public function setDeliveredToCustomerAttribute($value)
    {
        return $this->attributes['delivered_to_customer'] = $value;
    }

    public function getDeliveryNoteSubmittedAttribute($value)
    {
        return $value;
    }

    public function setDeliveryNoteSubmittedAttribute($value)
    {
        return $this->attributes['delivery_note_submitted'] = $value;
    }

    public function getCustomerPaidAttribute($value)
    {
        return $value;
    }

    public function setCustomerPaidAttribute($value)
    {
        return $this->attributes['customer_paid'] = $value;
    }

    public function getPaymentDueAttribute($value)
    {
        return $value;
    }

    public function setPaymentDueAttribute($value)
    {
        return $this->attributes['payment_due'] = $value;
    }

    public function getNoteAttribute($value)
    {
        return $value;
    }

    public function setNoteAttribute($value)
    {
        return $this->attributes['note'] = $value;
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y h:i:s');
    }

    public function getDeletedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y h:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y h:i:s');
    }

    public function client()
    {
        return $this->belongsTo('App\Clients', 'client_id');
    }

    public function contact()
    {
        return $this->belongsTo('App\ClientContact', 'contact_id');
    }

    public function shipper()
    {
        return $this->belongsTo('App\Shippers', 'shipper_id');
    }

    public function rfq(){
        return $this->belongsTo('App\ClientRfq','rfq_id');
    }

    // public function rfqs(){
    //     return $this->belongsTo(ClientRfq::class);
    // }


}
