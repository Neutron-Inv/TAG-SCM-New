<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NgState extends Model
{
    protected $table = 'ng_states';
    protected $fillable = [
        'name'
    ];
    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y h:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y h:i:s');
    }
}
