<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Clients extends Model
{

    use SoftDeletes;

    protected $table = 'clients';
    public $primaryKey = 'client_id';
    protected $guard_name = 'web';
    protected $fillable = [
        'company_id', 'client_name', 'address', 'state', 'city', 'country_code', 'phone', 'email', 'short_code', 'transfer', 'company_vendor_code',
        'login_url', 'vendor_username', 'vendor_password'
    ];

    public function getCompanyIdAttribute($value)
    {
        return $value;
    }

    public function setCompanyIdAttribute($value)
    {
        return $this->attributes['company_id'] = $value;
    }

    public function getClientNameAttribute($value)
    {
        return ucwords($value);
    }

    public function setClientNameAttribute($value)
    {
        return $this->attributes['client_name'] = ucwords($value);
    }

    public function getAddressAttribute($value)
    {
        return ucwords($value);
    }

    public function setAddressAttribute($value)
    {
        return $this->attributes['address'] = ucwords($value);
    }

    public function getStateAttribute($value)
    {
        return ucwords($value);
    }

    public function setStateAttribute($value)
    {
        return $this->attributes['state'] = $value;
    }

    public function getCityAttribute($value)
    {
        return $value;
    }

    public function setCityAttribute($value)
    {
        return $this->attributes['city'] = $value;
    }

    public function getCountryCodeAttribute($value)
    {
        return $value;
    }

    public function setCountryCodeAttribute($value)
    {
        return $this->attributes['country_code'] = $value;
    }

    public function getPhoneAttribute($value)
    {
        return $value;
    }

    public function setPhoneAttribute($value)
    {
        return $this->attributes['phone'] = $value;
    }

    public function getEmailAttribute($value)
    {
        return $value;
    }

    public function setEmailAttribute($value)
    {
        return $this->attributes['email'] = $value;
    }

    public function getShortCodeAttribute($value)
    {
        return $value;
    }

    public function setShortCodeAttribute($value)
    {
        return $this->attributes['short_code'] = strtoupper($value);
    }

    public function getTransferAttribute($value)
    {
        return $value;
    }

    public function setTransferAttribute($value)
    {
        return $this->attributes['transfer'] = $value;
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

    public function contact(){
        return $this->hasMany('App\ClientContact','contact_id', 'client_id');
    }

    public function rfq(){
        return $this->hasMany('App\ClientRfq','rfq_id', 'client_id');
    }

    public function po(){
        return $this->hasMany('App\ClientPo','po_id', 'client_id');
    }

    public function lineItem(){
        return $this->hasMany('App\LineItem','line_id', 'vendor_id');
    }

    public function report()
    {
        return $this->hasMany('App\ClientReports', 'report_id', 'client_id');
    }


}
