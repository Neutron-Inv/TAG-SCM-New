<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ClientContact extends Model
{
    use SoftDeletes;
    use Notifiable;

    protected $table = 'client_contacts';
    public $primaryKey = 'contact_id';
    protected $guard_name = 'web';
    protected $fillable = [
        'client_id', 'first_name', 'last_name','job_title', 'office_tel', 'mobile_tel',
        'email', 'email_other', 'address', 'state', 'city', 'country_code'
    ];

    public function getClientIdAttribute($value)
    {
        return $value;
    }
    public function setClientIdAttribute($value)
    {
        return $this->attributes['client_id'] = $value;
    }

    public function getFirstNameAttribute($value)
    {
        return $value;
    }
    public function setFirstNameAttribute($value)
    {
        return $this->attributes['first_name'] = $value;
    }

    public function getLastNameAttribute($value)
    {
        return $value;
    }
    public function setLastNameAttribute($value)
    {
        return $this->attributes['last_name'] = $value;
    }

    public function getJobTitleAttribute($value)
    {
        return $value;
    }

    public function setJobTitleAttribute($value)
    {
        return $this->attributes['job_title'] = $value;
    }

    public function getOfficeTelAttribute($value)
    {
        return $value;
    }

    public function setOfficeTelAttribute($value)
    {
        return $this->attributes['office_tel'] = $value;
    }

    public function getMobileTelAttribute($value)
    {
        return $value;
    }

    public function setMobileTelAttribute($value)
    {
        return $this->attributes['mobile_tel'] = $value;
    }

    public function getEmailAttribute($value)
    {
        return $value;
    }

    public function setEmailAttribute($value)
    {
        return $this->attributes['email'] = $value;
    }

    public function setEmailOtherAttribute($value)
    {
        return $this->attributes['email_other'] = $value;
    }

    public function getEmailOtherAttribute($value)
    {
        return $value;
    }

    public function getAddressAttribute($value)
    {
        return $value;
    }

    public function setAddressAttribute($value)
    {
        return $this->attributes['address'] = $value;
    }

    public function getStateAttribute($value)
    {
        return $value;
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

    public function rfq(){
        return $this->hasMany('App\ClientRfq','rfq_id', 'client_id');
    }

    public function rfqs(){
        return $this->hasMany('App\ClientRfq','rfq_id', 'contact_id');
    }

    public function po(){
        return $this->hasMany('App\ClientPo','po_id', 'client_id');
    }
}
