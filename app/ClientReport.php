<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ClientReport extends Model
{
    use SoftDeletes;
    protected $table = 'client_reports';
    public $primaryKey = 'report_id';
    protected $guard_name = 'web';
    protected $fillable = [
        'client_id', 'user_id','note',
    ];

    public function getClientIdAttribute($value)
    {
        return $value;
    }

    public function setClientIdAttribute($value)
    {
        return $this->attributes['client_id'] = $value;
    }

    public function getUserIdAttribute($value)
    {
        return $value;
    }

    public function setUserIdAttribute($value)
    {
        return $this->attributes['user_id'] = $value;
    }

    public function getNoteAttribute($value)
    {
        return $value;
    }

    public function setNoteAttribute($value)
    {
        return $this->attributes['note'] = $value;
    }

    public function client()
    {
        return $this->belongsTo('App\Clients',  'client_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User',  'user_id');
    }


}
