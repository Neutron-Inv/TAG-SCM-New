<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class RfqHistory extends Model
{
    use SoftDeletes;

    protected $table = 'rfq_histories';
    public $primaryKey = 'history_id';
    protected $guard_name = 'web';
    protected $fillable = [
        'rfq_id', 'user_id', 'action',
    ];

    public function getRfqIdAttribute($value)
    {
        return $value;
    }

    public function setRfqIdAttribute($value)
    {
        return $this->attributes['rfq_id'] = $value;
    }

    public function getUserIdAttribute($value)
    {
        return $value;
    }

    public function setUserIdAttribute($value)
    {
        return $this->attributes['user_id'] = $value;
    }

    public function getActionAttribute($value)
    {
        return $value;
    }

    public function setActionAttribute($value)
    {
        return $this->attributes['action'] = $value;
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

    public function rfq(){
        return $this->belongsTo('App\ClientRfq','rfq_id');
    }

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }
}
