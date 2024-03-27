<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ClientRfq extends Model
{
    use SoftDeletes;

    protected $table = 'client_rfqs';
    public $primaryKey = 'rfq_id';
    protected $guard_name = 'web';
    protected $fillable = [
        'company_id', 'client_id', 'employee_id', 'refrence_no', 'rfq_date', 'rfq_number', 'description', 'product', 'is_lumpsum', 'lumpsum', 'value_of_quote_usd', 'value_of_quote_ngn',
        'contract_po_value_usd', 'total_quote','incoterm', 'percent_margin','percent_net', 'supplier_quote_usd', 'freight_charges', 'local_delivery', 'fund_transfer', 'cost_of_funds', 'wht', 'ncd',
        'other_cost', 'net_value', 'net_percentage', 'total_weight', 'contact_id', 'shipper_id', 'delivery_due_date', 'note', 'status', 'rfq_acknowledge', 'shipper_mail',
        'shipper_submission_date', 'transport_mode', 'estimated_package_weight', 'estimated_package_dimension', 'hs_codes', 'certificates_offered', 'estimated_delivery_time',
        'delivery_location','payment_term', 'validity', 'technical_note', 'vendor_id', 'oversized', 'percent_supplier','intrest_rate', 'duration', 'percent_supplier_1','intrest_rate_1', 'duration_1', 'percent_supplier_2','intrest_rate_2', 'duration_2', 'percent_logistics','intrest_logistics', 'duration_logistics', 'percent_logistics_1','intrest_logistics_1', 'duration_logistics_1', 'percent_logistics_2','intrest_logistics_2', 'duration_logistics_2',
        'misc_cost_supplier','misc_cost_logistics','online_submission', 'currency', 'fund_transfer_charge', 'vat_transfer_charge', 'offshore_charges', 'swift_charges', 'send_image', 
        'contract_po_value_ngn', 'shipper_currency', 'freight_cost_option', 'end_user', 'clearing_agent', 'short_code', 'mark_up', 'auto_calculate','ncd_others'
    ];

    public function getRfqDateAttribute($value)
    {
        return $value;
    }

    public function setRfqDateAttribute($value)
    {
        return $this->attributes['rfq_date'] = $value;
    }

    public function getVendorIdAttribute($value)
    {
        return $value;
    }

    public function setVendorIdAttribute($value)
    {
        return $this->attributes['vendor_id'] = $value;
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

    public function getEmployeeIdAttribute($value)
    {
        return $value;
    }

    public function setEmployeeIdAttribute($value)
    {
        return $this->attributes['employee_id'] = $value;
    }

    public function getRefrenceNoAttribute($value)
    {
        return $value;
    }

    public function setRefrenceNoAttribute($value)
    {
        return $this->attributes['refrence_no'] = $value;
    }

    public function getRfqNumberAttribute($value)
    {
        return $value;
    }

    public function setRfqNumberAttribute($value)
    {
        return $this->attributes['rfq_number'] = $value;
    }

    public function getDesriptionAttribute($value)
    {
        return $value;
    }

    public function setDescriptionAttribute($value)
    {
        return $this->attributes['description'] = $value;
    }

    public function getProductAttribute($value)
    {
        return $value;
    }

    public function setProductAttribute($value)
    {
        return $this->attributes['product'] = $value;
    }

    public function getValueOfQuoteUsdAttribute($value)
    {
        return $value;
    }

    public function setValueOfQuoteUsdAttribute($value)
    {
        return $this->attributes['value_of_quote_usd'] = $value;
    }

    public function getValueOfQuoteNgnAttribute($value)
    {
        return $value;
    }

    public function setValueOfQuoteNgnAttribute($value)
    {
        return $this->attributes['value_of_quote_ngn'] = $value;
    }


    public function getContractPoValueUsdAttribute($value)
    {
        return $value;
    }

    public function setContractPoValueUsdAttribute($value)
    {
        return $this->attributes['contract_po_value_usd'] = $value;
    }

    public function getContractPoValueNgnAttribute($value)
    {
        return $value;
    }

    public function setContractPoValueNgnAttribute($value)
    {
        return $this->attributes['contract_po_value_ngn'] = $value;
    }

    public function getSupplierQuoteAttribute($value)
    {
        return $value;
    }

    public function setSupplierQuoteAttribute($value)
    {
        return $this->attributes['supplier_quote'] = $value;
    }

    public function getFreightChargesAttribute($value)
    {
        return $value;
    }

    public function setFrightChargesAttribute($value)
    {
        return $this->attributes['fright_charges'] = $value;
    }

    public function getLocalDeliveryAttribute($value)
    {
        return $value;
    }

    public function setLocalDeliveryAttribute($value)
    {
        return $this->attributes['local_delivery'] = $value;
    }

    public function getFundTransferAttribute($value)
    {
        return $value;
    }

    public function setFundTransferAttribute($value)
    {
        return $this->attributes['fund_transfer'] = $value;
    }

    public function getCostOfFundsAttribute($value)
    {
        return $value;
    }

    public function setCostOfFundsAttribute($value)
    {
        return $this->attributes['cost_of_funds'] = $value;
    }

    public function getWhtAttribute($value)
    {
        return $value;
    }

    public function setWhtAttribute($value)
    {
        return $this->attributes['wht'] = $value;
    }

    public function getNcdAttribute($value)
    {
        return $value;
    }

    public function setNcdAttribute($value)
    {
        return $this->attributes['ncd'] = $value;
    }

    public function getOtherCostAttribute($value)
    {
        return $value;
    }

    public function setOtherCostAttribute($value)
    {
        return $this->attributes['other_cost'] = $value;
    }

    public function getNetValueAttribute($value)
    {
        return $value;
    }

    public function setNetValueAttribute($value)
    {
        return $this->attributes['net_value'] = $value;
    }

    public function getNetPercentageAttribute($value)
    {
        return $value;
    }

    public function setNetPercentageAttribute($value)
    {
        return $this->attributes['net_percentage'] = $value;
    }

    public function getTotalWeightAttribute($value)
    {
        return $value;
    }

    public function setTotalWeightAttribute($value)
    {
        return $this->attributes['total_weight'] = $value;
    }

    public function getContactIdAttribute($value)
    {
        return $value;
    }

    public function setContactIdAttribute($value)
    {
        return $this->attributes['contact_id'] = $value;
    }

    public function getShipperIdAttribute($value)
    {
        return $value;
    }

    public function setShipperIdAttribute($value)
    {
        return $this->attributes['shipper_id'] = $value;
    }

    public function getDeliveryDueDateAttribute($value)
    {
        return $value;
    }

    public function setDeliveryDueDateAttribute($value)
    {
        return $this->attributes['delivery_due_date'] = $value;
    }

    public function getNoteAttribute($value)
    {
        return $value;
    }

    public function setNoteAttribute($value)
    {
        return $this->attributes['note'] = $value;
    }

    public function getStatusAttribute($value)
    {
        return $value;
    }

    public function setStatusAttribute($value)
    {
        return $this->attributes['status'] = $value;
    }

    public function getRfqAcknowledgeAttribute($value)
    {
        return $value;
    }

    public function setShipperMailAttribute($value)
    {
        return $this->attributes['shipper_mail'] = $value;
    }

    public function getShipperMailAttribute($value)
    {
        return $value;
    }

    public function setRfqAcknowledgeAttribute($value)
    {
        return $this->attributes['rfq_acknowledge'] = $value;
    }

    public function getTechnicalNoteAttribute($value)
    {
        return $value;
    }

    public function setTechnicalNoteAttribute($value)
    {
        return $this->attributes['technical_note'] = $value;
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

    public function employee()
    {
        return $this->belongsTo('App\Employers', 'employee_id');
    }

    public function contact()
    {
        return $this->belongsTo('App\ClientContact', 'contact_id');
    }

    public function shipper()
    {
        return $this->belongsTo('App\Shippers', 'shipper_id');
    }

    public function po(){
        return $this->hasMany('App\ClientPo','po_id', 'client_id');
    }

    public function lineItem(){
        return $this->hasMany('App\LineItem','line_id', 'vendor_id');
    }

    public function history(){
        return $this->hasMany('App\RfqHistory','rfq_id', 'history_id');
    }

    public function company()
    {
        return $this->belongsTo('App\Companies', 'company_id');
    }

    public function quote(){
        return $this->hasMany('App\ShipperQuote','quote_id', 'shipper_id');
    }

    public function assigned_to()
    {
        return $this->belongsTo('App\Employers', 'employee_id');
    }

    public function vendor()
    {
        return $this->belongsTo('App\Vendors', 'vendor_id');
    }
}
