<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */



    protected $table = 'users';
    public $primaryKey = 'user_id';
    protected $guard_name = 'web';
    protected $fillable = [
       'phone_number', 'email', 'first_name', 'last_name', 'role','password', 'user_activation_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getPhoneNumberAttribute($value)
    {
        return $value;
    }

    public function setPhoneNumberAttribute($value)
    {
        return $this->attributes['phone_number'] = $value;
    }

    public function getEmailAttribute($value)
    {
        return $value;
    }
    public function setEmailAttribute($value)
    {
        return $this->attributes['email'] = $value;
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

    public function getRoleAttribute($value)
    {
        return $value;
    }

    public function setRoleAttribute($value)
    {
        return $this->attributes['role'] = $value;
    }

    public function getPasswordAttribute($value)
    {
        return $value;
    }

    public function setPasswordAttribute($value)
    {
        return $this->attributes['password'] = $value;
    }

    public function getUserActivationCodeAttribute($value)
    {
        return $value;
    }

    public function setUserActivationCodeAttribute($value)
    {
        return $this->attributes['user_activation_code'] = $value;
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


    public function report()
    {
        return $this->hasMany('App\ClientReports', 'report_id', 'user_id');
    }

    public function history(){
        return $this->hasMany('App\RfqHistory','user_id', 'history_id');
    }

    public function assignedIssues(){
        return $this->hasMany(Issue::class);
    }

    // public function employer()
    // {
    //     return $this->hasOne(Employers::class);
    // }

    public function assignedRfqs(){
        return $this->hasMany(ClientRfq::class);
    }

    public function warehouse(){
        return $this->hasMany(Warehouse::class);
    }

    // public function userwarehouse(){
    //     return $this->belongsTo('App\UserWarehouse','warehouse_id');
    // }
}
