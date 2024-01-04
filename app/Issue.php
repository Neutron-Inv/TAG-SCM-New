<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Issue extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'company_id', 'sender_name', 'sender_email', 'message', 'status', 'comment', 'assigned_to', 'priority', 'category', 'completion_time'
    ];

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y h:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y h:i:s');
    }

    public function getDeletedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y h:i:s');
    }

    public function assigned(){
        return $this->belongsTo(User::class,'assigned_to');
    }

    public function company(){
        return $this->belongsTo(Companies::class,'company_id');
    }
}
