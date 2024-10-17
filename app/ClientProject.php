<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ClientProject extends Model
{

    use SoftDeletes;

    protected $table = 'client_projects';
    public $primaryKey = 'id';
    protected $guard_name = 'web';
    protected $fillable = [
        'client_id', 'project_name'
    ];



}
