<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ClientDocuments extends Model
{
    use SoftDeletes;
    protected $table = 'client_documents';
    public $primaryKey = 'doc_id';
    protected $guard_name = 'web';
    protected $fillable = [
        'client_id', 'file',
    ];

    public function getClientIdAttribute($value)
    {
        return $value;
    }
    public function setClientIdAttribute($value)
    {
        return $this->attributes['client_id'] = $value;
    }

    public function getFileAttribute($value)
    {
        return $value;
    }
    public function setCFileAttribute($value)
    {
        return $this->attributes['file'] = $value;
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
