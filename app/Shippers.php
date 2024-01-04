<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
class Shippers extends Model
{
    use SoftDeletes;
    use Notifiable;
    protected $table = 'shippers';
    public $primaryKey = 'shipper_id';
    protected $guard_name = 'web';
    protected $fillable = [
        'company_id', 'shipper_name', 'address', 'contact_name', 'country_code', 'contact_phone', 'contact_email'
    ];

    public function getCompanyIdAttribute($value)
    {
        return $value;
    }

    public function setCompanyIdAttribute($value)
    {
        return $this->attributes['company_id'] = $value;
    }

    public function getShipperNameAttribute($value)
    {
        return $value;
    }

    public function setShipperNameAttribute($value)
    {
        return $this->attributes['shipper_name'] = $value;
    }

    public function getCountryCodeAttribute($value)
    {
        return $value;
    }

    public function setCountryCodeAttribute($value)
    {
        return $this->attributes['country_code'] = $value;
    }

    public function getAddressAttribute($value)
    {
        return $value;
    }

    public function setAddressAttribute($value)
    {
        return $this->attributes['address'] = $value;
    }

    public function getContactPhoneAttribute($value)
    {
        return $value;
    }

    public function setContactPhoneAttribute($value)
    {
        return $this->attributes['contact_phone'] = $value;
    }

    public function getContactNameAttribute($value)
    {
        return $value;
    }

    public function setContactNameAttribute($value)
    {
        return $this->attributes['contact_name'] = $value;
    }
    public function getContactEmailAttribute($value)
    {
        return $value;
    }

    public function setContactEmailAttribute($value)
    {
        return $this->attributes['contact_email'] = $value;
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

    public function company()
    {
        return $this->belongsTo('App\Companies', 'company_id');
    }

    public function rfq(){
        return $this->hasMany('App\ClientRfq','rfq_id', 'client_id');
    }

    public function quote(){
        return $this->hasMany('App\ShipperQuote','quote_id', 'shipper_id');
    }


}
