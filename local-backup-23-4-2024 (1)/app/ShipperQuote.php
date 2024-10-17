<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ShipperQuote extends Model
{
    use SoftDeletes;

    protected $table = 'shipper_quotes';
    public $primaryKey = 'quote_id';
    protected $guard_name = 'web';
    protected $fillable = [
        'rfq_id', 'shipper_id', 'soncap_charges', 'customs_duty', 'clearing_and_documentation', 'trucking_cost','status', 'bmi_charges', 
        'mode', 'currency'
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

    public function shipper(){
        return $this->belongsTo('App\Shippers','shipper_id');
    }

}
