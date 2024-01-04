<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Employers extends Model
{
    use SoftDeletes;
    use Notifiable;


    protected $table = 'employers';
    public $primaryKey = 'employee_id';
    protected $guard_name = 'web';
    protected $fillable = [
        'email', 'full_name', 'company_id'
    ];


    public function getEmailAttribute($value)
    {
        return $value;
    }
    public function setEmailAttribute($value)
    {
        return $this->attributes['email'] = $value;
    }

    public function getFullNameAttribute($value)
    {
        return $value;
    }
    public function setFirstNameAttribute($value)
    {
        return $this->attributes['full_name'] = $value;
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y');
    }

    public function getDeletedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y');
    }

    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y');
    }

    public function rfq(){
        return $this->hasMany('App\ClientRfq','rfq_id', 'client_id');
    }

    public function po(){
        return $this->hasMany('App\ClientPo','po_id', 'client_id');
    }

    public function company()
    {
        return $this->belongsTo('App\Companies', 'company_id');
    }

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

}
