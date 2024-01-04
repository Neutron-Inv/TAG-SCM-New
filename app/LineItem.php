<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class LineItem extends Model
{
    use SoftDeletes;

    protected $table = 'line_items';
    public $primaryKey = 'line_id';
    protected $guard_name = 'web';
    protected $fillable = [
        'client_id', 'rfq_id', 'item_serialno', 'item_name', 'item_number', 'vendor_id', 'uom', 'quantity', 'unit_price', 'total_price', 'unit_quote',
        'total_quote', 'unit_margin', 'total_margin', 'unit_frieght', 'total_frieght', 'unit_cost', 'total_cost', 'unit_cost_naira',
        'total_cost_naira', 'item_description', 'mesc_code'
    ];


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

    public function getItemNameAttribute($value)
    {
        return $value;
    }

    public function setItemNameAttribute($value)
    {
        return $this->attributes['item_name'] = $value;
    }

    public function getItemNumberAttribute($value)
    {
        return $value;
    }

    public function setItemNumberAttribute($value)
    {
        return $this->attributes['item_number'] = $value;
    }

    public function getVendorIdAttribute($value)
    {
        return $value;
    }

    public function setVendorIdAttribute($value)
    {
        return $this->attributes['vendor_id'] = $value;
    }

    public function getUomAttribute($value)
    {
        return $value;
    }

    public function setUomAttribute($value)
    {
        return $this->attributes['uom'] = $value;
    }

    public function getQuantityAttribute($value)
    {
        return $value;
    }

    public function setQuantityAttribute($value)
    {
        return $this->attributes['quantity'] = $value;
    }

    public function getUnitPriceAttribute($value)
    {
        return $value;
    }

    public function setUnitPriceAttribute($value)
    {
        return $this->attributes['unit_price'] = $value;
    }

    public function getTotalPriceAttribute($value)
    {
        return $value;
    }

    public function setTotalPriceAttribute($value)
    {
        return $this->attributes['total_price'] = $value;
    }

    public function getUnitQuoteAttribute($value)
    {
        return $value;
    }

    public function setUnitQuoteAttribute($value)
    {
        return $this->attributes['unit_quote'] = $value;
    }

    public function getTotalQuoteAttribute($value)
    {
        return $value;
    }

    public function setTotalQuoteAttribute($value)
    {
        return $this->attributes['total_quote'] = $value;
    }

    public function getUnitMarginAttribute($value)
    {
        return $value;
    }

    public function setUnitMarginAttribute($value)
    {
        return $this->attributes['unit_margin'] = $value;
    }

    public function getTotalMarginAttribute($value)
    {
        return $value;
    }

    public function setTotalMarginAttribute($value)
    {
        return $this->attributes['total_margin'] = $value;
    }

    public function getUnitFrieghtAttribute($value)
    {
        return $value;
    }

    public function setUnitFrieghtAttribute($value)
    {
        return $this->attributes['unit_frieght'] = $value;
    }

    public function getTotalFrieghtAttribute($value)
    {
        return $value;
    }

    public function setTotalFrieghtAttribute($value)
    {
        return $this->attributes['total_frieght'] = $value;
    }

    public function getUnitCostAttribute($value)
    {
        return $value;
    }

    public function setUnitCostAttribute($value)
    {
        return $this->attributes['unit_cost'] = $value;
    }

    public function getTotalCostAttribute($value)
    {
        return $value;
    }

    public function setTotalCostAttribute($value)
    {
        return $this->attributes['total_cost'] = $value;
    }

    public function getUnitCostNairaAttribute($value)
    {
        return $value;
    }

    public function setUnitCostNairaAttribute($value)
    {
        return $this->attributes['unit_cost_naira'] = $value;
    }

    public function getTotalCostNaiaAttribute($value)
    {
        return $value;
    }

    public function setTotalCostNairaAttribute($value)
    {
        return $this->attributes['total_cost_naira'] = $value;
    }

    public function getItemDescriptionAttribute($value)
    {
        return $value;
    }

    public function setItemDescriptionAttribute($value)
    {
        return $this->attributes['item_description'] = $value;
    }

    public function getMescCodeAttribute($value)
    {
        return $value;
    }

    public function setMescCodeAttribute($value)
    {
        return $this->attributes['mesc_code'] = $value;
    }

    public function vendor()
    {
        return $this->belongsTo('App\Vendors', 'vendor_id');
    }

    public function rfq()
    {
        return $this->belongsTo('App\ClientRfq', 'rfq_id');
    }

    public function client()
    {
        return $this->belongsTo('App\Clients', 'client_id');
    }

    public function supQuote(){
        return $this->hasMany('App\SupplierQuote','supplier_quote_id', 'line_id');
    }

}
