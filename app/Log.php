<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Log extends Model
{
    use SoftDeletes;
    protected $table = 'logs';
    protected $primaryKey = 'log_id';

    protected $fillable = [
        'user_id', 'activities',
    ];

    public function getUserIdAttribute($value){
        return ($value);
    }

    public function setUserIdAttribute($value){
        return $this->attributes['user_id'] = ($value);
    }

    public function getActivitiesAttribute($value){
        return ($value);
    }

    public function setActivitiesAttribute($value){
        return $this->attributes['activities'] = ($value);
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
}
