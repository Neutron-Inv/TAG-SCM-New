<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
class RfqNumbers extends Model
{
    // use SoftDeletes;
    protected $table = 'rfq_numbers';
    public $primaryKey = 'id';
    protected $guard_name = 'web';
    protected $fillable = [
        'numbers', 'rfq', 'rfq_number'
    ];
}
