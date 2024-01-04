<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class RfqMeasurement extends Model
{
    use SoftDeletes;

    protected $table = 'rfq_measurements';
    public $primaryKey = 'unit_id';
    protected $guard_name = 'web';
    protected $fillable = [
        'unit_name',
    ];

    public function getUnitNameAttribute($value)
    {
        return ucwords($value);
    }

    public function setUnitNameAttribute($value)
    {
        return $this->attributes['unit_name'] = $value;
    }

}
