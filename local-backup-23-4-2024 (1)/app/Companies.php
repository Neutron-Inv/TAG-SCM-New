<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Companies extends Model
{

    use SoftDeletes;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'companies';
    public $primaryKey = 'company_id';
    protected $guard_name = 'web';
    protected $fillable = [
        'status', 'industry_id', 'company_name', 'company_code', 'address', 'lgaId', 'contact', 'contact_phone',
        'contact_email', 'phone', 'email', 'webadd', 'company_description', 'no_agents', 'no_cust', 'inactive',
        'activation_count', 'status_dt', 'lang_yr', 'servplan_allowed'
    ];

    public function getServplanAllowedAttribute($value)
    {
        return $value;
    }

    public function setServplanAllowedAttribute($value)
    {
        return $this->attributes['servplan_allowed'] = $value;
    }

    public function getLangYrAttribute($value)
    {
        return $value;
    }

    public function setLangYrAttribute($value)
    {
        return $this->attributes['lang_yr'] = $value;
    }

    public function getStatusDtAttribute($value)
    {
        return $value;
    }

    public function setStatusDtAttribute($value)
    {
        return $this->attributes['status_dt'] = $value;
    }

    public function getActivationCountAttribute($value)
    {
        return $value;
    }

    public function setActivationsCountAttribute($value)
    {
        return $this->attributes['account_count'] = $value;
    }

    public function getInactiveAttribute($value)
    {
        return $value;
    }

    public function setInactiveAttribute($value)
    {
        return $this->attributes['inactive'] = $value;
    }

    public function getNoCustAttribute($value)
    {
        return $value;
    }

    public function setNoCustAttribute($value)
    {
        return $this->attributes['no_cust'] = $value;
    }

    public function getNoAgentsAttribute($value)
    {
        return $value;
    }

    public function setNoAgentsAttribute($value)
    {
        return $this->attributes['no_agents'] = $value;
    }

    public function getCompanyDescriptionAttribute($value)
    {
        return $value;
    }

    public function setCompanyDescriptionAttribute($value)
    {
        return $this->attributes['company_description'] = $value;
    }

    public function getWebaddAttribute($value)
    {
        return $value;
    }

    public function setWebaddAttribute($value)
    {
        return $this->attributes['webadd'] = $value;
    }

    public function getEmailAttribute($value)
    {
        return $value;
    }

    public function setEmailAttribute($value)
    {
        return $this->attributes['email'] = $value;
    }

    public function getPhoneAttribute($value)
    {
        return $value;
    }

    public function setPhoneAttribute($value)
    {
        return $this->attributes['phone'] = $value;
    }

    public function getContactEmailAttribute($value)
    {
        return $value;
    }

    public function setContactEmailAttribute($value)
    {
        return $this->attributes['contact_email'] = $value;
    }

    public function getContactPhonbAttribute($value)
    {
        return $value;
    }

    public function setContactPhoneAttribute($value)
    {
        return $this->attributes['contact_phone'] = $value;
    }

    public function getContactAttribute($value)
    {
        return $value;
    }

    public function setContactAttribute($value)
    {
        return $this->attributes['contact'] = $value;
    }

    public function getLgaIdAttribute($value)
    {
        return $value;
    }

    public function setLgaIdAttribute($value)
    {
        return $this->attributes['lgaId'] = $value;
    }

    public function getAddressAttribute($value)
    {
        return $value;
    }

    public function setAddressAttribute($value)
    {
        return $this->attributes['address'] = $value;
    }

    public function getCompanyCodeAttribute($value)
    {
        return $value;
    }

    public function setCompanyCodeAttribute($value)
    {
        return $this->attributes['company_code'] = $value;
    }

    public function getStatusAttribute($value)
    {
        return $value;
    }

    public function setStatusAttribute($value)
    {
        return $this->attributes['status'] = $value;
    }

    public function getIndustryIdAttribute($value)
    {
        return $value;
    }

    public function setIndustryIdAttribute($value)
    {
        return $this->attributes['industry_id'] = $value;
    }

    public function getCompanyNameAttribute($value)
    {
        return $value;
    }

    public function setCompanyNameAttribute($value)
    {
        return $this->attributes['company_name'] = $value;
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

    public function industry()
    {
        return $this->belongsTo('App\Industries', 'industry_id');
    }

    public function clients(){
        return $this->hasMany('App\Clients','client_id', 'company_id');
    }

    public function shipper(){
        return $this->hasMany('App\Shippers','shipper_id', 'company_id');
    }

    public function employee(){
        return $this->hasMany('App\Employers','employee_id', 'company_id');
    }

    public function rfq(){
        return $this->hasMany('App\ClientRfq','rfq_id', 'company_id');
    }

    public function issues(){
        return $this->hasMany(Issue::class);
    }

}
