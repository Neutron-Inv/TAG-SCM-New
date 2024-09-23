<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Vendors extends Model
{

    use SoftDeletes;

    protected $table = 'vendors';
    public $primaryKey = 'vendor_id';
    protected $guard_name = 'web';
    protected $fillable = [
        'company_id', 'vendor_name', 'industry_id',  'contact_name', 'country_code', 'contact_phone', 'contact_email', 'address',
        'description', 'tamap', 'vendor_code'
    ];

    public function getTamapAttribute($value)
    {
        return $value;
    }

    public function setTamapAttribute($value)
    {
        return $this->attributes['tamap'] = $value;
    }



    public function getCompanyIdAttribute($value)
    {
        return $value;
    }

    public function setCompanyIdAttribute($value)
    {
        return $this->attributes['company_id'] = $value;
    }

    public function getIndustryIdAttribute($value)
    {
        return $value;
    }

    public function setIndustryIdAttribute($value)
    {
        return $this->attributes['industry_id'] = $value;
    }


    public function getShipperNameAttribute($value)
    {
        return $value;
    }

    public function setVendorNameAttribute($value)
    {
        return $this->attributes['vendor_name'] = $value;
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

    public function getDescriptionAttribute($value)
    {
        return $value;
    }

    public function setDescriptionAttribute($value)
    {
        return $this->attributes['description'] = $value;
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

    public function industry()
    {
        return $this->belongsTo('App\Industries', 'industry_id');
    }

    public function lineItem(){
        return $this->hasMany('App\LineItem','line_id', 'vendor_id');
    }


    public function client_rfq(){
        return $this->hasMany('App\ClientRfq','rfq_id', 'vendor_id');
    }
}
