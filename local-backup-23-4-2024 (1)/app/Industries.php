<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Industries extends Model
{
    use SoftDeletes;
    protected $table = 'industries';
    protected $primaryKey = 'industry_id';
    protected $fillable = [
        'industry_name'
    ];

    public function getIndustryNameAttribute($value)
    {
        return ($value);
    }

    public function setIndustryameAttribute($value)
    {
        return $this->attributes['industry_name'] = ($value);
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

    public function company(){
        return $this->hasMany('App\Companies','industry_id', 'company_id');
    }

    public function vendor(){
        return $this->hasMany('App\Vendors','company_id', 'vendor_id');
    }



}
