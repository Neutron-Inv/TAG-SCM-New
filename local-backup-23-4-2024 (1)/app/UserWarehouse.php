<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class UserWarehouse extends Model
{
    use SoftDeletes;
    protected $table = 'user_warehouses';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id', 'warehouse_id'
    ];

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
    //     return $this->hasMany(User::class, 'user_id');
    // }
}
