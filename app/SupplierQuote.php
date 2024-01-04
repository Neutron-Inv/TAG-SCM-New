<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class SupplierQuote extends Model
{
    use SoftDeletes;

    protected $table = 'supplier_quotes';
    public $primaryKey = 'supplier_quote_id';
    protected $guard_name = 'web';
    protected $fillable = [
        'rfq_id', 'vendor_id', 'status', 'line_id', 'price', 'quantity', 'weight', 'dimension', 'note', 'oversize', 'currency', 'location'
    ];


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

    public function rfq(){
        return $this->belongsTo('App\ClientRfq','rfq_id');
    }

    public function vendor(){
        return $this->belongsTo('App\Vendors','vendor_id');
    }
    public function line(){
        return $this->belongsTo('App\LineItem','line_id');
    }

}
