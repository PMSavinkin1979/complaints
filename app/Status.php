<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
    protected $table='status';
    protected $guarded=['id'];
    public $timestamps = false;

    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
