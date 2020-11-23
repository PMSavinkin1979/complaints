<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vina extends Model
{
    protected $table='vina';
    protected $guarded=['id'];
    public $timestamps = false;

    use SoftDeletes;
    protected $dates = ['deleted_at'];
}
