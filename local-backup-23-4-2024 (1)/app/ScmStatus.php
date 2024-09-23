<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ScmStatus extends Model
{
    use SoftDeletes;

    protected $table = 'scm_statuses';
    // public $primaryKey = 'status_id';
    protected $guard_name = 'web';
    protected $fillable = [
        'name', 'type', 'active'
    ];

    public function getNameAttribute($value)
    {
        return $value;
    }

    public function setNameAttribute($value)
    {
        return $this->attributes['name'] = $value;
    }

    public function getTypeAttribute($value)
    {
        return $value;
    }

    public function setTypeAttribute($value)
    {
        return $this->attributes['type'] = $value;
    }

    public function getActiveAttribute($value)
    {
        return $value;
    }

    public function setActiveAttribute($value)
    {
        return $this->attributes['active'] = $value;
    }
}
