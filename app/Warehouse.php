<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Warehouse extends Model
{
    use SoftDeletes;
    protected $table = 'warehouses';
    protected $primaryKey = 'warehouse_id';
    protected $fillable = [
        'name'
    ];

    public function getNameAttribute($value)
    {
        return ($value);
    }

    public function setNameAttribute($value)
    {
        return $this->attributes['name'] = ($value);
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

    // public function users(){
    //     return $this->hasMany(User::class);
    // }
}
